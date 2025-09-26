<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('name','email','created_at')
            ->orderByDesc('created_at')
            ->get();

        return view('users.index', compact('users'));
    }
}
