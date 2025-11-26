<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    // 📋 Daftar semua lokasi
    public function index()
    {
        $data = Location::all();
        return view('location.index', compact('data'));
    }

    // ➕ Form tambah lokasi
    public function create()
    {
        return view('location.form');
    }

    // 💾 Simpan lokasi baru
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Location::create($request->all());
            DB::commit();
            return redirect('location')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('location')->with('error', $e->getMessage());
        }
    }

    // ✏️ Form edit lokasi
    public function edit(Location $location)
    {
        return view('location.form_edit', compact('location'));
    }

    // 🔄 Update data lokasi
    public function update(Request $request, Location $location)
    {
        DB::beginTransaction();
        try {
            $location->update($request->all());
            DB::commit();
            return redirect('location')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('location')->with('error', $e->getMessage());
        }
    }

    // ❌ Hapus lokasi
    public function destroy(Location $location)
    {
        try {
            $location->delete();
            return redirect('location')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('location')->with('error', $e->getMessage());
        }
    }
}