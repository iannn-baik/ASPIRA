@extends('layouts.public')

@section('title', 'Laporan Publik')

@section('content')
<section class="page-head head-green">
    <div class="container">
        <span class="label">LAPORAN PUBLIK</span>
        <h1>Laporan yang sedang berjalan</h1>
        <p>Hanya laporan yang bersifat terbuka. Identitas pelapor tidak ditampilkan.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <form method="GET" action="{{ route('laporan.publik') }}" class="filter-bar">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul laporan...">
            <select name="kategori">
                <option value="">Semua kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}" @selected(request('kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request()->hasAny(['q', 'kategori']))
                <a href="{{ route('laporan.publik') }}" class="btn btn-outline">Reset</a>
            @endif
        </form>

        <div class="report-list three">
            @forelse($laporan as $item)
                <article class="report-card">
                    <div class="report-top">
                        <span class="tag tag-{{ \Illuminate\Support\Str::slug($item->jenis->nama_jenis ?? 'laporan') }}">{{ $item->jenis->nama_jenis ?? 'Laporan' }}</span>
                        <span class="status status-{{ strtolower($item->status->nama_status ?? 'menunggu') }}">{{ $item->status->nama_status ?? 'Menunggu' }}</span>
                    </div>
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($item->isi_laporan, 110) }}</p>
                    <small>{{ $item->kategori->nama_kategori ?? '-' }} · {{ $item->tanggal_laporan?->translatedFormat('d M Y') }}</small>
                </article>
            @empty
                <div class="empty">
                    <div>▤</div>
                    <strong>Tidak ada laporan</strong>
                    <p>Belum ada laporan terbuka yang sesuai.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">{{ $laporan->links() }}</div>
    </div>
</section>
@endsection
