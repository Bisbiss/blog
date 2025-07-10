@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body text-center py-5">
                <h1 class="mb-4">Welcome to My Blog</h1>
                <p class="lead">Thank you for visiting. We're glad to have you here!</p>
                <div class="mt-4">
                    <a href="/posts" class="btn btn-primary me-2">Browse Posts</a>
                    <a href="/gallery" class="btn btn-outline-secondary">View Gallery</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</html>