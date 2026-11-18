<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tb_transaksi', 'id_kendaraaan')
            && ! Schema::hasColumn('tb_transaksi', 'id_kendaraan')) {
            Schema::table('tb_transaksi', function (Blueprint $table) {
                $table->dropForeign(['id_kendaraaan']);
                $table->renameColumn('id_kendaraaan', 'id_kendaraan');
            });

            Schema::table('tb_transaksi', function (Blueprint $table) {
                $table->foreign('id_kendaraan')
                    ->references('id_kendaraan')
                    ->on('tb_kendaraan');
            });
        }

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->string('durasi_jam')->nullable()->change();
            $table->decimal('biaya_total', 10, 0)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('tb_transaksi')
            ->whereNull('durasi_jam')
            ->update(['durasi_jam' => '0']);

        DB::table('tb_transaksi')
            ->whereNull('biaya_total')
            ->update(['biaya_total' => 0]);

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->string('durasi_jam')->nullable(false)->change();
            $table->decimal('biaya_total', 10, 0)->nullable(false)->change();
        });
    }
};
