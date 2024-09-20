<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminControllerFE extends Controller
{
    public function index(){
        return view("home.dashboard");
    }
    
}
