<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangControllerFE extends Controller
{
    public function index()
    {
        $barang = Barang::all();


        return view('pages.barang.index',compact('barang'));
    }
}
