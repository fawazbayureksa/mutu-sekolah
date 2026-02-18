<?php

return [
    'user_role' => [
        'admin' => 'Admin',
        'verifier' => 'Verifier',
    ],

    'respondent_positions' => [
        'Kepala Sekolah',
        'Wakil Kepala Sekolah',
        'Ketua Jurusan (Kajur) / Ketua Kompetensi Keahlian',
        'Kepala Bengkel / Kepala Laboratorium',
        'Guru Normatif',
        'Guru Adaptif',
        'Guru Produktif',
        'Kepala Subbagian Tata Usaha',
        'Staf Administrasi',
    ],

    'expertise' => [
        'Kemaritiman' => [
            'programs' => ['Bidang Keahlian Kemaritiman'],
            'concentrations' => [
                'Bidang Keahlian Kemaritiman' => [
                    'Nautika_Kapal_Penangkap_Ikan',
                    'Teknika_Kapal_Penangkap_Ikan',
                    'Nautika_Kapal_Niaga',
                    'Teknika_Kapal_Niaga',
                ],
            ],
        ],
        'Perikanan' => [
            'programs' => ['Bidang Keahlian Perikanan'],
            'concentrations' => [
                'Bidang Keahlian Perikanan' => [
                    'Agribisnis_Ikan_Hias',
                    'Agribisnis_Perikanan_Payau_Dan_Laut',
                    'Agribisnis_Perikanan_Air_Tawar',
                    'Agribisnis_Rumput_Laut',
                ],
            ],
        ],
        'Teknologi Informasi' => [
            'programs' => ['Bidang Teknologi Informasi'],
            'concentrations' => [
                'Bidang Teknologi Informasi' => [
                    'Rekayasa_Perangkat_Lunak',
                    'Pengembangan_GIM',
                    'Sistem_Informasi_Jaringan_Dan_Aplikasi',
                    'Teknik_Komputer_Dan_Jaringan',
                    'Teknik_Jaringan_Akses_Telekomunikasi',
                    'Teknik_Transmisi_Telekomunikasi',
                ],
            ],
        ],
    ],

    'jenis_pengembangan_kompetensi' => [
        'Diklat',
        'Sertifikasi Profesi',
        'Magang Guru',
        'Seminar/Workshop',
        'TOT/Asesor',
        'Studi Lanjut',
    ],
];
