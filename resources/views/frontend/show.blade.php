@extends('layouts.frontend')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="blog-detail-header">
            <div class="mb-3">
                <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">{{ $blog->category->name ?? 'Uncategorized' }}</span>
            </div>
            <h1 class="display-4 fw-bold mb-3">{{ $blog->title }}</h1>
            <p class="text-muted fs-5">Published on {{ $blog->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>

        @if($blog->image_path)
            <img src="{{ asset('storage/'.$blog->image_path) }}" alt="{{ $blog->title }}" class="blog-detail-img">
        @endif

        <div class="blog-detail-content">
            <!-- Render Raw HTML from WYSIWYG Editor -->
            {!! $blog->content !!}
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                &larr; Back to all blogs
            </a>
        </div>
    </div>
</div>
@endsection
