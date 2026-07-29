@php
    $sidebarItemRoute = $sidebarItemRoute ?? 'mock-api.panel.mock-responses.edit';
    $inDocs = $sidebarItemRoute === 'mock-api.panel.docs.show';
@endphp

<aside class="sidebar">
    <div class="sidebar__header">
        <span class="sidebar__title">Endpoints</span>
        <span class="sidebar__header-actions">
            <a
                href="{{ route('mock-api.panel.docs.index') }}"
                class="sidebar__new @if ($inDocs) sidebar__new--active @endif"
                aria-label="API documentation"
                title="API documentation"
            >
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 4.5A1.5 1.5 0 0 1 5.5 3H15a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5.5A1.5 1.5 0 0 1 4 15.5v-11Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M4 4.5A1.5 1.5 0 0 1 5.5 3H6v14h-.5A1.5 1.5 0 0 1 4 15.5v-11Z" fill="currentColor" fill-opacity="0.15" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
            </a>
            <a href="{{ route('mock-api.panel.mock-responses.create') }}" class="sidebar__new" aria-label="New endpoint" title="New endpoint">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </a>
        </span>
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
                href="{{ route($sidebarItemRoute, $item['id']) }}"
                class="sidebar__item @if ($isActive) sidebar__item--active @endif"
                data-sidebar-search="{{ strtolower($item['method'].' /'.$item['path'].' '.($item['description'] ?? '')) }}"
                @if ($isActive) aria-current="page" @endif
            >
                <span class="sidebar__item-row">
                    <span class="method-badge method-badge--{{ strtolower($item['method']) }}">{{ $item['method'] }}</span>
                    <span class="sidebar__item-path">/{{ $item['path'] }}</span>
                </span>
                @if (! empty($item['description']))
                    <span class="sidebar__item-description">{{ $item['description'] }}</span>
                @endif
            </a>
        @empty
            <p class="sidebar__empty">No endpoints yet — create your first one.</p>
        @endforelse
    </nav>
</aside>
