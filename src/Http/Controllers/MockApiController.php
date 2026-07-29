<?php

namespace Saimain\LaravelMockApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Saimain\LaravelMockApi\Support\MockResponseStore;

class MockApiController extends Controller
{
    public function __invoke(Request $request, string $path, MockResponseStore $store): JsonResponse
    {
        $entry = $store->findMatch($request->method(), $path);

        if (! $entry) {
            return response()->json([
                'success' => false,
                'message' => 'Mock endpoint not found.',
            ], 404);
        }

        return response()->json($entry['response'], $entry['status']);
    }
}
