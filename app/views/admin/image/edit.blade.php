@extends('admin/index')
@section('title')
Edit Image
@endsection
@section('content')
    <h1>Edit image {{ $image->name }}</h1>
    {{ Form::open(array('url'=>'admin/image/update/'.$image->id)) }}
        {{ Form::token() }}

        <!-- name field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', $image->title) }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
