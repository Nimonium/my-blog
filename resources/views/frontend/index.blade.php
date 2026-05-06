@extends('layouts.frontend')

@section('content')
<div class="row">
    <!-- Main Content Area -->
    <div class="col-lg-8" id="blogs">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" id="current-category-title">All Blogs</h2>
            <!-- Optional Date Filter -->
            <div>
                <input type="date" id="date-filter" class="form-control" style="border-radius: 50px;">
            </div>
        </div>

        <div id="loader">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="blog-list-container">
            @include('frontend.partials.blog_list')
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="sidebar-widget">
            <h4><span style="color:var(--primary-color); margin-right:8px;">🔍</span> Search</h4>
            <div class="search-container">
                <input type="text" id="search-input" class="form-control search-input w-100" placeholder="Search articles...">
            </div>
        </div>

        <div class="sidebar-widget">
            <h4>Categories</h4>
            <ul class="category-list">
                <li><a class="category-link active" data-id="all">All Categories</a></li>
                @foreach($categories as $category)
                    <li><a class="category-link" data-id="{{ $category->id }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="sidebar-widget">
            <h4><span style="color:var(--primary-color); margin-right:8px;">📰</span> Recent Posts</h4>
            <div class="recent-posts">
                @foreach($recentBlogs as $recent)
                    <div class="mb-3 d-flex align-items-center">
                        @if($recent->image_path)
                            <img src="{{ asset('storage/'.$recent->image_path) }}" alt="{{ $recent->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                        @endif
                        <div>
                            <a href="{{ route('blog.show', $recent->slug) }}" class="text-decoration-none text-dark fw-bold d-block" style="font-size: 0.9rem;">{{ Str::limit($recent->title, 40) }}</a>
                            <small class="text-muted">{{ $recent->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(isset($helpVideos) && $helpVideos->count() > 0)
        <div class="sidebar-widget">
            <h4><span style="color:var(--primary-color); margin-right:8px;">▶️</span> Help Videos</h4>
            <div class="help-videos-list mt-3">
                @foreach($helpVideos as $video)
                    <div class="mb-4">
                        <a href="{{ $video->video_url }}" target="_blank" class="text-decoration-none" style="display: block; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <div class="position-relative mb-2 rounded-4 overflow-hidden" style="height: 160px; background: linear-gradient(135deg, #cbd5e1, #94a3b8); border: 1px solid var(--border-color); box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                <!-- Play Button Overlay -->
                                <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.15);">
                                    <div class="bg-white rounded-circle d-flex justify-content-center align-items-center shadow" style="width: 50px; height: 50px;">
                                        <span style="color: var(--primary-color); font-size: 1.2rem; margin-left: 4px;">▶</span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-dark fw-bold mb-0 px-1" style="line-height: 1.4; font-family: 'Inter', sans-serif;">{{ $video->title }}</h6>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($tags) && $tags->count() > 0)
        <div class="sidebar-widget">
            <h4><span style="color:var(--primary-color); margin-right:8px;">🏷️</span> Popular Tags</h4>
            <div class="d-flex flex-wrap gap-2 mt-3">
                @foreach($tags as $tag)
                    <span class="badge" style="background: var(--bg-color); color: var(--text-main); border: 1px solid var(--border-color); padding: 8px 16px; font-weight: 500; border-radius: 50px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='#fff'; this.style.borderColor='var(--primary-color)';" onmouseout="this.style.background='var(--bg-color)'; this.style.color='var(--text-main)'; this.style.borderColor='var(--border-color)';">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentCategoryId = 'all';
    let currentSearch = '';
    let currentDate = '';

    function fetchBlogs() {
        $('#blog-list-container').hide();
        $('#loader').show();

        $.ajax({
            url: "{{ route('home') }}",
            type: "GET",
            data: {
                category_id: currentCategoryId,
                search: currentSearch,
                date: currentDate
            },
            success: function(response) {
                $('#loader').hide();
                $('#blog-list-container').html(response).fadeIn(300);
            },
            error: function(xhr) {
                $('#loader').hide();
                console.error("Error fetching blogs");
            }
        });
    }

    // Category Filter
    $('.category-link').on('click', function(e) {
        e.preventDefault();
        $('.category-link').removeClass('active');
        $(this).addClass('active');
        
        currentCategoryId = $(this).data('id');
        let catText = $(this).text();
        $('#current-category-title').text(catText + ' Blogs');
        
        fetchBlogs();
    });

    // Search Filter with delay
    let typingTimer;
    let doneTypingInterval = 500; 
    
    $('#search-input').on('keyup', function() {
        clearTimeout(typingTimer);
        currentSearch = $(this).val();
        typingTimer = setTimeout(fetchBlogs, doneTypingInterval);
    });

    $('#search-input').on('keydown', function() {
        clearTimeout(typingTimer);
    });

    // Date Filter
    $('#date-filter').on('change', function() {
        currentDate = $(this).val();
        fetchBlogs();
    });

    // Pagination Links via AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let pageUrl = $(this).attr('href');
        
        $('#blog-list-container').hide();
        $('#loader').show();

        $.ajax({
            url: pageUrl,
            type: "GET",
            data: {
                category_id: currentCategoryId,
                search: currentSearch,
                date: currentDate
            },
            success: function(response) {
                $('#loader').hide();
                $('#blog-list-container').html(response).fadeIn(300);
                $('html, body').animate({ scrollTop: $('#blogs').offset().top - 100 }, 'slow');
            }
        });
    });
});
</script>
@endpush
