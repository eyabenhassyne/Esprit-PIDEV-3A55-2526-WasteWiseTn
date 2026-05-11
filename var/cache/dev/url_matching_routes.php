<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/admin' => [[['_route' => 'admin_dashboard', '_controller' => 'App\\Controller\\Admin6Controller::dashboard'], null, null, null, false, false, null]],
        '/api/zones' => [[['_route' => 'api_zones', '_controller' => 'App\\Controller\\ApiController::zones'], null, null, null, false, false, null]],
        '/chatbot' => [[['_route' => 'app_chatbot', '_controller' => 'App\\Controller\\ChatbotController::index'], null, null, null, false, false, null]],
        '/chatbot/ask' => [[['_route' => 'app_chatbot_ask', '_controller' => 'App\\Controller\\ChatbotController::ask'], null, ['POST' => 0], null, false, false, null]],
        '/dashboard-intelligent' => [[['_route' => 'app_dashboard_intelligent', '_controller' => 'App\\Controller\\DashboardIntelligentController::index'], null, null, null, false, false, null]],
        '/dashboard-intelligent/ask' => [[['_route' => 'app_dashboard_intelligent_ask', '_controller' => 'App\\Controller\\DashboardIntelligentController::ask'], null, ['POST' => 0], null, false, false, null]],
        '/indicateur-impact' => [[['_route' => 'app_indicateur_impact_index', '_controller' => 'App\\Controller\\IndicateurImpactController::index'], null, ['GET' => 0], null, true, false, null]],
        '/indicateur-impact/new' => [[['_route' => 'app_indicateur_impact_new', '_controller' => 'App\\Controller\\IndicateurImpactController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/map' => [[['_route' => 'app_map', '_controller' => 'App\\Controller\\MapController::index'], null, null, null, false, false, null]],
        '/qr-dashboard' => [[['_route' => 'app_qr_dashboard', '_controller' => 'App\\Controller\\QRDashboardController::index'], null, null, null, false, false, null]],
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
                .'|/dashboard\\-intelligent/compare/([^/]++)/([^/]++)(*:287)'
                .'|/indicateur\\-impact/([^/]++)(?'
                    .'|(*:326)'
                    .'|/(?'
                        .'|edit(*:342)'
                        .'|delete(*:356)'
                    .')'
                .')'
                .'|/scan/([^/]++)(*:380)'
                .'|/zone\\-polluee/([^/]++)(?'
                    .'|(*:414)'
                    .'|/(?'
                        .'|edit(*:430)'
                        .'|delete(*:444)'
                        .'|qr(?'
                            .'|(*:457)'
                            .'|/download/png(*:478)'
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
        287 => [[['_route' => 'app_dashboard_intelligent_compare', '_controller' => 'App\\Controller\\DashboardIntelligentController::compareZones'], ['id1', 'id2'], ['GET' => 0], null, false, true, null]],
        326 => [[['_route' => 'app_indicateur_impact_show', '_controller' => 'App\\Controller\\IndicateurImpactController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        342 => [[['_route' => 'app_indicateur_impact_edit', '_controller' => 'App\\Controller\\IndicateurImpactController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        356 => [[['_route' => 'app_indicateur_impact_delete', '_controller' => 'App\\Controller\\IndicateurImpactController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        380 => [[['_route' => 'app_qr_scan', '_controller' => 'App\\Controller\\QRScanController::track'], ['id'], null, null, false, true, null]],
        414 => [[['_route' => 'app_zone_polluee_show', '_controller' => 'App\\Controller\\ZonePollueeController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        430 => [[['_route' => 'app_zone_polluee_edit', '_controller' => 'App\\Controller\\ZonePollueeController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        444 => [[['_route' => 'app_zone_polluee_delete', '_controller' => 'App\\Controller\\ZonePollueeController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        457 => [[['_route' => 'app_zone_polluee_qr', '_controller' => 'App\\Controller\\ZonePollueeController::showQR'], ['id'], ['GET' => 0], null, false, false, null]],
        478 => [
            [['_route' => 'app_zone_polluee_qr_download_png', '_controller' => 'App\\Controller\\ZonePollueeController::downloadQRPNG'], ['id'], ['GET' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
