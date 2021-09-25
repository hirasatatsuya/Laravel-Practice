@extends('layouts.helloapp')

@section('content')
    <h1>データ内容表示</h1>
    <table>
        <tr><th>id</th><td>{{ $data->id }}</td></tr>
        <tr><th>title</th><td>{{ $data->title }}</td></tr>
        <tr><th>content</th><td>{{ $data->content }}</td></tr>
        <tr><th>active</th><td>{{ $message }}</td></tr>
        <tr><th>picture</th>
            <td>
                <img src={{ asset($data->picture) }} width="300px">
            </td>
        </tr>
    </table>

@endsection
