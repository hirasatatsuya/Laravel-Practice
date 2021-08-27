@extends('layouts.helloapp')

@section('content')
    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>content</th>
        </tr>
        @foreach($blogs as $blog)
            <tr>
                <td>{{$blog->id}}</td>
                <td>{{$blog->title}}</td>
                <td>{{$blog->content}}</td>
            </tr>
        @endforeach
    </table>
@endsection
