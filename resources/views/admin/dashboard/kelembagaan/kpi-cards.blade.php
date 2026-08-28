{{-- Stats Bar --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <x-dashboard.kpi-card title="Total Sekolah Terdata" :value="$stats['total_sekolah']" icon="bi-building" variant="default" />
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <x-dashboard.kpi-card title="Provinsi Tercakup" :value="$stats['total_provinsi']" icon="bi-geo-alt" variant="default" />
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <x-dashboard.kpi-card title="Bidang Keahlian" :value="$stats['total_bidang']" icon="bi-diagram-3" variant="default" />
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <x-dashboard.kpi-card title="Konsentrasi Keahlian" :value="$stats['total_konsentrasi']" icon="bi-layers" variant="default" />
    </div>
</div>