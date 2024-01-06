<?php

namespace App\Http\Controllers\Commercial\Purchases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home() {
        return Inertia::render('Commercial/Purchases/Home');
    }
}
