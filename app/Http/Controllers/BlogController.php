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
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

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
//        logger('other');
//        logger($data);
//        logger('other');
        if( $this->user->id !== $data->user_id ){
            abort(404);
        }
    }

    public function index(Request $request)
    {
        $keyword = $request['keyword'];

        $blogs = Blog::with('blog_accesses')->first();
        $active_blogs = $blogs->active($blogs)
            ->where('title', 'like', "%$keyword%")
            ->where('content', 'like', "%$keyword%")
            ->simplePaginate(20, ['*'], 'active');
        $inactive_blogs = $blogs->inactive($blogs)
            ->where('user_id', optional($this->user)->id)
            ->where('title', 'like', "%$keyword%")
            ->where('content', 'like', "%$keyword%")
            ->simplePaginate(20, ['*'], 'inactive');

//        $blogs_active = $blogs->active()->paginate(20);
//        $blogs_inactive = $blogs->inactive()->where('user_id', optional($this->user)->id)->paginate(20);

        return view('blogs.index', [
            'blogs_active' => $active_blogs,
            'blogs_inactive' => $inactive_blogs,
            'keyword' => $keyword
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $blog = new Blog($request->all());
        if( $request['picture'] ){
            $file_path = request()->file('picture')->getClientOriginalName();
            $this->store_image($file_path, $blog);
        }

        $this->validation($request);
        $blog->save();
        return redirect('/blogs');
    }

    public function store_image($request, $blog)
    {
        $blog->picture = $blog->picture->storeAs('public/image', $request);
        Storage::disk('local')->put($blog->picture, 'picture');
    }

    public function show($id)
    {
        logger($id);
        $data = $this->filter($id);
//        $data = Blog::find($new_id);
        $data->blog_accesses()->create([]);
        return view('blogs.show', ['data' => $data]);
    }

    public function edit($value)
    {
//        logger('edit');
//        logger($value);
//        logger('edit');
        $data = $this->filter($value);
//        $data = Blog::find($new_id);
        $this->other_users_deny($data);
        return view('blogs.edit', ['data' => $data]);
    }

    public function filter($id)
    {
        try {
//            logger(1111);
//            logger($id);
//            logger(2222);
            $decrypted = Crypt::decrypt($id);
//            logger(1111);
//            logger($decrypted);
        } catch(\Exception $e) {
//            logger(2222);
            abort(404);
        }
        //編集で記述した
//        $new_id = substr($decrypted, 2, -1);
        $data = Blog::find($decrypted);
        if( !$data ) {
            abort(404);
        }
//        logger($data);
        return $data;
    }

    public function update(Request $request, $id)
    {
//        logger($id);
//        logger($request);

        $data = $this->filter($id);
        $this->other_users_deny($data);
//        logger('update');
//        logger($data);
//        logger('update');

//        $param = [
//            'title' => $request->title,
//            'content' => $request->content,
//        ];
//        logger($param);

        $this->validation($request);


//        logger('update');
//        logger($data);
//        logger('update');

        $data->fill($request->all())->save();
        if( $request['picture'] ){
            $file_path = request()->file('picture')->getClientOriginalName();
            $this->store_image($file_path, $data);
        }
        return redirect('/blogs');
    }

    public function destroy(Request $request, $id)
    {
        $data = $this->filter($id);
        $this->other_users_deny($data);
        $data->delete();
        return redirect('/blogs');
    }

    public function validation($request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'content' => 'max:2000',
        ])->validate();
//        if ($validate->fails()) {
//            return redirect('/blogs/edit')
//                ->withErrors($validate)
//                ->withInput();
//        }
    }


    //２ページ目に行くとblog_accesses() on nullの表示
    //Lv4-03-08
    public function search(Request $request)
    {
        $keyword = $request['keyword'];

        $blogs = Blog::with('blog_accesses');
        $active_blogs = Blog::Active($blogs)
            ->where('title', 'like', "%$keyword%")
            ->Where('content', 'like', "%$keyword%")
            ->simplePaginate(20, ['*'], 'active');
        $inactive_blogs = Blog::InActive($blogs)
            ->where('user_id', optional($this->user)->id)
            ->where('title', 'like', "%$keyword%")
            ->Where('content', 'like', "%$keyword%")
            ->simplePaginate(10, ['*'], 'inactive');
        return view('blogs.index',
            ['blogs_active' => $active_blogs],
            ['blogs_inactive' => $inactive_blogs],
        );
    }
}
