<x-filament-panels::page>
    <div id="react-session-app"></div>

    {{-- React & ReactDOM CDN / Local Asset --}}
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('react-session-app');
            if (container) {
                const root = ReactDOM.createRoot(container);
                root.render(
                    React.createElement(SessionLearningApp, {
                        initialData: @json($sessionData),
                        csrfToken: '{{ csrf_token() }}'
                    })
                );
            }
        });
    </script>
</x-filament-panels::page>