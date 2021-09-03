@extends('layouts.helloapp')

@section('content')
    <h1>追加フォーム</h1>
    <form action="/blogs/create" method="post">
        <table>
            @csrf
            <tr><th>title: </th><td><input type="text" name="title"></td></tr>
            <tr><th>content: </th><td><input type="text" name="content"></td></tr>
            <tr><th></th><td><input type="submit" value="送信"></td></tr>
        </table>
    </form>
@endsection

