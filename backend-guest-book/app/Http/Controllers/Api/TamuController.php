<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tamu; // Pastikan model Tamu sudah dibuat
use Illuminate\Http\Request;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan semua data tamu
        $tamus = Tamu::all();
        return response()->json([
            'success' => true,
            'message' => 'Data tamu berhasil diambil',
            'data' => $tamus
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'ktp' => 'required|string|max:20|unique:tamus', // pastikan ktp unik
            'email' => 'required|email|unique:tamus'
        ]);

        // Menyimpan data tamu baru
        $tamu = Tamu::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'ktp' => $request->ktp,
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data tamu berhasil disimpan',
            'data' => $tamu
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan data tamu berdasarkan ID
        $tamu = Tamu::find($id);

        if (!$tamu) {
            return response()->json([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tamu ditemukan',
            'data' => $tamu
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'ktp' => 'required|string|max:20|unique:tamus,ktp,' . $id,
            'email' => 'required|email|unique:tamus,email,' . $id
        ]);

        // Menemukan tamu berdasarkan ID
        $tamu = Tamu::find($id);

        if (!$tamu) {
            return response()->json([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }

        // Memperbarui data tamu
        $tamu->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'ktp' => $request->ktp,
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data tamu berhasil diperbarui',
            'data' => $tamu
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menemukan tamu berdasarkan ID
        $tamu = Tamu::find($id);

        if (!$tamu) {
            return response()->json([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }

        // Menghapus data tamu
        $tamu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data tamu berhasil dihapus',
        ], 200);
    }
}
