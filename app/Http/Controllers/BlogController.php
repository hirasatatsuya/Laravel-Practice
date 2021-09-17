<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);

        $this->middleware(function ($request, $next) {
            // 認証情報を取得

            $this->user = Auth::user();

            View::share('user', $this->user);

            return $next($request);
        });
    }

    public function other_users_deny($data)
    {
        if( $this->user->id !== $data->user_id ){
            abort(404);
        }
    }

    public function index()
    {
        $blogs = Blog::with('blogaccesses')->first();

        $blogs_active = Blog::Active($blogs)->simplePaginate(20, ['*'], 'active');
        $blogs_inactive = Blog::Inactive($blogs)->where('user_id', optional($this->user)->id)->simplePaginate(20, ['*'], 'inactive');

        return view('blogs.index', [
            'blogs_active' => $blogs_active,
            'blogs_inactive' => $blogs_inactive,
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $blogs = new Blog($request->all());
        if( $request['picture'] ){
            $file_path = request()->file('picture')->getClientOriginalName();
            $this->store_image($file_path, $blogs);
        }

        $this->validation($request);
        $blogs->save();
        return redirect('/blogs');
    }

    public function store_image($request, $blogs)
    {
        $blogs->picture = $blogs->picture->storeAs('public/image', $request);
        Storage::disk('local')->put($blogs->picture, 'picture');
    }

    public function show(Request $request, $id)
    {
        $data = $this->filter($id);
//        $data = blog::where('id', $new_id)->first();
        $data->blogaccesses()->create([]);
        return view('blogs.show', ['data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        $data = $this->filter($id);
        $this->other_users_deny($data);
        return view('blogs.edit', ['data' => $data]);
    }

    public function filter($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
            logger();
        } catch(\Exception $e) {
            abort(404);
        }
//        $new_id = substr($decrypted, 2, -1);
        $data = Blog::find($decrypted);
        if( !$data ) {
            abort(404);
        }
        return $data;
    }

    public function update(Request $request)
    {
        $param = [
            'id' => $request['id'],
            'title' => $request['title'],
            'content' => $request['content'],
        ];
        $this->validation($request);
        $data = blog::where('id', $request->id)->update($param);
        if( $request['picture'] ){
            $file_path = request()->file('picture')->getClientOriginalName();
            $this->store_image($file_path, $data);
        }
        $this->other_users_deny($data);
        return redirect('/blogs');
    }

    public function destroy(Request $request, $id)
    {
        $data = $this->filter($id);
        $this->other_users_deny($data);
        $data->delete();
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


    //２ページ目に行くとblogaccesses() on nullの表示
    //Lv4-03-08
    public function search(Request $request)
    {
        $s_word = $request['keyword'];

        $blogs = Blog::with('blogaccesses');
        $active_blogs = Blog::Active($blogs)
            ->where('title', 'like', "%$s_word%")
            ->Where('content', 'like', "%$s_word%")
            ->simplePaginate(20, ['*'], 'active');
        $inactive_blogs = Blog::InActive($blogs)
            ->where('user_id', optional($this->user)->id)
            ->where('title', 'like', "%$s_word%")
            ->Where('content', 'like', "%$s_word%")
            ->simplePaginate(10, ['*'], 'inactive');
        return view('blogs.index',
            ['blogs_active' => $active_blogs],
            ['blogs_inactive' => $inactive_blogs],
        );
    }
}
