@extends('layouts.helloapp')

@section('content')
    <form action="/blogs" method="post">
        @csrf
        <input type="text" name="keyword" value="">
        <input type="submit" value="send">
    </form>
    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
        </tr>
        @foreach($blogs as $blog)
            <tr>
                <td>{{$blog->id}}</td>
                <td>{{$blog->title}}</td>
                <td>{{$blog->content}}</td>
                <td><a href="{{ route('blogs.show', Crypt::encrypt($blog->{'id'})) }}" class="btn btn-success">
                        <span>閲覧</span>
                    </a>
                </td>
                <td><a href="{{ route('blogs.edit' , Crypt::encrypt($blog->{'id'})) }}" class="btn btn-success">
                        <span>編集</span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
