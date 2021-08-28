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
        return view('blogs.index', ['blogs' => $blogs]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $blogs = new Blog($request->all());
        $this->validation($request);
        $blogs->save();
        return redirect('/blogs');
    }

    public function show(Request $request){
        $data=DB::table('blogs')->where('id', $request->id)->first();
        return view('blogs.show', compact('data'));
    }

    public function edit(Request $request){
        $data=DB::table('blogs')->where('id', $request->id)->first();
        return view('blogs.edit', ['data' => $data]);
    }

    public function update(Request $request){
        $param=[
            'id' => $request['id'],
            'title' => $request['title'],
            'content' => $request['content'],
        ];
        $this->validation($request);
        DB::table('blogs')->where('id',$request->id)->update($param);
        return redirect('/blogs');
    }

    public function destroy(Request $request){
        DB::table('blogs')->where('id',$request->id)->delete();
        return redirect('/blogs');
    }

    public function validation(Request $request){
        $validate_rule = [
            'title' => 'required|string|max:255',
            'content' => 'max:2000',
        ];
        $this->validate($request, $validate_rule);
    }
}
