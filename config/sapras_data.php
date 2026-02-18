<?php

/**
 * Predefined Sarana Prasarana (Equipment) data per Konsentrasi Keahlian.
 *
 * Structure:
 * 'Nama Konsentrasi' => [
 *     'sections' => [
 *         [
 *             'title' => 'Section Title',
 *             'type'  => 'room' | 'equipment' | 'equipment_no_spec' | 'k3' | 'utility' | 'culture',
 *             'items' => [ ... ]
 *         ],
 *     ],
 * ]
 *
 * To add a new concentration, simply add a new key to this array.
 */

return [
    'Teknik Jaringan Akses Telekomunikasi' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Praktik Dasar Sistem (Radio dan Tembaga)', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Praktik Fiber', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Praktik Instalasi Perangkat Pelanggan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Praktik V-SAT', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                ],
            ],

            // 2. PERALATAN PRAKTIK AREA KERJA DASAR SISTEL (RADIO DAN TEMBAGA)
            [
                'title' => 'Peralatan Praktik Area Kerja Dasar Sistel (Radio dan Tembaga)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 215 x 75 x 80 cm, rangka MDF tebal 18 mm berlapis vinyl bilaminasi anti gores, daun meja papan kayu lapis tebal 24 mm berlapis HPL anti gores', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Dimensi 400 x 430 x 750 mm, material pipa bulat 25.4 mm, multiplek, sanding cold foam, fabric, frame finishing powder coating', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Meja Alat', 'spec' => 'Desain sesuai jenis pekerjaan', 'standard_qty' => '1 buah/18 siswa'],
                    ['name' => 'Lemari Atas (Tools Cabinet)', 'spec' => 'Untuk menyimpan peralatan', 'standard_qty' => '1 buah/9 siswa'],
                    ['name' => 'Lemari', 'spec' => 'Untuk menyimpan alat dan bahan', 'standard_qty' => '1 buah/6 siswa'],
                    ['name' => 'Kotak Kontak', 'spec' => 'Kabel tembaga asli, panjang 1,5 m & 5 m, tersedia 2-5 lobang, dilengkapi saklar on/off', 'standard_qty' => 'Minimal 12 buah/ruang'],
                    ['name' => 'LCD Projector', 'spec' => 'Lumens min 3600, resolusi min XGA (1024x768), lamp life 5000 jam', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'Multimeter Digital', 'spec' => '3.5 digits (4000 count, 40 segment bar graph), dapat mengukur tegangan, hambatan, arus', 'standard_qty' => '4 buah/ruang'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Single fiber connection, cladding diameter 80-150um, splicing mode min 50 modes, return loss >60dB', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengevaluasi serat optik pada domain waktu', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'PC Client/Notebook', 'spec' => 'Processor 3.9 GHz/3MB L3 Cache, RAM 4GB, HDD 1TB, monitor 19", resolusi 1366x768, DVD-RW', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'PC Server', 'spec' => 'Processor 3.6 GHz/8MB L3 Cache, RAM 32GB, SSD 512GB, HDD 2TB', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Router', 'spec' => 'Interface min 4 port 10/100/1000 Mbps LAN, wireless standard IEEE 802.11n', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Switch Manageable', 'spec' => 'Untuk menghubungkan beberapa HUB, layer 2 switching', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'UPS', 'spec' => 'Input voltage 230V, input frequency 50/60 Hz', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'VoIP Gateway', 'spec' => 'Untuk menghubungkan telepon PSTN dengan telepon berbasis IP', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Access Point Indoor', 'spec' => '802.11b/g, support repeater, bridge, WDS, VLAN', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Access Point Outdoor', 'spec' => '802.11b/g, untuk koneksi jarak jauh', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Audio System', 'spec' => 'Amplifier, pre-amp, speaker', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Cleaver', 'spec' => 'Untuk memotong core kabel optik', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Single & multi mode, 24 core, material PVC', 'standard_qty' => '30 set/ruang'],
                    ['name' => 'Fluke Tester', 'spec' => 'Untuk mengecek kondisi kabel jaringan, support 10BASE-T, 100BASE-TX, 1000BASE-T', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'Genset', 'spec' => 'Generator listrik cadangan minimal 1500 watt', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'IP PBX', 'spec' => 'Integrated 2 FXO + 2 FXS port, protokol SIP', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'IP Phone', 'spec' => 'Telepon berbasis IP', 'standard_qty' => '18 unit/ruang'],
                    ['name' => 'Antenna Trainer', 'spec' => '1 unit antenna positioner, 1 set data acquisition, 2 unit horn antenna, 2 set helical antenna, 1 unit patch antenna, 1 unit Yagi antenna', 'standard_qty' => '1 set/ruang'],
                    ['name' => 'Drive Test', 'spec' => 'Untuk mengetahui kondisi jaringan seluler, support minimal 3G', 'standard_qty' => '1 set/ruang'],
                    ['name' => 'CPE Manageable Switch', 'spec' => 'Minimum 4 port 10/100/1000 Mbps, support network management', 'standard_qty' => '18 buah/ruang'],
                ],
            ],

            // 3. PERALATAN PRAKTIK AREA KERJA FIBER
            [
                'title' => 'Peralatan Praktik Area Kerja Fiber',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 215 x 75 x 80 cm, rangka MDF tebal 18 mm', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, nyaman', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Meja Alat', 'spec' => 'Desain sesuai jenis pekerjaan', 'standard_qty' => '1 buah/18 siswa'],
                    ['name' => 'Lemari Atas (Tools Cabinet)', 'spec' => 'Untuk menyimpan peralatan', 'standard_qty' => '1 buah/9 siswa'],
                    ['name' => 'Lemari', 'spec' => 'Untuk menyimpan alat dan bahan', 'standard_qty' => '1 buah/6 siswa'],
                    ['name' => 'Kotak Kontak', 'spec' => 'Penempatan dan daya listrik sesuai kebutuhan', 'standard_qty' => 'Minimal 12 buah/ruang'],
                    ['name' => 'LCD Projector', 'spec' => 'Lumens min 3600, resolusi XGA', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'Multimeter Digital', 'spec' => '3.5 digits, multi fungsi', 'standard_qty' => '4 buah/ruang'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Untuk penyambungan kabel fiber optik, 4 motor, high precision, auto splice', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengukur parameter sinyal optik', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Cleaver', 'spec' => 'Untuk memotong core kabel optik', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Drill/Press', 'spec' => 'Mesin bor untuk pekerjaan mekanik', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik single mode', 'standard_qty' => '30 set/ruang'],
                    ['name' => 'Fluke Tester', 'spec' => 'Untuk mengecek kondisi kabel jaringan', 'standard_qty' => '2 unit/ruang'],
                ],
            ],

            // 4. PERALATAN PRAKTIK AREA KERJA INSTALASI PERANGKAT PELANGGAN
            [
                'title' => 'Peralatan Praktik Area Kerja Instalasi Perangkat Pelanggan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 215 x 75 x 80 cm', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Meja Alat', 'spec' => 'Desain sesuai jenis pekerjaan', 'standard_qty' => '1 buah/18 siswa'],
                    ['name' => 'Lemari Atas (Tools Cabinet)', 'spec' => 'Tersedia 3 rak penyimpanan', 'standard_qty' => '1 buah/9 siswa'],
                    ['name' => 'Lemari', 'spec' => 'Struktur baja cold-rolled, tahan abrasi 150kg/lapis', 'standard_qty' => '1 buah/6 siswa'],
                    ['name' => 'Kotak Kontak', 'spec' => 'Minimal 12 buah/ruang', 'standard_qty' => 'Minimal 12 buah'],
                    ['name' => 'LCD Projector', 'spec' => '1 unit/ruang', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'Multimeter Digital', 'spec' => '4 buah/ruang', 'standard_qty' => '4 buah/ruang'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'PC Client/Notebook', 'spec' => 'Processor 3.9 GHz, RAM 4GB, HDD 1TB', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'PC Server', 'spec' => 'Processor 3.0 GHz, RAM 8GB', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Router', 'spec' => 'Interface 4 port 10/100/1000 Mbps', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Switch Manageable', 'spec' => 'Layer 2 switching', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'UPS', 'spec' => 'Input 230V, 50/60 Hz', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'VoIP Gateway', 'spec' => 'Support IP proxy servers', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Access Point Indoor', 'spec' => '802.11b/g, support repeater, bridge, WDS, VLAN', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Access Point Outdoor', 'spec' => '802.11b/g', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Audio System', 'spec' => 'Amplifier, pre-amp', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Direct Broadcast Satellite', 'spec' => 'C band, dish 1.8 m, LNB, up converter', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Single & multi mode', 'standard_qty' => '30 set/ruang'],
                    ['name' => 'Fluke Tester', 'spec' => 'Support 10BASE-T, 100BASE-TX, 1000BASE-T', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'Genset', 'spec' => 'Minimal 1500 watt', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'IP PBX', 'spec' => 'Integrated 2 FXO + 2 FXS port', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'IP Phone', 'spec' => 'Telepon berbasis IP', 'standard_qty' => '18 unit/ruang'],
                    ['name' => 'CPE Manageable Switch', 'spec' => 'Min 4 port 10/100/1000 Mbps', 'standard_qty' => '18 buah/ruang'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45', 'standard_qty' => '3 unit/ruang'],
                    ['name' => 'Printer', 'spec' => 'Inkjet, resolusi up to 5700x1400 dpi', 'standard_qty' => '2 unit/ruang'],
                ],
            ],

            // 5. PERALATAN PRAKTIK AREA KERJA V-SAT
            [
                'title' => 'Peralatan Praktik Area Kerja V-SAT',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 215 x 75 x 80 cm', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Meja Alat', 'spec' => 'Desain sesuai jenis pekerjaan', 'standard_qty' => '1 buah/18 siswa'],
                    ['name' => 'Lemari Atas (Tools Cabinet)', 'spec' => '1 buah/9 siswa', 'standard_qty' => '1 buah/9 siswa'],
                    ['name' => 'Lemari', 'spec' => 'Struktur baja cold-rolled', 'standard_qty' => '1 buah/6 siswa'],
                    ['name' => 'Kotak Kontak', 'spec' => 'Minimal 12 buah/ruang', 'standard_qty' => 'Minimal 12 buah'],
                    ['name' => 'LCD Projector', 'spec' => '1 unit/ruang', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'Multimeter Digital', 'spec' => '4 buah/ruang', 'standard_qty' => '4 buah/ruang'],
                    ['name' => 'PC Client/Notebook', 'spec' => '18 set/ruang', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'PC Server', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Router', 'spec' => '18 set/ruang', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Switch Manageable', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'UPS', 'spec' => '2 unit/ruang', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'VoIP Gateway', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'Access Point Indoor', 'spec' => '18 set/ruang', 'standard_qty' => '18 set/ruang'],
                    ['name' => 'Access Point Outdoor', 'spec' => '4 unit/ruang', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Audio System', 'spec' => '4 unit/ruang', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Direct Broadcast Satellite', 'spec' => 'C band, dish 1.8 m, LNB', 'standard_qty' => '4 unit/ruang'],
                    ['name' => 'Fiber Optic Cable', 'spec' => '30 set/ruang', 'standard_qty' => '30 set/ruang'],
                    ['name' => 'Fluke Tester', 'spec' => '2 unit/ruang', 'standard_qty' => '2 unit/ruang'],
                    ['name' => 'Genset', 'spec' => '1 unit/ruang', 'standard_qty' => '1 unit/ruang'],
                    ['name' => 'IP PBX', 'spec' => '6 unit/ruang', 'standard_qty' => '6 unit/ruang'],
                    ['name' => 'IP Phone', 'spec' => '18 unit/ruang', 'standard_qty' => '18 unit/ruang'],
                    ['name' => 'Satellite Training System', 'spec' => 'Sistem pelatihan komunikasi satelit', 'standard_qty' => '1 set/ruang'],
                ],
            ],

            // 6. PERALATAN SUB RUANG INSTRUKTUR DAN RUANG SIMPAN
            [
                'title' => 'Peralatan Sub Ruang Instruktur dan Ruang Simpan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 215 x 75 x 80 cm', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis', 'standard_qty' => '1 buah/instruktur'],
                    ['name' => 'Meja Alat', 'spec' => 'Desain sesuai jenis pekerjaan', 'standard_qty' => '1 buah/18 siswa'],
                    ['name' => 'Lemari Atas (Tools Cabinet)', 'spec' => '1 buah/9 siswa', 'standard_qty' => '1 buah/9 siswa'],
                    ['name' => 'Lemari', 'spec' => 'Struktur baja cold-rolled, tahan abrasi 150kg/lapis', 'standard_qty' => '1 buah/6 siswa'],
                    ['name' => 'Kotak Kontak', 'spec' => 'Minimal 12 buah/ruang', 'standard_qty' => 'Minimal 12 buah'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45', 'standard_qty' => '3 unit/ruang'],
                    ['name' => 'Printer', 'spec' => 'Inkjet, resolusi tinggi', 'standard_qty' => '2 unit/ruang'],
                ],
            ],

            // 7. PERALATAN PADA FASILITAS PROTOKOL KESEHATAN
            [
                'title' => 'Peralatan pada Fasilitas Protokol Kesehatan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Masker Bedah', 'spec' => '3 lapis, anti air', 'standard_qty' => '1 per orang'],
                    ['name' => 'Pelindung Muka/Face Shield', 'spec' => 'Pelindung wajah', 'standard_qty' => '1 per orang'],
                    ['name' => 'Handsanitizer', 'spec' => 'Cairan pembersih tangan', 'standard_qty' => '1 per orang'],
                    ['name' => 'Thermometer', 'spec' => 'Untuk mengecek suhu tubuh', 'standard_qty' => '1 per ruangan'],
                    ['name' => 'Disinfektan', 'spec' => 'Untuk membersihkan benda mati', 'standard_qty' => '1 per ruangan'],
                ],
            ],

            // 8. KELENGKAPAN SMART CLASSROOM
            [
                'title' => 'Kelengkapan Smart Classroom',
                'type' => 'equipment_no_spec',
                'items' => [
                    ['name' => 'Smart Board / Whiteboard Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart TV Videoconference', 'standard_qty' => '1 unit'],
                    ['name' => 'HD Pro Cam / Live Casting', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Table Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Controlroom Console', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Document Camera', 'standard_qty' => '1 unit'],
                    ['name' => 'Platform Pendukung (Student Response System, digital learning content, mobile learning)', 'standard_qty' => '1 paket'],
                ],
            ],

            // 9. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 10. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux (SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 pria + 1 wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011)'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Jarak masing-masing 3 m'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 11. PENERAPAN BUDAYA KERJA INDUSTRI
            [
                'title' => 'Penerapan Budaya Kerja Industri',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3 (C.A.N.T.I.K./T.A.M.P.A.N.)'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang'],
                ],
            ],
        ],
    ],

    'Pengembangan GIM' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Pengembangan Gim (Game Development Studio)', 'standard_area' => '3 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Area Kerja Desain Grafis dan Animasi 2D/3D', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Uji Coba/Playtesting', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Produksi Audio & Sound Effect', 'standard_area' => '3 m²/peserta didik', 'capacity' => '6 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                ],
            ],

            // 2. PERABOT DAN PERALATAN RUANG PENGEMBANGAN GIM
            [
                'title' => 'Perabot dan Peralatan Ruang Pengembangan Gim',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Workstation/PC Game Development', 'spec' => 'Processor minimal Intel Core i7/AMD Ryzen 7, RAM 32 GB, GPU Dedicated (NVIDIA RTX 3060 atau setara), SSD 1 TB', 'standard_qty' => '18 unit'],
                    ['name' => 'Monitor Grafis', 'spec' => 'Monitor 24-27 inch, resolusi 4K atau 2K, color accuracy tinggi (100% sRGB)', 'standard_qty' => '18 unit'],
                    ['name' => 'Laptop Developer (Mobile Game Testing)', 'spec' => 'Processor i7, RAM 16 GB, GPU dedicated, untuk testing game mobile', 'standard_qty' => '6 unit'],
                    ['name' => 'Graphics Tablet', 'spec' => 'Active area minimal 10" x 6", pressure sensitivity 8192 levels, stylus battery-free', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja Ergonomis', 'spec' => '120 x 70 x 75 cm, adjustable height, dengan cable management', 'standard_qty' => '18 unit'],
                    ['name' => 'Kursi Ergonomis', 'spec' => 'Adjustable height, lumbar support, armrest, bahan breathable', 'standard_qty' => '18 unit'],
                    ['name' => 'Server Penyimpanan/Storage', 'spec' => 'NAS dengan kapasitas minimal 16 TB, RAID support', 'standard_qty' => '1 unit'],
                    ['name' => 'UPS', 'spec' => 'Minimal 1200 VA, pure sine wave', 'standard_qty' => '18 unit'],
                    ['name' => 'Proyektor/LED TV', 'spec' => '4K UHD, minimal 65 inch, untuk presentasi dan review game', 'standard_qty' => '1 unit'],
                    ['name' => 'Sound System', 'spec' => '2.1 channel atau soundbar dengan subwoofer', 'standard_qty' => '1 set'],
                ],
            ],

            // 3. PERANGKAT LUNAK (SOFTWARE) PENGEMBANGAN GIM
            [
                'title' => 'Perangkat Lunak (Software) Pengembangan Gim',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Game Engine (Unity)', 'spec' => 'Unity Pro atau equivalent, lisensi pendidikan', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Game Engine (Unreal Engine)', 'spec' => 'Unreal Engine dengan akses full features', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Software Desain 2D (Adobe Photoshop/Illustrator)', 'spec' => 'Lisensi or setara (GIMP/Krita untuk open source)', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Software Desain 3D (Blender/Autodesk Maya/3DS Max)', 'spec' => 'Lisensi pendidikan atau open source', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Software Animasi (Spine/Adobe Animate)', 'spec' => 'Untuk animasi 2D karakter', 'standard_qty' => '9 lisensi'],
                    ['name' => 'Software Pemodelan 3D (ZBrush)', 'spec' => 'Untuk sculpting karakter 3D', 'standard_qty' => '6 lisensi'],
                    ['name' => 'Software Audio (Audacity/Adobe Audition)', 'spec' => 'Untuk editing suara dan musik', 'standard_qty' => '9 lisensi'],
                    ['name' => 'Integrated Development Environment (Visual Studio)', 'spec' => 'Untuk scripting dan programming', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Version Control (Git/GitHub Desktop)', 'spec' => 'Untuk kolaborasi tim', 'standard_qty' => '18 lisensi'],
                    ['name' => 'Project Management (Trello/Jira)', 'spec' => 'Untuk manajemen proyek game', 'standard_qty' => '1 paket'],
                ],
            ],

            // 4. PERALATAN AREA KERJA DESAIN GRAFIS DAN ANIMASI 2D/3D
            [
                'title' => 'Peralatan Area Kerja Desain Grafis dan Animasi 2D/3D',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Workstation Desain Grafis', 'spec' => 'Processor i7, RAM 32 GB, GPU RTX 3060, SSD 512 GB', 'standard_qty' => '9 unit'],
                    ['name' => 'Graphics Tablet (Professional)', 'spec' => 'Wacom Intuos Pro atau setara, area kerja besar', 'standard_qty' => '9 unit'],
                    ['name' => 'Monitor Calibrator', 'spec' => 'Untuk kalibrasi warna monitor (Spyder atau setara)', 'standard_qty' => '2 unit'],
                    ['name' => 'Lightbox', 'spec' => 'Untuk tracing dan animasi tradisional', 'standard_qty' => '6 unit'],
                    ['name' => 'Scanner', 'spec' => 'Resolusi tinggi untuk scan sketsa/drawing', 'standard_qty' => '1 unit'],
                ],
            ],

            // 5. PERALATAN RUANG UJI COBA/PLAYTESTING
            [
                'title' => 'Peralatan Ruang Uji Coba/Playtesting',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Smartphone/Tablet (Berbagai OS)', 'spec' => 'Android & iOS, berbagai ukuran layar dan spesifikasi', 'standard_qty' => '10 unit'],
                    ['name' => 'Console Game (PlayStation/Xbox/Nintendo Switch)', 'spec' => 'Untuk testing porting game ke konsol', 'standard_qty' => '3 unit'],
                    ['name' => 'VR Headset', 'spec' => 'Oculus Quest/Meta Quest atau HTC Vive', 'standard_qty' => '4 unit'],
                    ['name' => 'Game Controller/Joystick', 'spec' => 'Berbagai tipe (Xbox/PlayStation controller)', 'standard_qty' => '10 unit'],
                    ['name' => 'Capture Card', 'spec' => 'Untuk merekam gameplay dari konsol/HP', 'standard_qty' => '2 unit'],
                    ['name' => 'Green Screen', 'spec' => 'Untuk recording dan testing AR', 'standard_qty' => '1 set'],
                ],
            ],

            // 6. PERALATAN RUANG PRODUKSI AUDIO & SOUND EFFECT
            [
                'title' => 'Peralatan Ruang Produksi Audio & Sound Effect',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Studio Monitor Speaker', 'spec' => 'Active studio monitor, response flat', 'standard_qty' => '2 pasang'],
                    ['name' => 'Microphone Kondenser', 'spec' => 'Untuk rekaman suara dan voice over', 'standard_qty' => '3 unit'],
                    ['name' => 'Audio Interface', 'spec' => 'Minimal 2 input, phantom power', 'standard_qty' => '2 unit'],
                    ['name' => 'MIDI Keyboard', 'spec' => '49 keys atau lebih, dengan drum pad', 'standard_qty' => '2 unit'],
                    ['name' => 'Headphone Studio', 'spec' => 'Closed-back, response flat', 'standard_qty' => '6 unit'],
                    ['name' => 'Soundproofing Panel', 'spec' => 'Untuk akustik ruangan', 'standard_qty' => '1 set'],
                ],
            ],

            // 7. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja Instruktur', 'spec' => 'Ergonomis, adjustable', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja Instruktur', 'spec' => '120 x 60 x 75 cm, dengan laci', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => '5 rak, metal coating, knock down system', 'standard_qty' => '2 unit'],
                    ['name' => 'Rak Penyimpanan Media', 'spec' => 'Untuk menyimpan game, buku referensi, modul', 'standard_qty' => '2 unit'],
                    ['name' => 'Whiteboard/Papan Tulis', 'spec' => '180 x 120 cm, magnetic', 'standard_qty' => '2 unit'],
                    ['name' => 'Bulletin Board', 'spec' => 'Untuk display karya siswa', 'standard_qty' => '2 unit'],
                ],
            ],

            // 8. KELENGKAPAN SMART CLASSROOM
            [
                'title' => 'Kelengkapan Smart Classroom',
                'type' => 'equipment_no_spec',
                'items' => [
                    ['name' => 'Smart Board / Whiteboard Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart TV Videoconference', 'standard_qty' => '1 unit'],
                    ['name' => 'HD Pro Cam / Live Casting', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Table Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Controlroom Console', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Document Camera', 'standard_qty' => '1 unit'],
                    ['name' => 'Platform Pendukung (Student Response System, digital learning content, mobile learning)', 'standard_qty' => '1 paket'],
                ],
            ],

            // 9. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (kacamata anti radiasi, masker, sarung tangan anti-statis)', 'spec' => 'Tersedia dan sesuai standar untuk pekerja di depan komputer', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 10. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux (SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 pria + 1 wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011)'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Jarak masing-masing 3 m'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 11. PENERAPAN BUDAYA KERJA INDUSTRI
            [
                'title' => 'Penerapan Budaya Kerja Industri',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3 (C.A.N.T.I.K./T.A.M.P.A.N.)'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang'],
                ],
            ],
        ],
    ],

    'Sistem Informasi, Jaringan dan Aplikasi' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Mekanik Teknik Elektro', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Praktik Instalasi Jaringan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Perbaikan dan Perawatan Komputer', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Praktik Pengembangan Aplikasi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                ],
            ],

            // 2. PERALATAN SUB AREA KERJA MEKANIK TEKNIK ELEKTRO
            [
                'title' => 'Peralatan Sub Area Kerja Mekanik Teknik Elektro',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Obeng Kembang', 'spec' => 'Untuk membuka sekrup dengan mata obeng berbentuk kembang/plus', 'standard_qty' => '18 unit'],
                    ['name' => 'Obeng Pilih', 'spec' => 'Untuk membuka sekrup dengan mata obeng pipih/minus', 'standard_qty' => '18 unit'],
                    ['name' => 'Tang Kombinasi', 'spec' => 'Multi fungsi untuk teknik elektro', 'standard_qty' => '18 unit'],
                    ['name' => 'Kabel LAN Tester', 'spec' => 'Untuk memeriksa konektivitas kabel LAN', 'standard_qty' => '9 unit'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45 ke kabel UTP', 'standard_qty' => '9 unit'],
                ],
            ],

            // 3. PERALATAN SUB RUANG PRAKTIK INSTALASI JARINGAN
            [
                'title' => 'Peralatan Sub Ruang Praktik Instalasi Jaringan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Access Point Indoor', 'spec' => 'Connectivity: 802.11 n/g/b wireless, Operating Modes: Access Point (AP), WDS with AP, WDS/Bridge, Wireless Client, VLAN/SSID Support', 'standard_qty' => '9 unit'],
                    ['name' => 'Access Point Outdoor', 'spec' => 'Untuk menghubungkan antar PC dengan gelombang radio jarak jauh', 'standard_qty' => '9 unit'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik untuk transmisi sinyal', 'standard_qty' => '18 unit'],
                    ['name' => 'Cleaver dan Stripper', 'spec' => 'Untuk mengupas kabel optik dan memotong core, cladding diameter < 0.125 mm', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Untuk penyambungan kabel fiber optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik, applicable on single mode/multimode fibers', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengukur parameter sinyal optik (attenuation, panjang kabel, loss), Auto/Manual test and analysis', 'standard_qty' => '4 unit'],
                    ['name' => 'PC Server', 'spec' => 'Untuk aplikasi web server, mail server, video streaming, Processor min 3.6 GHz, RAM 8 GB, HDD 1 TB', 'standard_qty' => '4 unit'],
                    ['name' => 'PC Server (VoIP)', 'spec' => 'Untuk instalasi server VoIP, Processor min 3.3 GHz, RAM 8 GB, HDD 1 TB', 'standard_qty' => '4 unit'],
                    ['name' => 'Server Rack', 'spec' => 'Untuk menyimpan server, min 2 unit PDU outlet', 'standard_qty' => '1 unit'],
                    ['name' => 'Komputer Client', 'spec' => 'Resolusi min 1920 x 1080, Optical USB Mouse, USB Keyboard', 'standard_qty' => '4 unit'],
                    ['name' => 'VoIP Gateway', 'spec' => 'Untuk menghubungkan telepon PSTN dengan telepon IP', 'standard_qty' => '4 unit'],
                    ['name' => 'RFID Training Kit', 'spec' => 'Support up to 15 IP proxy servers, support 24 analog phone set', 'standard_qty' => '6 unit'],
                    ['name' => 'Network Simulator', 'spec' => 'Untuk menjalankan simulasi jaringan seperti kondisi nyata, mendukung simulasi switching Layer 2, simulasi jaringan berbasis kabel copper dan fiber optic, simulasi jaringan nirkabel', 'standard_qty' => '4 unit'],
                ],
            ],

            // 4. PERALATAN SUB RUANG PERBAIKAN DAN PERAWATAN KOMPUTER
            [
                'title' => 'Peralatan Sub Ruang Perbaikan dan Perawatan Komputer',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Obeng Kembang', 'spec' => 'Untuk membuka sekrup', 'standard_qty' => '18 unit'],
                    ['name' => 'Obeng Pilih', 'spec' => 'Untuk membuka sekrup', 'standard_qty' => '18 unit'],
                    ['name' => 'Kabel LAN Tester', 'spec' => 'Untuk memeriksa konektivitas kabel LAN', 'standard_qty' => '9 unit'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45', 'standard_qty' => '9 unit'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik', 'standard_qty' => '18 unit'],
                    ['name' => 'Cleaver dan Stripper', 'spec' => 'Untuk mengupas kabel optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Untuk penyambungan kabel fiber optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengukur parameter sinyal optik', 'standard_qty' => '4 unit'],
                ],
            ],

            // 5. PERALATAN SUB RUANG PRAKTIK PENGEMBANGAN APLIKASI
            [
                'title' => 'Peralatan Sub Ruang Praktik Pengembangan Aplikasi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'PC Server', 'spec' => 'Untuk pengembangan aplikasi, Processor min 3.0 GHz, RAM 8 GB, HDD 1 TB', 'standard_qty' => '4 unit'],
                    ['name' => 'Komputer Client', 'spec' => 'Resolusi min 1920 x 1080, USB Mouse, USB Keyboard', 'standard_qty' => '4 unit'],
                    ['name' => 'Kit Mikrokontroler', 'spec' => 'Untuk praktik aplikasi berbasis mikrokontroler dan internet of things, berbasis mikrokontroler min 16 pin, modul 7 segment, modul dot matrik, modul keypad, modul LCD, modul traffic light, modul serial komunikasi', 'standard_qty' => '4 unit'],
                    ['name' => 'Laptop', 'spec' => 'Untuk praktik database, pembuatan aplikasi IOT, pemrograman mikrokontroler, Processor up to 4.0 GHz', 'standard_qty' => '9 unit'],
                ],
            ],

            // 6. KELENGKAPAN SMART CLASSROOM
            [
                'title' => 'Kelengkapan Smart Classroom',
                'type' => 'equipment_no_spec',
                'items' => [
                    ['name' => 'Smart Board / Whiteboard Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart TV Videoconference', 'standard_qty' => '1 unit'],
                    ['name' => 'HD Pro Cam / Live Casting', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Table Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Controlroom Console', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Document Camera', 'standard_qty' => '1 unit'],
                    ['name' => 'Platform Pendukung (Student Response System, digital learning content, mobile learning)', 'standard_qty' => '1 paket'],
                ],
            ],

            // 7. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 8. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux (SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 pria + 1 wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011)'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Jarak masing-masing 3 m'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 9. PENERAPAN BUDAYA KERJA INDUSTRI
            [
                'title' => 'Penerapan Budaya Kerja Industri',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3 (C.A.N.T.I.K./T.A.M.P.A.N.)'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang'],
                ],
            ],
        ],
    ],

    'Teknik Komputer dan Jaringan' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Mekanik Teknik Elektro', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Praktik Instalasi Jaringan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Ruang Perbaikan dan Perawatan Komputer', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                ],
            ],

            // 2. PERALATAN SUB AREA KERJA MEKANIK TEKNIK ELEKTRO
            [
                'title' => 'Peralatan Sub Area Kerja Mekanik Teknik Elektro',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Obeng Kembang', 'spec' => 'Untuk membuka sekrup dengan mata obeng berbentuk kembang/plus, ukuran PH 0-2 x 75 mm, material chrome vanadium', 'standard_qty' => '18 unit'],
                    ['name' => 'Obeng Pilih', 'spec' => 'Untuk membuka sekrup dengan mata obeng pipih/minus, ukuran 6 x 150 mm, material chrome vanadium', 'standard_qty' => '18 unit'],
                    ['name' => 'Kabel LAN Tester', 'spec' => 'Untuk memeriksa konektivitas kabel LAN, dapat menguji kabel UTP, STP, BNC', 'standard_qty' => '9 unit'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45 ke kabel UTP', 'standard_qty' => '9 unit'],
                ],
            ],

            // 3. PERALATAN SUB AREA KERJA MEKANIK TEKNIK ELEKTRO (MCU Training)
            [
                'title' => 'Peralatan Sub Area Kerja Mekanik Teknik Elektro (MCU Training)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'MCU Training Set', 'spec' => 'Power output: 5V/1A DC voltage source, 12V/1A DC voltage source, 5V/3A DC voltage source, dilengkapi workbench, power supply, signal generator', 'standard_qty' => '4 set'],
                    ['name' => 'Digital Trainer Board Microcontroller', 'spec' => 'Untuk pembelajaran mikrokontroler Atmega16, dilengkapi safety universal relais board, transfersystem 24V DC', 'standard_qty' => '4 set'],
                    ['name' => 'Aplikasi Software Pengendali Mikrokontroler', 'spec' => 'Software untuk simulasi dan pengendali mikrokontroler', 'standard_qty' => '4 paket'],
                    ['name' => 'Tool Set', 'spec' => 'Kit peralatan untuk instalasi dan perawatan komputer', 'standard_qty' => '4 set'],
                ],
            ],

            // 4. PERALATAN SUB RUANG PRAKTIK INSTALASI JARINGAN
            [
                'title' => 'Peralatan Sub Ruang Praktik Instalasi Jaringan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Access Point Indoor', 'spec' => 'Connectivity: 802.11 n/g/b wireless, Operating Modes: Access Point (AP), WDS with AP, WDS/Bridge, Wireless Client, VLAN/SSID Support', 'standard_qty' => '4 unit'],
                    ['name' => 'Access Point Outdoor', 'spec' => 'Untuk menghubungkan antar PC dengan gelombang radio jarak jauh', 'standard_qty' => '4 unit'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik single mode/multimode', 'standard_qty' => '4 unit'],
                    ['name' => 'Cleaver dan Stripper', 'spec' => 'Untuk mengupas kabel optik dan memotong core, diameter fiber 125μm, cladding diameter 0.125 mm', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Untuk penyambungan kabel fiber optik, automatic/manual operation, display 5.1" color TFT', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik, wavelength 800-1700nm, detector InGaAs, measurement range -70 s.d. +6 dBm', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengukur parameter sinyal optik (attenuation, panjang kabel, loss), dead zone 0.8m, auto/manual test', 'standard_qty' => '4 unit'],
                    ['name' => 'Fluke Tester', 'spec' => 'Untuk mengecek kondisi kabel jaringan, media access 1000BASE-T (IEEE 802.3af)', 'standard_qty' => '4 unit'],
                    ['name' => 'Router', 'spec' => 'Antarmuka 5 x 10/100/1000 (1 WAN dan 4 LAN), processor 1.7GHz, RAM 512 MB', 'standard_qty' => '4 unit'],
                    ['name' => 'Switch Manageable', 'spec' => 'Layer 3 switching, VLAN support', 'standard_qty' => '4 unit'],
                    ['name' => 'PC Server', 'spec' => 'Processor minimal 3.0 GHz, RAM 8 GB, HDD 1 TB', 'standard_qty' => '4 unit'],
                    ['name' => 'Server Rack 19 inch', 'spec' => 'Untuk menyimpan server, dilengkapi PDU outlet', 'standard_qty' => '1 unit'],
                    ['name' => 'Komputer Client', 'spec' => 'Resolusi minimal 1920 x 1080, Optical USB Mouse, USB Keyboard', 'standard_qty' => '4 unit'],
                ],
            ],

            // 5. PERALATAN SUB RUANG PERBAIKAN DAN PERAWATAN KOMPUTER
            [
                'title' => 'Peralatan Sub Ruang Perbaikan dan Perawatan Komputer',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Obeng Kembang', 'spec' => 'Untuk membuka sekrup', 'standard_qty' => '18 unit'],
                    ['name' => 'Kabel LAN Tester', 'spec' => 'Untuk memeriksa konektivitas kabel LAN', 'standard_qty' => '9 unit'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45', 'standard_qty' => '9 unit'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik untuk praktik', 'standard_qty' => '4 unit'],
                    ['name' => 'Cleaver dan Stripper', 'spec' => 'Untuk mengupas kabel optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Untuk penyambungan kabel fiber optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Untuk mengukur kekuatan sinyal optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Untuk mengukur parameter sinyal optik', 'standard_qty' => '4 unit'],
                    ['name' => 'Fluke Tester', 'spec' => 'Untuk mengecek kondisi kabel jaringan', 'standard_qty' => '4 unit'],
                    ['name' => 'MCU Training Set', 'spec' => 'Untuk pembelajaran mikrokontroler', 'standard_qty' => '4 unit'],
                    ['name' => 'Digital Trainer Board Microcontroller', 'spec' => 'Trainer mikrokontroler', 'standard_qty' => '4 unit'],
                    ['name' => 'Aplikasi Software Pengendali Mikro', 'spec' => 'Software simulasi', 'standard_qty' => '4 paket'],
                    ['name' => 'Tool Set', 'spec' => 'Kit peralatan perbaikan', 'standard_qty' => '4 set'],
                ],
            ],

            // 6. TAMBAHAN PERALATAN PADA RUANG INSTALASI JARINGAN KOMPUTER
            [
                'title' => 'Tambahan Peralatan pada Ruang Instalasi Jaringan Komputer',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'IP PBX', 'spec' => 'Sentral telepon PBX berbasis IP, integrated 2 FXO + 2 FXS port, protokol SIP, IAX2, codec G.711, G.722, G.726, G.729A', 'standard_qty' => '6 set'],
                    ['name' => 'IP Phone', 'spec' => 'Telepon berbasis SIP, 10/100BASE-T, 3-way conference, multi-language support, PoE integrated', 'standard_qty' => '6 unit'],
                    ['name' => 'RFID Training Kit', 'spec' => 'Untuk praktik sistem RFID, dilengkapi base unit, board programming, board RFID, RFID tags', 'standard_qty' => '6 set'],
                    ['name' => 'Simulator Jaringan', 'spec' => 'Untuk simulasi jaringan kondisi nyata, dilengkapi patch panel, VGA port, USB port, LCD monitor, meja trainer, switch panel, media converter, routerboard, modem 3G/4G, antena sectoral', 'standard_qty' => '6 set'],
                    ['name' => 'Network Simulator', 'spec' => 'Untuk simulasi jaringan, dilengkapi application layer protocol module, routing layer protocol module, physical layer protocol module, media converter dengan SFP module', 'standard_qty' => '4 set'],
                    ['name' => 'IP Camera WiFi', 'spec' => 'CMOS 1 MP, Pan/Tilt, HD p2p, wifi 802.11b/g/n, Ethernet 100 Mbps RJ-45, support HTTP, FTP, TCP/IP, UDP, SMTP, DHCP, PPPoE, DDNS, UPnP', 'standard_qty' => '4 unit'],
                ],
            ],

            // 7. PERALATAN SUB RUANG PRAKTIK FIBER OPTIK
            [
                'title' => 'Peralatan Sub Ruang Praktik Fiber Optik',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Optical Network Unit (ONU)', 'spec' => 'GPON ONT, 1 port gigabit, 1 port FXS, 2.4G WiFi', 'standard_qty' => '4 unit'],
                    ['name' => 'OTB 12 Core', 'spec' => 'Untuk terminasi kabel fiber optik, 12 core', 'standard_qty' => '4 unit'],
                    ['name' => 'Roset', 'spec' => 'Kotak penghubung indoor optik ke CPE', 'standard_qty' => '4 unit'],
                    ['name' => 'Patch Cord Fiber Optic', 'spec' => 'Type SC/DC-LC UPC, single mode duplex, panjang 3 meter', 'standard_qty' => '4 unit'],
                    ['name' => 'SC Adapter', 'spec' => 'Untuk menghubungkan konektor serat optik, tipe SC-FC UPC', 'standard_qty' => '4 unit'],
                    ['name' => 'Pigtail', 'spec' => 'Untuk terminasi kabel fiber optik, berbagai core', 'standard_qty' => '4 unit'],
                ],
            ],

            // 8. TAMBAHAN RUANG PRAKTIK DESAIN GRAFIS
            [
                'title' => 'Tambahan Ruang Praktik Desain Grafis',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Komputer Grafis', 'spec' => 'Untuk pengolahan gambar berbasis pixel dan raster, spesifikasi tinggi', 'standard_qty' => '4 unit'],
                    ['name' => 'Software Grafis Editing (Pixel)', 'spec' => 'Software editing gambar berbasis pixel (setara Adobe Photoshop)', 'standard_qty' => '4 paket'],
                    ['name' => 'Software Grafis Editing (Vektor)', 'spec' => 'Software editing gambar berbasis vektor (setara CorelDraw, Adobe Illustrator)', 'standard_qty' => '4 paket'],
                    ['name' => 'Pen Tablet', 'spec' => 'Stylus tanpa kabel, tekanan 8192 levels, dilengkapi penghapus', 'standard_qty' => '4 unit'],
                ],
            ],

            // 9. TAMBAHAN RUANG PEMROGRAMAN DASAR
            [
                'title' => 'Tambahan Ruang Pemrograman Dasar',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'PC/Computer', 'spec' => 'Untuk pembelajaran pemrograman dasar, monitor 23.8 inch, wireless mouse, OS Windows 10 Home', 'standard_qty' => '4 unit'],
                    ['name' => 'Software Dasar', 'spec' => 'Software untuk pembelajaran pemrograman', 'standard_qty' => '4 paket'],
                ],
            ],

            // 10. KELENGKAPAN SMART CLASSROOM
            [
                'title' => 'Kelengkapan Smart Classroom',
                'type' => 'equipment_no_spec',
                'items' => [
                    ['name' => 'Smart Board / Whiteboard Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart TV Videoconference', 'standard_qty' => '1 unit'],
                    ['name' => 'HD Pro Cam / Live Casting', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Table Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Controlroom Console', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Document Camera', 'standard_qty' => '1 unit'],
                    ['name' => 'Platform Pendukung (Student Response System, digital learning content, mobile learning)', 'standard_qty' => '1 paket'],
                ],
            ],

            // 11. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 12. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux (SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 pria + 1 wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011)'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Jarak masing-masing 3 m'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 13. PENERAPAN BUDAYA KERJA INDUSTRI
            [
                'title' => 'Penerapan Budaya Kerja Industri',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3 (C.A.N.T.I.K./T.A.M.P.A.N.)'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang'],
                ],
            ],
        ],
    ],

    'Rekayasa Perangkat Lunak' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Pengembangan Perangkat Lunak (Software)', 'standard_area' => '3 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Area Kerja/Studio Web Desain', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Perawatan dan Perbaikan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Instruktur dan Penyimpanan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                ],
            ],

            // 2. PERABOT DAN PERALATAN SUB RUANG PRAKTIK PENGEMBANGAN PERANGKAT LUNAK
            [
                'title' => 'Perabot dan Peralatan Sub Ruang Praktik Pengembangan Perangkat Lunak',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Komputer Server', 'spec' => 'Menyediakan berbagai layanan yang dapat diakses oleh komputer klien', 'standard_qty' => '2 unit'],
                    ['name' => 'Komputer All in One', 'spec' => 'Processor min 2.3 GHz, RAM min 8 GB, HDD min 1 TB, layar min 18.5" resolusi 1366x768', 'standard_qty' => '18 unit'],
                    ['name' => 'Laptop', 'spec' => 'Untuk pengembangan mobile', 'standard_qty' => '18 unit'],
                    ['name' => 'Barcode Scanner', 'spec' => 'Handheld, 1D/2D (QR Code), kecepatan 1.0 unit/second, interface USB 2.0', 'standard_qty' => '6 unit'],
                    ['name' => 'Smartphone', 'spec' => 'Interface USB Type-C, GPS, GLONASS, WiFi, Bluetooth, NFC', 'standard_qty' => '18 unit'],
                    ['name' => 'RFID Training Kit', 'spec' => 'Untuk pembelajaran RFID', 'standard_qty' => '1 set'],
                    ['name' => 'UPS (Uninterruptible Power Supply)', 'spec' => 'Minimal 1200 VA', 'standard_qty' => '18 unit'],
                    ['name' => 'Access Point', 'spec' => 'Operating Mode: Access Point, WDS', 'standard_qty' => '1 unit'],
                    ['name' => 'Harddisk Eksternal', 'spec' => 'Kapasitas 2 TB, Port USB 3.2 Gen 1', 'standard_qty' => '6 unit'],
                    ['name' => 'Proyektor', 'spec' => 'Resolusi WUXGA, brightness min 3200 Lumen', 'standard_qty' => '1 unit'],
                    ['name' => 'Screen Proyektor', 'spec' => 'Ukuran 100 inch (1150 x 200 cm)', 'standard_qty' => '1 unit'],
                    ['name' => 'Bracket Proyektor', 'spec' => 'Max load 10 kg, height 75-105 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, W42 x D50 x H90 cm, dudukan busa injection', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Kerja', 'spec' => '900 x 450 mm, material MFC', 'standard_qty' => '19 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => '150 x 75 x 80 cm, dapat dipindah', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja untuk Siswa', 'spec' => 'W42 x D50 x H90 cm, dudukan busa injection', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => '1200 x 600 x 750 mm, particle board', 'standard_qty' => '2 unit'],
                ],
            ],

            // 3. PERABOT DAN PERALATAN SUB AREA KERJA/STUDIO WEB DESAIN
            [
                'title' => 'Perabot dan Peralatan Sub Area Kerja/Studio Web Desain',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Komputer Server', 'spec' => 'Untuk menyediakan layanan web server', 'standard_qty' => '2 unit'],
                    ['name' => 'Komputer All in One', 'spec' => 'Processor Intel Core i7, RAM 8 GB, HDD 1 TB', 'standard_qty' => '18 unit'],
                    ['name' => 'Laptop', 'spec' => 'Untuk desain mobile', 'standard_qty' => '18 unit'],
                    ['name' => 'Barcode Scanner', 'spec' => 'Untuk pembacaan barcode/QR', 'standard_qty' => '6 unit'],
                    ['name' => 'Smartphone', 'spec' => 'Untuk uji coba aplikasi mobile', 'standard_qty' => '18 unit'],
                    ['name' => 'Harddisk Eksternal', 'spec' => 'Kapasitas 2 TB', 'standard_qty' => '6 unit'],
                    ['name' => 'Proyektor', 'spec' => 'Resolusi WUXGA, brightness 3200 Lumen', 'standard_qty' => '1 unit'],
                    ['name' => 'Screen Proyektor', 'spec' => 'Ukuran 100 inch', 'standard_qty' => '1 unit'],
                    ['name' => 'Bracket Proyektor', 'spec' => 'Max load 10 kg', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, busa injection', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Kerja', 'spec' => '900 x 450 mm, MFC', 'standard_qty' => '19 unit'],
                    ['name' => 'Papan Tulis', 'spec' => '150 x 75 x 80 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja untuk Siswa', 'spec' => 'Ergonomis, busa injection', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => '1200 x 600 x 750 mm', 'standard_qty' => '2 unit'],
                ],
            ],

            // 4. PERABOT DAN PERALATAN SUB RUANG PERAWATAN DAN PERBAIKAN
            [
                'title' => 'Perabot dan Peralatan Sub Ruang Perawatan dan Perbaikan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Obeng Set', 'spec' => 'Mata obeng berbagai ukuran, dilengkapi magnet', 'standard_qty' => '18 unit'],
                    ['name' => 'Tang Kombinasi', 'spec' => 'Multi fungsi: pemotong kabel, pengupas kulit kabel, melilit kabel', 'standard_qty' => '18 unit'],
                    ['name' => 'LAN Tester', 'spec' => 'Untuk memeriksa konektivitas kabel LAN', 'standard_qty' => '9 unit'],
                    ['name' => 'Tang Crimping', 'spec' => 'Untuk pemasangan konektor RJ45 ke kabel UTP', 'standard_qty' => '9 unit'],
                    ['name' => 'Tisu/Kain Kering dan Cairan Pembersih', 'spec' => 'Untuk membersihkan layar monitor', 'standard_qty' => '18 unit'],
                    ['name' => 'Penyedot Debu Mini', 'spec' => 'Untuk membersihkan debu pada perangkat', 'standard_qty' => '3 unit'],
                ],
            ],

            // 5. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, nyaman', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Untuk menyimpan peralatan, sistem knock down', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Alat', 'spec' => 'Untuk perbaikan, sistem knock down', 'standard_qty' => '1 unit'],
                    ['name' => 'Thermometer Infrared', 'spec' => 'Type: Infrared Thermometer, Accuracy +/-2%, Laser Class: Laser pointer, Temperature: +50 to 280°C', 'standard_qty' => '9 unit'],
                ],
            ],

            // 6. KELENGKAPAN SMART CLASSROOM
            [
                'title' => 'Kelengkapan Smart Classroom',
                'type' => 'equipment_no_spec',
                'items' => [
                    ['name' => 'Smart Board / Whiteboard Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart TV Videoconference', 'standard_qty' => '1 unit'],
                    ['name' => 'HD Pro Cam / Live Casting', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Table Interaktif', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Controlroom Console', 'standard_qty' => '1 unit'],
                    ['name' => 'Smart Document Camera', 'standard_qty' => '1 unit'],
                    ['name' => 'Platform Pendukung (Student Response System, digital learning content, mobile learning)', 'standard_qty' => '1 paket'],
                ],
            ],

            // 7. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 8. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux (SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 pria + 1 wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011)'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Jarak masing-masing 3 m'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 9. PENERAPAN BUDAYA KERJA INDUSTRI
            [
                'title' => 'Penerapan Budaya Kerja Industri',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3 (C.A.N.T.I.K./T.A.M.P.A.N.)'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang'],
                ],
            ],
        ],
    ],

   
];
