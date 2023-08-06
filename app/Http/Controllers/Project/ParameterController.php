<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParameterController extends Controller
{
    public function index()
    {
        return Inertia::render('Project/Parameters/Index');
    }
}
