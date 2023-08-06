<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.email as email','people.fullName as fullname')
                ->join('people','users.person_id','=','people.id')
                ->paginate();
        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }
}

