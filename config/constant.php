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
        'Guru Produktif'
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
                    'Agribisnis_Pengolahan_Hasil_Perikanan',
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

    'curriculum'      => ['K13', 'Kurikulum Merdeka'],

    'approval_status' => ['Sudah', 'Belum'],

    'school_category' => [
        'SMK PK Reguler'  => 'SMK PK',
        'SMK Non PK'      => 'SMK Non PK',
        'SMK Model'       => 'SMK Model',
    ],

    'school_accreditation' => ['A', 'B', 'C', 'Belum Terakreditasi'],

    'scheme_types' => [
        'okupasi_nasional' => 'Okupasi Nasional',
        'klaster'          => 'Klaster',
        'kkni'             => 'KKNI',
    ],

    'jenis_pengembangan_kompetensi' => [
        'Pelatihan Teknis',
        'Sertifikasi Profesi',
        'Magang Guru',
        'Seminar/Workshop',
        'TOT/Asesor',
        'Studi Lanjut',
    ],
];
