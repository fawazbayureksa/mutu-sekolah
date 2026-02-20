@extends('layouts.app')

@section('title', 'Penjaminan Mutu SMK Bidang KPTK - BPPMPV')

@push('styles')
    <style>
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .custom-toast {
            min-width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease-out;
            overflow: hidden;
        }

        .custom-toast.hiding {
            animation: slideOutRight 0.3s ease-in;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 12px 16px;
        }

        .toast-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .toast-header .btn-close:hover {
            opacity: 1;
        }

        .toast-body {
            padding: 16px;
            color: #374151;
            font-size: 0.95rem;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            animation: progressBar 5s linear;
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>
@endpush

@section('content')
    {{-- Toast Container --}}
    <div class="toast-container" id="toastContainer"></div>
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-10 mx-auto text-center">
                    <div data-aos="fade-up" data-aos-duration="1000">
                        <h1 class="display-4 fw-bold mb-4">Penjaminan Mutu SMK Bidang KPTK</h1>
                        <p class="lead mb-5 text-white-50">Upaya sistematis BPPMPV dalam memastikan mutu pendidikan vokasi
                            bidang Kelautan, Perikanan, dan TIK</p>
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('instrument.v2.form') }}" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="bi bi-play-circle me-2"></i>Isi Instrumen
                            </a>
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5" data-aos="fade-up">
                        <h2 class="fw-bold mb-3">Apa itu Penjaminan Mutu SMK Bidang KPTK?</h2>
                        <div class="title-underline mx-auto"></div>
                    </div>
                    <div class="about-content bg-white p-4 p-lg-5 shadow-sm rounded-4" data-aos="fade-up"
                        data-aos-delay="200">
                        <p class="text-secondary mb-0">
                            Penjaminan Mutu SMK Bidang KPTK adalah upaya sistematis yang dilakukan oleh BPPMPV (Balai
                            Pengembangan Penjaminan Mutu Pendidikan Vokasi) untuk memastikan bahwa SMK dalam bidang
                            Kelautan, Perikanan, dan Teknologi Informasi dan Komunikasi (KPTK) memenuhi standar mutu yang
                            telah ditetapkan. Kegiatan ini meliputi pemetaan data, evaluasi, dan perbaikan berkelanjutan
                            terhadap tiga komponen utama: peserta didik, sarana prasarana, dan tata kelola pendidikan
                            vokasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold mb-3">Alur Penjaminan Mutu</h2>
                <div class="title-underline mx-auto"></div>
            </div>
            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-10">
                    <div class="flow-image-wrapper text-center">
                        <img src="{{ asset('images/flow.jpeg') }}" alt="Alur Penjaminan Mutu SMK Bidang KPTK"
                            class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ruang-lingkup" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold mb-3">Ruang Lingkup Penjaminan Mutu</h2>
                <div class="title-underline mx-auto"></div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4 text-center">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="bi bi-person-lines-fill fs-1"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-4">Standar Peserta Didik</h4>
                            <p class="card-text text-secondary">
                                Fokus pada kompetensi dan kesiapan kerja lulusan. Meliputi pemantauan kemampuan teknis, soft
                                skills, serta kesesuaian kompetensi dengan kebutuhan industri.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4 text-center">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="bi bi-building-gear fs-1"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-4">Standar Sarana Prasarana (Sapras)</h4>
                            <p class="card-text text-secondary">
                                Mengevaluasi kesesuaian fasilitas dengan standar industri. Meliputi kelengkapan, kondisi,
                                dan relevansi peralatan praktik serta lingkungan belajar.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4 text-center">
                            <div class="icon-box mb-4 mx-auto">
                                <i class="bi bi-diagram-3 fs-1"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-4">Standar Tata Kelola</h4>
                            <p class="card-text text-secondary">
                                Meliputi kerjasama dengan industri, pengelolaan Teaching Factory (TEFA), serta data
                                pelatihan dan sertifikasi guru. Memastikan adanya sistem manajemen yang mendukung
                                keterjalinan dengan dunia kerja.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tujuan" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold mb-3">Tujuan Penjaminan Mutu</h2>
                <div class="title-underline mx-auto"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="objectives-list" data-aos="fade-up" data-aos-delay="100">
                        <div class="objective-item d-flex align-items-start mb-4">
                            <div class="check-icon me-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <p class="mb-0">Memetakan kondisi mutu SMK KPTK di seluruh Indonesia.</p>
                            </div>
                        </div>
                        <div class="objective-item d-flex align-items-start mb-4">
                            <div class="check-icon me-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <p class="mb-0">Memberikan rekomendasi perbaikan berdasarkan data yang terukur.</p>
                            </div>
                        </div>
                        <div class="objective-item d-flex align-items-start mb-4">
                            <div class="check-icon me-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <p class="mb-0">Meningkatkan relevansi pendidikan vokasi dengan kebutuhan industri.</p>
                            </div>
                        </div>
                        <div class="objective-item d-flex align-items-start mb-4">
                            <div class="check-icon me-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <p class="mb-0">Memastikan standar nasional pendidikan vokasi tercapai secara konsisten.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="landasan-hukum" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="legal-box p-4 p-lg-5 shadow-sm" data-aos="fade-up">
                        <div class="d-flex align-items-start">
                            <div class="legal-icon me-4">
                                <i class="bi bi-journal-text fs-2"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-3">Landasan Hukum</h4>
                                <p class="text-secondary mb-0">
                                    Kegiatan ini didasarkan pada Pasal 22 Permendikbud No. 26 Tahun 2020 tentang Unit
                                    Pelaksana Teknis Kementerian Pendidikan dan Kebudayaan, yang menugaskan BPPMPV untuk
                                    melaksanakan fungsi penjaminan mutu peserta didik, sarana prasarana, dan tata kelola
                                    pendidikan vokasi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showToast('{{ session('success') }}');
            @endif
        });

        function showToast(message) {
            const toastContainer = document.getElementById('toastContainer');

            // Create toast element
            const toastEl = document.createElement('div');
            toastEl.className = 'custom-toast';
            toastEl.innerHTML = `
                <div class="toast-header">
                    <div class="toast-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <strong class="me-auto">Berhasil</strong>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
                <div class="toast-progress"></div>
            `;

            // Add to container
            toastContainer.appendChild(toastEl);

            // Close button handler
            const closeBtn = toastEl.querySelector('.btn-close');
            closeBtn.addEventListener('click', function() {
                hideToast(toastEl);
            });

            // Auto dismiss after 5 seconds
            setTimeout(function() {
                hideToast(toastEl);
            }, 5000);
        }

        function hideToast(toastEl) {
            toastEl.classList.add('hiding');
            setTimeout(function() {
                toastEl.remove();
            }, 300);
        }
    </script>
@endpush
