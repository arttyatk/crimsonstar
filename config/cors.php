<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Este arquivo define quais origens, métodos e headers são permitidos
    | para requisições cross-origin. Aqui está configurado para permitir
    | AJAX com multipart/form-data.
    |
    */

    // Rotas que usarão CORS
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Métodos HTTP permitidos
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Origens permitidas (coloque o domínio do front-end ou * para todos)
    'allowed_origins' => ['*'],

    // Permite padrões de origem (regex)
    'allowed_origins_patterns' => [],

    // Headers permitidos
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept', 'Origin'],

    // Headers que podem ser expostos no front-end
    'exposed_headers' => [],

    // Tempo de cache da preflight request (em segundos)
    'max_age' => 0,

    // Permitir cookies (necessário para autenticação)
    'supports_credentials' => false,
];
