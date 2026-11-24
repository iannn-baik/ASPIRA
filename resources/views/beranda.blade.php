@extends('layouts.public')

@section('title', 'Beranda')

@php
    $isMahasiswa = auth()->check() && auth()->user()->role === 'mahasiswa';
    $isAdmin     = auth()->check() && auth()->user()->role === 'admin';
    $jenisAktif  = old('id_jenis', optional($jenis->first())->id_jenis);
@endphp

@section('content')

{{-- HERO + FORM LAPORAN --}}
<section class="hero" id="beranda">
    <div class="container">
        <h1>Layanan Aspirasi dan Pengaduan Online Mahasiswa</h1>
        <p>Sampaikan laporan Anda langsung kepada instansi kampus yang berwenang secara cepat, aman, dan tervalidasi.</p>
    </div>
</section>

<section class="report-box-wrap">
    <div class="container">
        <div class="report-box">
            <div class="report-box-head">Sampaikan Laporan Anda</div>

            <form id="formLaporan"
                  action="{{ $isMahasiswa ? route('laporan.store') : route('laporan.lanjut') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_jenis" id="id_jenis" value="{{ $jenisAktif }}">

                <div class="tabs" role="tablist">
                    @foreach($jenis as $j)
                        <button type="button" class="tab {{ $jenisAktif == $j->id_jenis ? 'active' : '' }}" data-id="{{ $j->id_jenis }}">
                            {{ $j->nama_jenis }}
                        </button>
                    @endforeach
                </div>

                <div class="report-body">
                    @if($jenis->isEmpty())
                        <div class="alert alert-error">Data master belum terisi. Jalankan <code>php artisan db:seed</code>.</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <strong>Periksa kembali isian kamu:</strong>
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="notice">
                        <span class="notice-icon">!</span>
                        Perhatikan cara menyampaikan aduan yang baik, benar, dan sopan.
                        <a href="#alur">Lihat Panduan</a>
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul Laporan <span class="req">*</span></label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" maxlength="150" placeholder="Ketik Judul Laporan Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="isi_laporan">Isi Laporan <span class="req">*</span></label>
                        <textarea id="isi_laporan" name="isi_laporan" rows="3" placeholder="Ketik Isi Laporan Anda" required>{{ old('isi_laporan') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal_kejadian">Tanggal Kejadian <span class="req">*</span></label>
                            <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasi_kejadian">Lokasi Kejadian <span class="req">*</span></label>
                            <input type="text" id="lokasi_kejadian" name="lokasi_kejadian" value="{{ old('lokasi_kejadian') }}" maxlength="150" placeholder="Ketik lokasi kejadian.." required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="id_instansi">Instansi Tujuan</label>
                            <select id="id_instansi" name="id_instansi">
                                <option value="">Pilih instansi tujuan</option>
                                @foreach($instansi as $i)
                                    <option value="{{ $i->id_instansi }}" @selected(old('id_instansi') == $i->id_instansi)>{{ $i->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_kategori">Kategori Laporan <span class="req">*</span></label>
                            <select id="id_kategori" name="id_kategori" required>
                                <option value="">Pilih Kategori Laporan</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}" @selected(old('id_kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="report-actions">
                        <div class="report-options">
                            @if($isMahasiswa)
                                <label class="btn btn-outline btn-sm" for="lampiran">🔗 Upload Lampiran</label>
                                <input type="file" id="lampiran" name="lampiran[]" multiple accept=".jpg,.jpeg,.png,.pdf" hidden>
                                <span class="file-info" id="fileInfo"></span>
                            @endif
                            <label class="check-inline"><input type="checkbox" name="anonim" value="1" @checked(old('anonim'))> Anonim</label>
                            <label class="check-inline"><input type="checkbox" name="rahasia" value="1" @checked(old('rahasia'))> Rahasia</label>
                        </div>

                        @if($isMahasiswa)
                            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                        @elseif($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Buka Dashboard Admin</a>
                        @else
                            <button type="submit" class="btn btn-primary">Masuk untuk Lapor</button>
                        @endif
                    </div>

                    @guest
                        <p class="form-hint">Isianmu akan tersimpan sementara dan dipulihkan setelah kamu masuk atau mendaftar. Lampiran dapat diunggah setelah masuk.</p>
                    @endguest
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ALUR LAPORAN --}}
<section class="section section-alt" id="alur">
    <div class="container">
        <div class="alur-head">
            <div>
                <h2>Langkah Alur Laporan Anda</h2>
                <p>Setiap laporan yang dikirim akan diproses sesuai standar operasional baku kampus.</p>
            </div>
            <a href="{{ route('faq') }}" class="link-more">Pelajari Selengkapnya →</a>
        </div>

        <div class="alur">
            <div class="alur-step"><span class="alur-icon blue">✎</span> Tulis Laporan</div>
            <span class="alur-arrow">→</span>
            <div class="alur-step"><span class="alur-icon orange">◷</span> Proses Verifikasi</div>
            <span class="alur-arrow">→</span>
            <div class="alur-step"><span class="alur-icon sky">➤</span> Tindak Lanjut</div>
            <span class="alur-arrow">→</span>
            <div class="alur-step"><span class="alur-icon purple">✉</span> Beri Tanggapan</div>
            <span class="alur-arrow">→</span>
            <div class="alur-step"><span class="alur-icon green">✓</span> Selesai</div>
        </div>
    </div>
</section>

{{-- JELAJAHI (halaman terpisah) --}}
<section class="section">
    <div class="container">
        <div class="section-title">
            <span class="label">JELAJAHI</span>
            <h2>Informasi lainnya</h2>
        </div>

        <div class="explore">
            <a href="{{ route('statistik') }}" class="explore-card c-purple">
                <span class="explore-icon">▦</span>
                <h3>Statistik</h3>
                <p>Lihat jumlah laporan, status penanganan, dan kategori terbanyak.</p>
                <span class="explore-more">Buka halaman →</span>
            </a>
            <a href="{{ route('laporan.publik') }}" class="explore-card c-green">
                <span class="explore-icon">▤</span>
                <h3>Laporan Publik</h3>
                <p>Pantau laporan terbuka yang sedang ditindaklanjuti.</p>
                <span class="explore-more">Buka halaman →</span>
            </a>
            <a href="{{ route('faq') }}" class="explore-card c-orange">
                <span class="explore-icon">?</span>
                <h3>FAQ</h3>
                <p>Jawaban atas pertanyaan yang sering diajukan.</p>
                <span class="explore-more">Buka halaman →</span>
            </a>
        </div>
    </div>
</section>

<script>
    // Tab jenis laporan
    document.querySelectorAll('.tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab').forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            document.getElementById('id_jenis').value = tab.dataset.id;
        });
    });

    // Info jumlah lampiran
    var lampiran = document.getElementById('lampiran');
    if (lampiran) {
        lampiran.addEventListener('change', function () {
            document.getElementById('fileInfo').textContent = lampiran.files.length ? lampiran.files.length + ' file dipilih' : '';
        });
    }
</script>

@endsection
