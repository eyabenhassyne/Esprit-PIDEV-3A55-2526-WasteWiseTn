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
        $question = $request->request->get('question');
        
        // Get API key from .env file
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'];
        
        if (!$apiKey) {
            return $this->json(['answer' => '❌ Erreur: Clé API manquante dans .env']);
        }
        
        // Prepare the prompt for waste management
        $prompt = "Tu es un assistant spécialisé dans la gestion des déchets et l'environnement pour WasteWise TN en Tunisie. 
                   Réponds en français de façon claire et concise (maximum 100 mots). 
                   Question: " . $question;
        
        // Use the correct model name from the list - gemini-2.5-flash
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
        
        // Initialize cURL
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
        
        // Check for cURL errors
        if ($curlError) {
            return $this->json(['answer' => "❌ Erreur réseau: $curlError"]);
        }
        
        // Check HTTP status
        if ($httpCode !== 200) {
            // Try to get the error message from the response
            $errorData = json_decode($response, true);
            $errorMessage = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Erreur inconnue';
            return $this->json(['answer' => "❌ Erreur API ($httpCode): $errorMessage"]);
        }
        
        // Parse successful response
        $result = json_decode($response, true);
        $answer = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Je n'ai pas pu traiter votre demande.";
        
        return $this->json(['answer' => $answer]);
    }
}