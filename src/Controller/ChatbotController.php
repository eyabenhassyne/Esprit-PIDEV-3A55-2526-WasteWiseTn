<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatbotController extends AbstractController
{
    #[Route('/chatbot', name: 'app_chatbot')]
    public function index(): Response
    {
        return $this->render('chatbot/index.html.twig');
    }

    #[Route('/chatbot/ask', name: 'app_chatbot_ask', methods: ['POST'])]
    public function ask(Request $request): Response
    {
        try {
            $question = trim((string) $request->request->get('question', ''));

            if ($question === '') {
                return $this->json(['answer' => '❌ Veuillez poser une question.']);
            }

            $apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'] ?? null;

            if (!$apiKey) {
                return $this->json(['answer' => '❌ Clé API Gemini manquante. Veuillez configurer GEMINI_API_KEY dans le fichier .env']);
            }

            $prompt = "Tu es un assistant spécialisé dans la gestion des déchets, le recyclage et l'environnement pour WasteWise TN en Tunisie.
Réponds toujours en français de façon claire, amicale et concise (maximum 150 mots).
Ajoute des émojis pertinents pour rendre la réponse plus vivante.

Question : $question";

            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;

            $data = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 300,
                    'temperature'     => 0.7,
                ]
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                return $this->json(['answer' => '❌ Erreur réseau : ' . $curlError]);
            }

            $result = json_decode($response, true);

            if ($httpCode !== 200) {
                $errorMsg = $result['error']['message'] ?? 'Erreur inconnue';
                return $this->json(['answer' => "❌ Erreur API ($httpCode) : $errorMsg"]);
            }

            $answer = $result['candidates'][0]['content']['parts'][0]['text']
                ?? "Je n'ai pas pu traiter votre demande. Veuillez réessayer.";

            return $this->json(['answer' => trim($answer)]);

        } catch (\Throwable $e) {
            return $this->json(['answer' => '❌ Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
        }
    }
}
