@extends('layouts.app')


@section('content')
    <div class="content">
        <h1>データ一覧</h1>
        <a href="{{ route('blogs.create') }}" style="font-size: 30px;"><span>新規作成</span></a>

        <table>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>content</th>
                <th>閲覧数</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            @foreach($blogs_active as $blog)
                <tr>
                    <td>{{$blog->id}}</td>
                    <td>{{$blog->title}}</td>
                    <td>{{$blog->content}}</td>
                    <td>{{ $blog->user['name'] }}</td>
                    <td>{{ $blog->blogaccesses->count() }}</td>
                    <td><a href="{{ route('blogs.show', Crypt::encrypt($blog->{'id'})) }}" class="btn btn-success">
                            <span>閲覧</span>
                        </a>
                    </td>
                    @if($user && $blog->user_id == $user->id)
                        <td><a href=" {{ route('blogs.edit', Crypt::encrypt($blog['id'])) }} " class="btn btn-primary">
                            <span>編集</span></a></td>
                        <td>
                            <form action="{{ route('blogs.destroy', Crypt::encrypt($blog['id'])) }}"
                            id="form_{{ $blog->id }}" method="post">
                                @csrf
                                {{ method_field('delete') }}
                                <a href="#" data-id="{{ $blog->id }}" onclick="deletePost(this);" class="btn btn-danger">
                                <span>削除</span></a>
                            </form>
                        </td>
                    @else
                        <td></td>
                        <td></td>
                    @endif


                </tr>
            @endforeach
        </table>

        @if($user)
            <h3 style="margin-top: 30px;">非公開ブログ</h3>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>タイトル</th>
                        <th>内容</th>
                        <th>ユーザー</th>
                        <th>閲覧数</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @foreach($blogs_inactive as $blog)
                    <tr>
                        <td>{{ $blog['id'] }}</td>
                        <td>{{ $blog['title'] }}</td>
                        <td>{!! mb_substr(nl2br(e($blog['content'])), 0, 200) !!}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $blog->blogaccesses->count() }}</td>
                        <td><a href="{{ route('blogs.show', Crypt::encrypt($blog['id'])) }}" class="btn btn-success">
                                <span>閲覧</span></a></td>
                        <td><a href="{{ route('blogs.edit', Crypt::encrypt($blog['id'])) }}" class="btn btn-primary">
                                <span>編集</span></a></td>
                        <td>
                            <form action="{{ route('blogs.destroy', Crypt::encrypt($blog['id'])) }}"
                                  id="form_{{ $blog->id }}"
                                  method="post">
                                @csrf
                                {{ method_field('delete') }}
                                <a href="#" data-id="{{ $blog->id }}" onclick="deletePost(this);" class="btn btn-danger">
                                    <span>削除</span></a></form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
