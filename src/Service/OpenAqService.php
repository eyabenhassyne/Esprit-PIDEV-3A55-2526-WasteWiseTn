<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAqService
{
    private const ENDPOINT = 'https://api.openaq.org/v3/locations';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiKey
    ) {
    }

    public function getLocations(float $latitude, float $longitude, int $radius = 25000, int $limit = 100): array
    {
        if ('' === trim($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'OPENAQ_API_KEY manquante.',
                'results' => [],
            ];
        }

        try {
            $safeLimit = max(1, min($limit, 200));
            $safeRadius = max(1, min($radius, 1000000));

            // Strategie 1: autour de la position choisie.
            $tries = [
                [
                    'coordinates' => sprintf('%.4f,%.4f', $latitude, $longitude),
                    'radius' => $safeRadius,
                    'limit' => $safeLimit,
                ],
                // Strategie 2: tout le pays (Tunisie).
                [
                    'country' => 'TN',
                    'limit' => $safeLimit,
                ],
                // Strategie 3: fallback global pour eviter page vide.
                [
                    'limit' => $safeLimit,
                ],
            ];

            $lastMessage = 'Aucune station disponible.';
            foreach ($tries as $query) {
                $fetched = $this->fetchLocations($query);
                if (!($fetched['success'] ?? false)) {
                    $lastMessage = (string) ($fetched['message'] ?? $lastMessage);
                    continue;
                }

                $results = $fetched['results'] ?? [];
                if (is_array($results) && [] !== $results) {
                    return [
                        'success' => true,
                        'message' => null,
                        'results' => $results,
                    ];
                }
            }

            return [
                'success' => false,
                'message' => $lastMessage,
                'results' => [],
            ];
        } catch (\Throwable $exception) {
            return [
                'success' => false,
                'message' => sprintf('Erreur OpenAQ: %s', $exception->getMessage()),
                'results' => [],
            ];
        }
    }

    private function fetchLocations(array $query): array
    {
        $response = $this->httpClient->request('GET', self::ENDPOINT, [
            'headers' => [
                'X-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ],
            'query' => $query,
            'timeout' => 20,
        ]);

        if (200 !== $response->getStatusCode()) {
            return [
                'success' => false,
                'message' => sprintf('OpenAQ indisponible (%d).', $response->getStatusCode()),
                'results' => [],
            ];
        }

        $payload = $response->toArray(false);
        if (!is_array($payload) || !isset($payload['results']) || !is_array($payload['results'])) {
            return [
                'success' => false,
                'message' => 'Reponse OpenAQ invalide.',
                'results' => [],
            ];
        }

        return [
            'success' => true,
            'message' => null,
            'results' => $payload['results'],
        ];
    }
}
