<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Mock API') — Panel</title>
        <style>
            :root {
                color-scheme: light dark;
                --bg: #f8fafc;
                --panel: #ffffff;
                --border: #e2e8f0;
                --fg: #0f172a;
                --muted: #64748b;
                --accent: #4f46e5;
                --accent-fg: #ffffff;
                --danger: #dc2626;
                --success-bg: #ecfdf5;
                --success-border: #a7f3d0;
                --success-fg: #047857;
                --error-bg: #fef2f2;
                --error-border: #fecaca;
                --error-fg: #b91c1c;
                --code-bg: #282c34;
                --code-fg: #abb2bf;
                --tok-key: #e06c75;
                --tok-string: #98c379;
                --tok-number: #d19a66;
                --tok-boolean: #56b6c2;
                --tok-null: #5c6370;
                --m-get: #2563eb;
                --m-post: #15803d;
                --m-put: #b45309;
                --m-patch: #7c3aed;
                --m-delete: #dc2626;
            }
            @media (prefers-color-scheme: dark) {
                :root {
                    /* Atom "One Dark" palette */
                    --bg: #282c34;
                    --panel: #21252b;
                    --border: #3b4048;
                    --fg: #abb2bf;
                    --muted: #5c6370;
                    --accent: #61afef;
                    --accent-fg: #282c34;
                    --danger: #e06c75;
                    --success-bg: #1f2b1d;
                    --success-border: #3f6d36;
                    --success-fg: #98c379;
                    --error-bg: #2d2020;
                    --error-border: #6f3a3f;
                    --error-fg: #e06c75;
                    --m-get: #61afef;
                    --m-post: #98c379;
                    --m-put: #d19a66;
                    --m-patch: #c678dd;
                    --m-delete: #e06c75;
                }
            }
            * { box-sizing: border-box; }
            html, body { height: 100%; }
            body {
                margin: 0;
                background: var(--bg);
                color: var(--fg);
                font: 14px/1.5 -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            }
            .app-shell { display: flex; min-height: 100vh; }
            .main { flex: 1; min-width: 0; }
            .container { max-width: 760px; margin: 0 auto; padding: 40px 24px; }
            .topbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
            h1 { font-size: 20px; margin: 0 0 4px; letter-spacing: -0.01em; }
            .subtitle { color: var(--muted); font-size: 13px; margin: 0; }
            code { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 0.92em; }
            a { color: var(--accent); text-decoration: none; }
            a:hover { text-decoration: underline; }
            a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible {
                outline: 2px solid var(--accent);
                outline-offset: 2px;
            }

            .sidebar {
                width: 272px; flex-shrink: 0; height: 100vh; position: sticky; top: 0; overflow-y: auto;
                background: var(--panel); border-right: 1px solid var(--border);
                display: flex; flex-direction: column;
            }
            .sidebar__header { display: flex; align-items: center; justify-content: space-between; padding: 18px 16px 12px; }
            .sidebar__title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); }
            .sidebar__new {
                display: inline-flex; align-items: center; justify-content: center;
                width: 26px; height: 26px; border-radius: 6px; color: var(--muted);
                transition: background-color 150ms ease, color 150ms ease;
            }
            .sidebar__new:hover { background: color-mix(in srgb, var(--fg) 8%, transparent); color: var(--accent); text-decoration: none; }
            .sidebar__new svg { width: 16px; height: 16px; }
            .sidebar__search { padding: 0 12px 12px; }
            .sidebar__search-input {
                width: 100%; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--fg);
                padding: 6px 10px; font-size: 12.5px; font-family: inherit;
            }
            .sidebar__search-input:focus { outline: none; border-color: var(--accent); }
            .sidebar__list { flex: 1; padding: 4px 8px 16px; display: flex; flex-direction: column; gap: 2px; }
            .sidebar__item {
                display: flex; align-items: center; gap: 8px; padding: 7px 8px; border-radius: 6px;
                color: var(--fg); text-decoration: none; font-size: 12.5px;
            }
            .sidebar__item:hover { background: color-mix(in srgb, var(--fg) 6%, transparent); text-decoration: none; }
            .sidebar__item--active { background: color-mix(in srgb, var(--accent) 12%, transparent); }
            .sidebar__item-path {
                overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; color: var(--muted);
            }
            .sidebar__item--active .sidebar__item-path { color: var(--fg); }
            .sidebar__empty { padding: 12px 16px; font-size: 12.5px; color: var(--muted); }
            @media (max-width: 768px) {
                .app-shell { flex-direction: column; }
                .sidebar { width: 100%; height: auto; max-height: 260px; position: static; border-right: none; border-bottom: 1px solid var(--border); }
            }

            .btn {
                display: inline-flex; align-items: center; justify-content: center; gap: 6px;
                border: 1px solid var(--border); background: var(--panel); color: var(--fg);
                padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
                cursor: pointer; text-decoration: none; line-height: 1.2;
                transition: border-color 150ms ease, background-color 150ms ease, opacity 150ms ease;
            }
            .btn:hover { text-decoration: none; border-color: var(--accent); }
            .btn:disabled { cursor: default; opacity: 0.6; }
            .btn-primary { background: var(--accent); border-color: var(--accent); color: var(--accent-fg); }
            .btn-primary:hover { opacity: 0.92; border-color: var(--accent); }
            .btn-secondary { background: var(--panel); border-color: var(--border); color: var(--fg); }
            .btn-secondary:hover { border-color: var(--muted); }
            .btn-text { border: none; background: none; color: var(--muted); padding: 8px 4px; }
            .btn-danger-text { border: none; background: none; color: var(--danger); padding: 0; font-size: 13px; cursor: pointer; }
            .alert { border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; border: 1px solid; }
            .alert-success { background: var(--success-bg); border-color: var(--success-border); color: var(--success-fg); }
            .alert-error { background: var(--error-bg); border-color: var(--error-border); color: var(--error-fg); }
            .alert ul { margin: 6px 0 0; padding-left: 18px; }
            .alert a { color: inherit; font-weight: 600; text-decoration: underline; }
            .panel { background: var(--panel); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
            table { width: 100%; border-collapse: collapse; }
            th, td { text-align: left; padding: 10px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
            th { color: var(--muted); font-weight: 600; background: color-mix(in srgb, var(--panel) 60%, var(--bg)); }
            tr:last-child td { border-bottom: none; }
            .method-badge {
                display: inline-block; font-family: ui-monospace, monospace; font-size: 11px; font-weight: 700;
                padding: 2px 6px; border-radius: 4px; background: color-mix(in srgb, var(--accent) 15%, transparent); color: var(--accent);
            }
            .method-badge--get { background: color-mix(in srgb, var(--m-get) 15%, transparent); color: var(--m-get); }
            .method-badge--post { background: color-mix(in srgb, var(--m-post) 15%, transparent); color: var(--m-post); }
            .method-badge--put { background: color-mix(in srgb, var(--m-put) 15%, transparent); color: var(--m-put); }
            .method-badge--patch { background: color-mix(in srgb, var(--m-patch) 15%, transparent); color: var(--m-patch); }
            .method-badge--delete { background: color-mix(in srgb, var(--m-delete) 15%, transparent); color: var(--m-delete); }
            .empty-state { text-align: center; color: var(--muted); padding: 40px 16px; }
            form { margin: 0; }
            .field { margin-bottom: 18px; }
            .field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
            .hint { color: var(--muted); font-weight: 400; }
            .required { color: var(--danger); margin-left: 2px; }
            .field-error {
                display: flex; align-items: flex-start; gap: 5px;
                color: var(--error-fg); font-size: 12px; margin: 6px 0 0;
            }
            .input, select.input {
                width: 100%; border: 1px solid var(--border); border-radius: 8px; background: var(--panel); color: var(--fg);
                padding: 9px 12px; font-size: 13px; font-family: inherit;
                transition: border-color 150ms ease, box-shadow 150ms ease;
            }
            .input:focus, select.input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 20%, transparent); }
            .input.is-invalid { border-color: var(--danger); }
            .input.is-invalid:focus { box-shadow: 0 0 0 3px color-mix(in srgb, var(--danger) 20%, transparent); }

            .form-section + .form-section { margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--border); }
            .form-section__title {
                font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
                color: var(--muted); margin: 0 0 18px;
            }

            .request-line { display: flex; align-items: stretch; gap: 10px; }
            @media (max-width: 640px) {
                .request-line { flex-direction: column; }
            }

            select.method-dropdown {
                flex-shrink: 0; width: 120px; height: 40px;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
                font-size: 12.5px; font-weight: 700; letter-spacing: 0.02em;
                cursor: pointer; background-position: right 10px center;
            }
            @media (max-width: 640px) { select.method-dropdown { width: 100%; } }
            .method-dropdown--get { color: var(--m-get); border-color: color-mix(in srgb, var(--m-get) 45%, var(--border)); }
            .method-dropdown--post { color: var(--m-post); border-color: color-mix(in srgb, var(--m-post) 45%, var(--border)); }
            .method-dropdown--put { color: var(--m-put); border-color: color-mix(in srgb, var(--m-put) 45%, var(--border)); }
            .method-dropdown--patch { color: var(--m-patch); border-color: color-mix(in srgb, var(--m-patch) 45%, var(--border)); }
            .method-dropdown--delete { color: var(--m-delete); border-color: color-mix(in srgb, var(--m-delete) 45%, var(--border)); }

            .url-bar {
                display: flex; align-items: center; flex: 1; min-width: 0; height: 40px;
                border: 1px solid var(--border); border-radius: 8px; background: var(--panel); padding: 0 12px;
                transition: border-color 150ms ease, box-shadow 150ms ease;
            }
            .url-bar:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 20%, transparent); }
            .url-bar--invalid { border-color: var(--danger); }
            .url-bar--invalid:focus-within { box-shadow: 0 0 0 3px color-mix(in srgb, var(--danger) 20%, transparent); }
            .url-bar__prefix { color: var(--muted); font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 13px; white-space: nowrap; }
            .url-bar__input {
                flex: 1; min-width: 0; height: 100%; border: none; background: transparent; color: var(--fg);
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 13px; padding: 0 0 0 2px;
            }
            .url-bar__input:focus { outline: none; }
            .url-bar__preview { margin: 8px 0 0; font-size: 12px; color: var(--muted); }
            .url-bar__preview-link {
                display: inline-flex; align-items: center; gap: 4px; color: inherit;
            }
            .url-bar__preview-link:hover { color: var(--accent); text-decoration: none; }
            .url-bar__preview-link code {
                color: var(--fg); background: color-mix(in srgb, var(--accent) 8%, transparent);
                padding: 1px 6px; border-radius: 4px; transition: color 150ms ease;
            }
            .url-bar__preview-link:hover code { color: var(--accent); }
            .url-bar__preview-link .external-icon { width: 12px; height: 12px; flex-shrink: 0; }

            .status-field { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
            select.status-select { flex: 1; min-width: 220px; width: auto; height: 40px; cursor: pointer; }
            input.status-custom-input { flex: 1; min-width: 120px; width: auto; }

            .panel-tabs__list { display: flex; gap: 20px; border-bottom: 1px solid var(--border); margin-bottom: 16px; }
            .panel-tabs__tab {
                appearance: none; border: none; background: none; cursor: pointer;
                display: flex; align-items: center; gap: 6px;
                padding: 0 0 10px; margin-bottom: -1px;
                font-size: 13px; font-weight: 600; font-family: inherit; color: var(--muted);
                border-bottom: 2px solid transparent;
                transition: color 150ms ease, border-color 150ms ease;
            }
            .panel-tabs__tab:hover { color: var(--fg); }
            .panel-tabs__tab[aria-selected="true"] { color: var(--accent); border-bottom-color: var(--accent); }
            .tab-count {
                display: inline-flex; align-items: center; justify-content: center;
                min-width: 18px; height: 18px; padding: 0 5px; border-radius: 999px;
                font-size: 11px; font-weight: 700;
                background: color-mix(in srgb, var(--accent) 15%, transparent); color: var(--accent);
            }
            [data-tab-panel][hidden] { display: none; }

            .actions-row { display: flex; align-items: center; gap: 12px; margin-top: 24px; }

            .json-editor { position: relative; height: 320px; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; background: var(--code-bg); transition: border-color 150ms ease; }
            .json-editor--invalid { border-color: var(--danger); }
            .json-editor__gutter {
                position: absolute; top: 0; left: 0; bottom: 0; width: 44px; padding: 12px 8px;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12.5px; line-height: 1.6;
                white-space: pre; text-align: right; overflow: hidden; user-select: none;
                color: color-mix(in srgb, var(--code-fg) 40%, transparent);
                background: color-mix(in srgb, black 15%, var(--code-bg));
                border-right: 1px solid color-mix(in srgb, var(--code-fg) 15%, transparent);
            }
            .json-editor pre, .json-editor textarea {
                margin: 0; position: absolute; top: 0; right: 0; bottom: 0; left: 44px; padding: 12px; overflow: auto;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12.5px; line-height: 1.6;
                white-space: pre; tab-size: 4;
            }
            .json-editor__highlight { color: var(--code-fg); pointer-events: none; }
            .json-editor__textarea {
                width: calc(100% - 44px); height: 100%; resize: none; border: none; background: transparent; color: transparent;
                caret-color: #fff;
            }
            .json-editor__textarea:focus { outline: none; }
            .tok-key { color: var(--tok-key); }
            .tok-string { color: var(--tok-string); }
            .tok-number { color: var(--tok-number); }
            .tok-boolean { color: var(--tok-boolean); }
            .tok-null { color: var(--tok-null); font-style: italic; }
            .json-toolbar { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; }
            .json-status { font-size: 12px; }
            .json-status--ok { color: var(--success-fg); }
            .json-status--error { color: var(--error-fg); }

            .app-footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); text-align: center; }
            .app-footer a { color: var(--muted); text-decoration: underline; }
            .app-footer a:hover { color: var(--accent); }
        </style>
    </head>
    <body>
        <div class="app-shell">
            @isset($entries)
                @include('mock-api::panel.mock-responses._sidebar')
            @endisset

            <div class="main">
                <div class="container">
                    @yield('content')

                    <footer class="app-footer">
                        Built by <a href="https://mm.linkedin.com/in/saimain" target="_blank" rel="noopener noreferrer">justsaimain</a>
                    </footer>
                </div>
            </div>
        </div>

        <script>
            (function () {
                function escapeHtml(str) {
                    return str
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                }

                function highlightJson(source) {
                    var escaped = escapeHtml(source);

                    return escaped.replace(
                        /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false)\b|\bnull\b|-?\d+(?:\.\d+)?(?:[eE][+-]?\d+)?)/g,
                        function (match) {
                            var cls = 'tok-number';

                            if (/^"/.test(match)) {
                                cls = /:$/.test(match) ? 'tok-key' : 'tok-string';
                            } else if (/^(true|false)$/.test(match)) {
                                cls = 'tok-boolean';
                            } else if (match === 'null') {
                                cls = 'tok-null';
                            }

                            return '<span class="' + cls + '">' + match + '</span>';
                        }
                    );
                }

                function initEditor(root) {
                    var textarea = root.querySelector('.json-editor__textarea');
                    var highlight = root.querySelector('.json-editor__highlight');
                    var gutter = root.querySelector('.json-editor__gutter');
                    var code = highlight.querySelector('code');
                    var statusEl = root.parentElement.querySelector('[data-json-status]');
                    var formatBtn = root.parentElement.querySelector('[data-json-format]');

                    function validate() {
                        try {
                            JSON.parse(textarea.value);
                            if (statusEl) {
                                statusEl.textContent = 'Valid JSON';
                                statusEl.className = 'json-status json-status--ok';
                            }
                            root.classList.remove('json-editor--invalid');
                            return true;
                        } catch (e) {
                            if (statusEl) {
                                statusEl.textContent = 'Invalid JSON — ' + e.message;
                                statusEl.className = 'json-status json-status--error';
                            }
                            root.classList.add('json-editor--invalid');
                            return false;
                        }
                    }

                    function renderGutter() {
                        if (! gutter) return;

                        var lineCount = textarea.value.split('\n').length;
                        var lines = [];

                        for (var i = 1; i <= lineCount; i++) {
                            lines.push(i);
                        }

                        gutter.textContent = lines.join('\n');
                    }

                    function render() {
                        code.innerHTML = highlightJson(textarea.value) + '\n';
                        renderGutter();
                        validate();
                    }

                    textarea.addEventListener('input', render);

                    textarea.addEventListener('scroll', function () {
                        highlight.scrollTop = textarea.scrollTop;
                        highlight.scrollLeft = textarea.scrollLeft;
                        if (gutter) gutter.scrollTop = textarea.scrollTop;
                    });

                    textarea.addEventListener('keydown', function (e) {
                        if (e.key === 'Tab') {
                            e.preventDefault();
                            var start = textarea.selectionStart;
                            var end = textarea.selectionEnd;
                            textarea.value = textarea.value.slice(0, start) + '    ' + textarea.value.slice(end);
                            textarea.selectionStart = textarea.selectionEnd = start + 4;
                            render();
                        }
                    });

                    if (formatBtn) {
                        formatBtn.addEventListener('click', function () {
                            try {
                                textarea.value = JSON.stringify(JSON.parse(textarea.value), null, 4);
                                render();
                            } catch (e) {
                                if (statusEl) {
                                    statusEl.textContent = 'Cannot format — ' + e.message;
                                    statusEl.className = 'json-status json-status--error';
                                }
                            }
                        });
                    }

                    render();
                }

                document.querySelectorAll('.json-editor').forEach(initEditor);

                var methodSelect = document.getElementById('method');

                if (methodSelect) {
                    function updateMethodColor() {
                        methodSelect.className = 'input method-dropdown method-dropdown--' + methodSelect.value.toLowerCase();
                    }

                    methodSelect.addEventListener('change', updateMethodColor);
                    updateMethodColor();
                }

                var sidebarFilter = document.querySelector('[data-sidebar-filter]');

                if (sidebarFilter) {
                    var sidebarItems = Array.prototype.slice.call(document.querySelectorAll('.sidebar__item'));

                    sidebarFilter.addEventListener('input', function () {
                        var query = sidebarFilter.value.trim().toLowerCase();

                        sidebarItems.forEach(function (item) {
                            var matches = item.getAttribute('data-sidebar-search').indexOf(query) !== -1;
                            item.style.display = matches ? '' : 'none';
                        });
                    });
                }

                var statusSelect = document.getElementById('status-select');
                var statusCustomInput = document.getElementById('status');
                var statusLabel = document.querySelector('[data-status-label]');

                if (statusSelect && statusCustomInput) {
                    function syncStatusMode(focusCustom) {
                        var isCustom = statusSelect.value === 'custom';

                        if (isCustom) {
                            statusSelect.removeAttribute('name');
                            statusCustomInput.setAttribute('name', 'status');
                            statusCustomInput.hidden = false;
                            if (focusCustom) statusCustomInput.focus();
                        } else {
                            statusSelect.setAttribute('name', 'status');
                            statusCustomInput.removeAttribute('name');
                            statusCustomInput.hidden = true;
                        }

                        if (statusLabel) statusLabel.setAttribute('for', isCustom ? 'status' : 'status-select');
                    }

                    statusSelect.addEventListener('change', function () { syncStatusMode(true); });
                    syncStatusMode(false);
                }

                var pathInput = document.getElementById('path');
                var pathPreviewLink = document.querySelector('[data-path-preview]');
                var pathPreviewCode = pathPreviewLink ? pathPreviewLink.querySelector('code') : null;

                if (pathInput && pathPreviewLink && pathPreviewCode) {
                    var prefix = pathPreviewLink.getAttribute('data-prefix') || '/';
                    var baseUrl = pathPreviewLink.getAttribute('data-base-url') || '';

                    function updatePathPreview() {
                        var suffix = prefix + pathInput.value.replace(/^\/+/, '');
                        pathPreviewCode.textContent = suffix;
                        pathPreviewLink.href = baseUrl + suffix;
                    }

                    pathInput.addEventListener('input', updatePathPreview);
                    updatePathPreview();
                }

                document.querySelectorAll('[data-tabs]').forEach(function (root) {
                    var tabs = Array.prototype.slice.call(root.querySelectorAll('[role="tab"]'));

                    function activate(tab, focus) {
                        tabs.forEach(function (t) {
                            var selected = t === tab;
                            t.setAttribute('aria-selected', selected ? 'true' : 'false');
                            t.tabIndex = selected ? 0 : -1;

                            var panel = document.getElementById(t.getAttribute('aria-controls'));
                            if (panel) panel.hidden = !selected;
                        });

                        if (focus) tab.focus();
                    }

                    tabs.forEach(function (tab, index) {
                        tab.addEventListener('click', function () {
                            activate(tab, false);
                        });

                        tab.addEventListener('keydown', function (e) {
                            var newIndex = null;

                            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') newIndex = (index + 1) % tabs.length;
                            if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') newIndex = (index - 1 + tabs.length) % tabs.length;
                            if (e.key === 'Home') newIndex = 0;
                            if (e.key === 'End') newIndex = tabs.length - 1;

                            if (newIndex !== null) {
                                e.preventDefault();
                                activate(tabs[newIndex], true);
                            }
                        });
                    });
                });

                document.querySelectorAll('.alert-error a[href^="#"]').forEach(function (link) {
                    link.addEventListener('click', function () {
                        var target = document.getElementById(link.getAttribute('href').slice(1));
                        if (!target) return;

                        var panel = target.closest('[data-tab-panel]');
                        if (panel && panel.hidden) {
                            var tabBtn = document.getElementById(panel.getAttribute('aria-labelledby'));
                            if (tabBtn) tabBtn.click();
                        }
                    });
                });

                var firstInvalid = document.querySelector('.is-invalid, [aria-invalid="true"]');
                if (firstInvalid) {
                    var invalidPanel = firstInvalid.closest('[data-tab-panel]');
                    if (invalidPanel && invalidPanel.hidden) {
                        var invalidTabBtn = document.getElementById(invalidPanel.getAttribute('aria-labelledby'));
                        if (invalidTabBtn) invalidTabBtn.click();
                    }
                    firstInvalid.focus();
                }

                var primaryButtons = Array.prototype.slice.call(document.querySelectorAll('button.btn-primary[type="submit"]'));

                document.querySelectorAll('form').forEach(function (form) {
                    form.addEventListener('submit', function () {
                        var btn = primaryButtons.filter(function (b) { return b.form === form; })[0];
                        if (btn && !btn.disabled) {
                            btn.textContent = 'Saving…';
                            btn.disabled = true;
                        }
                    });
                });
            })();
        </script>
    </body>
</html>
