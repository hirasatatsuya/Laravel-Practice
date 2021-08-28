<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class BlogController extends Controller
{
    public function index()
    {
        $blogs = DB::table('blogs')->get();
        return view('blogs.index', $blogs);
    }

    public function create()
    {
        $blogs = DB::table('blogs')->get();
        return view('blogs.create', compact('blogs'));
    }

    public function store(Request $request)
    {
        $blogs = new Blog($request->all());
        $blogs->save();
        return redirect('blogs/create');
    }

    public function show(Request $request){
        $data=DB::table('blogs')->where('id', $request->id)->first();
        return view('blogs.show', compact('data'));
    }
}
