<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 🔹 Ambil input filter
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $locationId = $request->input('location_id');

        // 🔹 Query dasar undangan
        $query = Invitation::with(['category', 'location', 'guests']);

        // Filter tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        // Filter kategori
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter lokasi
        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        // 🔹 Dapatkan hasil + pagination
        $invitations = $query->paginate(10);

        // 🔹 Data tambahan untuk filter
        $categories = Category::all();
        $locations = Location::all();

        // 🔹 Ringkasan angka
        $totalInvitations = Invitation::count();
        $totalGuests = \App\Models\Guest::count();
        $present = \App\Models\Attendance::where('status', 'present')->count();
        $notPresent = \App\Models\Attendance::where('status', 'not_present')->count();

        // 🔹 Info tampilan filter aktif
        $selectedCategory = $categoryId ? Category::find($categoryId)->name ?? 'Semua' : 'Semua';
        $selectedLocation = $locationId ? Location::find($locationId)->name ?? 'Semua' : 'Semua';

        // 🔹 Kirim ke view
        return view('report.index', compact(
            'invitations',
            'categories',
            'locations',
            'startDate',
            'endDate',
            'selectedCategory',
            'selectedLocation',
            'totalInvitations',
            'totalGuests',
            'present',
            'notPresent'
        ));
    }
}
