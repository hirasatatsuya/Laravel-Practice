@extends('layouts.helloapp')
<style>
  .pagination{font-size:10pt;}
  .pagination li{display:inline-block}
  tr th a:link{color:white;}
  tr th a:visited{color:white;}
  tr th a:hover{color:white;}
  tr th a:active{color:white;}
</style>

@section('content')
<h3>Blog index</h3>
  <table>
  <tr>
  <th><a href="/hello?sort=name">id</a></th>
  <th><a href="/hello?sort=mail">title</a></th>
  <th><a href="/hello?sort=age">content</a></th>
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
