<!DOCTYPE html>
<html>

<head>
    <title>Booking Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        {{-- Mengambil dari file sidebar.blade --}}
        @include('components.sidebar.sidebar')

        <main class="main-content-with-sidebar" id="main-content">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Ambil section scripts dari sidebar.js --}}
    @yield('scripts')
</body>

</html>
