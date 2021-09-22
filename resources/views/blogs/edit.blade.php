@extends('layouts.helloapp')

@section('content')
    <h1>編集フォーム</h1>
    <form action="{{ route('blogs.update', Crypt::encrypt($data->{'id'})) }}" method="POST" enctype="multipart/form-data">
        <table>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $data->id }}">
            <tr><th>id:</th><td>{{ $data->id }}</td></tr>
            <tr><th>title:</th><td><input type="text" name="title" value="{{ $data->title }}" placeholder="ブログタイトル" required=""></td></tr>
            <tr><th>content:</th><td><input type="text" name="content" value="{{ $data->content }}"></td></tr>

{{--            ToDo 写真変更--}}

            <tr><th></th><td><input type="submit" value="編集"></td></tr>
        </table>
    </form>
@endsection
