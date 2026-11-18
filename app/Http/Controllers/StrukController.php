<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

use App\Models\Transaksi;

class StrukController extends Controller
{
    public function cetak(Transaksi $transaksi)
    {
        // Hanya petugas yang boleh mencetak struk
        abort_unless(auth()->user()->isPetugas(), 403);

        // Struk hanya bisa dicetak setelah kendaraan keluar
        abort_unless($transaksi->status === 'keluar', 404);

        return view('struk', compact('transaksi'));
    }
}
