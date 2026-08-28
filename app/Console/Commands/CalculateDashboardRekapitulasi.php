<?php

namespace App\Console\Commands;

use App\Services\Dashboard\DashboardRekapitulasiService;
use Illuminate\Console\Command;

class CalculateDashboardRekapitulasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:calculate-rekapitulasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kalkulasi dan sinkronisasi data rekapitulasi indikator mutu SMK per 6 jam';

    /**
     * Execute the console command.
     */
    public function handle(DashboardRekapitulasiService $service): int
    {
        @ini_set('memory_limit', '512M');

        $this->info('Memulai proses kalkulasi & rekapitulasi data dashboard Mutu SMK...');

        try {
            $syncedCount = $service->syncAll();
            $this->info("Berhasil mengalkulasi {$syncedCount} baris data rekapitulasi dashboard.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Gagal melakukan kalkulasi rekapitulasi: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
