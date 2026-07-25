<x-filament-widgets::widget>
    <div id="react-material-grid-app"></div>

    {{-- Script React CDN --}}
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('react-material-grid-app');
            if (container && typeof MaterialGridCards !== 'undefined') {
                const root = ReactDOM.createRoot(container);
                root.render(
                    React.createElement(MaterialGridCards, {
                        initialData: @json($sessionData),
                        csrfToken: '{{ csrf_token() }}'
                    })
                );
            }
        });
    </script>
</x-filament-widgets::widget>