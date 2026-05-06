<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Headline;
use App\Models\HelpVideo;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $recentBlogs = Blog::where('published_at', '<=', now())->orWhereNull('published_at')->latest('published_at')->take(5)->get();
        $headlines = Headline::where('is_active', true)->where(function($q) { $q->where('published_at', '<=', now())->orWhereNull('published_at'); })->latest('published_at')->get();
        $helpVideos = HelpVideo::where('published_at', '<=', now())->orWhereNull('published_at')->latest('published_at')->take(3)->get();
        $tags = Tag::all();

        $query = Blog::with('category')->where(function($q) { $q->where('published_at', '<=', now())->orWhereNull('published_at'); })->latest('published_at');

        if ($request->ajax()) {
            if ($request->has('category_id') && $request->category_id != 'all') {
                $query->where('category_id', $request->category_id);
            }
            
            if ($request->has('search') && $request->search != '') {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->has('date') && $request->date != '') {
                // e.g., filter by exact date or month. Assuming simple date filter here.
                $query->whereDate('created_at', $request->date);
            }

            $blogs = $query->paginate(10);
            return view('frontend.partials.blog_list', compact('blogs'))->render();
        }

        $blogs = $query->paginate(10);
        return view('frontend.index', compact('blogs', 'categories', 'recentBlogs', 'headlines', 'helpVideos', 'tags'));
    }

    public function show($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->firstOrFail();
        $headlines = Headline::where('is_active', true)->where(function($q) { $q->where('published_at', '<=', now())->orWhereNull('published_at'); })->latest('published_at')->get();
        $helpVideos = HelpVideo::where('published_at', '<=', now())->orWhereNull('published_at')->latest('published_at')->take(3)->get();
        return view('frontend.show', compact('blog', 'headlines', 'helpVideos'));
    }
}
