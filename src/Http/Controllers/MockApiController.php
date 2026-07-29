<?php

namespace Saimain\LaravelMockApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
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
                'data' => null,
            ], 404);
        }

        $rules = $entry['validation_rules'] ?? [];

        if (! empty($rules)) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null,
                    'errors' => $validator->errors(),
                ], 422);
            }
        }

        return response()->json($entry['response'], $entry['status']);
    }
}
