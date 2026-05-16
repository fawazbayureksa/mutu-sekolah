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
    'Teknik_Jaringan_Akses_Telekomunikasi' => [
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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

    'Pengembangan_GIM' => [
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
                    ['name' => 'Game Engine (Unity)', 'spec' => 'Platform: Windows, macOS, Linux. Lisensi: Software berlisensi resmi (Unity Pro - Lisensi Pendidikan). Fitur: Dukungan pengembangan gim 3D/2D, aset store, dokumentasi lengkap, multi-platform build. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Game Engine (Unreal Engine)', 'spec' => 'Platform: Windows, macOS, Linux. Lisensi: Software berlisensi resmi (Unreal Engine - Full Features). Fitur: Dukungan pengembangan gim 3D/2D, blueprint system, real-time rendering, dokumentasi lengkap. Garansi: Minimal 1 tahun untuk dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Software Desain 2D', 'spec' => 'Platform: Windows, macOS. Lisensi: Software berlisensi resmi (Adobe Photoshop/Illustrator) atau setara (GIMP/Krita - Open Source). Fitur: Desain grafis, ilustrasi, editing gambar, manipulasi foto, pembuatan aset 2D. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Software Desain 3D', 'spec' => 'Platform: Windows, macOS. Lisensi: Software berlisensi resmi (Autodesk Maya/3DS Max - Lisensi Pendidikan) atau Blender (Open Source). Fitur: Pemodelan 3D, texturing, rendering, animasi 3D, rigging. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Software Animasi 2D', 'spec' => 'Platform: Windows, macOS. Lisensi: Software berlisensi resmi (Spine/Adobe Animate). Fitur: Animasi 2D karakter, rigging, skeletal animation, ekspor ke berbagai format game engine. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '9 Unit/Ruang Praktik'],
                    ['name' => 'Software Pemodelan 3D (Sculpting)', 'spec' => 'Platform: Windows, macOS. Lisensi: Software berlisensi resmi (ZBrush). Fitur: Digital sculpting, high-poly modeling, texture painting, ekspor normal/displacement map. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '6 Unit/Ruang Praktik'],
                    ['name' => 'Software Audio', 'spec' => 'Platform: Windows, macOS. Lisensi: Software berlisensi resmi (Adobe Audition) atau Audacity (Open Source). Fitur: Editing suara, rekaman, mixing audio, efek suara, mastering untuk game audio. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '9 Unit/Ruang Praktik'],
                    ['name' => 'Integrated Development Environment (IDE)', 'spec' => 'Platform: Windows, macOS, Linux. Lisensi: Software berlisensi resmi (Visual Studio). Fitur: Scripting, programming, debugging, intellisense, integrasi dengan game engine. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Version Control System', 'spec' => 'Platform: Windows, macOS, Linux. Lisensi: Software berlisensi resmi (Git/GitHub Desktop) atau open source. Fitur: Kolaborasi tim, versioning, branching, merging, integrasi dengan IDE. Garansi: Minimal 1 tahun untuk lisensi dan dukungan teknis', 'standard_qty' => '18 Unit/Ruang Praktik'],
                    ['name' => 'Software Manajemen Proyek', 'spec' => 'Platform: Web-based, Windows, macOS, iOS, Android. Lisensi: Software berlisensi resmi (Trello/Jira - Akun Berlangganan). Fitur: Manajemen tugas, kolaborasi tim, tracking progres, sprint planning (untuk Jira). Garansi: Minimal 1 tahun untuk lisensi dan akses dan dukungan teknis', 'standard_qty' => '1 Paket/Ruang Praktik'],
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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

    'Sistem_Informasi_Jaringan_Dan_Aplikasi' => [
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                ],
            ],
        ],
    ],

    'Teknik_Komputer_dan_Jaringan' => [
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Rekayasa_Perangkat_Lunak' => [
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Teknik_Transmisi_Telekomunikasi' => [
        'sections' => [
            // 1. RUANG PRAKTIK SISWA (RPS)
            [
                'title' => 'Ruang Praktik Siswa (RPS)',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Praktik Utama (Area Kerja Bengkel dan Kelistrikan)', 'standard_area' => '3 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Ruang Praktik Utama (Area Kerja Transmisi Kabel Serat Optik, Satelit, dan Radio)', 'standard_area' => '4 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Ruang Praktik Utama (Area Kerja Sistem Komputer, Elektronika, dan Mikroprosesor)', 'standard_area' => '4 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Area Kerja Lab Radio Outdoor dan Indoor', 'standard_area' => '3 m²/peserta didik', 'capacity' => '18 siswa'],
                    ['name' => 'Ruang Instruktur dan Penyimpanan', 'standard_area' => '6 m²/instruktur', 'capacity' => '3 instruktur'],
                ],
            ],

            // 2. PERALATAN AREA KERJA BENGKEL DAN KELISTRIKAN
            [
                'title' => 'Peralatan Area Kerja Bengkel dan Kelistrikan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Gerinda Tangan', 'spec' => 'Daya listrik sekitar 670W, ukuran batu gerinda 4" (100mm), kecepatan tanpa beban sekitar 12.000 rpm', 'standard_qty' => '6 Unit'],
                    ['name' => 'Mesin Bor Tangan', 'spec' => 'Daya listrik sekitar 500W, kapasitas bor besi minimal 10 mm, kecepatan tanpa beban 0-3000 rpm', 'standard_qty' => '2 Unit'],
                    ['name' => 'Gerinda Potong', 'spec' => 'Daya sekitar 2000W, ukuran cakram sekitar 355mm, kecepatan tanpa beban sekitar 3800 rpm', 'standard_qty' => '2 Unit'],
                    ['name' => 'Gerinda Sudut (Angle Grinder)', 'spec' => 'Daya 500-700 Watt, kecepatan 8.000-12.000 rpm, diameter roda 100-125mm', 'standard_qty' => '2 Unit'],
                    ['name' => 'Bor Duduk (Bench Drill)', 'spec' => 'Daya 350-400 Watt, kecepatan 0-3000 rpm, ukuran chuck 16mm', 'standard_qty' => '2 Unit'],
                    ['name' => 'Cut Off Saw', 'spec' => 'Daya 1500-2000 Watt, kecepatan 3000-5000 rpm', 'standard_qty' => '2 Unit'],
                    ['name' => 'Bench Grinder', 'spec' => 'Daya motor 500-700 Watt, diameter roda 200mm', 'standard_qty' => '3 Unit'],
                    ['name' => 'Ragum (Bench Vice)', 'spec' => 'Ukuran minimal 5 inci, tipe cross (2 arah)', 'standard_qty' => '18 Unit'],
                    ['name' => 'Obeng Set (Kembang dan Pilih)', 'spec' => 'Set obeng untuk sekrup plus (PH) dan minus (SL), dengan berbagai ukuran. Material chrome vanadium', 'standard_qty' => '18 Unit'],
                    ['name' => 'Tool Kit', 'spec' => 'Set lengkap berisi kunci pas, kunci L, tang, obeng, palu, dan alat ukur', 'standard_qty' => '3 Set'],
                ],
            ],

            // 3. PERALATAN AREA KERJA TRANSMISI KABEL SERAT OPTIK, SATELIT, DAN RADIO
            [
                'title' => 'Peralatan Area Kerja Transmisi Kabel Serat Optik, Satelit, dan Radio',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Optical Time Domain Reflectometer (OTDR)', 'spec' => 'Panjang gelombang 1310/1550 nm, rentang dinamis 38/37 dB, auto/manual test', 'standard_qty' => '4 Unit'],
                    ['name' => 'Optical Power Meter (OPM)', 'spec' => 'Konektor universal (FC, SC, ST), daya tahan baterai hingga 240 jam', 'standard_qty' => '4 Unit'],
                    ['name' => 'Optical Fusion Splicer', 'spec' => 'Mendukung serat SM, MM, DS, NZD. Waktu penyambungan cepat (≤9 detik)', 'standard_qty' => '4 Unit'],
                    ['name' => 'Cleaver dan Stripper Fiber Optik', 'spec' => 'Untuk mengupas dan memotong core serat optik, diameter fiber 125μm', 'standard_qty' => '4 Unit'],
                    ['name' => 'Fiber Optic Cable', 'spec' => 'Kabel fiber optik single mode/multimode', 'standard_qty' => '4 Unit'],
                    ['name' => 'Optical Network Unit (ONU)', 'spec' => 'GPON ONT, 1 port gigabit, 2.4G WiFi', 'standard_qty' => '4 Unit'],
                    ['name' => 'OTB 12 Core', 'spec' => 'Panel untuk terminasi kabel fiber optik, 12 core', 'standard_qty' => '4 Unit'],
                    ['name' => 'Roset Fiber Optik', 'spec' => 'Kotak penghubung indoor optik ke CPE', 'standard_qty' => '4 Unit'],
                    ['name' => 'Patch Cord Fiber Optic', 'spec' => 'Type SC/DC-LC UPC, single mode duplex, panjang 3 meter', 'standard_qty' => '4 Unit'],
                    ['name' => 'SC Adapter', 'spec' => 'Untuk menghubungkan konektor serat optik, tipe SC-FC UPC', 'standard_qty' => '4 Unit'],
                    ['name' => 'Pigtail Fiber Optik', 'spec' => 'Untuk terminasi kabel fiber optik', 'standard_qty' => '4 Unit'],
                    ['name' => 'Access Point Outdoor', 'spec' => 'Untuk menghubungkan antar perangkat dengan gelombang radio jarak jauh, tahan cuaca', 'standard_qty' => '4 Unit'],
                    ['name' => 'Fluke Tester', 'spec' => 'Untuk menguji dan mendiagnosis jaringan kabel', 'standard_qty' => '4 Unit'],
                    ['name' => 'Network Simulator', 'spec' => 'Untuk mempelajari simulasi jaringan, dilengkapi berbagai modul protokol', 'standard_qty' => '4 Unit'],
                    ['name' => 'Switch Manageable', 'spec' => 'Layer 3 switching, mendukung konfigurasi VLAN, firewall, bandwidth limiter', 'standard_qty' => '4 Unit'],
                    ['name' => 'Router', 'spec' => 'Antarmuka 5 x 10/100/1000 (min. 1 WAN dan 4 LAN), processor ≥ 1.7GHz', 'standard_qty' => '4 Unit'],
                    ['name' => 'Komputer Client', 'spec' => 'Untuk praktik konfigurasi dan monitoring, resolusi minimal 1920 x 1080', 'standard_qty' => '4 Unit'],
                    ['name' => 'Antenna Analyzer', 'spec' => 'Untuk mengukur impedansi antena dan pengujian RF', 'standard_qty' => '3 Unit'],
                ],
            ],

            // 4. PERALATAN AREA KERJA SISTEM KOMPUTER, ELEKTRONIKA, DAN MIKROPROSESOR
            [
                'title' => 'Peralatan Area Kerja Sistem Komputer, Elektronika, dan Mikroprosesor',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'MCU Training Set', 'spec' => 'Untuk pelatihan/percobaan tentang microcomputer dasar. Dilengkapi workbench, power supply, signal generator', 'standard_qty' => '4 Set'],
                    ['name' => 'Digital Trainer Board Microcontroller', 'spec' => 'Untuk pembelajaran mikrokontroler (misal: Atmega), dilengkapi berbagai modul I/O', 'standard_qty' => '4 Set'],
                    ['name' => 'Aplikasi Software Pengendali Mikrokontroler', 'spec' => 'Software untuk simulasi dan pemrograman mikrokontroler', 'standard_qty' => '4 Paket'],
                    ['name' => 'RFID Training Kit', 'spec' => 'Untuk praktik sistem RFID, dilengkapi base unit, board RFID, dan RFID tags', 'standard_qty' => '4 Set'],
                    ['name' => 'Komputer Grafis', 'spec' => 'Untuk pemrograman dan desain, spesifikasi tinggi', 'standard_qty' => '4 Unit'],
                ],
            ],

            // 5. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'Alat Pelindung Diri (APD)', 'spec' => 'Set terdiri dari: baju hazmat, face shield, kacamata safety, masker N95, sarung tangan, sepatu boot', 'standard_qty' => '18 Set'],
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji. Jenis: Dry Chemical Powder', 'standard_qty' => '4 Unit'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 Unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 Set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 Unit'],
                    ['name' => 'Rambu K3 dan Jalur Evakuasi', 'spec' => 'Ada rambu yang jelas dan mudah dilihat menuju titik kumpul', 'standard_qty' => '1 Set'],
                ],
            ],

            // 6. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses dengan bandwidth memadai'],
                    ['name' => 'Pencahayaan Alami dan Buatan', 'spec' => 'Minimal 250 lux di area praktik (mengacu SNI 03-6197-2000)'],
                    ['name' => 'Ventilasi Udara', 'spec' => 'Sirkulasi udara baik (mengacu SNI 03-6572-2001)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita', 'spec' => 'Minimal 1 unit untuk pria dan 1 unit untuk wanita'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Tersedia dan mengalir lancar'],
                    ['name' => 'Instalasi Listrik yang Aman', 'spec' => 'Sesuai PUIL 2011 (SNI 0225:2011), dilengkapi pengaman'],
                    ['name' => 'Stop Kontak 1 Phase', 'spec' => 'Tersedia di titik-titik strategis'],
                    ['name' => 'Sistem Penangkal Petir', 'spec' => 'SNI 03-7015-2004, grounding ≤5 Ohm'],
                ],
            ],

            // 7. PENERAPAN BUDAYA KERJA INDUSTRI
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Agribisnis_Perikanan_Air_Tawar' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Laboratorium Hama dan Penyakit Ikan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal/Kolam Induk Jantan dan Kolam Induk Betina', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pemijahan, Penanganan Larva dan Pembuatan Pakan Alami, Pakan Buatan (Pellet) dan Penyimpanan (Gudang) Pakan Buatan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pendederan 1, Pendederan 2, Pendederan 3, dan Kolam Pembesaran Ikan/Kolam Produksi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Produksi', 'standard_area' => '30 m²/peserta', 'capacity' => '36 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']
                ],
            ],

            // 2. PERABOT DAN PERALATAN LABORATORIUM HAMA DAN PENYAKIT
            [
                'title' => 'Perabot dan Peralatan Laboratorium Hama dan Penyakit',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mikroskop', 'spec' => 'Untuk melihat bentuk bakteri/hama', 'standard_qty' => '2 unit'],
                    ['name' => 'Ekman Grab', 'spec' => 'Untuk pengambilan sampel benthos', 'standard_qty' => '3 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Untuk mengukur kadar gula/garam', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '2 unit'],
                    ['name' => 'Portable pH/ORP/Conductivity/DO Meter', 'spec' => 'Multi-parameter uji kualitas air', 'standard_qty' => '2 unit'],
                    ['name' => 'Turbidity Meter', 'spec' => 'Ukur kekeruhan air, range 0-200 NTU', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Hardness Tester', 'spec' => 'Menguji tingkat kesadahan air', 'standard_qty' => '2 unit'],
                    ['name' => 'BOD Meter', 'spec' => 'Mengukur oksigen terlarut', 'standard_qty' => '3 unit'],
                    ['name' => 'BOD Incubator', 'spec' => 'Kapasitas min 80L, range suhu 0-60°C', 'standard_qty' => '1 unit'],
                    ['name' => 'COD Analyzer', 'spec' => 'Untuk pengujian COD', 'standard_qty' => '1 unit'],
                    ['name' => 'Centrifuge', 'spec' => 'Max RCF 20.913, dengan rotor', 'standard_qty' => '3 unit'],
                    ['name' => 'Alat Pengukur Panjang Ikan', 'spec' => 'Bahan HDPE, skala 1 mm, panjang 60-75 cm', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari ES', 'spec' => 'Untuk menyimpan bahan/obat suhu rendah', 'standard_qty' => '1 unit'],
                    ['name' => 'Sedgewick-Rafter Counting Cell', 'spec' => 'Alat hitung jumlah plankton', 'standard_qty' => '6 unit'],
                    ['name' => 'Pisau Bedah', 'spec' => 'Alat bedah ikan, stainless steel', 'standard_qty' => '3 unit'],
                    ['name' => 'Gunting Bedah', 'spec' => 'Lurus, ujung tumpul, 14 cm', 'standard_qty' => '18 unit'],
                    ['name' => 'Gelas Ukur', 'spec' => '1 set gelas laboratorium, borosilicate', 'standard_qty' => '6 unit'],
                    ['name' => 'Pipet Ukur', 'spec' => '1 ml, 5 ml, 10 ml, 25 ml, kaca standar', 'standard_qty' => '6 unit'],
                    ['name' => 'Plankton Net', 'spec' => 'Diameter bukaan 30 cm, tinggi 100 cm, mesh size 200', 'standard_qty' => '3 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm, seat foam laminated', 'standard_qty' => '19 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'L1400 x W700 x H730 mm, sheet metal, MDF 25 mm', 'standard_qty' => '19 unit'],
                ],
            ],

            // 3. PERALATAN LABORATORIUM PAKAN BUATAN
            [
                'title' => 'Peralatan Laboratorium Pakan Buatan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '2 unit'],
                    ['name' => 'Mesin Penepung Disk Mill', 'spec' => 'Penggerak motor diesel 5,5 HP, kecepatan 9000 rpm, kapasitas 55 kg/jam', 'standard_qty' => '1 unit'],
                    ['name' => 'Oven', 'spec' => 'Range suhu room temp - 300°C, kapasitas min 140 L', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Cetak Pelet Apung', 'spec' => 'Kapasitas 30-40 kg, motor diesel', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Mixer', 'spec' => 'Kapasitas 100 kg, penggerak 5,5 HP', 'standard_qty' => '1 unit'],
                    ['name' => 'Pellet Mills', 'spec' => 'Untuk uji kualitas pelet', 'standard_qty' => '1 unit'],
                ],
            ],

            // 4. PERALATAN PRODUKSI BUDIDAYA
            [
                'title' => 'Peralatan Produksi Budidaya (Perawatan Induk, Pemijahan, Penanganan Telur, Perawatan Larva, Pendederan dan Pembuatan Pakan Alami)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass', 'spec' => 'Untuk kultur pakan alami', 'standard_qty' => '1 unit'],
                    ['name' => 'Corong Tetas', 'spec' => 'Untuk menetaskan artemia', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium', 'spec' => 'Untuk menetaskan telur ikan, P 200 cm, L 100 cm, T 100 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Bak Fiberglass Persegi', 'spec' => 'Untuk pendederan ikan, P 2 m, L 1 m, outlet pembuangan', 'standard_qty' => '1 unit'],
                    ['name' => 'Corong Tetas Telur', 'spec' => 'Untuk menetaskan telur ikan, diameter min 30 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Bak Fiberglass Persegi', 'spec' => 'Untuk pemeliharaan ikan', 'standard_qty' => '1 unit'],
                    ['name' => 'Water Pump', 'spec' => 'Mesin pemompa air', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass Persegi', 'spec' => 'Untuk wadah pemeliharaan induk', 'standard_qty' => '1 unit'],
                    ['name' => 'Pompa Udara/Blower/Aerator', 'spec' => 'Untuk memompa udara ke kolam', 'standard_qty' => '1 unit'],
                    ['name' => 'Pond Blower Filter', 'spec' => 'Untuk resirkulasi air kolam', 'standard_qty' => '2 unit'],
                    ['name' => 'Fish Counter', 'spec' => 'Alat penghitung ikan digital', 'standard_qty' => '1 unit'],
                    ['name' => 'Kotak Pendingin', 'spec' => 'Untuk penyimpanan', 'standard_qty' => '2 unit'],
                    ['name' => 'Freezer', 'spec' => 'Untuk menyimpan bahan/produk', 'standard_qty' => '1 unit'],
                    ['name' => 'Heater Aquarium', 'spec' => 'Bahan kaca/stainless, dilengkapi termostat', 'standard_qty' => '3 unit'],
                    ['name' => 'Autofeeder', 'spec' => 'Pemberi pakan otomatis', 'standard_qty' => '1 unit'],
                    ['name' => 'Seser/Serokan', 'spec' => 'Untuk menangkap ikan kecil', 'standard_qty' => '3 unit'],
                    ['name' => 'Serokan Induk', 'spec' => 'Untuk menangkap induk ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Corong Penetasan Telur Ikan', 'spec' => 'Bahan fiber, diameter min 30 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Corong Tetas Artemia', 'spec' => 'Bahan fiber, untuk penetasan artemia', 'standard_qty' => '3 unit'],
                    ['name' => 'Plankton Net', 'spec' => 'Diameter bukaan 30 cm, mesh size 200', 'standard_qty' => '3 unit'],
                    ['name' => 'Tabung Gas O₂', 'spec' => 'Volume 1 m³, termasuk isi oksigen', 'standard_qty' => '2 unit'],
                    ['name' => 'Generator', 'spec' => 'Minimal 5000 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm', 'standard_qty' => '19 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'L1400 x W700 x H730 mm', 'standard_qty' => '19 unit'],
                ],
            ],

            // 5. PERALATAN BANGSAL KOLAM INDUK JANTAN DAN BETINA
            [
                'title' => 'Peralatan Bangsal Kolam Induk Jantan dan Betina',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass', 'spec' => 'Untuk wadah pemeliharaan induk', 'standard_qty' => '2 unit'],
                ],
            ],

            // 6. PERALATAN KOLAM PENDEDERAN, PEMBESARAN, AKUARIUM, FIBER DAN KOLAM PRODUKSI
            [
                'title' => 'Peralatan Kolam Pendederan, Pembesaran, Akuarium, Fiber dan Kolam Produksi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Penepung Disk Mill', 'spec' => 'Penggerak motor diesel 5,5 HP, kecepatan 9000 rpm', 'standard_qty' => '1 unit'],
                    ['name' => 'Oven', 'spec' => 'Range suhu room temp - 300°C', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Cetak Pelet Apung', 'spec' => 'Kapasitas 30-40 kg', 'standard_qty' => '1 unit'],
                    ['name' => 'Water Pump', 'spec' => 'Mesin pemompa air', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass Persegi', 'spec' => 'Wadah pembesaran ikan, tinggi min 50 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium', 'spec' => 'Wadah penetasan telur, P 100 cm, L 50 cm, T 40 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Pond Blower Filter + Pompa Air', 'spec' => 'Untuk resirkulasi air', 'standard_qty' => '1 unit'],
                    ['name' => 'Tabung Oksigen', 'spec' => 'Untuk packaging, volume 1 m³', 'standard_qty' => '1 unit'],
                    ['name' => 'Tabung CO₂', 'spec' => 'Untuk aquascape, dengan regulator', 'standard_qty' => '1 unit'],
                    ['name' => 'Chiller', 'spec' => 'Untuk menurunkan suhu air, min 1/10 HP', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium Dekorasi', 'spec' => 'Kaca, panjang 1,5 m, tinggi 1,5 m, tebal 12 mm', 'standard_qty' => '2 unit'],
                ],
            ],

            // 7. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, ukuran memadai', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja', 'standard_qty' => '9 unit'],
                    ['name' => 'Komputer/PC All In One', 'spec' => 'Processor 3.0 GHz, RAM 8 GB, HDD 1 TB', 'standard_qty' => '9 unit'],
                    ['name' => 'Printer', 'spec' => 'Printer, scan, copy', 'standard_qty' => '3 unit'],
                    ['name' => 'Filing Cabinet 4 Drawers', 'spec' => 'Rak kabinet 4 laci', 'standard_qty' => '3 unit'],
                    ['name' => 'Shelving 5 Shelf', 'spec' => 'Rak buku 5 susun, 1450 x W620 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Pesawat Telepon', 'spec' => 'Untuk komunikasi jarak jauh', 'standard_qty' => '1 unit'],
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                    ['name' => 'APD (masker, sarung tangan, safety shoes, jas laboratorium)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Agribisnis_Perikanan_Payau_Dan_Laut' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Laboratorium Hama dan Penyakit Ikan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal/Kolam Induk Jantan dan Kolam Induk Betina', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pemijahan, Penanganan Larva, Pembuatan Pakan Alami, dan Gudang Penyimpanan Pakan Buatan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pendederan 1, Pendederan 2, Pendederan 3, dan Kolam Produksi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']
                ],
            ],

            // 2. PERABOT DAN PERALATAN LABORATORIUM HAMA DAN PENYAKIT IKAN
            [
                'title' => 'Perabot dan Peralatan Laboratorium Hama dan Penyakit Ikan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mikroskop', 'spec' => 'Untuk melihat bentuk bakteri/hama', 'standard_qty' => '2 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Untuk mengukur kadar gula/garam, Brix 0-35%', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '1 unit'],
                    ['name' => 'Lux Meter', 'spec' => 'Untuk mengukur intensitas cahaya', 'standard_qty' => '2 unit'],
                    ['name' => 'Portable pH/ORP/Conductivity/DO Meter', 'spec' => 'Multi-parameter uji kualitas air', 'standard_qty' => '2 unit'],
                    ['name' => 'Turbidity Meter', 'spec' => 'Ukur kekeruhan air, range 0-200 NTU', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Hardness Tester', 'spec' => 'Menguji tingkat kesadahan air', 'standard_qty' => '2 unit'],
                    ['name' => 'Ekman Grab', 'spec' => 'Untuk pengambilan sampel benthos', 'standard_qty' => '1 unit'],
                    ['name' => 'Centrifuge', 'spec' => 'Max RCF 20.913, dengan rotor', 'standard_qty' => '2 unit'],
                    ['name' => 'Kotak Pendingin', 'spec' => 'Kapasitas min. 30 liter', 'standard_qty' => '3 unit'],
                    ['name' => 'Tangguk Ikan', 'spec' => 'Untuk menangkap ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Alat Pengukur Panjang Ikan', 'spec' => 'Bahan HDPE, skala 1 mm, panjang 60-75 cm', 'standard_qty' => '9 unit'],
                    ['name' => 'Freezer', 'spec' => 'Kapasitas 4 rak, volume 121 liter', 'standard_qty' => '1 unit'],
                    ['name' => 'Heater Aquarium', 'spec' => 'Untuk memanaskan air, dilengkapi termostat', 'standard_qty' => '1 unit'],
                    ['name' => 'Thermometer', 'spec' => 'Digital, rentang -10°C s.d. 50°C', 'standard_qty' => '3 unit'],
                    ['name' => 'Secchi Disc', 'spec' => 'Untuk mengukur kecerahan air, diameter 20 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Depth Sounder', 'spec' => 'Untuk mengetahui kedalaman air', 'standard_qty' => '1 unit'],
                    ['name' => 'Spectrophotometer', 'spec' => 'Wavelength range 200-1000 nm', 'standard_qty' => '1 unit'],
                    ['name' => 'Shrimp/Fish Test Kit', 'spec' => 'Untuk deteksi virus udang/ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Pisau Bedah', 'spec' => 'Untuk bedah ikan, bahan stainless steel', 'standard_qty' => '3 unit'],
                    ['name' => 'Gunting Bedah', 'spec' => 'Lurus, ujung tumpul, 14 cm, stainless steel', 'standard_qty' => '9 unit'],
                    ['name' => 'Gelas Ukur', 'spec' => 'Berbagai ukuran', 'standard_qty' => '3 unit'],
                    ['name' => 'Pipet Ukur', 'spec' => '1 ml, 5 ml, 10 ml, 25 ml', 'standard_qty' => '3 set'],
                    ['name' => 'Plankton Net', 'spec' => 'Diameter bukaan 30 cm, tinggi 100 cm, mesh size 200', 'standard_qty' => '3 unit'],
                    ['name' => 'Water Sample Kit', 'spec' => 'Untuk pengambilan sampel air dan plankton', 'standard_qty' => '1 unit'],
                    ['name' => 'Phospate Water Test Kit', 'spec' => 'Mengukur kadar fosfat dalam air', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm, seat foam laminated', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'L1400 x W700 x H730 mm, sheet metal, MDF 25 mm', 'standard_qty' => '19 unit'],
                ],
            ],

            // 3. PERALATAN LABORATORIUM PAKAN BUATAN
            [
                'title' => 'Peralatan Laboratorium Pakan Buatan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '2 unit'],
                    ['name' => 'Mesin Penepung Disk Mill', 'spec' => 'Penggerak motor diesel 5,5 HP, kecepatan 9000 rpm, kapasitas 55 kg/jam', 'standard_qty' => '1 unit'],
                    ['name' => 'Oven', 'spec' => 'Range suhu room temp - 300°C, kapasitas min 140 L', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Cetak Pelet Apung', 'spec' => 'Kapasitas 30-40 kg, motor diesel', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Mixer', 'spec' => 'Kapasitas 100 kg, penggerak 5,5 HP', 'standard_qty' => '1 unit'],
                    ['name' => 'Pellet Mills', 'spec' => 'Untuk uji kualitas pelet', 'standard_qty' => '1 unit'],
                ],
            ],

            // 4. PERALATAN PRODUKSI BUDIDAYA
            [
                'title' => 'Peralatan Produksi Budidaya (Perawatan Induk, Pemijahan, Penanganan Telur, Perawatan Larva, Pendederan dan Pembuatan Pakan Alami)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass', 'spec' => 'Untuk kultur pakan alami', 'standard_qty' => '1 unit'],
                    ['name' => 'Corong Tetas', 'spec' => 'Untuk menetaskan artemia', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Kapasitas 1000 g, ketelitian 0,1 g', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium Penetasan', 'spec' => 'Ukuran min. P 200 cm, L 100 cm, T 100 cm, tebal kaca 12 mm', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Pump', 'spec' => 'Daya min 100 watt, kapasitas 1100 liter/jam', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass Resegi', 'spec' => 'Untuk wadah pemeliharaan induk, ukuran P 230 cm, L 120 cm, T 100 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium', 'spec' => 'Untuk penetasan telur, P 100 cm, L 50 cm, T 40 cm, tebal kaca 15 mm', 'standard_qty' => '2 unit'],
                    ['name' => 'Pompa Udara/Blower/Aerator', 'spec' => 'Power min 100 watt, outlet min 33 cabang', 'standard_qty' => '1 unit'],
                    ['name' => 'Pond Blower Filter + Pompa Air', 'spec' => 'Kapasitas 8000 liter, volume filter 100 liter', 'standard_qty' => '1 unit'],
                    ['name' => 'Keramba Jaring Apung', 'spec' => 'Untuk budidaya di perairan', 'standard_qty' => '1 unit'],
                    ['name' => 'Paddle Wheel', 'spec' => 'Untuk meningkatkan oksigen di tambak, min 1 HP', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass Bulat', 'spec' => 'Untuk pemeliharaan larva, diameter min 1 m', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass Persegi', 'spec' => 'Untuk pendederan, P 2 m, L 1 m, T 0,5 m', 'standard_qty' => '1 unit'],
                    ['name' => 'Generator Genset', 'spec' => 'Minimal 5000 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Fish Counter', 'spec' => 'Penghitung ikan digital', 'standard_qty' => '1 unit'],
                    ['name' => 'Fish Cool Box', 'spec' => 'Kotak pendingin ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Kotak Pendingin', 'spec' => 'Kapasitas min 30 liter', 'standard_qty' => '3 unit'],
                    ['name' => 'Tangguk Ikan', 'spec' => 'Untuk menangkap ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Alat Pengukur Panjang Ikan', 'spec' => 'Bahan HDPE, skala 1 mm, panjang 60-75 cm', 'standard_qty' => '9 unit'],
                    ['name' => 'Freezer', 'spec' => 'Kapasitas 4 rak, volume 121 liter', 'standard_qty' => '1 unit'],
                    ['name' => 'Heater Aquarium', 'spec' => 'Dilengkapi termostat', 'standard_qty' => '1 unit'],
                    ['name' => 'Autofeeder', 'spec' => 'Pemberi pakan otomatis', 'standard_qty' => '1 unit'],
                    ['name' => 'Container Budidaya Kepiting', 'spec' => 'Crab house', 'standard_qty' => '1 unit'],
                    ['name' => 'Floating Pump', 'spec' => 'Power 1800 watt, 3 phase, flow 5 l/min', 'standard_qty' => '1 unit'],
                    ['name' => 'Thermometer', 'spec' => 'Digital, rentang -10°C s.d. 50°C', 'standard_qty' => '3 unit'],
                    ['name' => 'Seser/Serokan', 'spec' => 'Untuk menangkap ikan kecil', 'standard_qty' => '3 unit'],
                    ['name' => 'Serokan Induk', 'spec' => 'Untuk menangkap induk ikan', 'standard_qty' => '3 unit'],
                    ['name' => 'Corong Tetas Artemia', 'spec' => 'Bahan fiber, diameter 40 cm, tinggi 50 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Plankton Net', 'spec' => 'Diameter bukaan 30 cm, tinggi 100 cm, mesh size 200', 'standard_qty' => '3 unit'],
                    ['name' => 'Tabung Oksigen', 'spec' => 'Volume 1 m³, tinggi 65 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Secchi Disc', 'spec' => 'Untuk mengukur kecerahan air, diameter 20 cm', 'standard_qty' => '3 unit'],
                    ['name' => 'Depth Sounder', 'spec' => 'Handheld digital', 'standard_qty' => '1 unit'],
                ],
            ],

            // 5. PERALATAN BANGSAL KOLAM INDUK JANTAN DAN BETINA
            [
                'title' => 'Peralatan Bangsal Kolam Induk Jantan dan Betina',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass Resegi', 'spec' => 'Untuk wadah pemeliharaan induk', 'standard_qty' => '2 unit'],
                    ['name' => 'Aerator/Blower', 'spec' => 'Untuk suplai oksigen', 'standard_qty' => '2 unit'],
                    ['name' => 'Seser/Serokan', 'spec' => 'Untuk menangkap induk', 'standard_qty' => '4 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Untuk menimbang induk', 'standard_qty' => '1 unit'],
                ],
            ],

            // 6. PERALATAN KOLAM PENDEDERAN, PEMBESARAN, AKUARIUM, FIBER DAN KOLAM PRODUKSI
            [
                'title' => 'Peralatan Kolam Pendederan, Pembesaran, Akuarium, Fiber dan Kolam Produksi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Penepung Disk Mill', 'spec' => 'Penggerak motor diesel 5,5 HP, kecepatan 9000 rpm', 'standard_qty' => '1 unit'],
                    ['name' => 'Oven', 'spec' => 'Range suhu room temp - 300°C, kapasitas min 140 L', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Cetak Pelet Apung', 'spec' => 'Kapasitas 30-40 kg', 'standard_qty' => '1 unit'],
                    ['name' => 'Water Pump', 'spec' => 'Mesin pemompa air', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass', 'spec' => 'Wadah pembesaran', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium', 'spec' => 'Wadah pemeliharaan', 'standard_qty' => '1 unit'],
                    ['name' => 'Pond Blower Filter + Pompa Air', 'spec' => 'Kapasitas 8000 liter', 'standard_qty' => '1 unit'],
                    ['name' => 'Tabung Oksigen', 'spec' => 'Untuk packing', 'standard_qty' => '1 unit'],
                    ['name' => 'Tabung CO₂', 'spec' => 'Untuk aquascape', 'standard_qty' => '1 unit'],
                    ['name' => 'Chiller', 'spec' => 'Untuk menurunkan suhu air, min 1/10 HP', 'standard_qty' => '1 unit'],
                    ['name' => 'Aquarium Dekorasi', 'spec' => 'Kaca, panjang 1,5 m, tinggi 1,5 m, tebal 12 mm', 'standard_qty' => '1 unit'],
                ],
            ],

            // 7. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm, ergonomis', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Knock down system, 900 x 400 x 1850 mm, sheet metal 0,7 mm', 'standard_qty' => '2 unit'],
                    ['name' => 'Komputer/PC All In One', 'spec' => 'Processor 3.0 GHz, RAM 8 GB, HDD 1 TB, layar 19"', 'standard_qty' => '9 unit'],
                    ['name' => 'Printer', 'spec' => 'Printer, scan, copy', 'standard_qty' => '3 unit'],
                    ['name' => 'Filing Cabinet', 'spec' => '6 laci', 'standard_qty' => '1 unit'],
                    ['name' => 'Shelving', 'spec' => 'Rak buku 5 susun', 'standard_qty' => '1 unit'],
                    ['name' => 'Pesawat Telepon', 'spec' => 'Untuk komunikasi', 'standard_qty' => '1 unit'],
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                    ['name' => 'APD (masker, sarung tangan, safety shoes, jas laboratorium)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Agribisnis_Ikan_Hias' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Laboratorium Hama dan Penyakit Ikan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal/Kolam Induk Jantan dan Induk Betina', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pemijahan, Penanganan Larva, Pembuatan Pakan Alami', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Pendederan (1), Pendederan (2), Kolam/Bak Pembesaran, Akuarium, Fiber, dan Kolam Produksi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']
                ],
            ],

            // 2. PERABOT DAN PERALATAN LABORATORIUM HAMA DAN PENYAKIT IKAN
            [
                'title' => 'Perabot dan Peralatan Laboratorium Hama dan Penyakit Ikan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm, seat foam laminated with oscar, nylon support, powder coating', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'L1400 x W700 x H730 mm, sheet metal 0.6-1.2 mm, MDF 25 mm, powder coating', 'standard_qty' => '19 unit'],
                    ['name' => 'Mikroskop', 'spec' => 'Untuk melihat bentuk/bakteri/hama', 'standard_qty' => '6 unit'],
                    ['name' => 'BOD Incubator', 'spec' => 'Kapasitas min. 80L, range suhu 0-60°C, AC 220V/50Hz', 'standard_qty' => '1 unit'],
                    ['name' => 'COD Analyzer', 'spec' => 'Range COD 5-2000 mg/L', 'standard_qty' => '1 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => '150 x 75 x 80 cm, dapat dipindah', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => '1200 x 600 x 750 mm, particle board', 'standard_qty' => '2 unit'],
                ],
            ],

            // 3. PERALATAN BANGSAL/KOLAM INDUK JANTAN DAN INDUK BETINA
            [
                'title' => 'Peralatan Bangsal/Kolam Induk Jantan dan Induk Betina',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass Resegi', 'spec' => 'Ukuran: 100 cm, 1000 cm, 1100 cm', 'standard_qty' => '7 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => '150 x 75 x 80 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => '1200 x 600 x 750 mm', 'standard_qty' => '2 unit'],
                ],
            ],

            // 4. PERALATAN KOLAM PEMIJAHAN, PENANGANAN LARVA DAN PEMBUATAN PAKAN ALAMI
            [
                'title' => 'Peralatan Kolam Pemijahan, Penanganan Larva dan Pembuatan Pakan Alami',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Bak Fiberglass Bulat', 'spec' => 'Untuk kultur pakan alami, ada outlet pembuangan', 'standard_qty' => '3 unit'],
                    ['name' => 'Seser/Grab', 'spec' => 'Untuk penangkapan/penyiponan', 'standard_qty' => '3 unit'],
                    ['name' => 'Aquarium Penetasan', 'spec' => 'Ukuran min 15x15 cm, bahan stainless', 'standard_qty' => '7 unit'],
                    ['name' => 'Pompa Udara/Blower/Aerator', 'spec' => 'Untuk memasok udara ke kolam', 'standard_qty' => '1 unit'],
                    ['name' => 'Lampu Metal Halide', 'spec' => 'Untuk fotosintesis, aquarium laut', 'standard_qty' => '4 unit'],
                    ['name' => 'Aquarium Dekorasi', 'spec' => 'Kaca, panjang min 1,5m, tinggi min 1,5m, tebal min 12mm', 'standard_qty' => '3 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => '150 x 75 x 80 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => '1200 x 600 x 750 mm', 'standard_qty' => '2 unit'],
                ],
            ],

            // 5. PERALATAN KOLAM PENDEDERAN, PEMBESARAN, AKUARIUM, FIBER DAN KOLAM PRODUKSI
            [
                'title' => 'Peralatan Kolam Pendederan, Pembesaran, Akuarium, Fiber dan Kolam Produksi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Penepung Disk Mill', 'spec' => 'Penggerak motor diesel 5,5 HP, kecepatan 9000 rpm', 'standard_qty' => '1 unit'],
                    ['name' => 'Oven', 'spec' => 'Range suhu room temp - 300°C, kapasitas min 1/4 m³', 'standard_qty' => '1 unit'],
                    ['name' => 'Water Pump', 'spec' => 'Mesin pemompa air', 'standard_qty' => '1 unit'],
                    ['name' => 'Bak Fiberglass', 'spec' => 'Wadah pembesaran', 'standard_qty' => '6 unit'],
                    ['name' => 'Aquarium', 'spec' => 'Wadah penetasan telur', 'standard_qty' => '6 unit'],
                    ['name' => 'Pond Blower Filter + Pompa Air', 'spec' => 'Kapasitas min 8000 liter, volume filter 1000L', 'standard_qty' => '1 unit'],
                    ['name' => 'Tabung Oksigen', 'spec' => 'Untuk packing, tinggi min 2,5M', 'standard_qty' => '2 unit'],
                    ['name' => 'Tabung CO₂', 'spec' => 'Untuk aquascape, min 1m², lengkap regulator', 'standard_qty' => '3 unit'],
                    ['name' => 'Chiller', 'spec' => 'Power min 1HP, output min 1000L/jam, volt 220v', 'standard_qty' => '3 unit'],
                    ['name' => 'Aquarium Dekorasi', 'spec' => 'Kaca, panjang min 1,5m, tinggi min 1,5m, tebal min 12mm', 'standard_qty' => '6 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'L480 x W420 x H850 mm', 'standard_qty' => '18 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'L1400 x W700 x H730 mm', 'standard_qty' => '19 unit'],
                ],
            ],

            // 6. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, dudukan busa injection', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Knock down system, 1000 x 400 x 1850 mm', 'standard_qty' => '2 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Untuk mengukur kadar gula/garam', 'standard_qty' => '6 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Ketelitian 0,1 g', 'standard_qty' => '6 unit'],
                    ['name' => 'Lux Meter', 'spec' => 'Pengujian kualitas air', 'standard_qty' => '6 unit'],
                    ['name' => 'Water Quality Meter', 'spec' => 'Untuk mengukur pH/ORP/Conductivity/DO', 'standard_qty' => '6 unit'],
                    ['name' => 'Turbidity Meter', 'spec' => 'Ukur kekeruhan, range 0-200 NTU', 'standard_qty' => '6 unit'],
                    ['name' => 'Water Hardness Test', 'spec' => 'Pengujian kesadahan air', 'standard_qty' => '6 unit'],
                    ['name' => 'Water Color Test', 'spec' => 'Pengujian warna air', 'standard_qty' => '6 unit'],
                    ['name' => 'BOD Meter', 'spec' => 'Mengukur oksigen terlarut, range 5-4000 mg/L', 'standard_qty' => '6 unit'],
                ],
            ],

            // 7. KELENGKAPAN SMART CLASSROOM
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 8. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, jas laboratorium, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 9. KELENGKAPAN UTILITAS DAN BANGUNAN
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

            // 10. PENERAPAN BUDAYA KERJA INDUSTRI
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Agribisnis_Rumput_Laut' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Laboratorium Kultur Jaringan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Laboratorium Hama dan Penyakit', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Indoor Culture', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Pasca Panen', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']
                ],
            ],

            // 2. PERABOT DAN PERALATAN LABORATORIUM KULTUR JARINGAN
            [
                'title' => 'Perabot dan Peralatan Laboratorium Kultur Jaringan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Pencuci Rumput Laut', 'spec' => 'Tipe rotary, kapasitas 200 kg/proses, material stainless steel, penggerak mesin diesel 40 Hp', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Dimensi min. L480 x W420 x H850 mm, seat foam laminated with oscar, nylon support, powder coating', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai, sistem knock down yang mudah dirakit', 'standard_qty' => '9 unit'],
                    ['name' => 'Mesin Peniris Rumput Laut', 'spec' => 'Untuk meniriskan air setelah pencucian', 'standard_qty' => '1 unit'],
                ],
            ],

            // 3. PERABOT DAN PERALATAN LABORATORIUM HAMA DAN PENYAKIT
            [
                'title' => 'Perabot dan Peralatan Laboratorium Hama dan Penyakit',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Pencuci Rumput Laut', 'spec' => 'Tipe rotary, kapasitas 200 kg/proses, material stainless steel', 'standard_qty' => '1 unit'],
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, bahan berkualitas', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai, sistem knock down', 'standard_qty' => '9 unit'],
                ],
            ],

            // 4. PERALATAN INDOOR CULTURE
            [
                'title' => 'Peralatan Indoor Culture',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Long Line Kit', 'spec' => 'Untuk tempat pertumbuhan rumput laut', 'standard_qty' => '2 unit'],
                    ['name' => 'Tali Pengikat Nilon', 'spec' => 'Panjang ± 100 meter, untuk transportasi/penanaman', 'standard_qty' => '2 unit'],
                ],
            ],

            // 5. PERALATAN RUANG PASCA PANEN
            [
                'title' => 'Peralatan Ruang Pasca Panen',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Penepung Rumput Laut', 'spec' => 'Kapasitas min. 500 kg/jam, material stainless steel, mild steel, ukuran mesin 40-60', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Pengayak Rumput Laut', 'spec' => 'Tipe meja getar, kapasitas kontinyu min 500 kg input/jam, material stainless steel, kerangka mild steel, penggerak motor listrik 1 PK', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Pengering Rumput Laut', 'spec' => 'Kapasitas ± 250 kg/proses, bahan bakar minyak tanah', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Perajang Rumput Laut', 'spec' => 'Untuk merajang rumput laut menjadi potongan kecil (chips)', 'standard_qty' => '1 unit'],
                    ['name' => 'Pres Bal/Hidrolik', 'spec' => 'Panjang stroke ± 1250 mm, diameter stroke ± 50 mm, motor 7.5 HP, rangka vertikal & horizontal ± 150 mm', 'standard_qty' => '1 unit'],
                ],
            ],

            // 6. PERABOT DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabot dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, bahan berkualitas', 'standard_qty' => '9 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja', 'standard_qty' => '9 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Sistem knock down, minimal 3 rak, dimensi min. L900 x W400 x H1850 mm, sheet metal 0.7 mm, powder coating', 'standard_qty' => '2 unit'],
                    ['name' => 'Komputer/PC All In One', 'spec' => 'Processor min. 3.0 GHz 6 MB', 'standard_qty' => '9 unit'],
                    ['name' => 'Printer', 'spec' => 'Printer, scan, copy, resolusi up to 1500x1400 dpi, kecepatan print hitam up to 30 ppm, warna up to 15 ppm', 'standard_qty' => '3 unit'],
                    ['name' => 'Filing Cabinet 4 Drawers', 'spec' => 'Untuk menyimpan buku, dokumen, arsip', 'standard_qty' => '2 unit'],
                    ['name' => 'Shelving 5 Shelf/Set 1 Side Backplate', 'spec' => 'Rak buku 1 muka, untuk partisi ruangan dan penyimpanan', 'standard_qty' => '1 unit'],
                    ['name' => 'Pesawat Telepon', 'spec' => 'Untuk komunikasi jarak jauh', 'standard_qty' => '1 unit'],
                    ['name' => 'Sorokke Kit', 'spec' => 'Untuk penyelamatan', 'standard_qty' => '3 unit'],
                    ['name' => 'Scuba Tank', 'spec' => 'Tabung oksigen untuk penyelaman, ukuran 80 cm, berat 140-240 kg', 'standard_qty' => '3 unit'],
                    ['name' => 'Pakaian Selam', 'spec' => 'Ketebalan 1.5-3 mm, neoprene, dengan nylon jersey', 'standard_qty' => '3 unit'],
                    ['name' => 'Perahu', 'spec' => 'Untuk mobilisasi di lokasi agribisnis, panjang minimal 7 meter, bermesin tunggal', 'standard_qty' => '1 unit'],
                ],
            ],

            // 7. KELENGKAPAN SMART CLASSROOM
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 8. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, jas laboratorium, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 9. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Pompa Air', 'spec' => 'Ada dan berfungsi'],
                    ['name' => 'Tangki Air', 'spec' => 'Min. 2 x 1.000 liter'],
                    ['name' => 'Instalasi Listrik di Toilet', 'spec' => 'Ada dan berfungsi'],
                    ['name' => 'Kloset Jongkok (Pria)', 'spec' => 'Min. 2 unit'],
                    ['name' => 'Kloset Jongkok (Wanita)', 'spec' => 'Min. 3 unit'],
                    ['name' => 'Urinoir (Pria)', 'spec' => 'Min. 2 unit'],
                    ['name' => 'Tempat Cuci Tangan + Cermin', 'spec' => 'Min. 2 unit'],
                    ['name' => 'Sumber Air Bersih', 'spec' => 'Mengalir lancar'],
                    ['name' => 'Septic Tank', 'spec' => 'Berfungsi baik'],
                ],
            ],

            // 10. PENERAPAN BUDAYA KERJA INDUSTRI
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Nautika_Kapal_Niaga' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Menjangka Peta', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Praktik Komunikasi dan MERSAR', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Kerja Navigasi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal Kecakapan Bahari/Penanganan dan Pengaturan Muatan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kapal', 'standard_area' => '1 unit (panjang 24 m)', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Instruktur dan Penyimpanan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']

                ],
            ],

            // 2. PERALATAN AREA KERJA MENJANGKA PETA
            [
                'title' => 'Peralatan Area Kerja Menjangka Peta',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Menjangka Peta', 'spec' => 'Untuk membuat perencanaan pelayaran', 'standard_qty' => '1 unit'],
                    ['name' => 'Marine Nautical (Sextant)', 'spec' => 'Untuk menentukan posisi kapal', 'standard_qty' => '1 unit'],
                    ['name' => 'Pre-computed Altitude and Azimuth Tables', 'spec' => 'Tabel perhitungan navigasi celestial', 'standard_qty' => '1 set'],
                    ['name' => 'Ocean Plotting Charts of Area Concerned', 'spec' => 'Peta laut untuk perencanaan pelayaran', 'standard_qty' => '2 set'],
                ],
            ],

            // 3. PERALATAN RUANG KOMUNIKASI DAN MERSAR
            [
                'title' => 'Peralatan Ruang Komunikasi dan MERSAR',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'CB Transceiver', 'spec' => 'Frekuensi CB, untuk komunikasi jarak dekat', 'standard_qty' => '1 unit'],
                    ['name' => 'Radio Direction Finder', 'spec' => 'Untuk menentukan arah sinyal radio', 'standard_qty' => '1 unit'],
                    ['name' => 'VHF Transceiver', 'spec' => '25W, NMEA 0183, fitur DSC', 'standard_qty' => '1 unit'],
                    ['name' => 'MF/HF Marine Radio', 'spec' => 'Untuk komunikasi jarak jauh dan GMDSS', 'standard_qty' => '1 unit'],
                    ['name' => 'SART (Search and Rescue Transponder)', 'spec' => 'Frekuensi 9.2-9.5 GHz, floating', 'standard_qty' => '1 unit'],
                    ['name' => 'EPIRB', 'spec' => 'Frekuensi 406 MHz, dengan GPS built-in', 'standard_qty' => '1 unit'],
                    ['name' => 'Weather Station', 'spec' => 'Mengukur kecepatan angin, arah angin, suhu, kelembaban, tekanan udara', 'standard_qty' => '1 unit'],
                    ['name' => 'Satellite Communication Trainer', 'spec' => 'Trainer komunikasi satelit lengkap dengan modul orbit, software, dan panduan', 'standard_qty' => '1 set'],
                ],
            ],

            // 4. PERALATAN RUANG KERJA NAVIGASI
            [
                'title' => 'Peralatan Ruang Kerja Navigasi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Marine Autopilot', 'spec' => 'Sistem kemudi otomatis terintegrasi dengan GPS dan Gyro', 'standard_qty' => '1 unit'],
                    ['name' => 'Marine Radar with AIS', 'spec' => 'X-band, 4KW, LCD, dengan AIS terintegrasi', 'standard_qty' => '1 unit'],
                    ['name' => 'Marine Radar with ARPA', 'spec' => 'Dengan kemampuan target tracking otomatis (min. 20 target)', 'standard_qty' => '1 unit'],
                    ['name' => 'Electronic Compass with GPS', 'spec' => '10.5-40VDC, NMEA0183, sensor 3-axis', 'standard_qty' => '1 unit'],
                    ['name' => 'GPS Plotter with Echo Sounder', 'spec' => 'Layar minimal 7", tracklog 8000 titik, dengan fish finder', 'standard_qty' => '1 unit'],
                    ['name' => 'Fish Finder', 'spec' => 'Untuk mendeteksi gerombolan ikan', 'standard_qty' => '1 unit'],
                    ['name' => 'Projection Magnetic Compass', 'spec' => 'Kompas magnetik proyeksi untuk menentukan arah', 'standard_qty' => '2 unit'],
                    ['name' => 'Gyro Compass', 'spec' => 'Sistem kompas gyro dengan koreksi otomatis', 'standard_qty' => '1 unit'],
                    ['name' => 'Navtex Receiver', 'spec' => 'Untuk menerima informasi navigasi dan cuaca (GMDSS)', 'standard_qty' => '1 unit'],
                    ['name' => 'Binoculars', 'spec' => '7x50, untuk pengamatan benda di laut', 'standard_qty' => '18 unit'],
                ],
            ],

            // 5. PERALATAN RUANG BANGSAL KECAKAPAN BAHARI/PENANGANAN DAN PENGATURAN MUATAN
            [
                'title' => 'Peralatan Ruang Bangsal Kecakapan Bahari/Penanganan dan Pengaturan Muatan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Navtex Receiver', 'spec' => 'Untuk kelengkapan GMDSS, frekuensi 518 kHz', 'standard_qty' => '1 unit'],
                    ['name' => 'Peralatan Penanganan Muatan', 'spec' => 'Model/peraga untuk simulasi pengaturan muatan kapal niaga', 'standard_qty' => '1 set'],
                    ['name' => 'Peralatan Keselamatan Kapal', 'spec' => 'Life jacket, life buoy, dll.', 'standard_qty' => '1 set'],
                ],
            ],

            // 6. PERALATAN RUANG KAPAL SATU UNIT
            [
                'title' => 'Peralatan Ruang Kapal Satu Unit',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kapal Latih', 'spec' => 'Kapal ukuran panjang 24 m, untuk praktik kondisi pelayaran nyata', 'standard_qty' => '1 unit'],
                    ['name' => 'Cutaway 3D Models', 'spec' => 'Model struktur bangunan kapal (potongan) untuk pembelajaran konstruksi kapal', 'standard_qty' => '3 unit'],
                    ['name' => 'Floating Ship Stability Model', 'spec' => 'Model stabilitas kapal untuk demonstrasi pergerakan titik gravitasi dan efek permukaan bebas', 'standard_qty' => '3 unit'],
                    ['name' => 'Ship Bridge Simulator', 'spec' => 'Sesuai sertifikasi DNV Class B, dengan visualisasi 225°, RADAR, ECDIS, GMDSS, konsole kemudi', 'standard_qty' => '1 unit'],
                ],
            ],

            // 7. PERABOTAN DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabotan dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, dudukan busa injection', 'standard_qty' => '3 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja nyaman', 'standard_qty' => '3 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => '5 rak, metal coating, knock down', 'standard_qty' => '2 unit'],
                    ['name' => 'SART', 'spec' => 'Sebagai kelengkapan GMDSS, TX Freq 9.2-9.5 GHz, 400mW', 'standard_qty' => '1 unit'],
                    ['name' => 'EPIRB', 'spec' => 'Sebagai kelengkapan GMDSS, 406 MHz', 'standard_qty' => '1 unit'],
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 9. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3) DAN PROTOKOL KEADAAN DARURAT
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3) dan Protokol Keadaan Darurat',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, life jacket, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Teknika_Kapal_Niaga' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Bangku/Perbengkelan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Laboratorium Dasar Elektro & Sistem Kontrol', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Mesin Kapal', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Mesin Bantu', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Instruktur dan Penyimpanan (RIS)', 'standard_area' => '30 m² (24+6)', 'capacity' => '9 instruktur'],
                    ['name' => 'Smart Classroom', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']

                ],
            ],

            // 2. PERALATAN AREA KERJA BANGKU/PERBENGKELAN
            [
                'title' => 'Peralatan Area Kerja Bangku/Perbengkelan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Bubut Manual', 'spec' => 'Panjang kerja 70-200 cm, range', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Ulir Pipa', 'spec' => 'Untuk membuat ulir pada pipa', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Gerinda Potong', 'spec' => 'Untuk memotong bahan', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Gerinda Piring', 'spec' => 'Untuk surface grinding', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Las SMAW', 'spec' => 'Las listrik, 200-450 A', 'standard_qty' => '2 unit'],
                    ['name' => 'Mesin Las TIG (GTW)', 'spec' => 'Untuk pengelasan presisi', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Las CO₂/MIG', 'spec' => 'Untuk pengelasan kawat berkelanjutan', 'standard_qty' => '2 unit'],
                    ['name' => 'Bor Duduk', 'spec' => 'Kapasitas pengeboran 13-25', 'standard_qty' => '2 unit'],
                    ['name' => 'Mesin Gerinda Tangan', 'spec' => '4 inch, 400-600W', 'standard_qty' => '4 unit'],
                    ['name' => 'Mesin Bor Tangan', 'spec' => '10-13 mm, 500-800W', 'standard_qty' => '4 unit'],
                ],
            ],

            // 3. PERALATAN LABORATORIUM DASAR ELEKTRO
            [
                'title' => 'Peralatan Laboratorium Dasar Elektro',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Basic Electric Training System', 'spec' => 'Input 3 phase AC 380V, module trainer', 'standard_qty' => '1 unit'],
                    ['name' => 'Primary Electrical Lighting Trainer', 'spec' => 'Trainer instalasi penerangan', 'standard_qty' => '1 unit'],
                    ['name' => 'Motor & Transformer Maintenance Trainer', 'spec' => 'Trainer perawatan motor & trafo', 'standard_qty' => '1 unit'],
                    ['name' => 'Digital Circuit Training Kit', 'spec' => 'Trainer sirkuit digital', 'standard_qty' => '1 unit'],
                    ['name' => 'PLC Training Set', 'spec' => 'Trainer Programmable Logic Controller', 'standard_qty' => '1 unit'],
                    ['name' => 'Basic Electro-Pneumatic Training System', 'spec' => 'Trainer elektro-pneumatik dengan kompresor', 'standard_qty' => '1 unit'],
                    ['name' => 'Basic Electro-Hydraulic Training System', 'spec' => 'Trainer elektro-hidrolik', 'standard_qty' => '1 unit'],
                ],
            ],

            // 4. PERALATAN AREA KERJA MESIN KAPAL
            [
                'title' => 'Peralatan Area Kerja Mesin Kapal',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Ship Machinery Operation Simulator', 'spec' => 'Simulator ruang mesin kapal', 'standard_qty' => '1 unit'],
                    ['name' => 'Motor Tempel 4 Tak', 'spec' => '15-25 kW, bensin', 'standard_qty' => '2 unit'],
                    ['name' => 'Mesin Diesel Kapal Kecil', 'spec' => 'Mesin penggerak utama kapal', 'standard_qty' => '1 unit'],
                ],
            ],

            // 5. PERALATAN AREA KERJA MESIN BANTU
            [
                'title' => 'Peralatan Area Kerja Mesin Bantu',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Pompa Sentrifugal', 'spec' => 'Untuk sistem pendingin/bilga', 'standard_qty' => '1 unit'],
                    ['name' => 'Kompresor Udara', 'spec' => 'Untuk sistem pneumatik dan servis', 'standard_qty' => '1 unit'],
                    ['name' => 'Steam Boiler Simulator', 'spec' => 'Simulator ketel uap', 'standard_qty' => '1 unit'],
                ],
            ],

            // 6. PERABOTAN DAN PERALATAN RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabotan dan Peralatan Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, dudukan busa injection', 'standard_qty' => '3 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai untuk bekerja nyaman', 'standard_qty' => '3 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => '5 rak, metal coating', 'standard_qty' => '2 unit'],
                    ['name' => 'Power Bank (Portable)', 'spec' => 'Catu daya darurat', 'standard_qty' => '1 unit'],
                    ['name' => 'Electric Drill / Bor Tangan', 'spec' => 'Standar kapal/industri', 'standard_qty' => '1 unit'],
                    ['name' => 'Impact Drill', 'spec' => 'Bor impact 600W, 13 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Multi-function Tools', 'spec' => 'Oscillating tool 300W', 'standard_qty' => '1 unit'],
                    ['name' => 'Gerinda Listrik Tangan', 'spec' => 'Angle grinder 4 inch, 400W', 'standard_qty' => '1 unit'],
                    ['name' => 'Kotak Alat (Toolkit)', 'spec' => 'Set kunci pas, ring, obeng, tang', 'standard_qty' => '2 set'],
                ],
            ],

            // 7. KELENGKAPAN SMART CLASSROOM
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 8. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3) DAN PROTOKOL KEADAAN DARURAT
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3) dan Protokol Keadaan Darurat',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, life jacket, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                ],
            ],

            // 9. KELENGKAPAN UTILITAS DAN BANGUNAN
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
                ],
            ],

            // 10. PENERAPAN BUDAYA KERJA INDUSTRI (5S/5R DAN K3)
            [
                'title' => 'Penerapan Budaya Kerja Industri (5S/5R dan K3)',
                'type' => 'culture',
                'items' => [
                    ['name' => 'Penerapan 5R (Ringkas, Rapi, Resik, Rawat, Rajin)'],
                    ['name' => 'Poster/Infografis 5S/5R terpasang'],
                    ['name' => 'Penerapan Budaya Safety/K3'],
                    ['name' => 'Poster/Infografis K3 terpasang'],
                    ['name' => 'SOP Penggunaan Peralatan tersedia'],
                    ['name' => 'Jadwal Pemeliharaan Peralatan tersedia'],
                    ['name' => 'Buku Log Penggunaan Ruang Praktik'],
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Nautika_Kapal_Penangkap_Ikan' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Sub Ruang Menjangka Peta', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Komunikasi dan MERSAR', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Navigasi dan Kecakapan Bahari', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal Kerja Alat Tangkap dan Tali-temali', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Kapal Latih', 'standard_area' => '1 unit (panjang 24 m)', 'capacity' => '-'],
                    ['name' => 'Sub Ruang Instruktur dan Penyimpanan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']

                ],
            ],

            // 2. PERALATAN SHIP SIMULATOR
            [
                'title' => 'Peralatan Ship Simulator',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Ship Bridge Simulator', 'spec' => 'DNV Class B, 7x55" UHD/4K, 225° view, lengkap dengan RADAR, ECDIS, GMDSS, Konsole Kemudi.', 'standard_qty' => '1 set'],
                ],
            ],

            // 3. PERALATAN SATU UNIT KAPAL DAN MINIATUR
            [
                'title' => 'Peralatan Satu Unit Kapal dan Miniatur (Mengacu pada Tabel 9)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Alat Tangkap Ikan (Gill net, Payang, Rawai, Pole and line)', 'spec' => 'Miniatur atau alat operasional sesuai klasifikasi FAO.', 'standard_qty' => '3 set'],
                    ['name' => 'Model Stabilitas Kapal', 'spec' => 'Cut-away 3D models atau floating model yang menunjukkan struktur dan pergerakan titik gravitasi.', 'standard_qty' => '3 set'],
                ],
            ],

            // 4. PERALATAN SUB RUANG MENJANGKA PETA
            [
                'title' => 'Peralatan Sub Ruang Menjangka Peta',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Menjangka Peta', 'spec' => '-', 'standard_qty' => '18 buah'],
                    ['name' => 'Tabel Altitude dan Azimuth', 'spec' => '-', 'standard_qty' => '18 buah'],
                    ['name' => 'Peta Laut', 'spec' => 'Kertas, berbagai nomor peta', 'standard_qty' => '18 lembar'],
                    ['name' => 'Mistar Jajar', 'spec' => 'Logam, 600 mm', 'standard_qty' => '9 alat'],
                    ['name' => 'Mistar Segitiga Pelayaran', 'spec' => '-', 'standard_qty' => '9 alat'],
                    ['name' => 'Jangka Semat', 'spec' => '-', 'standard_qty' => '3 alat'],
                    ['name' => 'Globe Bumi', 'spec' => 'Diameter 25–40 inci, fiber', 'standard_qty' => '3 alat'],
                ],
            ],

            // 5. PERALATAN NAVIGASI DAN KECAKAPAN BAHARI
            [
                'title' => 'Peralatan Navigasi dan Kecakapan Bahari',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Marine Autopilot', 'spec' => 'Lengkap dengan unit kontrol, GPS, dan antarmuka Gyro.', 'standard_qty' => '1 set'],
                    ['name' => 'Marine Radar with AIS', 'spec' => 'X-band, 4KW, minimal 9.7" LCD, AIS terintegrasi.', 'standard_qty' => '1 unit'],
                    ['name' => 'Marine Radar with ARPA', 'spec' => 'Dengan kemampuan target tracking otomatis.', 'standard_qty' => '1 unit'],
                    ['name' => 'Electronic Compass with GPS', 'spec' => 'NMEA0183, rentang tegangan 10.5–40VDC.', 'standard_qty' => '1 unit'],
                    ['name' => 'Echo Sounder', 'spec' => 'Dual frequency 50/200kHz, daya 600W.', 'standard_qty' => '1 unit'],
                    ['name' => 'Fish Finder', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Projection Magnetic Compass', 'spec' => '-', 'standard_qty' => '2 unit'],
                    ['name' => 'Gyro Compass', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Navtex Receiver', 'spec' => 'Frekuensi 518 kHz.', 'standard_qty' => '1 unit'],
                    ['name' => 'Marine Nautical (Sextant)', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Binoculars', 'spec' => '7x50', 'standard_qty' => '18 unit'],
                ],
            ],

            // 6. PERALATAN KOMUNIKASI DAN MERSAR
            [
                'title' => 'Peralatan Komunikasi dan MERSAR',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'CB Transceiver', 'spec' => '12W SSB, lengkap dengan antena.', 'standard_qty' => '1 unit'],
                    ['name' => 'Radio Direction Finder', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'VHF Transceiver', 'spec' => '25W, NMEA 0183, fitur DSC.', 'standard_qty' => '1 unit'],
                    ['name' => 'MF/HF Marine Radio', 'spec' => 'Frekuensi 1.6–30 MHz.', 'standard_qty' => '1 unit'],
                    ['name' => 'SART (Search and Rescue Transponder)', 'spec' => 'Frekuensi 9.2–9.5 GHz, tipe floating.', 'standard_qty' => '1 unit'],
                    ['name' => 'EPIRB (Emergency Position Indicating Radio Beacon)', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Weather Station', 'spec' => 'Untuk mengukur kecepatan angin, suhu, kelembaban.', 'standard_qty' => '1 unit'],
                    ['name' => 'Handy Talky (HT)', 'spec' => '-', 'standard_qty' => '3 unit'],
                    ['name' => 'Isyarat Bendera/Isyarat Visual', 'spec' => 'Satu set bendera kode isyarat internasional.', 'standard_qty' => '1 set'],
                ],
            ],

            // 7. PERALATAN TANGKAP DAN TALI-TEMALI
            [
                'title' => 'Peralatan Tangkap dan Tali-temali',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Alat Tangkap Ikan (lengkap)', 'spec' => 'Mewakili berbagai jenis alat tangkap (jaring lingkar, jaring insang, pancing, perangkap, dll.).', 'standard_qty' => '13 set'],
                ],
            ],

            // 8. PERALATAN INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Peralatan Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja Instruktur', 'spec' => '900 x 450 mm, MFC.', 'standard_qty' => '3 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Minimal 5 rak, bahan metal coating.', 'standard_qty' => '2 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Untuk mengukur salinitas/kadar gula.', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Ketelitian 0.1 gram.', 'standard_qty' => '2 unit'],
                    ['name' => 'Lux Meter', 'spec' => '-', 'standard_qty' => '2 unit'],
                    ['name' => 'Portable pH/ORP/Conductivity/DO Meter', 'spec' => 'Multi-parameter uji kualitas air.', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Hardness Tester', 'spec' => '-', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Color Meter', 'spec' => '-', 'standard_qty' => '2 unit'],
                    ['name' => 'BOD Meter', 'spec' => '-', 'standard_qty' => '2 unit'],
                ],
            ],

            // 9. KELENGKAPAN SMART CLASSROOM
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
                    ['name' => 'Platform Pendukung (Student Response System, dll.)', 'standard_qty' => '1 paket'],
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 10. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 11. KELENGKAPAN UTILITAS DAN BANGUNAN
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

            // 12. PENERAPAN BUDAYA KERJA INDUSTRI
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
                    ['name' => 'Prosedur Masuk Ruang (Protokol Kesehatan) terpasang']
                ],
            ],
        ],
    ],

    'Teknika_Kapal_Penangkap_Ikan' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Area Kerja Bangku/Bengkel', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Lab. Dasar Elektro/Kelistrikan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Mesin Bantu Kapal', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Bangsal Kerja Alat Tangkap dan Tali-temali', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Mesin Utama Kapal', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Area Kerja Mesin Pendingin/Refrigerasi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Penyimpanan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']

                ],
            ],

            // 2. PERALATAN AREA KERJA BANGKU/BENGKEL
            [
                'title' => 'Peralatan Area Kerja Bangku/Bengkel',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Mesin Bubut Manual (Lathe Machine)', 'spec' => 'Untuk pekerjaan bubut dasar', 'standard_qty' => '1 unit'],
                    ['name' => 'Pipe Thread Machine', 'spec' => '1/2" - 2", 750W, 220V/380V', 'standard_qty' => '1 unit'],
                    ['name' => 'Gerinda Listrik Tangan', 'spec' => '600W, 10.000 rpm, 100 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Gerinda Potong', 'spec' => 'Untuk memotong bahan baku', 'standard_qty' => '1 unit'],
                    ['name' => 'Digital Optical Measurement Profile Projector', 'spec' => 'X/Y travel 0-200 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Foot Shearing Machine', 'spec' => 'Lebar 1300 mm, tebal 1.15 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Band Saw Machine', 'spec' => 'Untuk memotong bahan baku', 'standard_qty' => '1 unit'],
                    ['name' => 'Las Busur Manual (Arc Welding)', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Las Busur GAS (MIG/MAG)', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'TIG Welding Machine (GTAW)', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Plasma Cutting Welding Machine', 'spec' => '-', 'standard_qty' => '1 unit'],
                    ['name' => 'Electric Drill', 'spec' => '550W, 10mm (steel), 20mm (wood)', 'standard_qty' => '1 unit'],
                    ['name' => 'Impact Drill', 'spec' => '550W, 10mm (steel), 20mm (wood)', 'standard_qty' => '1 unit'],
                    ['name' => 'Multi-function Tools', 'spec' => '300W, 22.000 rpm', 'standard_qty' => '1 unit'],
                    ['name' => 'Drill Press', 'spec' => '350W, 13 mm, 2620 rpm', 'standard_qty' => '1 unit'],
                ],
            ],

            // 3. PERALATAN LABORATORIUM DASAR ELEKTRO/KELISTRIKAN
            [
                'title' => 'Peralatan Laboratorium Dasar Elektro/Kelistrikan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Basic Electric Training System', 'spec' => '3 phase AC380V, modul eksperimen', 'standard_qty' => '1 unit'],
                    ['name' => 'Primary Electricity Training System', 'spec' => '3 phase 380V', 'standard_qty' => '1 unit'],
                    ['name' => 'Basic Electronics Trainer', 'spec' => 'Single phase AC220V', 'standard_qty' => '1 unit'],
                    ['name' => 'MCU Trial Set', 'spec' => 'Mikrokontroler trainer', 'standard_qty' => '1 unit'],
                    ['name' => 'Motor & Transformer Maintenance', 'spec' => 'Trainer motor dan transformator', 'standard_qty' => '1 unit'],
                    ['name' => 'Analog Circuit Training Kit', 'spec' => 'Trainer rangkaian analog', 'standard_qty' => '1 unit'],
                    ['name' => 'Digital Circuit Training Kit', 'spec' => 'Trainer rangkaian digital', 'standard_qty' => '1 unit'],
                    ['name' => 'Programmable Logic Controller Training Set', 'spec' => 'Trainer PLC', 'standard_qty' => '1 unit'],
                    ['name' => 'Basic Electro Pneumatic Training System', 'spec' => 'Trainer elektro-pneumatik', 'standard_qty' => '1 unit'],
                    ['name' => 'Hydraulic Training System', 'spec' => 'Trainer hidrolik', 'standard_qty' => '1 unit'],
                    ['name' => 'Synchronous Generator', 'spec' => 'Untuk pengenalan generator', 'standard_qty' => '2 unit'],
                    ['name' => 'Box Panel Sinkronisasi (Syncroscope)', 'spec' => 'Panel distribusi daya', 'standard_qty' => '1 unit'],
                ],
            ],

            // 4. PERALATAN AREA KERJA MESIN KAPAL DAN MESIN BANTU
            [
                'title' => 'Peralatan Area Kerja Mesin Kapal dan Mesin Bantu (Mengacu pada Tabel 10)',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Ship Machinery Operation (Engine Room Simulator)', 'spec' => 'Simulasi ruang mesin, sistem propulsi, monitoring', 'standard_qty' => '1 unit'],
                    ['name' => 'Motor Diesel', 'spec' => 'Untuk pengenalan motor diesel', 'standard_qty' => '1 unit'],
                    ['name' => 'Motor Tempel/Motor Outboard', 'spec' => '18.4 kW (25 HP), 4-stroke', 'standard_qty' => '1 unit'],
                    ['name' => 'Sistem Propeller Kapal', 'spec' => 'Panjang 900-2000 mm', 'standard_qty' => '1 unit'],
                    ['name' => 'Pompa (Pompa Sentrifugal, Pompa Gear)', 'spec' => 'Berbagai jenis pompa', 'standard_qty' => '1 set'],
                    ['name' => 'Power Block', 'spec' => 'Penarik jaring purse seine', 'standard_qty' => '1 unit'],
                    ['name' => 'Line Hauler/Rooler', 'spec' => 'Penarik long line', 'standard_qty' => '1 unit'],
                ],
            ],

            // 5. PERALATAN BANGSAL KERJA ALAT TANGKAP DAN TALI-TEMALI
            [
                'title' => 'Peralatan Bangsal Kerja Alat Tangkap dan Tali-temali',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Fishing Gear (Alat Tangkap Ikan)', 'spec' => 'Mewakili klasifikasi FAO: Jaring lingkar, jaring insang, pancing, rawai, dll.', 'standard_qty' => '3 set'],
                ],
            ],

            // 6. PERALATAN SUB RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Peralatan Sub Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Meja Kerja Instruktur', 'spec' => '900 x 450 mm, MFC', 'standard_qty' => '3 unit'],
                    ['name' => 'Kursi Kerja Instruktur', 'spec' => 'Ergonomis, nyaman', 'standard_qty' => '3 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => '5 rak, metal coating, knock down', 'standard_qty' => '2 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Brix 0-53%, akurasi ±0.2%', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Ketelitian 0.1 gram', 'standard_qty' => '2 unit'],
                    ['name' => 'Portable pH/ORP/Conductivity/DO Meter', 'spec' => 'Multi-parameter uji kualitas air', 'standard_qty' => '2 unit'],
                ],
            ],

            // 7. PERALATAN MESIN PENDINGIN/REFRIGERASI
            [
                'title' => 'Peralatan Mesin Pendingin/Refrigerasi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Basic Cycle Refrigeration Trainer', 'spec' => 'Refrigerant R134a/NON CFC, pipa transparan', 'standard_qty' => '2 unit'],
                    ['name' => 'Industrial Refrigeration Trainer', 'spec' => 'Kompresor 2 HP, untuk sistem refrigerasi industri', 'standard_qty' => '2 unit'],
                    ['name' => 'Air Conditioning Trainer', 'spec' => 'AC Split 1 PK, inverter, R-410a, manifold set', 'standard_qty' => '3 unit'],
                    ['name' => 'Refrigeration Wiring Skills Trainer', 'spec' => 'Panel akrilik, kompresor 1 PK', 'standard_qty' => '1 unit'],
                    ['name' => 'Cold Storage Trainer', 'spec' => 'Sistem pendingin industri skala kecil', 'standard_qty' => '1 unit'],
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
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
                    ['name' => 'APD (masker, sarung tangan, safety shoes, safety glasses, ear plug, dll.)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
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

    'Agriteknologi Pengolahan Hasil Perikanan' => [
        'sections' => [
            // 1. RUANG PRAKTIK UTAMA
            [
                'title' => 'Ruang Praktik Utama',
                'type' => 'room',
                'items' => [
                    ['name' => 'Ruang Laboratorium Mikrobiologi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Dapur Produksi', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Pengolahan Hasil Perikanan', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Ruang Laboratorium Uji Sensoris', 'standard_area' => '3 m²/peserta didik', 'capacity' => '9 siswa'],
                    ['name' => 'Sub Ruang Instruktur dan Ruang Simpan', 'standard_area' => '3 m²/instruktur', 'capacity' => '9 instruktur'],
                    ['name' => 'Kolam Latih BST', 'standard_area' => 'Panjang: 20–25 m, Lebar: 10–15 m', 'capacity' => '1,2–1,5 m (dangkal) & 3,5–5 m (dalam) - m²']
                ],
            ],

            // 2. PERABOTAN DAN PERALATAN RUANG LABORATORIUM MIKROBIOLOGI
            [
                'title' => 'Perabotan dan Peralatan Ruang Laboratorium Mikrobiologi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Dimensi W42 x D50 x H90 cm, dudukan dan sandaran busa injection, finish fabric, rangka pipa besi oval finishing chrome', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Dimensi 900 x 500 x 450 mm, material MFC', 'standard_qty' => '1 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => 'Dimensi 150 x 75 x 80 cm, material hard pressed fibreboard, PVC rubber strips, tahan air dan bahan kimia', 'standard_qty' => '1 unit'],
                    ['name' => 'TV Layar Besar', 'spec' => 'Ukuran layar 45"-75", smart technology, direct full array, quantum dot technology', 'standard_qty' => '1 unit'],
                    ['name' => 'Lemari Alat (Tools Cabinet)', 'spec' => 'Untuk menyimpan peralatan', 'standard_qty' => '2 unit'],
                    ['name' => 'Kursi Kerja Lab (Stool)', 'spec' => 'Ukuran memadai untuk duduk saat praktik', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Alat', 'spec' => 'Bahan stainless steel, model rak dengan tingkat, ukuran minimal 800 x 400 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => 'Bahan stainless steel, model rak tingkat 2 atau 3, ukuran minimal 150 x 70 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Bangku Kerja', 'spec' => 'Bahan stainless steel, ukuran minimal 150 x 70 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Mikroskop Monokuler', 'spec' => 'Perbesaran sampai ± 500X, untuk mengamati mikroorganisme', 'standard_qty' => '6 unit'],
                    ['name' => 'Mikroskop Binokuler', 'spec' => 'Focusing coaxial cables/fine focusing knobs, illuminator, halogen 6V-20W', 'standard_qty' => '6 unit'],
                    ['name' => 'Laboratory Refrigerator', 'spec' => 'Untuk pembelajaran proses sterilisasi bahan makanan dengan suhu tinggi', 'standard_qty' => '1 unit'],
                    ['name' => 'Autoklaf', 'spec' => 'Kapasitas 30-50 liter, tegangan 220V/50Hz, temperatur sterilisasi 105-132°C', 'standard_qty' => '1 unit'],
                ],
            ],

            // 3. PERALATAN RUANG DAPUR PRODUKSI
            [
                'title' => 'Peralatan Ruang Dapur Produksi',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Vacuum Sealer', 'spec' => 'Power ≥ 900W, double sealing bar 50 x 1 cm, vacuum pump capacity min 20 m³/h, cycle time 15-25 sec', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Pembuat Kerupuk', 'spec' => 'Kapasitas 60 kg/jam, motor ± ¾ PK, pemotong otomatis, pisau bahan baja', 'standard_qty' => '1 unit'],
                    ['name' => 'Meat Grinder', 'spec' => 'Material stainless steel, produktivitas ±120 kg/jam, power ±850W', 'standard_qty' => '1 unit'],
                    ['name' => 'Silent Cutter', 'spec' => 'Untuk mencampur adonan bakso, power ±0.37kW, voltage 220/50Hz, kapasitas min 5L', 'standard_qty' => '1 unit'],
                    ['name' => 'Mixer', 'spec' => 'Untuk mencampur adonan', 'standard_qty' => '1 unit'],
                    ['name' => 'Vacuum Packing Machine', 'spec' => 'Voltage 220V/50Hz', 'standard_qty' => '1 unit'],
                    ['name' => 'Mikro Bakery/Planetary Mixer', 'spec' => 'Kapasitas ±7 L, power ±300 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Planetary Mixer', 'spec' => 'Voltage 220V/50Hz, kapasitas 1000 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Spiral Mixer', 'spec' => 'Voltage 220V/50Hz, kapasitas bowl ±20L, power ±1500 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Drying Oven', 'spec' => 'Range suhu room temperature-300°C, precision ±1°C, power 2 kW, kapasitas min 140L', 'standard_qty' => '1 unit'],
                    ['name' => 'Air Blast Freezer', 'spec' => 'Kapasitas 900 kg, temperatur -30°C s.d. -78°C, refrigerant R-410a, material stainless steel', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Penepung/Disk Mill', 'spec' => 'Penggerak motor bensin 5.5 HP, kecepatan 9000 rpm, kapasitas 55 kg/jam, material stainless steel', 'standard_qty' => '1 unit'],
                    ['name' => 'High Speed Automatic Filling and Packaging Machine', 'spec' => 'Untuk mengemas produk olahan kecepatan tinggi dan produk berbentuk granular', 'standard_qty' => '1 unit'],
                    ['name' => 'Mesin Cetak Bakso', 'spec' => 'Power 220V-750W', 'standard_qty' => '1 unit'],
                    ['name' => 'Bowl Chopper', 'spec' => 'Untuk mencincang dan mencampur daging', 'standard_qty' => '1 unit'],
                ],
            ],

            // 4. PERABOTAN DAN PERALATAN RUANG HASIL PENGOLAHAN PERIKANAN
            [
                'title' => 'Perabotan dan Peralatan Ruang Hasil Pengolahan Perikanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Dimensi 400 x 450 mm, material MFC', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Untuk bekerja', 'standard_qty' => '1 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => 'Dapat dipindah-pindah', 'standard_qty' => '1 unit'],
                    ['name' => 'TV Layar Besar', 'spec' => 'Untuk penayangan kegiatan langsung atau online', 'standard_qty' => '1 unit'],
                    ['name' => 'Lemari Alat (Tools Cabinet)', 'spec' => 'Untuk menyimpan peralatan', 'standard_qty' => '2 unit'],
                    ['name' => 'Stool/Kursi Kerja Bengkel', 'spec' => 'Rangka pipa dinding, fitting milling, tinggi 40.5 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Alat', 'spec' => 'Bahan stainless steel, model rak dengan tingkat 3, ukuran minimal 880 x 440 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => 'Bahan stainless steel, model rak tingkat 2 atau 3, ukuran minimal 1150 x 700 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Bangku Kerja', 'spec' => 'Bahan stainless steel, model dengan laci, ukuran minimal 1150 x 700 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Vacuum Packing Machine', 'spec' => 'Volume vacuum chamber min 375x270x80mm, exhaust pump speed, voltage 220V/50Hz', 'standard_qty' => '1 unit'],
                    ['name' => 'Continuous Band Sealer', 'spec' => 'Material stainless steel, voltage 220V, input power 2300W, speed up to 20m/min', 'standard_qty' => '1 unit'],
                    ['name' => 'Combihiler Freezer Cabinet', 'spec' => 'Kapasitas 6000 liter, daya listrik ±450 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Refrigerator Side by Side', 'spec' => 'Kapasitas 350L, daya listrik ±300 watt', 'standard_qty' => '1 unit'],
                    ['name' => 'Spray Dryer', 'spec' => 'Untuk membuat bahan cair menjadi powder dengan metode penyemprotan', 'standard_qty' => '1 unit'],
                    ['name' => 'Continuous Band Sealer', 'spec' => 'Daya ±500 watt, kecepatan 0-21 m/menit, lebar penyegelan ±1.2 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'High Speed Automatic Filling and Packaging Machine', 'spec' => 'Untuk produk bentuk irregular', 'standard_qty' => '1 unit'],
                    ['name' => 'Spray Dryer', 'spec' => 'Untuk pembelajaran proses pengolahan berupa serbuk', 'standard_qty' => '1 unit'],
                    ['name' => 'Automatic Pasta Machine', 'spec' => 'Automatic weighing and feeding', 'standard_qty' => '1 unit'],
                ],
            ],

            // 5. PERABOTAN DAN PERALATAN RUANG LABORATORIUM UJI SENSORIS
            [
                'title' => 'Perabotan dan Peralatan Ruang Laboratorium Uji Sensoris',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'W42 x D50 x H90 cm, dudukan busa injection', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Kerja', 'spec' => '900 x 450 mm, material MFC', 'standard_qty' => '1 unit'],
                    ['name' => 'Papan Tulis Dorong', 'spec' => '150 x 75 x 80 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'TV Layar Besar', 'spec' => 'Ukuran 45"-75"', 'standard_qty' => '1 unit'],
                    ['name' => 'Lemari Alat', 'spec' => 'Untuk menyimpan peralatan', 'standard_qty' => '2 unit'],
                    ['name' => 'Stool/Kursi Kerja Bengkel', 'spec' => 'Rangka pipa, tinggi 40.5 cm', 'standard_qty' => '1 unit'],
                    ['name' => 'Meja Alat', 'spec' => 'Stainless steel, 880 x 440 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Meja Persiapan', 'spec' => 'Stainless steel, 1150 x 700 x 80 cm', 'standard_qty' => '2 unit'],
                    ['name' => 'Bangku Kerja', 'spec' => 'Stainless steel dengan laci', 'standard_qty' => '2 unit'],
                    ['name' => 'Viscometer', 'spec' => 'Untuk mengukur kekentalan bahan cair', 'standard_qty' => '2 unit'],
                    ['name' => 'Moisture Tester', 'spec' => 'Untuk mengukur kadar air, power supply 1.5V, suhu 0-50°C', 'standard_qty' => '2 unit'],
                    ['name' => 'Laboratory Refrigerator', 'spec' => 'Untuk sterilisasi bahan makanan', 'standard_qty' => '1 unit'],
                    ['name' => 'Timbangan Analitik', 'spec' => 'Ketelitian 4 angka, kapasitas 120-300 gram', 'standard_qty' => '2 unit'],
                    ['name' => 'Desikator', 'spec' => 'Tempat penyimpanan bahan yang mudah menyerap air', 'standard_qty' => '6 unit'],
                    ['name' => 'Jangka Sorong', 'spec' => 'Range 0-150 mm, material stainless steel, akurasi ±0.07 mm', 'standard_qty' => '18 unit'],
                    ['name' => 'Infrared Thermometer', 'spec' => 'Range suhu -32°C s.d. 380°C, akurasi ±2%, distance spot ratio 12:1', 'standard_qty' => '18 unit'],
                ],
            ],

            // 6. PERABOTAN DAN PERALATAN SUB RUANG INSTRUKTUR DAN PENYIMPANAN
            [
                'title' => 'Perabotan dan Peralatan Sub Ruang Instruktur dan Penyimpanan',
                'type' => 'equipment',
                'items' => [
                    ['name' => 'Kursi Kerja', 'spec' => 'Ergonomis, nyaman', 'standard_qty' => '5 unit'],
                    ['name' => 'Meja Kerja', 'spec' => 'Ukuran memadai', 'standard_qty' => '5 unit'],
                    ['name' => 'Lemari Simpan', 'spec' => 'Sistem knock down, 900 x 400 x 1850 mm, sheet metal 0.7 mm', 'standard_qty' => '2 unit'],
                    ['name' => 'Refraktometer', 'spec' => 'Untuk mengukur kadar gula/garam, range Brix 0-53%', 'standard_qty' => '2 unit'],
                    ['name' => 'Timbangan Digital', 'spec' => 'Ketelitian 0.1 g', 'standard_qty' => '1 unit'],
                    ['name' => 'Lux Meter', 'spec' => 'Range 0-200.000 LUX', 'standard_qty' => '2 unit'],
                    ['name' => 'Portable pH/ORP/Conductivity Meter', 'spec' => 'Untuk uji kualitas air', 'standard_qty' => '2 unit'],
                    ['name' => 'Turbidity Meter', 'spec' => 'Untuk mengukur kekeruhan, minimum 90% scattered light', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Hardness Tester', 'spec' => 'Untuk uji kesadahan air', 'standard_qty' => '2 unit'],
                    ['name' => 'Water Color Meter', 'spec' => 'Untuk uji warna air', 'standard_qty' => '2 unit'],
                    ['name' => 'BOD Meter', 'spec' => 'Untuk mengukur oksigen terlarut, range 5-4000 mg/L', 'standard_qty' => '2 unit'],
                ],
            ],

            // 7. KELENGKAPAN SMART CLASSROOM
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
                    ['name' => 'Interactive Flat Panel(IFP)', 'standard_qty' => '1 Unit']
                ],
            ],

            // 8. KELENGKAPAN KESELAMATAN DAN KESEHATAN KERJA (K3)
            [
                'title' => 'Kelengkapan Keselamatan dan Kesehatan Kerja (K3)',
                'type' => 'k3',
                'items' => [
                    ['name' => 'APAR (Alat Pemadam Api Ringan)', 'spec' => 'Tersedia, terisi, dan berkala uji', 'standard_qty' => '4 unit'],
                    ['name' => 'Hydrant Box dan Alarm', 'spec' => 'Berfungsi, mudah diakses', 'standard_qty' => '1 set'],
                    ['name' => 'Smoke Detector', 'spec' => 'Terpasang di area rawan, berfungsi', 'standard_qty' => '4 unit'],
                    ['name' => 'Sprinkler', 'spec' => 'Terpasang sesuai ketentuan', 'standard_qty' => '1 set'],
                    ['name' => 'P3K Kit', 'spec' => 'Isi lengkap dan tidak kadaluarsa', 'standard_qty' => '2 unit'],
                    ['name' => 'APD (masker, sarung tangan, safety shoes, jas laboratorium)', 'spec' => 'Tersedia dan sesuai standar', 'standard_qty' => '18 set'],
                    ['name' => 'Jalur Evakuasi dan Titik Kumpul', 'spec' => 'Ada rambu yang jelas dan mudah dilihat', 'standard_qty' => '1 set'],
                    ['name' => 'Rambu K3 dan Poster Keselamatan', 'spec' => 'Terpasang di area strategis', 'standard_qty' => '10 buah'],
                    ['name' => 'Fasilitas Cuci Tangan (CTPS)', 'spec' => 'Dengan air mengalir dan sabun', 'standard_qty' => '2 unit'],
                    ['name' => 'Prosedur Kesehatan (Covid-19)', 'spec' => 'Poster protokol kesehatan terpasang', 'standard_qty' => '5 buah'],
                ],
            ],

            // 9. KELENGKAPAN UTILITAS DAN BANGUNAN
            [
                'title' => 'Kelengkapan Utilitas dan Bangunan',
                'type' => 'utility',
                'items' => [
                    ['name' => 'Jaringan Internet', 'spec' => 'Tersedia dan dapat diakses'],
                    ['name' => 'Pencahayaan Alami dan Buatan (Sesuai SNI)'],
                    ['name' => 'Ventilasi Udara (Sesuai SNI)'],
                    ['name' => 'Toilet Terpisah Pria/Wanita'],
                    ['name' => 'Sumber Air Bersih'],
                    ['name' => 'Instalasi Listrik yang Aman (Sesuai SNI)'],
                    ['name' => 'Stop Kontak 1 Phase (jarak 3 m sepanjang dinding)'],
                    ['name' => 'Sistem Penangkal Petir'],
                ],
            ],

            // 10. PENERAPAN BUDAYA KERJA INDUSTRI
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
