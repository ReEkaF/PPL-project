<?php

namespace App\Http\Controllers\pembinaekstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembinaekstraController extends Controller
{
    public function index()
    {
        // Logic for the dashboard, e.g., fetching data or statistics for the dashboard view
        return view('pembina_ekstra.dashboard'); // Adjust view path as needed
    }
}
