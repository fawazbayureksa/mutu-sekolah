<?php

return [
    'user_role' => [
        'admin' => 'Admin',
        'verifier' => 'Verifier',
    ],

    'respondent_positions' => [
        'Kepala Sekolah',
        'Wakil Kepala Sekolah',
        'Ketua Kompetensi Keahlian',
        'Kepala Bengkel / Laboratorium',
        'Guru'
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
                ],
            ],
        ],
        'Teknologi Informasi' => [
            'programs' => ['Bidang Teknologi Informasi'],
            'concentrations' => [
                'Bidang Teknologi Informasi' => [
                    'Rekayasa Perangkat Lunak',
                    'Pengembangan GIM',
                    'Sistem Informasi Jaringan dan Aplikasi',
                    'Teknik Komputer dan Jaringan',
                    'Teknik Jaringan Akses Telekomunikasi',
                    'Teknik Transmisi Telekomunikasi',
                ],
            ],
        ],
    ],

    // Expertise data separated by curriculum
    'expertise_by_curriculum' => [

        'Kurikulum Merdeka' => [
            'Kemaritiman' => [
                'programs' => [
                    'Teknika Kapal Penangkap Ikan',
                    'Nautika Kapal Penangkap Ikan',
                    'Nautika Kapal Niaga',
                    'Teknika Kapal Niaga',
                ],
                'concentrations' => [
                    'Teknika Kapal Penangkap Ikan' => ['Teknika Kapal Penangkap Ikan'],
                    'Nautika Kapal Penangkap Ikan' => ['Nautika Kapal Penangkap Ikan'],
                    'Nautika Kapal Niaga'          => ['Nautika Kapal Niaga'],
                    'Teknika Kapal Niaga'           => ['Teknika Kapal Niaga'],
                ],
            ],
            'Agribisnis dan Agriteknologi' => [
                'programs' => [
                    'Agribisnis Perikanan',
                    'Agriteknologi Pengolahan Hasil Pertanian',
                ],
                'concentrations' => [
                    'Agribisnis Perikanan' => [
                        'Agribisnis Perikanan Air Tawar',
                        'Agribisnis Perikanan Payau dan Laut',
                        'Agribisnis Ikan Hias',
                        'Agribisnis Rumput Laut',
                        'Agribisnis Pengolahan Hasil Perikanan',
                    ],
                    'Agriteknologi Pengolahan Hasil Pertanian' => [
                        'Agriteknologi Pengolahan Hasil Perikanan',
                    ],
                ],
            ],
            'Teknologi Informasi' => [
                'programs' => [
                    'Pengembangan Perangkat Lunak dan GIM',
                    'Teknik Jaringan Komputer dan Telekomunikasi',
                ],
                'concentrations' => [
                    'Pengembangan Perangkat Lunak dan GIM' => [
                        'Rekayasa Perangkat Lunak',
                        'Pengembangan GIM',
                        'Sistem Informasi Jaringan dan Aplikasi',
                    ],
                    'Teknik Jaringan Komputer dan Telekomunikasi' => [
                        'Teknik Komputer dan Jaringan',
                        'Teknik Transmisi Telekomunikasi',
                        'Pengembangan GIM',
                        'Teknik Jaringan Akses Telekomunikasi',
                    ],
                ],
            ],
        ],

        'K13' => [
            'Kemaritiman' => [
                'programs' => [
                    'Pelayaran Kapal Penangkap Ikan',
                    'Perikanan',
                ],
                'concentrations' => [
                    'Pelayaran Kapal Penangkap Ikan' => [
                        'Nautika Kapal Penangkap Ikan',
                        'Teknika Kapal Penangkap Ikan',
                        'Nautika Kapal Niaga',
                        'Teknika Kapal Niaga',
                    ],
                    'Perikanan' => [
                        'Agribisnis Perikanan Air Tawar',
                        'Agribisnis Perikanan Payau dan Laut',
                        'Agribisnis Ikan Hias',
                    ],
                ],
            ],
            'Teknologi Informasi dan Komunikasi' => [
                'programs' => [
                    'Teknik Komputer dan Informatika',
                    'Teknik Telekomunikasi',
                ],
                'concentrations' => [
                    'Teknik Komputer dan Informatika' => [
                        'Rekayasa Perangkat Lunak',
                        'Teknik Komputer dan Jaringan',
                        'Multimedia',
                    ],
                    'Teknik Telekomunikasi' => [
                        'Teknik Transmisi Telekomunikasi',
                        'Teknik Jaringan Akses Telekomunikasi',
                    ],
                ],
            ],
        ],

    ],

    'curriculum'      => ['K13', 'Kurikulum Merdeka'],

    'approval_status' => ['Sudah', 'Belum'],

    'school_category' => [
        'SMK PK'  => 'SMK PK',
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

    /**
     * Rasio Ideal Guru Produktif : Konsentrasi Keahlian per Bidang Keahlian
     * Key   = Bidang Keahlian (matches expertiseSelect value)
     * Value = human-readable ratio string displayed in the readonly field
     */
    'ideal_productive_ratio_by_bidang' => [
        'Kemaritiman'                          => '1 : 5 (5 guru produktif untuk 1 konsentrasi keahlian bidang Kemaritiman)',
        'Perikanan'                            => '1 : 2 (2 guru produktif untuk 1 konsentrasi keahlian bidang Perikanan)',
        'Teknologi Informasi dan Komunikasi'   => '1 : 2 (2 guru produktif untuk 1 konsentrasi keahlian bidang TIK)',
        'Teknologi dan Rekayasa'               => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        'Bisnis dan Manajemen'                 => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        'Pariwisata'                           => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        'Seni dan Industri Kreatif'            => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        'Agribisnis dan Agroteknologi'         => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        'Kesehatan dan Pekerjaan Sosial'       => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
        '_default'                             => '1 : 5 (minimal 5 guru produktif per konsentrasi keahlian)',
    ],
];

