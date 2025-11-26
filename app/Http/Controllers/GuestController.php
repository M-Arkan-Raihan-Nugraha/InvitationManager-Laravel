<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    // 🧾 Daftar semua tamu
    public function index()
    {
        $data = Guest::all();
        return view('guest.index', compact('data'));
    }

    // ➕ Form tambah tamu
    public function create()
    {
        return view('guest.form');
    }

    // 💾 Simpan tamu baru
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Guest::create($request->all());
            DB::commit();
            return redirect('guest')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('guest')->with('error', $e->getMessage());
        }
    }

    // ✏️ Form edit tamu
    public function edit(Guest $guest)
    {
        return view('guest.form_edit', compact('guest'));
    }

    // 🔄 Update data tamu
    public function update(Request $request, Guest $guest)
    {
        DB::beginTransaction();
        try {
            $guest->update($request->all());
            DB::commit();
            return redirect('guest')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('guest')->with('error', $e->getMessage());
        }
    }

    // ❌ Hapus tamu
    public function destroy(Guest $guest)
    {
        try {
            $guest->delete();
            return redirect('guest')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('guest')->with('error', $e->getMessage());
        }
    }
}