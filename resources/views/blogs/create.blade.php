@extends('layouts.helloapp')

@section('content')
    <h1>追加フォーム</h1>
    <form action="{{ route('blogs.store') }}" method="post">
        <table>
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->{'id'} }}">
            <tr><th>title: </th><td><input type="text" name="title"></td></tr>
            <tr><th>content: </th><td><input type="text" name="content"></td></tr>
            <tr><th></th><td><input type="submit" value="送信"></td></tr>
        </table>
    </form>
@endsection

