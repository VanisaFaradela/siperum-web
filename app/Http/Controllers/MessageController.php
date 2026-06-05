<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function submit(Request $request)
    {
        DB::table('message')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'subjek' => 'Pesan Website',
            'pesan' => $request->pesan,
            'status' => 'belum_dibaca',
            'dibaca_pada' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}