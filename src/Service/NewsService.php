<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsService
{
    private const ENDPOINT = 'https://newsapi.org/v2/everything';
    private const POLLUTION_KEYWORDS = [
        'pollution',
        'polluant',
        'polluted',
        'polluting',
        'contamination',
        'smog',
        'air quality',
        'water quality',
    ];

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiKey
    ) {
    }

    public function getWasteAndEnergyNews(int $limit = 12): array
    {
        if ('' === trim($this->apiKey)) {
            return [
                'available' => false,
                'message' => 'NEWS_API_KEY manquante. Ajoutez votre cle NewsAPI dans .env.local.',
                'articles' => [],
            ];
        }

        try {
            $pageSize = max(1, min($limit, 20));

            // Requete principale: pollution en francais.
            $payload = $this->fetchNewsPayload([
                'q' => '("pollution" OR "air pollution" OR "water pollution")',
                'searchIn' => 'title,description,content',
                'language' => 'fr',
                'sortBy' => 'publishedAt',
                'pageSize' => $pageSize,
            ]);

            // Fallback: meme theme, sans filtre langue si la requete FR ne retourne rien.
            if (($payload['success'] ?? false) && [] === ($payload['articles'] ?? [])) {
                $payload = $this->fetchNewsPayload([
                    'q' => '("pollution" OR "air pollution" OR "water pollution")',
                    'searchIn' => 'title,description,content',
                    'sortBy' => 'publishedAt',
                    'pageSize' => $pageSize,
                ]);
            }

            if (!($payload['success'] ?? false)) {
                return [
                    'available' => false,
                    'message' => (string) ($payload['message'] ?? 'NewsAPI indisponible.'),
                    'articles' => [],
                ];
            }

            if (!isset($payload['articles']) || !is_array($payload['articles'])) {
                return [
                    'available' => false,
                    'message' => 'Reponse NewsAPI invalide.',
                    'articles' => [],
                ];
            }

            $articles = $this->mapPollutionArticles($payload['articles'], $pageSize);

            return [
                'available' => true,
                'message' => [] === $articles ? 'Aucun article pollution recent trouve pour le moment.' : null,
                'articles' => $articles,
            ];
        } catch (\Throwable) {
            return [
                'available' => false,
                'message' => 'Impossible de charger les nouveautes pour le moment.',
                'articles' => [],
            ];
        }
    }

    private function fetchNewsPayload(array $query): array
    {
        $response = $this->httpClient->request('GET', self::ENDPOINT, [
            'headers' => [
                'X-Api-Key' => $this->apiKey,
            ],
            'query' => $query,
            'timeout' => 20,
        ]);

        if (200 !== $response->getStatusCode()) {
            return [
                'success' => false,
                'message' => sprintf('NewsAPI indisponible (%d).', $response->getStatusCode()),
                'articles' => [],
            ];
        }

        $payload = $response->toArray(false);
        if (!is_array($payload) || !isset($payload['articles']) || !is_array($payload['articles'])) {
            return [
                'success' => false,
                'message' => 'Reponse NewsAPI invalide.',
                'articles' => [],
            ];
        }

        return [
            'success' => true,
            'articles' => $payload['articles'],
        ];
    }

    private function mapPollutionArticles(array $rawArticles, int $limit): array
    {
        $articles = [];
        foreach ($rawArticles as $article) {
            if (!is_array($article)) {
                continue;
            }

            $title = (string) ($article['title'] ?? '');
            $description = (string) ($article['description'] ?? '');
            $content = (string) ($article['content'] ?? '');
            $normalized = strtolower($title.' '.$description.' '.$content);

            $isPollution = false;
            foreach (self::POLLUTION_KEYWORDS as $keyword) {
                if (str_contains($normalized, $keyword)) {
                    $isPollution = true;
                    break;
                }
            }

            if (!$isPollution) {
                continue;
            }

            $articles[] = [
                'title' => '' !== $title ? $title : 'Sans titre',
                'description' => $description,
                'url' => (string) ($article['url'] ?? ''),
                'image' => (string) ($article['urlToImage'] ?? ''),
                'source' => (string) (($article['source']['name'] ?? 'Source inconnue')),
                'publishedAt' => (string) ($article['publishedAt'] ?? ''),
            ];

            if (\count($articles) >= $limit) {
                break;
            }
        }

        return $articles;
    }
}
