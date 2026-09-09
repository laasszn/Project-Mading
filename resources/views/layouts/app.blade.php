<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Mading SMK N 1 Dukuhturi</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            rel="stylesheet"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            // Terapkan tema tersimpan sebelum paint agar tidak flicker.
            try {
                document.documentElement.dataset.theme = localStorage.getItem('smezine-theme') || 'dark';
            } catch (e) {
                document.documentElement.dataset.theme = 'dark';
            }
        </script>
        @stack('styles')
    </head>
    <body oncontextmenu="return false;">
        <x-layout.navbar />
        <x-theme-toggle />
        @yield('content')
        <x-layout.footer />
        @stack('scripts')
    </body>
</html>
