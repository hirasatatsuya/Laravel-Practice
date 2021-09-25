@extends('layouts.helloapp')

@section('content')
    <h1>データ内容表示</h1>
    <table>
        <tr><th>id</th><td>{{ $data->id }}</td></tr>
        <tr><th>title</th><td>{{ $data->title }}</td></tr>
        <tr><th>content</th><td>{{ $data->content }}</td></tr>
        <tr><th>active</th><td>{{ $message }}</td></tr>
        <tr><th>picture</th>
            @if( !$data->picture )
                <td>画像なし</td>
            @endif
            @if($data->picture)
                <td>
                    <img src={{ asset($data->picture) }} width="300px">
                </td>
            @endif
        </tr>
    </table>

@endsection
