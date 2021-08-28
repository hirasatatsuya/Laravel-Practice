<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        return view('blogs.index');
    }
    public function create()
    {
        $blogs = DB::select('SELECT * FROM blogs');
        return view('blogs.create', ['blogs' => $blogs]);
    }

    public function store(Request $request)
    {
        $blogs = new Blog($request->all());
        $blogs->save();
        return redirect('blogs/index');
    }

    public function show(Request $request){
        $id = $request->id;
        $select = DB::select('SELECT * FROM blogs');
        $data = $select->find($id);
        return view('blogs.show', $data);
    }
}
