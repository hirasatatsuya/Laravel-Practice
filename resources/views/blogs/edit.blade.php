@extends('layouts.helloapp')

@section('content')
    <h1>編集フォーム</h1>
    <form action="{{ route('blogs.update', Crypt::encrypt($data->{'id'})) }}" method="POST" enctype="multipart/form-data">
        <table>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $data->id }}">
            <tr><th>id:</th><td>{{ $data->id }}</td></tr>
            <tr><th>title:</th><td>
                    @if ($errors->has('title'))
                        {{ $errors->first('title') }}
                        <br>
                    @endif
                    <input type="text" name="title" value="{{ old('title', $data->title) }}" placeholder="ブログタイトル" required="">
                </td>
            </tr>
            <tr>
                <th>
                    content:
                </th>
                <td>
                    @if ($errors->has('content'))
                        {{ $errors->first('content') }}
                        <br>
                    @endif
                     <textarea name="content"
                        placeholder="ブログ内容"
                        required="">{{ old('content', isset($data) ? $data['content'] : '')}}</textarea>
                </td>
            </tr>

{{--            ToDo 公開非公開　変更--}}
            <tr>
                <th>active:</th>
                @if( $data->active == 1)
                    <td><input type="radio" name="active" value="1" checked="checked">公開
                        <input type="radio" name="active" value="0">非公開</td>
                @endif
                @if( $data->active == 0)
                    <td><input type="radio" name="active" value="1">公開
                        <input type="radio" name="active" value="0" checked="checked">非公開</td>
                @endif
            </tr>

{{--            ToDo 写真変更--}}
            <tr>
                <th>picture:</th>
                <td><img src={{ asset($data->picture) }} width="200px"><br>
                    <input type="file" name="picture" style="margin:20px 0px 10px"></td>
            </tr>

            <tr><th></th><td><input type="submit" value="編集"></td></tr>
        </table>
    </form>
@endsection
