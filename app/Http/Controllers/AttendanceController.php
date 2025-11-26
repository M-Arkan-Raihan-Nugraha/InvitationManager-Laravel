<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // 📋 Daftar semua attendance
    public function index()
{
    // Ambil semua undangan beserta tamu yang hadir
    $data = Invitation::with(['guests'])->get();

    return view('attendance.index', compact('data'));
}


    // ➕ Form tambah attendance
    public function create()
    {
        $invitations = Invitation::all();
        $guests = Guest::all();
        return view('attendance.form', compact('invitations', 'guests'));
    }

    // 💾 Simpan attendance baru
    public function store(Request $request)
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'guest_id' => 'required|exists:guests,id',
            'status' => 'required|in:pending,present,not_present',
            'response_time' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            Attendance::create($request->all());
            DB::commit();
            return redirect()->route('attendance.index')->with('success', 'Attendance berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ✏️ Form edit attendance
    public function edit(Attendance $attendance)
    {
        $invitations = Invitation::all();
        $guests = Guest::all();
        return view('attendance.form_edit', compact('attendance', 'invitations', 'guests'));
    }

    // 🔄 Update attendance
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'guest_id' => 'required|exists:guests,id',
            'status' => 'required|in:pending,present,not_present',
            'response_time' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $attendance->update($request->all());
            DB::commit();
            return redirect()->route('attendance.index')->with('success', 'Attendance berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ❌ Hapus attendance
    public function destroy(Attendance $attendance)
    {
        try {
            $attendance->delete();
            return redirect()->route('attendance.index')->with('success', 'Attendance berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('attendance.index')->with('error', $e->getMessage());
        }
    }
}
