<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'jumlah_undangan' => Invitation::count(),
            'jumlah_tamu'    => Guest::count(),
            'jumlah_kehadiran'   => Attendance::count(),
        ];

        return view('home', $data);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
