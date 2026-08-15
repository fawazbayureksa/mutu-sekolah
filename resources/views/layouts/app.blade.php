<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Penjaminan Mutu SMK Bidang KPTK - BPPMPV')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- write icon here --}}
    <link rel="icon" href="{{ asset('images/tut-wuri-handayani.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @stack('styles')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BPPMPV KPTK" height="40" class="me-2">
                    {{-- <span>BPPMPV KPTK</span> --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ruang-lingkup">Ruang Lingkup</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tujuan">Tujuan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#landasan-hukum">Landasan Hukum</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-4 mt-auto" style="position:relative;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small">&copy; 2026 BPPMPV KPTK. Seluruh hak cipta dilindungi.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <small>Badan Pengembangan Penjaminan Mutu Pendidikan Vokasi</small>
                </div>
            </div>
        </div>

        {{-- Hidden admin backup trigger — only rendered for admin role --}}
        @if (auth()->check() && auth()->user()->role === 'admin')
            <button id="backup-trigger-btn" type="button" title="" aria-label="Admin Database Backup"
                onclick="document.getElementById('backupModal').style.display='flex'"
                style="
                position: absolute;
                bottom: 10px;
                right: 14px;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                border: none;
                background: rgba(255,255,255,0.08);
                cursor: pointer;
                padding: 0;
                transition: background 0.3s, transform 0.3s;
                outline: none;
            "
                onmouseover="this.style.background='rgba(255,255,255,0.35)';this.style.transform='scale(1.8)'"
                onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.transform='scale(1)'"></button>
        @endif
    </footer>

    {{-- ===================== BACKUP MODAL (admin only) ===================== --}}
    @if (auth()->check() && auth()->user()->role === 'admin')
        <div id="backupModal"
            style="
        display: none;
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
        padding: 1rem;
        font-family: 'Poppins', sans-serif;
    "
            onclick="if(event.target===this)closeBackupModal()">
            <div
                style="
            background: #1a1a2e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            width: 100%;
            max-width: 560px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.6);
            animation: backupSlideIn 0.25s ease;
        ">
                {{-- Header --}}
                <div
                    style="padding:20px 24px 16px; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; gap:12px;">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                            stroke="rgba(255,255,255,0.7)" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7M9 11l3 3 3-3M12 3v11" />
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <div style="color:#fff;font-weight:600;font-size:0.95rem;letter-spacing:-0.01em;">Database
                            Backup</div>
                        <div style="color:rgba(255,255,255,0.4);font-size:0.72rem;margin-top:1px;">Admin only &bull;
                            Akses terbatas</div>
                    </div>
                    <button onclick="closeBackupModal()"
                        style="background:none;border:none;color:rgba(255,255,255,0.4);cursor:pointer;font-size:1.2rem;padding:4px;line-height:1;border-radius:6px;transition:color 0.2s;"
                        onmouseover="this.style.color='#fff'"
                        onmouseout="this.style.color='rgba(255,255,255,0.4)'">&times;</button>
                </div>

                {{-- Tabs --}}
                <div style="display:flex;border-bottom:1px solid rgba(255,255,255,0.08);padding:0 24px;">
                    <button id="tab-files-btn" onclick="switchTab('files')"
                        style="background:none;border:none;color:#fff;font-size:0.8rem;padding:12px 0;margin-right:24px;cursor:pointer;border-bottom:2px solid #fff;font-family:inherit;font-weight:500;transition:color 0.2s;opacity:1;">
                        Daftar Backup
                    </button>
                    <button id="tab-trigger-btn" onclick="switchTab('trigger')"
                        style="background:none;border:none;color:rgba(255,255,255,0.45);font-size:0.8rem;padding:12px 0;cursor:pointer;border-bottom:2px solid transparent;font-family:inherit;font-weight:500;transition:color 0.2s;opacity:1;">
                        Buat Backup Baru
                    </button>
                </div>

                {{-- Tab: File List --}}
                <div id="tab-files" style="flex:1;overflow-y:auto;padding:16px 24px;">
                    <div id="backup-files-loading"
                        style="text-align:center;padding:32px 0;color:rgba(255,255,255,0.35);font-size:0.8rem;">
                        <div
                            style="width:24px;height:24px;border:2px solid rgba(255,255,255,0.15);border-top-color:rgba(255,255,255,0.6);border-radius:50%;animation:backupSpin 0.7s linear infinite;margin:0 auto 12px;">
                        </div>
                        Memuat daftar backup...
                    </div>
                    <div id="backup-files-list" style="display:none;"></div>
                    <div id="backup-files-empty"
                        style="display:none;text-align:center;padding:32px 0;color:rgba(255,255,255,0.3);font-size:0.8rem;">
                        Tidak ada file backup ditemukan.<br><span style="font-size:0.72rem;">Buat backup baru dari tab
                            "Buat Backup Baru".</span>
                    </div>
                    <div id="backup-files-error"
                        style="display:none;text-align:center;padding:24px;color:#f87171;font-size:0.8rem;background:rgba(248,113,113,0.08);border-radius:8px;margin-top:8px;">
                    </div>
                </div>

                {{-- Tab: Trigger New Backup --}}
                <div id="tab-trigger" style="display:none;padding:20px 24px;">
                    <p style="color:rgba(255,255,255,0.55);font-size:0.78rem;margin-bottom:16px;line-height:1.6;">
                        Jalankan script backup di background server. Proses ini tidak memblokir server dan file akan
                        muncul di daftar dalam beberapa menit.
                    </p>

                    <div id="trigger-alert"
                        style="display:none;padding:12px 16px;border-radius:8px;font-size:0.78rem;margin-bottom:16px;">
                    </div>

                    <form id="backup-trigger-form" onsubmit="submitTrigger(event)">
                        @csrf
                        <label
                            style="display:block;color:rgba(255,255,255,0.6);font-size:0.75rem;margin-bottom:6px;font-weight:500;">Konfirmasi
                            Password Admin</label>
                        <input type="password" id="backup-password" name="password"
                            placeholder="Masukkan password Anda" autocomplete="current-password" required
                            style="
                            width:100%;padding:10px 14px;
                            background:rgba(255,255,255,0.06);
                            border:1px solid rgba(255,255,255,0.12);
                            border-radius:8px;color:#fff;
                            font-size:0.82rem;font-family:inherit;
                            outline:none;transition:border-color 0.2s;
                            box-sizing:border-box;
                        "
                            onfocus="this.style.borderColor='rgba(255,255,255,0.4)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                        <button type="submit" id="trigger-submit-btn"
                            style="
                            margin-top:14px;width:100%;
                            padding:11px;border:none;border-radius:8px;
                            background:rgba(255,255,255,0.1);color:#fff;
                            font-size:0.82rem;font-family:inherit;font-weight:500;
                            cursor:pointer;transition:background 0.2s;
                            display:flex;align-items:center;justify-content:center;gap:8px;
                        "
                            onmouseover="if(!this.disabled)this.style.background='rgba(255,255,255,0.18)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            <svg id="trigger-icon" width="15" height="15" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                            <span id="trigger-btn-text">Jalankan Backup</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <style>
            @keyframes backupSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.97);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes backupSpin {
                to {
                    transform: rotate(360deg);
                }
            }

            #backup-files-list .bk-row:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            #backupModal ::-webkit-scrollbar {
                width: 5px;
            }

            #backupModal ::-webkit-scrollbar-track {
                background: transparent;
            }

            #backupModal ::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.15);
                border-radius: 99px;
            }
        </style>

        <script>
            (function() {
                const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
                const ROUTES = {
                    list: '{{ route('admin.backup.index') }}',
                    trigger: '{{ route('admin.backup.trigger') }}',
                    download: function(name) {
                        return '{{ url('admin/backup/download') }}/' + encodeURIComponent(name);
                    }
                };

                /* ── open / close ── */
                window.closeBackupModal = function() {
                    document.getElementById('backupModal').style.display = 'none';
                };

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closeBackupModal();
                });

                /* ── tabs ── */
                window.switchTab = function(tab) {
                    ['files', 'trigger'].forEach(function(t) {
                        document.getElementById('tab-' + t).style.display = t === tab ? 'block' : 'none';
                        var btn = document.getElementById('tab-' + t + '-btn');
                        btn.style.color = t === tab ? '#fff' : 'rgba(255,255,255,0.45)';
                        btn.style.borderBottomColor = t === tab ? '#fff' : 'transparent';
                    });
                    if (tab === 'files') loadBackupFiles();
                };

                /* ── load file list ── */
                function loadBackupFiles() {
                    document.getElementById('backup-files-loading').style.display = 'block';
                    document.getElementById('backup-files-list').style.display = 'none';
                    document.getElementById('backup-files-empty').style.display = 'none';
                    document.getElementById('backup-files-error').style.display = 'none';

                    fetch(ROUTES.list, {
                            headers: {
                                'X-CSRF-TOKEN': CSRF,
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(data) {
                            document.getElementById('backup-files-loading').style.display = 'none';
                            if (!data.success) {
                                var el = document.getElementById('backup-files-error');
                                el.textContent = data.message || 'Gagal memuat daftar backup.';
                                el.style.display = 'block';
                                return;
                            }
                            if (!data.files || data.files.length === 0) {
                                document.getElementById('backup-files-empty').style.display = 'block';
                                return;
                            }
                            var html = data.files.map(function(f) {
                                return '<div class="bk-row" style="display:flex;align-items:center;gap:12px;padding:10px 10px;border-radius:8px;transition:background 0.15s;">' +
                                    '<div style="flex:1;min-width:0;">' +
                                    '<div style="color:#fff;font-size:0.78rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="' +
                                    escHtml(f.name) + '">' + escHtml(f.name) + '</div>' +
                                    '<div style="color:rgba(255,255,255,0.35);font-size:0.68rem;margin-top:2px;">' +
                                    escHtml(f.modified_str) + ' &bull; ' + escHtml(f.size_human) + '</div>' +
                                    '</div>' +
                                    '<a href="' + ROUTES.download(f.name) + '" download style="' +
                                    'flex-shrink:0;padding:6px 12px;border-radius:6px;' +
                                    'background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.75);' +
                                    'text-decoration:none;font-size:0.72rem;font-weight:500;' +
                                    'transition:background 0.15s,color 0.15s;white-space:nowrap;' +
                                    '" onmouseover="this.style.background=\'rgba(255,255,255,0.18)\';this.style.color=\'#fff\'"' +
                                    ' onmouseout="this.style.background=\'rgba(255,255,255,0.08)\';this.style.color=\'rgba(255,255,255,0.75)\'">' +
                                    '&#8595; Unduh' +
                                    '</a>' +
                                    '</div>';
                            }).join('<div style="height:1px;background:rgba(255,255,255,0.05);margin:0 0;"></div>');

                            var listEl = document.getElementById('backup-files-list');
                            listEl.innerHTML = html;
                            listEl.style.display = 'block';
                        })
                        .catch(function() {
                            document.getElementById('backup-files-loading').style.display = 'none';
                            var el = document.getElementById('backup-files-error');
                            el.textContent = 'Gagal terhubung ke server. Coba lagi.';
                            el.style.display = 'block';
                        });
                }

                /* ── trigger backup ── */
                window.submitTrigger = function(e) {
                    e.preventDefault();
                    var password = document.getElementById('backup-password').value;
                    var btn = document.getElementById('trigger-submit-btn');
                    var btnText = document.getElementById('trigger-btn-text');
                    var alertEl = document.getElementById('trigger-alert');
                    var icon = document.getElementById('trigger-icon');

                    btn.disabled = true;
                    btn.style.opacity = '0.6';
                    btnText.textContent = 'Memproses...';
                    icon.innerHTML =
                        '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" stroke-dasharray="28 56" style="animation:backupSpin 0.7s linear infinite;transform-origin:center"/>';
                    alertEl.style.display = 'none';

                    fetch(ROUTES.trigger, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': CSRF,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                password: password
                            })
                        })
                        .then(function(r) {
                            return r.json().then(function(d) {
                                d._status = r.status;
                                return d;
                            });
                        })
                        .then(function(data) {
                            btn.disabled = false;
                            btn.style.opacity = '1';
                            btnText.textContent = 'Jalankan Backup';
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>';

                            if (data.success) {
                                alertEl.style.background = 'rgba(74,222,128,0.1)';
                                alertEl.style.color = '#4ade80';
                                alertEl.style.border = '1px solid rgba(74,222,128,0.2)';
                                document.getElementById('backup-password').value = '';
                            } else {
                                alertEl.style.background = 'rgba(248,113,113,0.1)';
                                alertEl.style.color = '#f87171';
                                alertEl.style.border = '1px solid rgba(248,113,113,0.2)';
                            }
                            alertEl.textContent = data.message || (data.success ? 'Backup dimulai.' :
                                'Terjadi kesalahan.');
                            alertEl.style.display = 'block';
                        })
                        .catch(function() {
                            btn.disabled = false;
                            btn.style.opacity = '1';
                            btnText.textContent = 'Jalankan Backup';
                            icon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>';
                            alertEl.style.background = 'rgba(248,113,113,0.1)';
                            alertEl.style.color = '#f87171';
                            alertEl.style.border = '1px solid rgba(248,113,113,0.2)';
                            alertEl.textContent = 'Koneksi gagal. Coba lagi.';
                            alertEl.style.display = 'block';
                        });
                };

                /* ── auto-load file list on open ── */
                var originalOpen = window.HTMLElement && window.HTMLElement.prototype;
                document.getElementById('backup-trigger-btn') &&
                    document.getElementById('backup-trigger-btn').addEventListener('click', function() {
                        loadBackupFiles();
                    });

                function escHtml(str) {
                    return String(str)
                        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                }
            })();
        </script>
    @endif
    {{-- ===================================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>

</html>
