@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h2>Edit Blog</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">Select a Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Thumbnail / Cover Image (Leave blank to keep current)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if($blog->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$blog->image_path) }}" alt="Current Image" style="height: 100px; border-radius: 5px;">
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" rows="3" class="form-control" required>{{ old('short_description', $blog->short_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control summernote" required>{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="mb-3"><label class="form-label">Scheduled Publish Date</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', isset($blog->published_at) ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"></div><button type="submit" class="btn btn-primary">Update Blog</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Write your blog content here...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
