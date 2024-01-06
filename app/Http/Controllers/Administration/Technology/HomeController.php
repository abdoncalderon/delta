<?php

namespace App\Http\Controllers\Administration\Technology;


use App\Http\Controllers\Controller;
use Inertia\Inertia;


class HomeController extends Controller
{
    public function home() {
        return Inertia::render('Administration/Technology/Home');
    }
}
