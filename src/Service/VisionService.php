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
                $message = is_array($data) && isset($data['error']) ? (string) $data['error'] : 'Model loading';
                return $this->errorResult(sprintf('503 Model loading: %s', $message));
            }

            if ($statusCode >= 500) {
                $message = is_array($data) && isset($data['error']) ? (string) $data['error'] : 'Erreur serveur Hugging Face.';
                return $this->errorResult(sprintf('%d Server error: %s', $statusCode, $message));
            }

            if (!is_array($data) || [] === $data) {
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
