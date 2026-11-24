@extends('layouts.public')

@section('title', 'Statistik')

@section('content')
<section class="page-head head-purple">
    <div class="container">
        <span class="label">STATISTIK</span>
        <h1>ASPIRA dalam angka</h1>
        <p>Ringkasan laporan yang masuk dan perkembangan penanganannya.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats">
            <div class="stat s-blue"><div class="stat-icon blue">▤</div><strong>{{ number_format($stats['total']) }}</strong><span>Total Laporan</span></div>
            <div class="stat s-purple"><div class="stat-icon purple">↻</div><strong>{{ number_format($stats['diproses']) }}</strong><span>Sedang Diproses</span></div>
            <div class="stat s-green"><div class="stat-icon green">✓</div><strong>{{ number_format($stats['selesai']) }}</strong><span>Laporan Selesai</span></div>
            <div class="stat s-orange"><div class="stat-icon orange">♙</div><strong>{{ number_format($stats['mahasiswa']) }}</strong><span>Mahasiswa Terdaftar</span></div>
        </div>

        <div class="two-col">
            <div class="panel">
                <h3>Laporan per Status</h3>
                @foreach($perStatus as $st)
                    @php $persen = round($st->laporan_count / $totalLaporan * 100); @endphp
                    <div class="bar-row">
                        <div class="bar-label"><span>{{ $st->nama_status }}</span><strong>{{ $st->laporan_count }}</strong></div>
                        <div class="bar"><div class="bar-fill fill-{{ strtolower($st->nama_status) }}" style="width: {{ $persen }}%"></div></div>
                    </div>
                @endforeach
            </div>

            <div class="panel">
                <h3>Laporan per Kategori</h3>
                @forelse($perKategori as $k)
                    @php $lebar = round($k->laporan_count / $maxKategori * 100); @endphp
                    <div class="bar-row">
                        <div class="bar-label"><span>{{ $k->nama_kategori }}</span><strong>{{ $k->laporan_count }}</strong></div>
                        <div class="bar"><div class="bar-fill fill-cycle-{{ ($loop->index % 6) + 1 }}" style="width: {{ $lebar }}%"></div></div>
                    </div>
                @empty
                    <p class="muted">Belum ada data kategori.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
