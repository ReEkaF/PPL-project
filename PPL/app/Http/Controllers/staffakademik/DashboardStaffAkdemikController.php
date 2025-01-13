<?php

namespace App\Http\Controllers\staffakademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardStaffAkdemikController extends Controller
{
    public function index() {
        return view('staff_akademik.dashboard');
    }
}