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
                --code-bg: #0f172a;
                --code-fg: #e2e8f0;
                --tok-key: #7dd3fc;
                --tok-string: #86efac;
                --tok-number: #fca5a5;
                --tok-boolean: #fdba74;
                --tok-null: #94a3b8;
            }
            @media (prefers-color-scheme: dark) {
                :root {
                    --bg: #0b1120;
                    --panel: #111827;
                    --border: #1f2937;
                    --fg: #e5e7eb;
                    --muted: #9ca3af;
                    --success-bg: #052e1f;
                    --success-border: #065f46;
                    --success-fg: #34d399;
                    --error-bg: #2c0b0b;
                    --error-border: #7f1d1d;
                    --error-fg: #f87171;
                    --code-bg: #05070d;
                }
            }
            * { box-sizing: border-box; }
            body {
                margin: 0;
                background: var(--bg);
                color: var(--fg);
                font: 14px/1.5 -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            }
            .container { max-width: 880px; margin: 0 auto; padding: 40px 24px; }
            .topbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
            h1 { font-size: 20px; margin: 0 0 4px; }
            .subtitle { color: var(--muted); font-size: 13px; margin: 0; }
            code { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 0.92em; }
            a { color: var(--accent); text-decoration: none; }
            a:hover { text-decoration: underline; }
            .btn {
                display: inline-flex; align-items: center; gap: 6px;
                border: 1px solid var(--border); background: var(--panel); color: var(--fg);
                padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 500;
                cursor: pointer; text-decoration: none;
            }
            .btn:hover { text-decoration: none; border-color: var(--accent); }
            .btn-primary { background: var(--accent); border-color: var(--accent); color: var(--accent-fg); }
            .btn-primary:hover { opacity: 0.92; }
            .btn-text { border: none; background: none; color: var(--muted); padding: 8px 4px; }
            .btn-danger-text { border: none; background: none; color: var(--danger); padding: 0; font-size: 13px; cursor: pointer; }
            .alert { border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 20px; border: 1px solid; }
            .alert-success { background: var(--success-bg); border-color: var(--success-border); color: var(--success-fg); }
            .alert-error { background: var(--error-bg); border-color: var(--error-border); color: var(--error-fg); }
            .alert ul { margin: 0; padding-left: 18px; }
            .panel { background: var(--panel); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
            table { width: 100%; border-collapse: collapse; }
            th, td { text-align: left; padding: 10px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
            th { color: var(--muted); font-weight: 600; background: color-mix(in srgb, var(--panel) 60%, var(--bg)); }
            tr:last-child td { border-bottom: none; }
            .method-badge {
                display: inline-block; font-family: ui-monospace, monospace; font-size: 11px; font-weight: 700;
                padding: 2px 6px; border-radius: 4px; background: color-mix(in srgb, var(--accent) 15%, transparent); color: var(--accent);
            }
            .empty-state { text-align: center; color: var(--muted); padding: 40px 16px; }
            form { margin: 0; }
            .field { margin-bottom: 18px; }
            .field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
            .field .hint { color: var(--muted); font-weight: 400; }
            .input, select.input {
                width: 100%; border: 1px solid var(--border); border-radius: 8px; background: var(--panel); color: var(--fg);
                padding: 8px 10px; font-size: 13px; font-family: inherit;
            }
            .input:focus, select.input:focus { outline: 2px solid var(--accent); outline-offset: -1px; border-color: var(--accent); }
            .input-sm { width: 120px; }
            .path-row { display: flex; align-items: center; gap: 6px; }
            .path-prefix { color: var(--muted); font-family: ui-monospace, monospace; font-size: 13px; }
            .path-row .input { font-family: ui-monospace, monospace; }
            .actions-row { display: flex; align-items: center; gap: 12px; margin-top: 24px; }

            .json-editor { position: relative; height: 320px; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; background: var(--code-bg); }
            .json-editor pre, .json-editor textarea {
                margin: 0; position: absolute; inset: 0; padding: 12px; overflow: auto;
                font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12.5px; line-height: 1.6;
                white-space: pre; tab-size: 4;
            }
            .json-editor__highlight { color: var(--code-fg); pointer-events: none; }
            .json-editor__textarea {
                width: 100%; height: 100%; resize: none; border: none; background: transparent; color: transparent;
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
        </style>
    </head>
    <body>
        <div class="container">
            @yield('content')
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
                            return true;
                        } catch (e) {
                            if (statusEl) {
                                statusEl.textContent = 'Invalid JSON — ' + e.message;
                                statusEl.className = 'json-status json-status--error';
                            }
                            return false;
                        }
                    }

                    function render() {
                        code.innerHTML = highlightJson(textarea.value) + '\n';
                        validate();
                    }

                    textarea.addEventListener('input', render);

                    textarea.addEventListener('scroll', function () {
                        highlight.scrollTop = textarea.scrollTop;
                        highlight.scrollLeft = textarea.scrollLeft;
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
            })();
        </script>
    </body>
</html>
