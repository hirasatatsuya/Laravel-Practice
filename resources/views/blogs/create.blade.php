@extends('layouts.helloapp')

@section('content')
    <h1>追加フォーム</h1>
    <form action="{{ route('blogs.store') }}" method="post" enctype='multipart/form-data'>
        <table>
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->{'id'} }}">
            <tr><th>title: </th><td><input type="text" name="title" value="{{ old('title') }}" placeholder="ブログタイトル" required=""></td></tr>
            <tr><th>content: </th><td><input type="text" name="content" placeholder="内容"></td></tr>
            <tr><th>picture: </th><td><input type="file" name="picture"></td></tr>
            <tr><th></th><td><input type="checkbox" name="active" value="1"> 公開</td></tr>
            <tr><th></th><td><input type="checkbox" name="active" value="0"> 非公開</td></tr>
            <tr><th></th><td><input type="submit" value="送信"></td></tr>
        </table>
    </form>
@endsection

