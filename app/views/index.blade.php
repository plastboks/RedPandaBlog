@extends('base')
@section('title')
Welcome
@endsection
@section('content')
    @if ($header)
    <h1>{{ $header }}</h1>
    @endif
@if ($posts)
  @foreach ($posts as $post)
    <div class="post @if (!$post->published)unpublished @endif">
      <h2>{{ HTML::link('post/view/'.$post->id, $post->title) }}</h2>
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
          @if ($img->pivot->placement == 'list')

            <a href="/post/view/{{$post->id}}">
            {{ HTML::image('uploads/'.$img->filename, $img->title,
                array(
                  'class' => 'listimage',
                  'title' => $img->title,
                )) }}
            </a>
          @endif
        @endforeach
      @endif
      @if ($post->excerpt)
        <p>{{ substr($post->excerpt, 0, $s->excerptCut). ' [..]' }}</p> 
      @else
        <p>{{ substr($post->body, 0, $s->excerptCut). ' [..]' }}</p> 
      @endif
      <p class='readmore'>{{ HTML::link('post/view/'.$post->id, 'Read more &rarr;') }}</p>
    </div>
  @endforeach
  {{ $posts->links() }}
@else
  <h2>No posts found</h2>
@endif
@endsection
