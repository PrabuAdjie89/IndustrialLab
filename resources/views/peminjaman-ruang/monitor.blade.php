<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Jadwal Ruangan Laboratorium</title>
    <link rel="icon" href="{{ asset('template') }}/assets/img/kaiadmin/lab.svg" type="image/x-icon"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/monitor-ruangan.css" />
</head>

<body class="dark">



    <div class="container-fluid px-4 py-4">

        <div class="tv-header mb-4">
            <div class="tv-header-left">
                <a href="{{ url('/home') }}" class="control-btn" title="Kembali ke Dashboard">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div class="tv-title-wrapper">
                    <i class="bi bi-tv display-5 me-3 text-primary"></i>

                    <div>
                        <div class="tv-title">JADWAL PENGGUNAAN RUANGAN</div>
                        <div class="tv-subtitle">SISTEM INFORMASI LABORATORIUM</div>
                        <div class="tv-date">{{ now()->translatedFormat('l, d F Y') }}</div>
                    </div>
                </div>
            </div>



            <div class="clock-container">

                <div class="icons" title="Ubah Tema Gelap/Terang">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </div>

                <div class="time">

                    <div class="time-colon">
                        <div class="time-text">
                            <span class="num hour_num">00</span>
                            <span class="text">Jam</span>
                        </div>

                        <span class="colon">:</span>
                    </div>

                    <div class="time-colon">
                        <div class="time-text">
                            <span class="num min_num">00</span>
                            <span class="text">Menit</span>
                        </div>

                        <span class="colon">:</span>
                    </div>

                    <div class="time-colon">
                        <div class="time-text">
                            <span class="num sec_num">00</span>
                            <span class="text">Detik</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="row g-4" id="schedule-container">

            @forelse ($jadwalHariIni as $item)

                @php
                    $status = $item->status_realtime;

                    $theme = match($status){
                        'dipakai'   => 'tv-dipakai',
                        'disetujui' => 'tv-disetujui',
                        'selesai'   => 'tv-selesai',
                        default     => 'tv-kosong'
                    };

                    $label = match($status){
                        'dipakai'   => 'SEDANG DIPAKAI',
                        'disetujui' => 'AKAN DIGUNAKAN',
                        'selesai'   => 'SELESAI',
                        default     => 'KOSONG'
                    };
                @endphp

                <div class="col-md-6 col-xl-4 d-flex align-items-stretch">

                    <div class="tv-card w-100 {{ $theme }}">

                        <div class="tv-card-header">
                            <h3>{{ $item->ruangan->nama_ruangan }}</h3>
                            <span class="tv-badge {{ $theme }}">{{ $label }}</span>
                        </div>

                        <div class="tv-card-body">

                            <div class="tv-time-range">
                                <i class="bi bi-clock me-2"></i>
                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                            </div>

                            <div class="tv-activity">
                                {{ $item->nama_kegiatan }}
                            </div>

                            <div class="tv-user">
                                <i class="bi bi-person-badge me-2"></i>
                                {{ $item->nama_peminjam }}
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <div class="display-1 text-muted mb-3">
                        <i class="bi bi-display"></i>
                    </div>

                    <h2>Tidak Ada Jadwal Berlangsung Hari Ini</h2>
                </div>

            @endforelse

        </div>

    </div>

    <script>

        const bodyTag = document.querySelector("body"),
              icons = document.querySelector(".icons");

        icons.onclick = () => {
            bodyTag.classList.toggle("dark");
        };

        setInterval(() => {

            let date = new Date(),
                hour = date.getHours(),
                min = date.getMinutes(),
                sec = date.getSeconds();

            hour = hour < 10 ? "0" + hour : hour;
            min = min < 10 ? "0" + min : min;
            sec = sec < 10 ? "0" + sec : sec;

            document.querySelector(".hour_num").innerText = hour;
            document.querySelector(".min_num").innerText = min;
            document.querySelector(".sec_num").innerText = sec;

        }, 1000);

        setInterval(() => location.reload(), 60000);

        function toggleFullScreen() {

            if (!document.fullscreenElement) {

                document.documentElement.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable full-screen mode: ${err.message}`);
                });

            } else {

                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }

            }

        }

        let scrollDirection = 1;
        const scrollSpeed = 1;
        const scrollInterval = 50;

        setInterval(() => {

            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

            if (maxScroll > 0) {

                window.scrollBy(0, scrollDirection * scrollSpeed);

                if (window.scrollY >= maxScroll - 1) {
                    scrollDirection = -1;
                } else if (window.scrollY <= 0) {
                    scrollDirection = 1;
                }

            }

        }, scrollInterval);

    </script>

</body>
</html>