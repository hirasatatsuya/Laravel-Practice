<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateCotroller extends Controller
{
    public function create(){
        return view('create.index');
    }
}
