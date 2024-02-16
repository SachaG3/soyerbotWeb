<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class errorController extends Controller
{
    public function error()
    {
        return view('errors.general');
    }
}
