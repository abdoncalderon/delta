<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class PeriodController extends Controller
{
    public function home(){
        return Inertia::render('Dashboard');
    }
}
