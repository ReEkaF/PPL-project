<?php

namespace App\Http\Controllers\pembinaekstra;

use App\Http\Controllers\Controller;

class PembinaekstraController extends Controller
{
    public function index()
    {
        return redirect()->route('guru.dashboard');
    }
}
