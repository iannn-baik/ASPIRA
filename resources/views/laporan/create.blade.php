@extends('layouts.public')

@section('title', 'Buat Laporan')

@section('content')
<section class="page-head">
    <div class="container narrow">
        <span class="label">BUAT LAPORAN</span>
        <h1>Sampaikan aspirasi atau pengaduanmu</h1>
        <p>Isi formulir di bawah ini dengan jelas agar laporanmu dapat segera ditindaklanjuti.</p>
    </div>
</section>

<section class="section form-section">
    <div class="container narrow">
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Periksa kembali isian kamu:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!empty($draft))
            <div class="alert alert-info">Isian dari beranda sudah kami pulihkan. Jika sebelumnya kamu memilih lampiran, silakan unggah ulang di bawah.</div>
        @endif

        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="id_jenis">Jenis <span class="req">*</span></label>
                    <select id="id_jenis" name="id_jenis" required>
                        <option value="">Pilih jenis</option>
                        @foreach($jenis as $j)
                            <option value="{{ $j->id_jenis }}" @selected(old('id_jenis', $draft['id_jenis'] ?? null) == $j->id_jenis)>{{ $j->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kategori">Kategori <span class="req">*</span></label>
                    <select id="id_kategori" name="id_kategori" required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id_kategori }}" @selected(old('id_kategori', $draft['id_kategori'] ?? null) == $k->id_kategori)>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="id_instansi">Instansi Tujuan</label>
                <select id="id_instansi" name="id_instansi">
                    <option value="">Tidak tahu / serahkan ke admin</option>
                    @foreach($instansi as $i)
                        <option value="{{ $i->id_instansi }}" @selected(old('id_instansi', $draft['id_instansi'] ?? null) == $i->id_instansi)>{{ $i->nama_instansi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="judul">Judul Laporan <span class="req">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $draft['judul'] ?? null) }}" maxlength="150" placeholder="Ringkas dan jelas" required>
            </div>

            <div class="form-group">
                <label for="isi_laporan">Isi Laporan <span class="req">*</span></label>
                <textarea id="isi_laporan" name="isi_laporan" rows="7" placeholder="Ceritakan secara rinci: apa yang terjadi, dampaknya, dan harapanmu." required>{{ old('isi_laporan', $draft['isi_laporan'] ?? null) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal_kejadian">Tanggal Kejadian</label>
                    <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $draft['tanggal_kejadian'] ?? null) }}" max="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="lokasi_kejadian">Lokasi Kejadian</label>
                    <input type="text" id="lokasi_kejadian" name="lokasi_kejadian" value="{{ old('lokasi_kejadian', $draft['lokasi_kejadian'] ?? null) }}" maxlength="150" placeholder="Mis. Gedung A, Lantai 2">
                </div>
            </div>

            <div class="form-group">
                <label for="lampiran">Lampiran (opsional)</label>
                <input type="file" id="lampiran" name="lampiran[]" multiple accept=".jpg,.jpeg,.png,.pdf">
                <small class="hint">Maksimal 3 file, format JPG/PNG/PDF, masing-masing maksimal 2 MB.</small>
            </div>

            <div class="checks">
                <label class="check">
                    <input type="checkbox" name="anonim" value="1" @checked(old('anonim', $draft['anonim'] ?? null))>
                    <span><strong>Kirim sebagai anonim</strong><br><small>Namamu disembunyikan dari pihak yang menindaklanjuti.</small></span>
                </label>
                <label class="check">
                    <input type="checkbox" name="rahasia" value="1" @checked(old('rahasia', $draft['rahasia'] ?? null))>
                    <span><strong>Laporan rahasia</strong><br><small>Laporan tidak ditampilkan di beranda publik.</small></span>
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('beranda') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg">Kirim Laporan →</button>
            </div>
        </form>
    </div>
</section>
@endsection
