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
        if( $this->user->id !== $data->user_id ){
            abort(404);
        }
    }

    public function index(Request $request)
    {
        $keyword = $request['keyword'];

        $active_query = Blog::query()->with(['blog_accesses', 'user']);
        $inactive_query = Blog::query()->with(['blog_accesses', 'user']);


        if ( $keyword ){
            $active_blogs = $active_query
                ->active()
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%". $keyword. "%")
                        ->orwhere('content', 'like', "%". $keyword. "%");
                })
                ->Paginate(20);
            $inactive_blogs = $inactive_query
                ->inactive()
                ->where('user_id', optional($this->user)->id)
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%". $keyword. "%")
                        ->orwhere('content', 'like', "%". $keyword. "%");
                })
                ->Paginate(20);
            logger(optional($this->user)->id);
            foreach ($inactive_blogs as $data){
                logger($data->title);
            }
        } else {
            $active_blogs = $active_query
                ->active()
                ->Paginate(20);
            $inactive_blogs = $inactive_query
                ->where('user_id', optional($this->user)->id)
                ->inactive()
                ->Paginate(20);
        }

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
        $temp_path = request()->file('picture')->storeAs('public/image', $request);
        $blog->picture = str_replace('public/', 'storage/', $temp_path);
//        Storage::disk('local')->put($blog->picture, 'picture');
    }

    public function show($id)
    {
        $data = $this->filter($id);
//        $data = Blog::find($new_id);
        $data->blog_accesses()->create([]);
        if( $data->active == 1){
            $message = "公開";
        }
        if( $data->active == 0){
            $message = "非公開";
        }
        return view('blogs.show', [
            'data' => $data,
            'message' => $message,
        ]);
    }

    public function edit($value)
    {
        $data = $this->filter($value);
//        $data = Blog::find($new_id);
        $this->other_users_deny($data);
        return view('blogs.edit', ['data' => $data]);
    }

    public function filter($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
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

        $data = $this->filter($id);
        $this->other_users_deny($data);

        $this->validation($request);

        if( $request['picture'] ){
            $file_path = request()->file('picture')->getClientOriginalName();
            $this->store_image($file_path, $data);
        }
        $data->fill($request->all())->save();
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
        $rules = [
            'title' => 'required|string|max:250',
            'content' => 'max:2000',
        ];
        $messages = [
            'title.required' => 'タイトルは必ず入力してください．',
            'title.string' => '文字列で入力してください',
            'title.max' => '250文字以内で入力してください',
            'content.max' => '2000文字以内で入力してください'
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
    }


    //２ページ目に行くとblog_accesses() on nullの表示
    //Lv4-03-08
//    public function search(Request $request)
//    {
//        $keyword = $request->keyword;
//
//        logger(111111);
//        logger($keyword);
//        logger(111111);
//        $blogs = Blog::with('blog_accesses');
//        $active_blogs = Blog::Active($blogs)
//            ->where('title', 'like', "%$keyword%")
//            ->where('content', 'like', "%$keyword%");
//        $inactive_blogs = Blog::InActive($blogs)
//            ->where('user_id', optional($this->user)->id);
////            ->where('title', 'like', "%$keyword%")
////            ->where('content', 'like', "%$keyword%");
//        return view('blogs.index',
//            ['blogs_active' => $active_blogs],
//            ['blogs_inactive' => $inactive_blogs],
//        );
//    }
}
