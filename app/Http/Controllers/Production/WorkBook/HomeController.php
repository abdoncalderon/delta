<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home() {
        return Inertia::render('Production/WorkBook/Index');
    }
}
