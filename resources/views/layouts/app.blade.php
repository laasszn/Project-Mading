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
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        @stack('styles')
    </head>
    <body oncontextmenu="return false;">
        <nav class="navbar">
            <div class="container nav-content">
                <div class="brand-wrapper">
                    <img src="{{ asset('image/icon_2.png') }}" alt="Logo" class="nav-icon" />
                    <div class="brand-text">
                        <span class="brand-school">SMK N 1 DUKUHTURI</span>
                        <span class="brand-name">EKSTRAKULIKULER MADING</span>
                    </div>
                </div>
                <ul class="nav-links" id="navLinks">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/berita') }}">Berita</a></li>
                    <li><a href="{{ url('/galeri') }}">Galeri</a></li>
                    <li><a href="{{ url('/tentang') }}">Tentang</a></li>

                    @guest
                        <li>
                            <a href="{{ route('login') }}" style="color: #86868b;">
                                <i class="fa-solid fa-right-to-bracket"></i> Login
                            </a>
                        </li>
                    @endguest

                    @auth
                        <li><a href="{{ route('admin.berita.index') }}" style="color: var(--primary-color); font-weight: bold;">Kelola Berita</a></li>
                        <li><a href="{{ route('admin.galeri.index') }}" style="color: var(--primary-color); font-weight: bold;">Kelola Galeri</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #ff4d4d; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500; cursor: pointer; transition: 0.2s;">
                                    Logout
                                </button>
                            </form>
                    @endauth
                </ul>
                <div class="hamburger" onclick="toggleMenu()">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </nav>
        @yield('content')
        <script src="{{ asset('js/script.js') }}"></script>
        @stack('scripts')
    </body>
</html>
