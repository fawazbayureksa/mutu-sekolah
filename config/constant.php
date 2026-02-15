<?php
return [
    'user_role' => [
        'admin' => 'Admin',
        'verifier' => 'Verifier'
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
                    'Nautika Kapal Penangkap Ikan',
                    'Teknika Kapal Penangkap Ikan',
                    'Nautika Kapal Niaga',
                    'Teknika Kapal Niaga',
                    'Lainnya',
                ],
            ],
        ],
        'Perikanan' => [
            'programs' => ['Bidang Keahlian Perikanan'],
            'concentrations' => [
                'Bidang Keahlian Perikanan' => [
                    'Agribisnis Ikan Hias',
                    'Agribisnis Perikanan Payau dan Laut',
                    'Agribisnis Perikanan Air Tawar',
                    'Agribisnis Rumput Laut',
                    'Lainnya',
                ],
            ],
        ],
        'TIK' => [
            'programs' => ['Bidang TIK'],
            'concentrations' => [
                'Bidang TIK' => [
                    'Rekayasa Perangkat Lunak',
                    'Pengembangan GIM',
                    'Sistem Informasi, Jaringan, dan Aplikasi',
                    'Teknik Komputer dan Jaringan',
                    'Teknik Jaringan Akses Telekomunikasi',
                    'Teknik Transmisi Telekomunikasi',
                    'Lainnya',
                ],
            ],
        ],
    ],
];
