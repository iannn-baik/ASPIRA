<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Akun
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('nama_lengkap', 100);
            $table->string('nim', 20)->nullable()->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('fakultas', 100)->nullable();
            $table->string('program_studi', 100)->nullable();
            $table->enum('role', ['mahasiswa', 'admin'])->default('mahasiswa');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Jenis Pengajuan
        Schema::create('jenis_pengajuan', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('nama_jenis', 50)->unique();
            $table->timestamps();
        });

        // 3. Kategori
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100)->unique();
            $table->timestamps();
        });

        // 4. Instansi Tujuan
        Schema::create('instansi_tujuan', function (Blueprint $table) {
            $table->id('id_instansi');
            $table->string('nama_instansi', 100);
            $table->timestamps();
        });

        // 5. Status Laporan
        Schema::create('status_laporan', function (Blueprint $table) {
            $table->id('id_status');
            $table->string('nama_status', 50)->unique();
            $table->timestamps();
        });

        // 6. Laporan
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');

            $table->foreignId('id_akun')
                ->constrained('akun', 'id_akun')
                ->restrictOnDelete();

            $table->foreignId('id_jenis')
                ->constrained('jenis_pengajuan', 'id_jenis')
                ->restrictOnDelete();

            $table->foreignId('id_kategori')
                ->constrained('kategori', 'id_kategori')
                ->restrictOnDelete();

            $table->foreignId('id_instansi')
                ->nullable()
                ->constrained('instansi_tujuan', 'id_instansi')
                ->nullOnDelete();

            $table->foreignId('id_status')
                ->constrained('status_laporan', 'id_status')
                ->restrictOnDelete();

            $table->string('judul', 150);
            $table->text('isi_laporan');
            $table->date('tanggal_kejadian')->nullable();
            $table->string('lokasi_kejadian', 150)->nullable();
            $table->boolean('anonim')->default(false);
            $table->boolean('rahasia')->default(false);
            $table->timestamp('tanggal_laporan')->useCurrent();
            $table->timestamps();
        });

        // 7. Lampiran
        Schema::create('lampiran', function (Blueprint $table) {
            $table->id('id_lampiran');

            $table->foreignId('id_laporan')
                ->constrained('laporan', 'id_laporan')
                ->cascadeOnDelete();

            $table->string('nama_file');
            $table->string('path_file');
            $table->timestamps();
        });

        // 8. Riwayat Status
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id('id_riwayat');

            $table->foreignId('id_laporan')
                ->constrained('laporan', 'id_laporan')
                ->cascadeOnDelete();

            $table->foreignId('id_status')
                ->constrained('status_laporan', 'id_status')
                ->restrictOnDelete();

            $table->foreignId('id_akun')
                ->nullable()
                ->constrained('akun', 'id_akun')
                ->nullOnDelete();

            $table->text('keterangan')->nullable();
            $table->timestamp('waktu_perubahan')->useCurrent();
            $table->timestamps();
        });

        // 9. Tanggapan
        Schema::create('tanggapan', function (Blueprint $table) {
            $table->id('id_tanggapan');

            $table->foreignId('id_laporan')
                ->constrained('laporan', 'id_laporan')
                ->cascadeOnDelete();

            $table->foreignId('id_akun')
                ->constrained('akun', 'id_akun')
                ->restrictOnDelete();

            $table->text('isi_tanggapan');
            $table->timestamp('tanggal_tanggapan')->useCurrent();
            $table->timestamps();
        });

        // 10. Feedback
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id_feedback');

            $table->foreignId('id_laporan')
                ->unique()
                ->constrained('laporan', 'id_laporan')
                ->cascadeOnDelete();

            $table->foreignId('id_akun')
                ->constrained('akun', 'id_akun')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->timestamp('tanggal_feedback')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('tanggapan');
        Schema::dropIfExists('riwayat_status');
        Schema::dropIfExists('lampiran');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('status_laporan');
        Schema::dropIfExists('instansi_tujuan');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('jenis_pengajuan');
        Schema::dropIfExists('akun');
    }
};
