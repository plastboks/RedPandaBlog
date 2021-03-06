@extends('admin/index')
@section('title')
Edit post {{ $post->title }}
@endsection
@section('content')
    <h1>Edit post - {{ $post->title }}</h1>
    {{ Form::open(array('url'=>'admin/post/update/'.$post->id)) }}
        {{ Form::token() }}
        {{ Form::hidden('author_id', $user->id) }}
        <!-- title field -->
        <p>{{ Form::label('title', 'Title') }}</p>
        {{ $errors->first('title', '<p class="error">:message</p>') }}
        <p>{{ Form::text('title', $post->title) }}</p>
        <!-- excerpt field -->
        <p>{{ Form::label('excerpt', 'Excerpt') }}</p>
        {{ $errors->first('excerpt', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('excerpt', $post->excerpt) }}</p>
        <!-- body field -->
        <p>{{ Form::label('body', 'Body') }}</p>
        {{ $errors->first('body', '<p class="error">:message</p>') }}
        <p>{{ Form::textarea('body', $post->body) }}</p>
        <!-- published field -->
        @if ($p->canI('publishPost'))
        <p>
            {{ Form::label('published', "Published") }}
            {{ $errors->first('published', '<p class="error">:message</p>')}}
            {{ Form::checkbox('published', 1, $post->published) }}
        </p>
        @endif
        <p>
            <span>Categories:</span>
            <ul class="categorylist">
            @foreach ($categories as $category)
                <li>
                    <label>{{ Form::label('category', $category->title) }}</label>
                    {{ Form::checkbox('category[]',$category->id,$post->categories()->where('title', '=', $category->title)->first())}}
                </li>
            @endforeach
            </ul>
        </p>
        <p>
            <div id="jqEditPostImageList" class="jqCommonImageList" data-id="{{ $post->id }} "></div>
            <p><input type="button" class="jqEditGetImages" data-id="{{$post->id}}" value="Add image"/></p>
        </p>
        <!-- submit button -->
        <p>{{ Form::submit('Update') }}</p>
    {{ Form::close() }}
@endsection
