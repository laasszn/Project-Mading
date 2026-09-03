@extends('layouts.app')

@section('title', 'Profil Mading - SMK N 1 Dukuhturi')

@push('styles')
    <style>
        body { background-image: none !important; background-color: #121212 !important; font-family: "Poppins", sans-serif; opacity: 1 !important; transform: none !important; }

        /* HERO */
        .profile-hero {
            position: relative;
            text-align: center;
            padding: 80px 20px 60px;
            overflow: hidden;
        }
        .profile-hero::before {
            content: "";
            position: absolute;
            top: -100px; left: 50%; transform: translateX(-50%);
            width: 600px; height: 400px;
            background: radial-gradient(circle, rgba(41, 151, 255, 0.18) 0%, transparent 70%);
            z-index: 0;
        }
        .profile-hero .eyebrow {
            position: relative; z-index: 1;
            display: inline-block; color: var(--primary); background: rgba(41, 151, 255, 0.1);
            border: 1px solid rgba(41, 151, 255, 0.3); padding: 6px 18px; border-radius: 30px;
            font-size: 0.8rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 20px;
        }
        .profile-hero h1 { position: relative; z-index: 1; color: #fff; font-size: 2.6rem; font-weight: 800; margin-bottom: 15px; }
        .profile-hero p { position: relative; z-index: 1; color: #999; font-size: 1.05rem; max-width: 600px; margin: 0 auto; line-height: 1.7; }

        /* STATS */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
            max-width: 900px; margin: 50px auto 70px;
        }
        .stat-box { text-align: center; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; padding: 25px 15px; }
        .stat-box .num { color: var(--primary); font-size: 2rem; font-weight: 800; }
        .stat-box .label { color: #999; font-size: 0.8rem; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* SEJARAH */
        .intro-section {
            background: linear-gradient(145deg, rgba(30, 30, 30, 0.8), rgba(20, 20, 20, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px;
            padding: 40px; margin-bottom: 40px; position: relative; overflow: hidden;
        }
        .intro-section::before { content: ""; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--primary); }
        .intro-section h2 { color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .intro-section p { color: #ccc; line-height: 1.8; }

        /* VISI MISI */
        .vm-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 25px; margin-bottom: 60px; }
        .vm-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; padding: 30px; height: 100%; transition: 0.3s; }
        .vm-card:hover { background: rgba(255, 255, 255, 0.06); border-color: rgba(255, 255, 255, 0.2); transform: translateY(-5px); }
        .vm-title { color: var(--primary); font-size: 1.5rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .misi-list { list-style: none; padding: 0; }
        .misi-list li { position: relative; padding-left: 25px; margin-bottom: 12px; color: #ccc; }
        .misi-list li::before { content: "\f00c"; font-family: "Font Awesome 6 Free"; font-weight: 900; position: absolute; left: 0; top: 2px; color: var(--primary); }

        /* DIVISI / BIDANG */
        .divisi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px; margin-bottom: 60px; }
        .divisi-card {
            background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 14px; padding: 25px;
            transition: 0.3s;
        }
        .divisi-card:hover { border-color: var(--primary); transform: translateY(-4px); box-shadow: 0 10px 25px rgba(41,151,255,0.15); }
        .divisi-icon {
            width: 46px; height: 46px; border-radius: 12px; background: rgba(41,151,255,0.12);
            color: var(--primary); display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 15px;
        }
        .divisi-card h4 { color: #fff; font-size: 1.05rem; margin-bottom: 8px; }
        .divisi-card p { color: #999; font-size: 0.85rem; line-height: 1.6; }

        /* STRUKTUR ORGANISASI */
        .org-container { position: relative; padding-top: 20px; }
        .org-level { display: flex; justify-content: center; flex-wrap: wrap; gap: 30px; margin-bottom: 45px; position: relative; z-index: 2; }
        .profile-card {
            background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 14px; padding: 22px;
            width: 210px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); transition: 0.3s;
        }
        .profile-card:hover { transform: translateY(-6px); border-color: var(--primary); box-shadow: 0 10px 25px rgba(41, 151, 255, 0.2); }
        .profile-img {
            display: block; margin: 0 auto 15px; width: 78px; height: 78px;
            border-radius: 50%; border: 2px solid var(--primary); object-fit: cover; background: #000;
        }
        .p-name { color: white; font-weight: 700; font-size: 1rem; margin-bottom: 4px; }
        .p-role { color: #888; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .p-role.highlight { color: var(--primary); }
        .divisi-heading { text-align: center; color: #aaa; margin-bottom: 20px; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; }

        @media (max-width: 768px) {
            .vm-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .org-level { gap: 15px; }
            .profile-card { width: 100%; max-width: 250px; }
            .profile-hero h1 { font-size: 2rem; }
        }
    </style>
@endpush

@section('content')
    <div class="ambient-bg">
        <div class="light-blob-1"></div>
        <div class="light-blob-2"></div>
    </div>

    <div class="profile-hero">
        <span class="eyebrow">Profil Ekstrakurikuler</span>
        <h1>Smezine</h1>
        <p>Kreativitas Tanpa Batas, Literasi Berkualitas — wadah siswa SMK N 1 Dukuhturi untuk berkarya lewat tulisan, desain, dan media digital.</p>
    </div>

    <div class="stats-row">
        <div class="stat-box"><div class="num">2010</div><div class="label">Didirikan</div></div>
        <div class="stat-box"><div class="num">15+</div><div class="label">Tahun Berkarya</div></div>
        <div class="stat-box"><div class="num">4</div><div class="label">Divisi Aktif</div></div>
        <div class="stat-box"><div class="num">50+</div><div class="label">Anggota</div></div>
    </div>

    <div class="container" style="padding-bottom: 80px">
        <div class="intro-section">
            <h2><i class="fa-solid fa-clock-rotate-left"></i> Sejarah Singkat</h2>
            <p>
                Ekstrakurikuler Mading (Smezine) SMK N 1 Dukuhturi didirikan pada tahun 2010. Awalnya, kami hanya berfokus pada majalah dinding tempel konvensional yang terbit setiap bulan.
                <br /><br />
                Seiring perkembangan teknologi, pada tahun 2020 kami mulai merambah ke dunia digital dengan mengembangkan <strong>Mading 3D, E-Magazine, dan Jurnalistik Website</strong>. Kini, Smezine menjadi wadah utama bagi siswa untuk menyalurkan bakat di bidang desain grafis, fotografi, videografi, dan kepenulisan.
            </p>
        </div>

        <div class="vm-grid">
            <div class="vm-card">
                <div class="vm-title"><i class="fa-solid fa-eye"></i> Visi</div>
                <p style="font-size: 1.05rem; color: white; line-height: 1.6; font-style: italic;">
                    "Mewujudkan generasi muda yang kritis, kreatif, dan inovatif melalui budaya literasi serta penguasaan teknologi media digital."
                </p>
            </div>
            <div class="vm-card">
                <div class="vm-title"><i class="fa-solid fa-list-check"></i> Misi</div>
                <ul class="misi-list">
                    <li>Mengembangkan kemampuan jurnalistik dan reportase siswa.</li>
                    <li>Meningkatkan skill desain grafis dan multimedia anggota.</li>
                    <li>Menyajikan informasi sekolah yang akurat dan menarik.</li>
                    <li>Berpartisipasi aktif dalam kompetisi mading tingkat daerah & nasional.</li>
                </ul>
            </div>
        </div>

        <div class="section-title text-center" style="margin-bottom: 30px; text-align: center">
            <h2 style="color: white">Bidang Kegiatan</h2>
            <p style="color: var(--primary)">Ruang berkarya untuk setiap minat</p>
        </div>

        <div class="divisi-grid">
            <div class="divisi-card">
                <div class="divisi-icon"><i class="fa-solid fa-pen-nib"></i></div>
                <h4>Jurnalistik</h4>
                <p>Reportase kegiatan sekolah, penulisan artikel, dan wawancara narasumber.</p>
            </div>
            <div class="divisi-card">
                <div class="divisi-icon"><i class="fa-solid fa-palette"></i></div>
                <h4>Desain Grafis</h4>
                <p>Ilustrasi, layout mading, dan visual untuk publikasi digital maupun cetak.</p>
            </div>
            <div class="divisi-card">
                <div class="divisi-icon"><i class="fa-solid fa-camera"></i></div>
                <h4>Fotografi & Videografi</h4>
                <p>Dokumentasi kegiatan sekolah dalam bentuk foto dan video singkat.</p>
            </div>
            <div class="divisi-card">
                <div class="divisi-icon"><i class="fa-solid fa-laptop-code"></i></div>
                <h4>Media Digital</h4>
                <p>Mengelola website dan media sosial Smezine agar tetap update.</p>
            </div>
        </div>

        <div class="section-title text-center" style="margin-bottom: 40px; text-align: center">
            <h2 style="color: white">Struktur Organisasi</h2>
            <p style="color: var(--primary)">Periode 2025/2026</p>
        </div>

        <div class="org-container">
            <div class="org-level">
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Ketua+Umum&background=2997ff&color=fff&size=128" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role highlight">Ketua Umum</div>
                </div>
            </div>

            <div class="org-level">
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Ketua+1&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Ketua 1</div>
                </div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Ketua+2&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Ketua 2</div>
                </div>
            </div>

            <div class="org-level">
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Sekre+1&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Sekretaris 1</div>
                </div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Sekre+2&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Sekretaris 2</div>
                </div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Bendahara+1&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Bendahara 1</div>
                </div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=Bendahara+2&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Bendahara 2</div>
                </div>
            </div>

            <h4 class="divisi-heading">Divisi PDD</h4>
            <div class="org-level">
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=PDD+1&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Koord. PDD</div>
                </div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name=PDD+2&background=333&color=fff" alt="Foto" class="profile-img" />
                    <div class="p-name">Nama Siswa</div>
                    <div class="p-role">Anggota PDD</div>
                </div>
            </div>
        </div>
    </div>
@endsection
