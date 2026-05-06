<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HelpVideo;
use Illuminate\Http\Request;

class HelpVideoController extends Controller {
    public function index() { $items = HelpVideo::paginate(10); return view('admin.help_videos.index', compact('items')); }
    public function create() { return view('admin.help_videos.create'); }
    public function store(Request $request) {
        $request->validate(['title' => 'required|string', 'video_url' => 'required|string', ]);
        HelpVideo::create([
'title' => $request->title, 'video_url' => $request->video_url,  
 
]);
        return redirect()->route('admin.help_videos.index')->with('success', 'Created successfully.');
    }
    public function edit(HelpVideo $help_video) { $item = $help_video; return view('admin.help_videos.edit', compact('item')); }
    public function update(Request $request, HelpVideo $help_video) {
        $request->validate(['title' => 'required|string', 'video_url' => 'required|string', ]);
        $help_video->update([
'title' => $request->title, 'video_url' => $request->video_url,  
'published_at' => $request->published_at ?? now(),
 
]);
        return redirect()->route('admin.help_videos.index')->with('success', 'Updated successfully.');
    }
    public function destroy(HelpVideo $help_video) { $help_video->delete(); return redirect()->route('admin.help_videos.index')->with('success', 'Deleted successfully.'); }
}
