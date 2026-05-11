<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'weather_api', methods: ['GET'])]
    public function current(WeatherService $weatherService): JsonResponse
    {
        $weather = $weatherService->getCurrentWeather();

        if (!($weather['available'] ?? false)) {
            return $this->json($weather, 503);
        }

        return $this->json($weather);
    }
}

