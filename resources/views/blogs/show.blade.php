@extends('layouts.helloapp')

@section('content')
    <h1>データ内容表示</h1>
    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
        </tr>
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->title }}</td>
            <td>{{ $data->content }}</td>
        </tr>
    </table>

@endsection
