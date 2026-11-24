@extends('layouts.public')

@section('title', 'Riwayat Laporan')

@section('content')
<section class="page-head">
    <div class="container narrow">
        <span class="label">RIWAYAT LAPORAN</span>
        <h1>Laporan yang sudah kamu kirim</h1>
        <p>Pantau status setiap laporanmu di sini.</p>
    </div>
</section>

<section class="section form-section">
    <div class="container narrow">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="list-toolbar">
            <span>{{ $laporan->total() }} laporan</span>
            <a href="{{ route('laporan.create') }}" class="btn btn-primary">＋ Buat Laporan</a>
        </div>

        <div class="report-list single">
            @forelse($laporan as $item)
                <article class="report-card">
                    <div class="report-top">
                        <span class="tag tag-{{ \Illuminate\Support\Str::slug($item->jenis->nama_jenis ?? 'laporan') }}">{{ $item->jenis->nama_jenis ?? 'Laporan' }}</span>
                        <span class="status status-{{ strtolower($item->status->nama_status ?? 'menunggu') }}">
                            {{ $item->status->nama_status ?? 'Menunggu' }}
                        </span>
                    </div>
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($item->isi_laporan, 160) }}</p>
                    <small>
                        {{ $item->kategori->nama_kategori ?? '-' }}
                        · {{ $item->tanggal_laporan?->translatedFormat('d M Y, H:i') }}
                        @if($item->anonim) · Anonim @endif
                        @if($item->rahasia) · Rahasia @endif
                    </small>
                </article>
            @empty
                <div class="empty">
                    <div>▤</div>
                    <strong>Belum ada laporan</strong>
                    <p>Kamu belum mengirimkan laporan apa pun.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">{{ $laporan->links() }}</div>
    </div>
</section>
@endsection
