@extends('layouts.public')

@section('title', 'FAQ')

@section('content')
<section class="page-head head-orange">
    <div class="container narrow">
        <span class="label">FAQ</span>
        <h1>Pertanyaan yang sering diajukan</h1>
        <p>Belum menemukan jawabannya? Hubungi layanan bantuan ASPIRA.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <details class="faq f-blue" open>
            <summary>Apakah saya harus login untuk melihat beranda?</summary>
            <p>Tidak. Beranda dan formulir dapat dilihat siapa saja. Login baru diminta saat kamu menekan tombol untuk mengirim laporan.</p>
        </details>
        <details class="faq f-green">
            <summary>Apakah identitas saya bisa dirahasiakan?</summary>
            <p>Ya. Centang opsi Anonim dan/atau Rahasia, sehingga laporan tidak ditampilkan secara publik.</p>
        </details>
        <details class="faq f-purple">
            <summary>Bagaimana cara memantau laporan saya?</summary>
            <p>Buka dashboard atau riwayat laporan setelah masuk. Status laporan diperbarui selama proses berlangsung.</p>
        </details>
        <details class="faq f-orange">
            <summary>Lampiran apa saja yang bisa diunggah?</summary>
            <p>Hingga 3 file berformat JPG, PNG, atau PDF dengan ukuran maksimal 2 MB per file.</p>
        </details>
        <details class="faq f-pink">
            <summary>Apa bedanya Pengaduan, Aspirasi, dan Permintaan Informasi?</summary>
            <p>Pengaduan untuk keluhan atau masalah, Aspirasi untuk saran dan masukan, sedangkan Permintaan Informasi untuk menanyakan informasi layanan kampus.</p>
        </details>
    </div>
</section>
@endsection
