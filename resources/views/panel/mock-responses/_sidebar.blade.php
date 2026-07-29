<aside class="sidebar">
    <div class="sidebar__header">
        <span class="sidebar__title">Endpoints</span>
        <a href="{{ route('mock-api.panel.mock-responses.create') }}" class="sidebar__new" aria-label="New endpoint" title="New endpoint">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        </a>
    </div>

    @if ($entries->isNotEmpty())
        <div class="sidebar__search">
            <input
                type="search"
                class="sidebar__search-input"
                placeholder="Filter endpoints…"
                aria-label="Filter endpoints"
                data-sidebar-filter
            >
        </div>
    @endif

    <nav class="sidebar__list" aria-label="Mock endpoints">
        @forelse ($entries as $item)
            @php $isActive = isset($entry) && $entry['id'] === $item['id']; @endphp
            <a
                href="{{ route('mock-api.panel.mock-responses.edit', $item['id']) }}"
                class="sidebar__item @if ($isActive) sidebar__item--active @endif"
                data-sidebar-search="{{ strtolower($item['method'].' /'.$item['path']) }}"
                @if ($isActive) aria-current="page" @endif
            >
                <span class="method-badge method-badge--{{ strtolower($item['method']) }}">{{ $item['method'] }}</span>
                <span class="sidebar__item-path">/{{ $item['path'] }}</span>
            </a>
        @empty
            <p class="sidebar__empty">No endpoints yet — create your first one.</p>
        @endforelse
    </nav>
</aside>
