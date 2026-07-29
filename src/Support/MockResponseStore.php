<?php

namespace Saimain\LaravelMockApi\Support;

use Illuminate\Support\Facades\File;

class MockResponseStore
{
    protected string $path;

    public function __construct()
    {
        $this->path = config('mock-api.storage_path');
    }

    public function all(): array
    {
        if (! File::exists($this->path)) {
            return [];
        }

        return json_decode(File::get($this->path), true) ?? [];
    }

    public function find(int $id): ?array
    {
        return collect($this->all())->firstWhere('id', $id);
    }

    public function findMatch(string $method, string $path): ?array
    {
        $path = trim($path, '/');

        return collect($this->all())->first(
            fn (array $entry) => strtoupper($entry['method']) === strtoupper($method)
                && trim($entry['path'], '/') === $path
        );
    }

    public function create(array $data): array
    {
        $entries = $this->all();

        $entry = [
            'id' => $this->nextId($entries),
            'method' => strtoupper($data['method']),
            'path' => trim($data['path'], '/'),
            'description' => $data['description'] ?? null,
            'status' => (int) $data['status'],
            'validation_rules' => $data['validation_rules'] ?? [],
            'response' => $data['response'],
        ];

        $entries[] = $entry;
        $this->persist($entries);

        return $entry;
    }

    public function update(int $id, array $data): void
    {
        $entries = array_map(function (array $entry) use ($id, $data) {
            if ($entry['id'] !== $id) {
                return $entry;
            }

            return [
                'id' => $id,
                'method' => strtoupper($data['method']),
                'path' => trim($data['path'], '/'),
                'description' => $data['description'] ?? null,
                'status' => (int) $data['status'],
                'validation_rules' => $data['validation_rules'] ?? [],
                'response' => $data['response'],
            ];
        }, $this->all());

        $this->persist($entries);
    }

    public function delete(int $id): void
    {
        $entries = array_filter($this->all(), fn (array $entry) => $entry['id'] !== $id);

        $this->persist($entries);
    }

    protected function nextId(array $entries): int
    {
        return empty($entries) ? 1 : max(array_column($entries, 'id')) + 1;
    }

    protected function persist(array $entries): void
    {
        File::ensureDirectoryExists(dirname($this->path));

        File::put(
            $this->path,
            json_encode(array_values($entries), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}
