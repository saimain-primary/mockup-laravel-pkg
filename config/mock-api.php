<?php

return [
    // Turn the whole package off (e.g. force false in production) without uninstalling it.
    'enabled' => env('MOCK_API_ENABLED', true),

    // Mock endpoints are served under this prefix, e.g. "api" -> GET /api/{path}.
    'api_prefix' => env('MOCK_API_PREFIX', 'api'),

    // The management panel is served under this prefix, e.g. /mock-panel.
    'panel_prefix' => env('MOCK_API_PANEL_PREFIX', 'mock-panel'),

    'api_middleware' => ['api'],

    'panel_middleware' => ['web'],

    // Where the JSON manifest of mock responses is stored.
    'storage_path' => storage_path('app/mock-api/responses.json'),

    // Starting template pre-filled into a new endpoint's response body in the
    // panel. Purely a convenience default — each endpoint's response is still
    // freely editable and can deviate from this shape entirely.
    'default_response' => [
        'success' => true,
        'message' => 'Mockup Response',
        'data' => null,
    ],
];
