<?php

namespace App\Http\Controllers;

use App\Mail\resetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class homeController extends Controller
{
    public function Home()
    {
        return view('home');
    }
}
