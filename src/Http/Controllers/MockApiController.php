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
            return response()->json($this->errorResponse('Mock endpoint not found.'), 404);
        }

        $rules = $entry['validation_rules'] ?? [];

        if (! empty($rules)) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(
                    $this->errorResponse($validator->errors()->first(), ['errors' => $validator->errors()]),
                    422
                );
            }
        }

        return response()->json($entry['response'], $entry['status']);
    }

    protected function errorResponse(string $message, array $extra = []): array
    {
        $base = config('mock-api.default_error_response', ['success' => false, 'message' => null, 'data' => null]);

        return array_merge($base, ['message' => $message], $extra);
    }
}
