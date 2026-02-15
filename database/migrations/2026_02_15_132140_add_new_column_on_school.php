<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('province_code')->nullable();
            $table->string('regency_code')->nullable();
            $table->string('expertise')->nullable()->comment('kelautan/kemaritiman/perikanan/tik');
            $table->string('expertise_program')->nullable()->comment('contoh: Nautika Kapal Niaga, Nautika Kapal Penangkapan Ikan, dll');
            $table->string('expertise_concentration')->nullable()->comment('contoh: Nautika Kapal Niaga, Nautika Kapal Penangkapan Ikan, dll');
        });
    }

// Expertise Program

// A. Bidang Keahlian Kemaritiman:		
// - Teknika Kapal Penangkapan Ikan		
// - Nautika Kapal Penangkapan Ikan		
// - Teknika Kapal Niaga		
// - Nautika Kapal Niaga		
// B. Bidang Keahlian Perikanan		
// - Agribisnis Perikanan		
// C. Bidang TIK		
// - Pengembangan Perangkat Lunak dan Gim		
// - Teknik Jaringan Komputer dan Telekomunikasi		

// Expertise Concentration

// Kemaritiman:	
// - Nautika Kapal Penangkap Ikan	
// - Teknika Kapal Penangkap Ikan	
// - Nautika Kapal Niaga	
// - Teknika Kapal Niaga	
// - Lainnya, sebutkan	
// Perikanan:	
// - Agribisnis Ikan Hias	
// - Agribisnis Perikanan Payau dan Laut	
// - Agribisnis Perikanan Air Tawar	
// -Agribisnis Rumput Laut	
// - Lainnya, sebutkan	
// TIK:	
// - Rekayasa Perangkat Lunak	
// - Pengembangan GIM	
// - Sistem Informasi, Jaringan, dan Aplikasi	
// - Teknik Komputer dan Jarinngan	
// - Teknik Jaringan Akses Telekomunikasi	
// - Teknik Transmisi Telekomunikasi	
// - Lainnya, sebutkan	

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
            $table->dropColumn('province_code');
            $table->dropColumn('regency_code');
            $table->dropColumn('expertise');
            $table->dropColumn('expertise_program');
            $table->dropColumn('expertise_concentration');
        });
    }
};
