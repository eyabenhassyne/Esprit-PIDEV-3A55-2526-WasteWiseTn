<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private const TUNIS_LATITUDE = 36.8065;
    private const TUNIS_LONGITUDE = 10.1815;

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function getCurrentWeather(): array
    {
        try {
            $response = $this->client->request('GET', 'https://api.open-meteo.com/v1/forecast', [
                'query' => [
                    'latitude' => self::TUNIS_LATITUDE,
                    'longitude' => self::TUNIS_LONGITUDE,
                    'current_weather' => 'true',
                ],
            ]);

            if (200 !== $response->getStatusCode()) {
                return [
                    'available' => false,
                    'message' => 'Meteo indisponible',
                ];
            }

            $data = $response->toArray();
            $current = $data['current_weather'] ?? null;

            if (!\is_array($current)) {
                return [
                    'available' => false,
                    'message' => 'Meteo indisponible',
                ];
            }

            return [
                'available' => true,
                'city' => 'Tunis',
                'temperature' => $current['temperature'] ?? null,
                'wind_speed' => $current['windspeed'] ?? null,
                'wind_direction' => $current['winddirection'] ?? null,
                'weather_code' => $current['weathercode'] ?? null,
                'time' => $current['time'] ?? null,
            ];
        } catch (\Throwable) {
            return [
                'available' => false,
                'message' => 'Meteo indisponible',
            ];
        }
    }
}

