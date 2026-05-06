<div class="row">
    @forelse($blogs as $blog)
        <div class="col-md-6 mb-4">
            <div class="blog-card">
                <div class="blog-img-container">
                    <span class="category-badge">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                    @if($blog->image_path)
                        <img src="{{ asset('storage/'.$blog->image_path) }}" alt="{{ $blog->title }}">
                    @else
                        <!-- Placeholder -->
                        <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image">
                    @endif
                </div>
                <div class="blog-content">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-title">{{ $blog->title }}</a>
                    <p class="blog-excerpt">{{ $blog->short_description }}</p>
                    
                    <div class="blog-meta">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="read-more">Read More</a>
                        <span class="blog-date">
                            <span style="margin-right: 5px;">🕒</span> {{ $blog->created_at->format('d M, Y | h:i A') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">No blogs found matching your criteria.</h4>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $blogs->links('pagination::bootstrap-5') }}
</div>
