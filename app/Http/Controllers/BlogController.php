<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class BlogController extends Controller
{
    public function index()
    {
//        $blogs = DB::select('SELECT * FROM blogs');

        $blogs = Blog::with('blogaccesses')->get();
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

    public function show(Request $request, $id)
    {
        $new_id = $this->filter($id);
        $data = blog::where('id', $new_id)->first();
        $data->blogaccesses()->create([]);
        return view('blogs.show', ['data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        $new_id = $this->filter($id);
        $data = blog::where('id', $new_id)->first();
        return view('blogs.edit', ['data' => $data]);
    }

    public function filter($id)
    {
        try {
            $decrypted = Crypt::decryptString($id);
            return substr($decrypted, 2, -1);
        } catch(\Exception $e) {
            return view('errors.404');
        }
    }

    public function update(Request $request)
    {
        $param = [
            'id' => $request['id'],
            'title' => $request['title'],
            'content' => $request['content'],
        ];
        $this->validation($request);
        blog::where('id', $request->id)->update($param);
        return redirect('/blogs');
    }

    public function destroy(Request $request)
    {
        blog::where('id', $request->id)->delete();
        return redirect('/blogs');
    }

    public function validation(Request $request)
    {
        $validate_rule = [
            'title' => 'required|string|max:255',
            'content' => 'max:2000',
        ];
        $this->validate($request, $validate_rule);
    }

    public function search(Request $request)
    {
        $s_word = $request['keyword'];
        echo $s_word;
        $blogs = DB::table('blogs')
            ->where('title', 'like', "%$s_word%")
            ->orWhere('content', 'like', "%$s_word%")
            ->get();
        return view('blogs.index', ['blogs' => $blogs]);
    }
}
