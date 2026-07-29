<?php

namespace Saimain\LaravelMockApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Saimain\LaravelMockApi\Support\MockResponseStore;

class MockResponseRequest extends FormRequest
{
    public function __construct(protected MockResponseStore $store)
    {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'method' => ['required', Rule::in(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])],
            'path' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9\-_\/]+$/i'],
            'status' => ['required', 'integer', 'between:100,599'],
            'response' => ['required', 'json'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $existing = $this->store->findMatch((string) $this->input('method'), (string) $this->input('path'));

            $routeParams = $this->route()?->parameters() ?: [];
            $editingId = (int) (reset($routeParams) ?: 0);

            if ($existing && $existing['id'] !== $editingId) {
                $validator->errors()->add('path', 'A mock already exists for this method and path.');
            }
        });
    }
}
