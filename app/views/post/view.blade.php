@extends('base')
@section('title')
{{ $post->title }}
@endsection
@section('content')
  <div class="singlepost">
    <h1>{{ $post->title }}</h1>
    <ul class="postinfo">
      <li class="created">Created: {{ $post->created_at }}, </li>
      <li class="updated">Updated: {{ $post->updated_at }}, </li>
      <li class="author">Author: {{ $post->author->username }}, </li>
      @if ($post->categories)
        <li class="categories">Categories: 
        @foreach ($post->categories as $category)
            {{ HTML::link('post/category/'.$category->slug, $category->title) }}
        @endforeach
        </li>
      @endif
    </ul>
    @if ($post->images()->get())
      @foreach ($post->images()->get() as $img)
        @if ($img->pivot->placement == 'main')
          {{ HTML::image('/uploads/'.$img->filename, $img->title,
              array(
                'class' => 'postmainimage',
                'title' => $img->title,
          ))}}
        @endif
      @endforeach
    @endif
    <p class="excerpt">{{ $post->excerpt }}</p>
    <p class="body">{{ $post->body }}</p>
    @if (!Auth::guest())
      {{ HTML::link('admin/post/edit/'.$post->id, 'Edit') }}  
    @endif
  </div>
@endsection
