@extends('layouts.helloapp')

@section('content')
{{--    <form action="blogs/search" method="post">--}}
{{--        @csrf--}}
{{--        <input type="text" name="keyword" value="">--}}
{{--        <button>--}}
{{--            <a href="{{ route('blogs.index') }}" class="btn btn-success">--}}
{{--                <span>送信</span></a>--}}
{{--        </button>--}}
{{--    </form>--}}


    <h1>データ一覧</h1>
    <a href="blogs/create"><span>[新規作成]</span></a>
    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
            <th>閲覧数</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @foreach($blogs as $blog)
            <tr>
                <td>{{$blog->id}}</td>
                <td>{{$blog->title}}</td>
                <td>{{$blog->content}}</td>
                <td>{{ $blog->blogaccesses->count() }}</td>
                <td><a href="{{ route('blogs.show', Crypt::encrypt($blog->{'id'})) }}" class="btn btn-success">
                        <span>閲覧</span>
                    </a>
                </td>
                <td><a href="{{ route('blogs.edit' , Crypt::encrypt($blog->{'id'})) }}" class="btn btn-success">
                        <span>編集</span>
                    </a>
                </td>
{{--                destroy未完成--}}
                <td><a href="{{ 'blogs.destroy' , Crypt::encrypt($blog->{'id'}) }}" class="btn btn-success">
                        <span>削除</span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
