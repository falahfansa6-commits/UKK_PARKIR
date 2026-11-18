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
       Schema::create('tb_user', function (Blueprint $table) {
    $table->id('id_user');
    $table->string('nama_lengkap',100);
    $table->string('username',100)->unique();
    $table->string('password',100);
    $table->enum('role',['admin','petugas','owner']);
    $table->boolean('status_aktif')->default(true);
});

Schema::create('tb_kendaraan', function (Blueprint $table) {
    $table->id('id_kendaraan');
    $table->string('plat_nomor',100)->unique();
    $table->enum('jenis_kendaraan',['motor','mobil','lainnya']);
    $table->string('warna')->nullable();
    $table->string('pemilik')->nullable();
    $table->foreignId('is_user')->nullable()->constrained('tb_user','id_user')->onDelete('cascade');

});

Schema::create('tb_area_parkir', function (Blueprint $table) {
    $table->id('id_area');
    $table->string('nama_area', 100);
    $table->unsignedInteger('kapasitas');
    $table->unsignedInteger('terisi')->default(0);
});

Schema::create('tb_tarif', function (Blueprint $table) {
    $table->id('id_tarif');
    $table->enum('jenis_kendaraan',['motor','mobil','lainnya'])->unique();
    $table->decimal('tarif_per_jam',10, 0);
});

Schema::create('tb_transaksi', function (Blueprint $table) {
    $table->id('id_transaksi');
    $table->foreignId('id_kendaraan')->constrained('tb_kendaraan', 'id_kendaraan');
    $table->dateTime('waktu_masuk');
    $table->dateTime('waktu_keluar')->nullable();
    $table->foreignId('id_tarif')->constrained('tb_tarif', 'id_tarif');
    $table->string('durasi_jam')->nullable();
    $table->decimal('biaya_total',10, 0)->nullable();
    $table->enum('status', ['masuk', 'keluar'])->default('masuk');
    $table->foreignId('id_user')->constrained('tb_user', 'id_user');
    $table->foreignId('id_area')->constrained('tb_area_parkir', 'id_area');

});

Schema::create('tb_log_aktivitas', function (Blueprint $table) {
    $table->id('id_log');
    $table->foreignId('id_user')->nullable()->constrained('tb_user','id_user')->onDelete('cascade');
    $table->string('aktivitas',100);
    $table->dateTime('waktu_aktivitas');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
        Schema::dropIfExists('tb_transaksi');
        Schema::dropIfExists('tb_tarif');
        Schema::dropIfExists('tb_area_parkir');
        Schema::dropIfExists('tb_kendaraan');
        Schema::dropIfExists('tb_user');
    }
};
