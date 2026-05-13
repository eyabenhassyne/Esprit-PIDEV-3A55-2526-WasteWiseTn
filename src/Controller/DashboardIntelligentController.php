<?php

namespace App\Controller;

use App\Repository\ZonePollueeRepository;
use App\Repository\IndicateurImpactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardIntelligentController extends AbstractController
{
    #[Route('/dashboard-intelligent', name: 'app_dashboard_intelligent')]
    public function index(
        ZonePollueeRepository $zoneRepo,
        IndicateurImpactRepository $indicateurRepo
    ): Response {
        // Données pour les graphiques
        $zones = $zoneRepo->findAll();
        $indicateurs = $indicateurRepo->findAll();
        
        // Statistiques globales
        $totalZones = count($zones);
        $zonesCritiques = array_filter($zones, fn($z) => $z->getNiveauPollution() >= 7);
        $zonesMoyennes = array_filter($zones, fn($z) => $z->getNiveauPollution() >= 4 && $z->getNiveauPollution() <= 6);
        $zonesFaibles = array_filter($zones, fn($z) => $z->getNiveauPollution() <= 3);
        
        // Données pour le graphique en camembert
        $chartData = [
            'labels' => ['Critique (≥7)', 'Moyen (4-6)', 'Faible (≤3)'],
            'datasets' => [
                [
                    'label' => 'Zones par niveau',
                    'data' => [
                        count($zonesCritiques),
                        count($zonesMoyennes),
                        count($zonesFaibles)
                    ],
                    'backgroundColor' => ['#dc3545', '#ffc107', '#28a745']
                ]
            ]
        ];
        
        return $this->render('dashboard_intelligent/index.html.twig', [
            'total_zones' => $totalZones,
            'zones_critiques' => count($zonesCritiques),
            'zones_moyennes' => count($zonesMoyennes),
            'zones_faibles' => count($zonesFaibles),
            'chart_data' => $chartData,
            'zones' => $zones,
        ]);
    }

    #[Route('/dashboard-intelligent/ask', name: 'app_dashboard_intelligent_ask', methods: ['POST'])]
    public function ask(Request $request, ZonePollueeRepository $zoneRepo, IndicateurImpactRepository $indicateurRepo): Response
    {
        $question = $request->request->get('question');
        
        // Récupère toutes les données réelles
        $zones = $zoneRepo->findAll();
        $indicateurs = $indicateurRepo->findAll();
        
        // Calcule les stats en temps réel
        $totalZones = count($zones);
        $zonesCritiques = array_filter($zones, fn($z) => $z->getNiveauPollution() >= 7);
        $zonesMoyennes = array_filter($zones, fn($z) => $z->getNiveauPollution() >= 4 && $z->getNiveauPollution() <= 6);
        $zonesFaibles = array_filter($zones, fn($z) => $z->getNiveauPollution() <= 3);
        
        // Trouve la zone la plus polluée
        $zonePlusPolluee = null;
        $maxNiveau = 0;
        foreach ($zones as $zone) {
            if ($zone->getNiveauPollution() > $maxNiveau) {
                $maxNiveau = $zone->getNiveauPollution();
                $zonePlusPolluee = $zone;
            }
        }
        
        // Calcule les stats des indicateurs
        $totalKg = 0;
        $totalCo2 = 0;
        foreach ($indicateurs as $ind) {
            $totalKg += $ind->getTotalKgRecoltes();
            $totalCo2 += $ind->getCo2Evite();
        }
        
        // Prépare un résumé complet des données pour l'IA
        $resumeDonnees = "📊 DONNÉES ACTUELLES DE WASTEWISE TN:\n\n";
        $resumeDonnees .= "ZONES POLLUÉES:\n";
        $resumeDonnees .= "- Total zones: $totalZones\n";
        $resumeDonnees .= "- Zones critiques (≥7): " . count($zonesCritiques) . "\n";
        $resumeDonnees .= "- Zones moyennes (4-6): " . count($zonesMoyennes) . "\n";
        $resumeDonnees .= "- Zones faibles (≤3): " . count($zonesFaibles) . "\n\n";
        
        if ($zonePlusPolluee) {
            $resumeDonnees .= "🏆 ZONE LA PLUS POLLUÉE:\n";
            $resumeDonnees .= "- Nom: {$zonePlusPolluee->getNomZone()}\n";
            $resumeDonnees .= "- Niveau: {$zonePlusPolluee->getNiveauPollution()}/10\n";
            $resumeDonnees .= "- GPS: {$zonePlusPolluee->getCoordonneesGps()}\n";
            $resumeDonnees .= "- Date: {$zonePlusPolluee->getDateIdentification()->format('d/m/Y')}\n\n";
        }
        
        $resumeDonnees .= "IMPACT ENVIRONNEMENTAL:\n";
        $resumeDonnees .= "- Total déchets collectés: " . round($totalKg) . " kg\n";
        $resumeDonnees .= "- Total CO₂ évité: " . round($totalCo2) . " kg\n\n";
        
        // Ajoute la liste de toutes les zones
        $resumeDonnees .= "LISTE COMPLÈTE DES ZONES:\n";
        foreach ($zones as $zone) {
            $resumeDonnees .= "- {$zone->getNomZone()}: niveau {$zone->getNiveauPollution()}/10\n";
        }
        
        // Clé API Gemini
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'];
        
        // Prompt avec les VRAIES données
        $prompt = "Tu es un assistant expert en analyse de données environnementales pour WasteWise TN en Tunisie.
        Tu réponds toujours en français de façon claire, amicale et précise.
        
        $resumeDonnees
        
        Question de l'utilisateur: $question
        
        Instructions:
        - Utilise UNIQUEMENT les données fournies ci-dessus
        - Si la question concerne la zone la plus polluée, donne son nom et son niveau exact
        - Si la question concerne les statistiques, donne les chiffres exacts
        - Sois concis (maximum 4 phrases)
        - Ajoute des émojis pertinents pour rendre la réponse plus vivante 🎯";
        
        // Appel à Gemini API
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
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        $answer = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Désolé, je n'ai pas pu analyser cette question.";
        
        return $this->json(['answer' => $answer]);
    }

    #[Route('/dashboard-intelligent/compare/{id1}/{id2}', name: 'app_dashboard_intelligent_compare', methods: ['GET'])]
    public function compareZones(
        ZonePollueeRepository $zoneRepo,
        int $id1,
        int $id2
    ): Response {
        $zone1 = $zoneRepo->find($id1);
        $zone2 = $zoneRepo->find($id2);
        
        if (!$zone1 || !$zone2) {
            return $this->json(['error' => 'Zone non trouvée']);
        }
        
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'];
        
        // Calcul des différences
        $diffNiveau = $zone1->getNiveauPollution() - $zone2->getNiveauPollution();
        $date1 = $zone1->getDateIdentification()->format('d/m/Y');
        $date2 = $zone2->getDateIdentification()->format('d/m/Y');
        
        // Prompt intelligent pour comparer les zones
        $prompt = "Tu es un expert en environnement. Compare ces deux zones polluées en Tunisie:
        
        Zone 1: '{$zone1->getNomZone()}'
        - Niveau: {$zone1->getNiveauPollution()}/10
        - Date: {$date1}
        - GPS: {$zone1->getCoordonneesGps()}
        
        Zone 2: '{$zone2->getNomZone()}'
        - Niveau: {$zone2->getNiveauPollution()}/10
        - Date: {$date2}
        - GPS: {$zone2->getCoordonneesGps()}
        
        Différence de niveau: " . abs($diffNiveau) . " points (" . ($diffNiveau > 0 ? 'Zone 1 plus polluée' : ($diffNiveau < 0 ? 'Zone 2 plus polluée' : 'Niveaux égaux')) . ")
        
        Réponds en français avec:
        1. Une phrase qui compare les niveaux
        2. Laquelle est la plus urgente à traiter
        3. Un conseil simple
        
        Maximum 3 phrases. Sois clair et direct.";
        
        // Appel à Gemini
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
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        $comparison = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Impossible de comparer les zones.";
        
        return $this->json([
            'comparison' => $comparison,
            'zone1' => [
                'nom' => $zone1->getNomZone(),
                'niveau' => $zone1->getNiveauPollution(),
                'color' => $zone1->getNiveauPollution() >= 7 ? 'danger' : ($zone1->getNiveauPollution() >= 4 ? 'warning' : 'success')
            ],
            'zone2' => [
                'nom' => $zone2->getNomZone(),
                'niveau' => $zone2->getNiveauPollution(),
                'color' => $zone2->getNiveauPollution() >= 7 ? 'danger' : ($zone2->getNiveauPollution() >= 4 ? 'warning' : 'success')
            ]
        ]);
    }
}