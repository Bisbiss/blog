@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
            @endif
            <div class="card-body">
                <h1 class="card-title mb-3">{{ $post->title }}</h1>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Category: {{ $post->category->name ?? 'Uncategorized' }}</span>
                    <span class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</span>
                </div>
                <div class="card-text">
                    {!! $post->content !!}
                </div>
            </div>
            <div class="card-footer">
                <a href="/posts" class="btn btn-outline-secondary">&larr; Back to Posts</a>
            </div>
        </div>
    </div>
</div>
@endsection