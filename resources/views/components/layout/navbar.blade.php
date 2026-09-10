<nav class="navbar">
    <div class="container nav-content">
        <a href="{{ url('/') }}" class="brand-wrapper" style="text-decoration:none;">
            <img src="{{ asset('image/icon_2.png') }}" alt="Logo" class="nav-icon" />
            <div class="brand-text">
                <span class="brand-school">SMK N 1 DUKUHTURI</span>
                <span class="brand-name">EKSTRAKULIKULER MADING</span>
            </div>
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a></li>
            <li><a href="{{ url('/galeri') }}" class="{{ request()->is('galeri*') ? 'active' : '' }}">Galeri</a></li>
            <li><a href="{{ url('/tentang') }}" class="{{ request()->is('tentang*') ? 'active' : '' }}">Tentang</a></li>

            @guest
                <li>
                    <a href="{{ route('login') }}" style="color: #86868b;">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </a>
                </li>
            @endguest

            @auth
                <li><a href="{{ route('admin.berita.index') }}" style="color: var(--primary); font-weight: bold;">Kelola Berita</a></li>
                <li><a href="{{ route('admin.galeri.index') }}" style="color: var(--primary); font-weight: bold;">Kelola Galeri</a></li>
                <li><a href="{{ route('admin.anggota.index') }}" style="color: var(--primary); font-weight: bold;">Kelola Anggota</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #ff4d4d; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500; cursor: pointer; transition: 0.2s;">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
        <div class="hamburger" onclick="toggleMenu()" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </div>
    </div>
</nav>
