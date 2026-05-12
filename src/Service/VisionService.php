<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VisionService
{
    private const ENDPOINT = 'https://router.huggingface.co/hf-inference/models/google/vit-base-patch16-224';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiKey
    ) {
    }

    /**
     * @return array{success: bool, label: string|null, score: float|null, error: string|null}
     */
    public function classifyImage(string $imagePath): array
    {
        $token = trim($this->apiKey);
        if ('' === $token) {
            return $this->errorResult('Token Hugging Face manquant.');
        }

        $stream = @fopen($imagePath, 'rb');
        if (false === $stream) {
            return $this->errorResult('Impossible de lire le fichier image.');
        }

        try {
            $response = $this->httpClient->request('POST', self::ENDPOINT, [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $token),
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => $stream,
                'timeout' => 30,
            ]);

            $statusCode = $response->getStatusCode();
            $data = $response->toArray(false);

            if (401 === $statusCode) {
                return $this->errorResult('401 Unauthorized: token Hugging Face invalide.');
            }

            if (429 === $statusCode) {
                return $this->errorResult('429 Rate limit: quota Hugging Face depasse.');
            }

            if (503 === $statusCode) {
                $message = isset($data['error']) ? (string) $data['error'] : 'Model loading';
                return $this->errorResult(sprintf('503 Model loading: %s', $message));
            }

            if ($statusCode >= 500) {
                $message = isset($data['error']) ? (string) $data['error'] : 'Erreur serveur Hugging Face.';
                return $this->errorResult(sprintf('%d Server error: %s', $statusCode, $message));
            }

            if ([] === $data) {
                return $this->errorResult('JSON vide ou invalide depuis Hugging Face.');
            }

            if (isset($data['error'])) {
                return $this->errorResult((string) $data['error']);
            }

            if (!isset($data[0]) || !is_array($data[0])) {
                return $this->errorResult('Aucune prediction exploitable dans la reponse.');
            }

            $label = isset($data[0]['label']) ? (string) $data[0]['label'] : null;
            $score = isset($data[0]['score']) ? (float) $data[0]['score'] : null;

            if (null === $label || null === $score) {
                return $this->errorResult('Prediction incomplete: label ou score manquant.');
            }

            return [
                'success' => true,
                'label' => $label,
                'score' => $score,
                'error' => null,
            ];
        } catch (DecodingExceptionInterface) {
            return $this->errorResult('JSON invalide recu depuis Hugging Face.');
        } catch (TransportExceptionInterface $e) {
            $message = strtolower($e->getMessage());
            if (str_contains($message, 'timed out') || str_contains($message, 'timeout')) {
                return $this->errorResult('Timeout pendant l appel Hugging Face.');
            }

            return $this->errorResult(sprintf('Erreur reseau Hugging Face: %s', $e->getMessage()));
        } catch (\Throwable $e) {
            return $this->errorResult(sprintf('Erreur Hugging Face: %s', $e->getMessage()));
        } finally {
            fclose($stream);
        }
    }

    /**
     * @return array{success: bool, label: string|null, score: float|null, match: bool, error: string|null}
     */
    public function classifyAndValidate(string $imagePath, string $selectedType): array
    {
        $result = $this->classifyImage($imagePath);
        if (!$result['success']) {
            return [
                'success' => false,
                'label' => null,
                'score' => null,
                'match' => false,
                'error' => $result['error'],
            ];
        }

        $label = (string) $result['label'];
        $score = (float) $result['score'];
        $typeMatches = $this->isTypeMatchingLabel($selectedType, $label);
        $match = !($score > 0.6 && !$typeMatches);

        return [
            'success' => true,
            'label' => $label,
            'score' => $score,
            'match' => $match,
            'error' => null,
        ];
    }

    private function isTypeMatchingLabel(string $selectedType, string $label): bool
    {
        $type = $this->normalizeText($selectedType);
        $predicted = $this->normalizeText($label);

        if ('' === $type || '' === $predicted) {
            return false;
        }

        if (str_contains($predicted, $type) || str_contains($type, $predicted)) {
            return true;
        }

        $aliases = [
            'plastique' => ['plastic', 'bottle', 'pet', 'container'],
            'carton' => ['carton', 'cardboard', 'box'],
            'papier' => ['paper', 'newspaper', 'notebook'],
            'verre' => ['glass', 'bottle'],
            'metal' => ['metal', 'can', 'aluminum', 'steel'],
            'canette' => ['can', 'aluminum'],
            'organique' => ['organic', 'food', 'compost', 'biodegradable'],
        ];

        foreach ($aliases as $family => $keywords) {
            $typeInFamily = str_contains($type, $family);
            $labelInFamily = false;
            foreach ($keywords as $keyword) {
                if (str_contains($predicted, $keyword)) {
                    $labelInFamily = true;
                    break;
                }
            }

            if ($typeInFamily && $labelInFamily) {
                return true;
            }
        }

        return false;
    }

    private function normalizeText(string $value): string
    {
        $value = strtolower(trim($value));
        $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if (\is_string($transliterated) && '' !== $transliterated) {
            $value = $transliterated;
        }

        return preg_replace('/\s+/', ' ', $value) ?? '';
    }

    /**
     * @return array{success: false, label: null, score: null, error: string}
     */
    private function errorResult(string $error): array
    {
        return [
            'success' => false,
            'label' => null,
            'score' => null,
            'error' => $error,
        ];
    }
}
