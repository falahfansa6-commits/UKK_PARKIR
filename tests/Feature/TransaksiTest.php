<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_vehicle_entry_can_be_saved_before_checkout(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => 'password',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234XYZ',
            'jenis_kendaraan' => 'mobil',
        ]);
        $area = AreaParkir::create([
            'nama_area' => 'A',
            'kapasitas' => 10,
            'terisi' => 0,
        ]);
        $tarif = Tarif::create([
            'jenis_kendaraan' => 'mobil',
            'tarif_per_jam' => 5000,
        ]);

        $transaksi = Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_area' => $area->id_area,
            'id_tarif' => $tarif->id_tarif,
            'id_user' => $user->id_user,
            'waktu_masuk' => now(),
            'status' => 'masuk',
        ]);

        $this->assertSame('id_transaksi', $transaksi->getKeyName());
        $this->assertNotNull($transaksi->id_transaksi);
        $this->assertSame($kendaraan->id_kendaraan, $transaksi->kendaraan->id_kendaraan);
        $this->assertNull($transaksi->durasi_jam);
        $this->assertNull($transaksi->biaya_total);
    }
}
