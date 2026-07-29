<?php

namespace Saimain\LaravelMockApi\Http\Controllers\Panel;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Saimain\LaravelMockApi\Http\Requests\MockResponseRequest;
use Saimain\LaravelMockApi\Support\MockResponseStore;

class MockResponseController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('mock-api.panel.mock-responses.create');
    }

    public function create(MockResponseStore $store): View
    {
        return view('mock-api::panel.mock-responses.create', [
            'entries' => $this->sidebarEntries($store),
        ]);
    }

    public function store(MockResponseRequest $request, MockResponseStore $store): RedirectResponse
    {
        $entry = $store->create($this->normalized($request));

        return redirect()->route('mock-api.panel.mock-responses.edit', $entry['id'])
            ->with('status', 'Mock endpoint created.');
    }

    public function edit(int $mockResponse, MockResponseStore $store): View
    {
        $entry = $store->find($mockResponse) ?? abort(404);

        return view('mock-api::panel.mock-responses.edit', [
            'entry' => $entry,
            'entries' => $this->sidebarEntries($store),
        ]);
    }

    public function update(MockResponseRequest $request, int $mockResponse, MockResponseStore $store): RedirectResponse
    {
        $store->update($mockResponse, $this->normalized($request));

        return redirect()->route('mock-api.panel.mock-responses.edit', $mockResponse)
            ->with('status', 'Mock endpoint updated.');
    }

    public function destroy(int $mockResponse, MockResponseStore $store): RedirectResponse
    {
        $store->delete($mockResponse);

        return redirect()->route('mock-api.panel.mock-responses.create')
            ->with('status', 'Mock endpoint deleted.');
    }

    protected function sidebarEntries(MockResponseStore $store): Collection
    {
        return collect($store->all())->sortBy('path')->values();
    }

    protected function normalized(MockResponseRequest $request): array
    {
        $data = $request->validated();
        $data['response'] = json_decode($data['response'], true);
        $data['validation_rules'] = filled($data['validation_rules'] ?? null)
            ? (json_decode($data['validation_rules'], true) ?: [])
            : [];

        return $data;
    }
}
