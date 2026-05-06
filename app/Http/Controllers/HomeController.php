<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'ho' => redirect()->route('dashboard.ho'),
            'lead' => redirect()->route('dashboard.lead'),
            'officer' => redirect()->route('dashboard.officer'),
            default => redirect()->route('login'),
        };
    }
}