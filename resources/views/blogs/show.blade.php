@extends('layouts.helloapp')

@section('content')
    <h1>データ内容表示</h1>
    <table>
        <tr><th>id</th><td>{{ $data->id }}</td></tr>
        <tr><th>title</th><td>{{ $data->title }}</td></tr>
        <tr><th>content</th><td>{{ $data->content }}</td></tr>
    </table>

@endsection
