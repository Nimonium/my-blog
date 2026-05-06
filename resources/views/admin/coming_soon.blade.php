@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ $title ?? 'Coming Soon' }}</h2>
</div>

<div class="card">
    <div class="card-body text-center py-5">
        <h3 class="text-muted mb-3">🚧 Under Construction</h3>
        <p class="text-secondary">This module is currently being built and will be available soon.</p>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary mt-3">Back to Manage Blogs</a>
    </div>
</div>
@endsection
