@extends('layouts.helloapp')


<style>
    tr th a:link{color:white;}
    tr th a:visited{color:white;}
    tr th a:hover{color:white;}
    tr th a:active{color:white;}
</style>

@section('content')
    <h1>入力フォーム</h1>
    <form action="/blogs/show" method="post">
        <table>
            @csrf
            <tr><th>title: </th><td><input type="text" name="title"></td></tr>
            <tr><th>content: </th><td><input type="text" name="content"></td></tr>
            <tr><th></th><td><input type="submit" value="送信"></td></tr>
        </table>
    </form>
@endsection
