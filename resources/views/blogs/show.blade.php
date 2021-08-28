@extends('layouts.helloapp')

@section('content')
    <h1>入力フォーム</h1>
    <form action="/blogs/show" method="post">
        <table>
            @csrf
            <tr><th>表示するid: </th><td><input type="text" name="id"></td></tr>
            <tr><th></th><td><input type="submit" value="送信"></td></tr>
        </table>
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
        </tr>
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->title}}</td>
            <td>{{$data->content}}</td>
        </tr>
    </table>
@endsection
