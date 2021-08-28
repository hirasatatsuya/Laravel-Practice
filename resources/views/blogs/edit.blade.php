@extends('layouts.helloapp')

@section('content')
    <form action="/blogs/edit" method="POST">
        <table>
            @csrf
            <input type="hidden"name="id"value="{{$data->id}}">
            <tr><th>title:</th><td><input type="text"name="title" value="{{$data->title}}"></td></tr>
            <tr><th>content:</th><td><input type="text"name="content" value="{{$data->content}}"></td></tr>
            <tr><th></th><td><input type="submit" value="send"></td></tr>
        </table>
    </form>

@endsection
