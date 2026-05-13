<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/2fa' => [[['_route' => '2fa_login', '_controller' => 'scheb_two_factor.form_controller::form'], null, null, null, false, false, null]],
        '/2fa_check' => [[['_route' => '2fa_login_check'], null, null, null, false, false, null]],
        '/_wdt/styles' => [[['_route' => '_wdt_stylesheet', '_controller' => 'web_profiler.controller.profiler::toolbarStylesheetAction'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/admin/dashboard' => [[['_route' => 'admin_dashboard', '_controller' => 'App\\Controller\\AdminController::dashboard'], null, null, null, false, false, null]],
        '/admin/declarations/legacy' => [[['_route' => 'admin_declarations_legacy', '_controller' => 'App\\Controller\\AdminController::declarationsLegacy'], null, null, null, false, false, null]],
        '/admin/utilisateurs' => [[['_route' => 'admin_utilisateurs', '_controller' => 'App\\Controller\\AdminController::utilisateurs'], null, null, null, false, false, null]],
        '/admin/declarations' => [[['_route' => 'admin_declarations', '_controller' => 'App\\Controller\\AdminDeclarationController::index'], null, ['GET' => 0], null, false, false, null]],
        '/admin/declarations/stats' => [[['_route' => 'admin_declarations_stats', '_controller' => 'App\\Controller\\AdminDeclarationController::stats'], null, ['GET' => 0], null, false, false, null]],
        '/admin/declarations/heatmap' => [[['_route' => 'admin_declarations_heatmap', '_controller' => 'App\\Controller\\AdminDeclarationController::heatmap'], null, ['GET' => 0], null, false, false, null]],
        '/admin/declarations/activity' => [[['_route' => 'admin_declarations_activity', '_controller' => 'App\\Controller\\AdminDeclarationController::activity'], null, ['GET' => 0], null, false, false, null]],
        '/admin/declarations/export/csv' => [[['_route' => 'admin_declarations_export_csv', '_controller' => 'App\\Controller\\AdminDeclarationController::exportCsv'], null, ['GET' => 0], null, false, false, null]],
        '/admin/declarations/export/pdf' => [[['_route' => 'admin_declarations_export_pdf', '_controller' => 'App\\Controller\\AdminDeclarationController::exportPdf'], null, ['GET' => 0], null, false, false, null]],
        '/api/zones' => [[['_route' => 'api_zones', '_controller' => 'App\\Controller\\ApiController::zones'], null, null, null, false, false, null]],
        '/appel/offre' => [[['_route' => 'app_appel_offre_index', '_controller' => 'App\\Controller\\AppelOffreController::index'], null, ['GET' => 0], null, false, false, null]],
        '/appel/offre/new' => [[['_route' => 'app_appel_offre_new', '_controller' => 'App\\Controller\\AppelOffreController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/calendar' => [[['_route' => 'app_calendar', '_controller' => 'App\\Controller\\CalendarController::index'], null, ['GET' => 0], null, false, false, null]],
        '/fc-load-events' => [[['_route' => 'fc_load_events', '_controller' => 'App\\Controller\\CalendarController::loadEvents'], null, ['GET' => 0], null, false, false, null]],
        '/chatbot' => [[['_route' => 'app_chatbot', '_controller' => 'App\\Controller\\ChatbotController::index'], null, null, null, false, false, null]],
        '/chatbot/ask' => [[['_route' => 'app_chatbot_ask', '_controller' => 'App\\Controller\\ChatbotController::ask'], null, ['POST' => 0], null, false, false, null]],
        '/citoyen/dashboard' => [[['_route' => 'citoyen_dashboard', '_controller' => 'App\\Controller\\CitoyenController::dashboard'], null, null, null, false, false, null]],
        '/citoyen/declarations' => [[['_route' => 'citoyen_declarations', '_controller' => 'App\\Controller\\CitoyenController::declarations'], null, null, null, false, false, null]],
        '/citoyen/nouveautes' => [[['_route' => 'citoyen_nouveautes', '_controller' => 'App\\Controller\\CitoyenController::nouveautes'], null, ['GET' => 0], null, false, false, null]],
        '/citoyen/air-quality' => [[['_route' => 'citoyen_air_quality', '_controller' => 'App\\Controller\\CitoyenController::airQuality'], null, ['GET' => 0], null, false, false, null]],
        '/citoyen/air-quality/data' => [[['_route' => 'citoyen_air_quality_data', '_controller' => 'App\\Controller\\CitoyenController::airQualityData'], null, ['GET' => 0], null, false, false, null]],
        '/citoyen/withdraw' => [[['_route' => 'citoyen_withdraw', '_controller' => 'App\\Controller\\CitoyenController::withdraw'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/citoyen/withdraw/connect-stripe' => [[['_route' => 'citoyen_withdraw_connect_stripe', '_controller' => 'App\\Controller\\CitoyenController::connectStripeWithdraw'], null, ['GET' => 0], null, false, false, null]],
        '/citoyen/statistiques' => [[['_route' => 'citoyen_statistiques', '_controller' => 'App\\Controller\\CitoyenController::statistiques'], null, null, null, false, false, null]],
        '/citoyen/parametres' => [[['_route' => 'citoyen_parametres', '_controller' => 'App\\Controller\\CitoyenController::parametres'], null, null, null, false, false, null]],
        '/dashboard' => [[['_route' => 'app_dashboard', '_controller' => 'App\\Controller\\DashboardController::index'], null, ['GET' => 0], null, false, false, null]],
        '/dashboard/citoyen' => [[['_route' => 'app_dashboard_citoyen', '_controller' => 'App\\Controller\\DashboardController::citoyen'], null, ['GET' => 0], null, false, false, null]],
        '/dashboard/admin' => [[['_route' => 'app_dashboard_admin', '_controller' => 'App\\Controller\\DashboardController::admin'], null, ['GET' => 0], null, false, false, null]],
        '/dashboard/valorisateur' => [[['_route' => 'app_dashboard_valorizateur', '_controller' => 'App\\Controller\\DashboardController::valorisateur'], null, ['GET' => 0], null, false, false, null]],
        '/offres' => [[['_route' => 'app_front_dashboard', '_controller' => 'App\\Controller\\DashboardController::front'], null, ['GET' => 0], null, false, false, null]],
        '/back/dashboard' => [[['_route' => 'app_back_dashboard', '_controller' => 'App\\Controller\\DashboardController::back'], null, ['GET' => 0], null, false, false, null]],
        '/dashboard-intelligent' => [[['_route' => 'app_dashboard_intelligent', '_controller' => 'App\\Controller\\DashboardIntelligentController::index'], null, null, null, false, false, null]],
        '/dashboard-intelligent/ask' => [[['_route' => 'app_dashboard_intelligent_ask', '_controller' => 'App\\Controller\\DashboardIntelligentController::ask'], null, ['POST' => 0], null, false, false, null]],
        '/citoyen/declaration' => [[['_route' => 'citoyen_declaration', '_controller' => 'App\\Controller\\DeclarationDechetController::new'], null, null, null, false, false, null]],
        '/citoyen/declaration/new' => [[['_route' => 'declaration_dechet_new', '_controller' => 'App\\Controller\\DeclarationDechetController::new'], null, null, null, false, false, null]],
        '/citoyen/analyse-image' => [[['_route' => 'citoyen_analyse_image', '_controller' => 'App\\Controller\\DeclarationDechetController::analyseImage'], null, ['POST' => 0], null, false, false, null]],
        '/evenement' => [[['_route' => 'app_evenement_index', '_controller' => 'App\\Controller\\EvenementController::index'], null, ['GET' => 0], null, false, false, null]],
        '/evenement/new' => [[['_route' => 'app_evenement_new', '_controller' => 'App\\Controller\\EvenementController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/citoyen/face/enroll' => [
            [['_route' => 'citoyen_face_enroll_page', '_controller' => 'App\\Controller\\FaceEnrollController::page'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'citoyen_face_enroll_save', '_controller' => 'App\\Controller\\FaceEnrollController::save'], null, ['POST' => 0], null, false, false, null],
        ],
        '/connect/facebook' => [[['_route' => 'connect_facebook_start', '_controller' => 'App\\Controller\\FacebookController::connectAction'], null, null, null, false, false, null]],
        '/front' => [[['_route' => 'app_front', '_controller' => 'App\\Controller\\FrontController::index'], null, null, null, false, false, null]],
        '/organisateur/proposer-action' => [[['_route' => 'app_front_evenement_new', '_controller' => 'App\\Controller\\FrontController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/mes-actions' => [[['_route' => 'app_mes_actions', '_controller' => 'App\\Controller\\FrontController::mesActions'], null, null, null, false, false, null]],
        '/organisateur/mes-actions' => [[['_route' => 'app_organisateur_index', '_controller' => 'App\\Controller\\FrontController::organisateurIndex'], null, null, null, false, false, null]],
        '/meteo-details' => [[['_route' => 'app_meteo_details', '_controller' => 'App\\Controller\\FrontController::meteoDetails'], null, null, null, false, false, null]],
        '/mes-badges' => [[['_route' => 'app_mes_badges', '_controller' => 'App\\Controller\\FrontController::mesBadges'], null, null, null, false, false, null]],
        '/connect/github' => [[['_route' => 'connect_github_start', '_controller' => 'App\\Controller\\GithubController::connect'], null, null, null, false, false, null]],
        '/connect/github/check' => [[['_route' => 'connect_github_check', '_controller' => 'App\\Controller\\GithubController::check'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/home' => [[['_route' => 'app_root', '_controller' => 'App\\Controller\\HomeController::root'], null, null, null, false, false, null]],
        '/indicateur-impact' => [[['_route' => 'app_indicateur_impact_index', '_controller' => 'App\\Controller\\IndicateurImpactController::index'], null, ['GET' => 0], null, true, false, null]],
        '/indicateur-impact/new' => [[['_route' => 'app_indicateur_impact_new', '_controller' => 'App\\Controller\\IndicateurImpactController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/privacy' => [[['_route' => 'app_privacy', '_controller' => 'App\\Controller\\LegalController::privacy'], null, null, null, false, false, null]],
        '/data-deletion' => [[['_route' => 'app_data_deletion', '_controller' => 'App\\Controller\\LegalController::dataDeletion'], null, null, null, false, false, null]],
        '/map' => [[['_route' => 'app_map', '_controller' => 'App\\Controller\\MapController::index'], null, null, null, false, false, null]],
        '/notifications' => [[['_route' => 'app_notifications', '_controller' => 'App\\Controller\\NotificationAdminController::index'], null, null, null, false, false, null]],
        '/connect/google' => [[['_route' => 'connect_google_start', '_controller' => 'App\\Controller\\OAuthController::connectGoogle'], null, null, null, false, false, null]],
        '/connect/google/check' => [[['_route' => 'connect_google_check', '_controller' => 'App\\Controller\\OAuthController::connectGoogleCheck'], null, null, null, false, false, null]],
        '/connect/facebook/check' => [[['_route' => 'connect_facebook_check', '_controller' => 'App\\Controller\\OAuthController::connectFacebookCheck'], null, null, null, false, false, null]],
        '/partenaire' => [[['_route' => 'partenaire_home', '_controller' => 'App\\Controller\\PartenaireController::index'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/dashboard' => [[['_route' => 'partenaire_dashboard', '_controller' => 'App\\Controller\\PartenaireController::dashboard'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/api/dashboard-stats' => [[['_route' => 'partenaire_dashboard_stats', '_controller' => 'App\\Controller\\PartenaireController::dashboardStats'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/bons' => [[['_route' => 'partenaire_bons', '_controller' => 'App\\Controller\\PartenaireController::bons'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/bons/nouveau' => [[['_route' => 'partenaire_bons_new', '_controller' => 'App\\Controller\\PartenaireController::createBon'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/partenaire/heatmap' => [[['_route' => 'partenaire_heatmap', '_controller' => 'App\\Controller\\PartenaireController::heatmap'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/api/heatmap' => [[['_route' => 'partenaire_heatmap_data', '_controller' => 'App\\Controller\\PartenaireController::heatmapData'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/impact-global' => [[['_route' => 'partenaire_impact_global', '_controller' => 'App\\Controller\\PartenaireController::impactGlobal'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/api/impact-global' => [[['_route' => 'partenaire_impact_global_data', '_controller' => 'App\\Controller\\PartenaireController::impactGlobalData'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/declarations' => [[['_route' => 'partenaire_declarations', '_controller' => 'App\\Controller\\PartenaireController::declarations'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/valorisation' => [[['_route' => 'partenaire_valorisation', '_controller' => 'App\\Controller\\PartenaireController::valorisation'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/export-fiscal/pdf' => [[['_route' => 'partenaire_export_fiscal_pdf', '_controller' => 'App\\Controller\\PartenaireController::exportFiscalPdf'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/collectes' => [[['_route' => 'partenaire_collectes', '_controller' => 'App\\Controller\\PartenaireController::legacyCollectes'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/zones' => [[['_route' => 'partenaire_zones', '_controller' => 'App\\Controller\\PartenaireController::legacyZones'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/planning' => [[['_route' => 'partenaire_planning', '_controller' => 'App\\Controller\\PartenaireController::legacyPlanning'], null, ['GET' => 0], null, false, false, null]],
        '/partenaire/parametres' => [[['_route' => 'partenaire_parametres', '_controller' => 'App\\Controller\\PartenaireController::legacyParametres'], null, ['GET' => 0], null, false, false, null]],
        '/participation' => [[['_route' => 'app_participation_index', '_controller' => 'App\\Controller\\ParticipationController::index'], null, ['GET' => 0], null, false, false, null]],
        '/participation/new' => [[['_route' => 'app_participation_new', '_controller' => 'App\\Controller\\ParticipationController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/valorisateur/profil' => [[['_route' => 'valorisateur_profile_show', '_controller' => 'App\\Controller\\ProfilController::show'], null, ['GET' => 0], null, false, false, null]],
        '/valorisateur/profil/modifier' => [[['_route' => 'valorisateur_profile_edit', '_controller' => 'App\\Controller\\ProfilController::edit'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/citoyen/profil' => [[['_route' => 'citoyen_profile_show', '_controller' => 'App\\Controller\\ProfileController::show'], null, ['GET' => 0], null, false, false, null]],
        '/citoyen/profil/modifier' => [[['_route' => 'citoyen_profile_edit', '_controller' => 'App\\Controller\\ProfileController::edit'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/qr-dashboard' => [[['_route' => 'app_qr_dashboard', '_controller' => 'App\\Controller\\QRDashboardController::index'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/reponse/offre' => [[['_route' => 'app_reponse_offre_index', '_controller' => 'App\\Controller\\ReponseOffreController::index'], null, ['GET' => 0], null, false, false, null]],
        '/reponse/offre/moderation' => [[['_route' => 'app_reponse_offre_moderation', '_controller' => 'App\\Controller\\ReponseOffreController::moderation'], null, ['GET' => 0], null, false, false, null]],
        '/reponse/offre/new' => [[['_route' => 'app_reponse_offre_new', '_controller' => 'App\\Controller\\ReponseOffreController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/reponse/offre/stats' => [[['_route' => 'app_reponse_offre_stats', '_controller' => 'App\\Controller\\ReponseOffreController::stats'], null, ['GET' => 0], null, false, false, null]],
        '/forgot-password' => [[['_route' => 'app_forgot_password', '_controller' => 'App\\Controller\\ResetPasswordController::forgot'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/face-login' => [[['_route' => 'app_face_login', '_controller' => 'App\\Controller\\SecurityController::faceLoginPage'], null, ['GET' => 0], null, false, false, null]],
        '/api/face-login/verify' => [[['_route' => 'api_face_login_verify', '_controller' => 'App\\Controller\\SecurityController::verifyFace'], null, ['POST' => 0], null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/profile/2fa/manual' => [[['_route' => 'app_2fa_manual', '_controller' => 'App\\Controller\\TwoFactorSetupController::manual'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/type-dechet' => [[['_route' => 'app_typedechet_index', '_controller' => 'App\\Controller\\TypeDechetController::index'], null, ['GET' => 0], null, true, false, null]],
        '/admin/type-dechet/new' => [[['_route' => 'app_typedechet_new', '_controller' => 'App\\Controller\\TypeDechetController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/user' => [[['_route' => 'app_user_index', '_controller' => 'App\\Controller\\UserController::index'], null, ['GET' => 0], null, true, false, null]],
        '/admin/user/new' => [[['_route' => 'app_user_new', '_controller' => 'App\\Controller\\UserController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/valorisateur/dashboard' => [[['_route' => 'valorisateur_dashboard', '_controller' => 'App\\Controller\\ValorisateurController::dashboard'], null, null, null, false, false, null]],
        '/valorisateur/dechets' => [[['_route' => 'valorisateur_dechets', '_controller' => 'App\\Controller\\ValorisateurController::dechetsRecus'], null, null, null, false, false, null]],
        '/valorisateur/valorisation' => [[['_route' => 'valorisateur_valorisation', '_controller' => 'App\\Controller\\ValorisateurController::valorisation'], null, null, null, false, false, null]],
        '/valorisateur/statistiques' => [[['_route' => 'valorisateur_statistiques', '_controller' => 'App\\Controller\\ValorisateurController::statistiques'], null, null, null, false, false, null]],
        '/valorisateur/parametres' => [[['_route' => 'valorisateur_parametres', '_controller' => 'App\\Controller\\ValorisateurController::parametres'], null, null, null, false, false, null]],
        '/weather' => [[['_route' => 'weather_api', '_controller' => 'App\\Controller\\WeatherController::current'], null, ['GET' => 0], null, false, false, null]],
        '/zone-polluee' => [[['_route' => 'app_zone_polluee_index', '_controller' => 'App\\Controller\\ZonePollueeController::index'], null, ['GET' => 0], null, true, false, null]],
        '/zone-polluee/new' => [[['_route' => 'app_zone_polluee_new', '_controller' => 'App\\Controller\\ZonePollueeController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/zone-polluee/qr/batch' => [[['_route' => 'app_zone_polluee_qr_batch', '_controller' => 'App\\Controller\\ZonePollueeController::batchQR'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/qr\\-code/([^/]++)/([\\w\\W]+)(*:35)'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:73)'
                    .'|wdt/([^/]++)(*:92)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:133)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:170)'
                                .'|router(*:184)'
                                .'|exception(?'
                                    .'|(*:204)'
                                    .'|\\.css(*:217)'
                                .')'
                            .')'
                            .'|(*:227)'
                        .')'
                    .')'
                .')'
                .'|/a(?'
                    .'|dmin/(?'
                        .'|declarations/(?'
                            .'|(\\d+)/details(*:280)'
                            .'|(\\d+)(*:293)'
                        .')'
                        .'|type\\-dechet/([^/]++)(?'
                            .'|(*:326)'
                            .'|/edit(*:339)'
                            .'|(*:347)'
                        .')'
                        .'|user/(?'
                            .'|(\\d+)(*:369)'
                            .'|(\\d+)/edit(*:387)'
                            .'|(\\d+)/delete(*:407)'
                            .'|([^/]++)/toggle\\-active(?'
                                .'|(*:441)'
                            .')'
                        .')'
                    .')'
                    .'|ppel/offre/([^/]++)(?'
                        .'|(*:474)'
                        .'|/edit(*:487)'
                        .'|(*:495)'
                    .')'
                .')'
                .'|/dashboard\\-intelligent/compare/([^/]++)/([^/]++)(*:554)'
                .'|/evenement/([^/]++)(?'
                    .'|(*:584)'
                    .'|/(?'
                        .'|edit(*:600)'
                        .'|delete(*:614)'
                    .')'
                .')'
                .'|/part(?'
                    .'|icip(?'
                        .'|er/([^/]++)(*:650)'
                        .'|ation/([^/]++)(?'
                            .'|/edit(*:680)'
                            .'|(*:688)'
                        .')'
                    .')'
                    .'|enaire/bons/(?'
                        .'|(\\d+)/modifier(*:727)'
                        .'|(\\d+)/supprimer(*:750)'
                        .'|(\\d+)/stats(*:769)'
                    .')'
                .')'
                .'|/organisateur/(?'
                    .'|modifier/([^/]++)(*:813)'
                    .'|details/([^/]++)(*:837)'
                    .'|supprimer/([^/]++)(*:863)'
                .')'
                .'|/mes\\-actions/annuler/([^/]++)(*:902)'
                .'|/indicateur\\-impact/([^/]++)(?'
                    .'|(*:941)'
                    .'|/(?'
                        .'|edit(*:957)'
                        .'|delete(*:971)'
                    .')'
                .')'
                .'|/scan/([^/]++)(*:995)'
                .'|/re(?'
                    .'|ponse/offre/([^/]++)(?'
                        .'|(*:1032)'
                        .'|/(?'
                            .'|edit(*:1049)'
                            .'|status/([^/]++)(*:1073)'
                        .')'
                        .'|(*:1083)'
                    .')'
                    .'|set\\-password/([^/]++)(*:1115)'
                .')'
                .'|/valorisateur/(?'
                    .'|dechets/([^/]++)/confirmer(*:1168)'
                    .'|valider/([^/]++)(*:1193)'
                .')'
                .'|/zone\\-polluee/([^/]++)(?'
                    .'|(*:1229)'
                    .'|/(?'
                        .'|edit(*:1246)'
                        .'|delete(*:1261)'
                        .'|qr(?'
                            .'|(*:1275)'
                            .'|/download/png(*:1297)'
                        .')'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => 'qr_code_generate', '_controller' => 'Endroid\\QrCodeBundle\\Controller\\GenerateController'], ['builder', 'data'], null, null, false, true, null]],
        73 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        92 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        133 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        170 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        184 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        204 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        217 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        227 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        280 => [[['_route' => 'admin_declarations_show_details', '_controller' => 'App\\Controller\\AdminDeclarationController::showDetails'], ['id'], ['GET' => 0], null, false, false, null]],
        293 => [[['_route' => 'admin_declarations_delete', '_controller' => 'App\\Controller\\AdminDeclarationController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        326 => [[['_route' => 'app_typedechet_show', '_controller' => 'App\\Controller\\TypeDechetController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        339 => [[['_route' => 'app_typedechet_edit', '_controller' => 'App\\Controller\\TypeDechetController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        347 => [[['_route' => 'app_typedechet_delete', '_controller' => 'App\\Controller\\TypeDechetController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        369 => [[['_route' => 'app_user_show', '_controller' => 'App\\Controller\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        387 => [[['_route' => 'app_user_edit', '_controller' => 'App\\Controller\\UserController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        407 => [[['_route' => 'app_user_delete', '_controller' => 'App\\Controller\\UserController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        441 => [
            [['_route' => 'app_user_toggle_active', '_controller' => 'App\\Controller\\UserController::toggleActive'], ['id'], ['POST' => 0], null, false, false, null],
            [['_route' => 'admin_user_toggle_active', '_controller' => 'App\\Controller\\UserStatusController::toggleActive'], ['id'], ['POST' => 0], null, false, false, null],
        ],
        474 => [[['_route' => 'app_appel_offre_show', '_controller' => 'App\\Controller\\AppelOffreController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        487 => [[['_route' => 'app_appel_offre_edit', '_controller' => 'App\\Controller\\AppelOffreController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        495 => [[['_route' => 'app_appel_offre_delete', '_controller' => 'App\\Controller\\AppelOffreController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        554 => [[['_route' => 'app_dashboard_intelligent_compare', '_controller' => 'App\\Controller\\DashboardIntelligentController::compareZones'], ['id1', 'id2'], ['GET' => 0], null, false, true, null]],
        584 => [[['_route' => 'app_evenement_show', '_controller' => 'App\\Controller\\EvenementController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        600 => [[['_route' => 'app_evenement_edit', '_controller' => 'App\\Controller\\EvenementController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        614 => [[['_route' => 'app_evenement_delete', '_controller' => 'App\\Controller\\EvenementController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        650 => [[['_route' => 'app_participer_event', '_controller' => 'App\\Controller\\FrontController::participer'], ['id'], ['POST' => 0], null, false, true, null]],
        680 => [[['_route' => 'app_participation_edit', '_controller' => 'App\\Controller\\ParticipationController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        688 => [
            [['_route' => 'app_participation_delete', '_controller' => 'App\\Controller\\ParticipationController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [['_route' => 'app_participation_show', '_controller' => 'App\\Controller\\ParticipationController::show'], ['id'], ['GET' => 0], null, false, true, null],
        ],
        727 => [[['_route' => 'partenaire_bons_edit', '_controller' => 'App\\Controller\\PartenaireController::editBon'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        750 => [[['_route' => 'partenaire_bons_delete', '_controller' => 'App\\Controller\\PartenaireController::deleteBon'], ['id'], ['POST' => 0], null, false, false, null]],
        769 => [[['_route' => 'partenaire_bons_stats', '_controller' => 'App\\Controller\\PartenaireController::bonStats'], ['id'], ['GET' => 0], null, false, false, null]],
        813 => [[['_route' => 'app_organisateur_edit', '_controller' => 'App\\Controller\\FrontController::editAction'], ['id'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        837 => [[['_route' => 'app_organisateur_show', '_controller' => 'App\\Controller\\FrontController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        863 => [[['_route' => 'app_organisateur_delete', '_controller' => 'App\\Controller\\FrontController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        902 => [[['_route' => 'app_participation_annuler', '_controller' => 'App\\Controller\\FrontController::annulerParticipation'], ['id'], ['POST' => 0, 'GET' => 1], null, false, true, null]],
        941 => [[['_route' => 'app_indicateur_impact_show', '_controller' => 'App\\Controller\\IndicateurImpactController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        957 => [[['_route' => 'app_indicateur_impact_edit', '_controller' => 'App\\Controller\\IndicateurImpactController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        971 => [[['_route' => 'app_indicateur_impact_delete', '_controller' => 'App\\Controller\\IndicateurImpactController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        995 => [[['_route' => 'app_qr_scan', '_controller' => 'App\\Controller\\QRScanController::track'], ['id'], null, null, false, true, null]],
        1032 => [[['_route' => 'app_reponse_offre_show', '_controller' => 'App\\Controller\\ReponseOffreController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        1049 => [[['_route' => 'app_reponse_offre_edit', '_controller' => 'App\\Controller\\ReponseOffreController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        1073 => [[['_route' => 'app_reponse_offre_change_status', '_controller' => 'App\\Controller\\ReponseOffreController::changeStatus'], ['id', 'target'], ['POST' => 0], null, false, true, null]],
        1083 => [[['_route' => 'app_reponse_offre_delete', '_controller' => 'App\\Controller\\ReponseOffreController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        1115 => [[['_route' => 'app_reset_password', '_controller' => 'App\\Controller\\ResetPasswordController::reset'], ['token'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        1168 => [[['_route' => 'valorisateur_confirmer', '_controller' => 'App\\Controller\\ValorisateurController::confirmer'], ['id'], ['POST' => 0], null, false, false, null]],
        1193 => [[['_route' => 'valorisateur_valider_qr', '_controller' => 'App\\Controller\\ValorisateurController::validerQr'], ['id'], ['GET' => 0], null, false, true, null]],
        1229 => [[['_route' => 'app_zone_polluee_show', '_controller' => 'App\\Controller\\ZonePollueeController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        1246 => [[['_route' => 'app_zone_polluee_edit', '_controller' => 'App\\Controller\\ZonePollueeController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        1261 => [[['_route' => 'app_zone_polluee_delete', '_controller' => 'App\\Controller\\ZonePollueeController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        1275 => [[['_route' => 'app_zone_polluee_qr', '_controller' => 'App\\Controller\\ZonePollueeController::showQR'], ['id'], ['GET' => 0], null, false, false, null]],
        1297 => [
            [['_route' => 'app_zone_polluee_qr_download_png', '_controller' => 'App\\Controller\\ZonePollueeController::downloadQRPNG'], ['id'], ['GET' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
