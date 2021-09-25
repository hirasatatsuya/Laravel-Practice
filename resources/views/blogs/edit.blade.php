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
                <th></th>
                <td></td>
            </tr>

{{--            ToDo 写真変更--}}
            <tr>
                <th></th>
                <td></td>
            </tr>

            <tr><th></th><td><input type="submit" value="編集"></td></tr>
        </table>
    </form>
@endsection
