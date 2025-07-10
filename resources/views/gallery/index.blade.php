@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Photo Gallery</h1>
    </div>
</div>

<div class="row">
    @forelse($galleries as $gallery)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($gallery->image)
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $gallery->title }}</h5>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info">
                No gallery images found.
            </div>
        </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-md-12">
        {{ $galleries->links() }}
    </div>
</div>
@endsection