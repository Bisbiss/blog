@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Latest Posts</h1>
    </div>
</div>

<div class="row">
    @forelse($posts as $post)
        <div class="col-md-4">
            <div class="card">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text text-muted small">Category: {{ $post->category->name ?? 'Uncategorized' }}</p>
                    {!! Str::limit($post->content, 100) !!}
                    <a href="/posts/{{ $post->id }}" class="btn btn-primary">Read More</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{ $post->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info">
                No posts found.
            </div>
        </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-md-12">
        {{ $posts->links() }}
    </div>
</div>
@endsection