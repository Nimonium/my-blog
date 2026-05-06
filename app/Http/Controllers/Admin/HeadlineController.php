<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Headline;
use Illuminate\Http\Request;

class HeadlineController extends Controller {
    public function index() { $items = Headline::paginate(10); return view('admin.headlines.index', compact('items')); }
    public function create() { return view('admin.headlines.create'); }
    public function store(Request $request) {
        $request->validate(['title' => 'required|string', 'url' => 'nullable|url', 'is_active' => 'nullable', ]);
        Headline::create([
'title' => $request->title, 'url' => $request->url, 'is_active' => $request->has('is_active'),  
 
]);
        return redirect()->route('admin.headlines.index')->with('success', 'Created successfully.');
    }
    public function edit(Headline $headline) { $item = $headline; return view('admin.headlines.edit', compact('item')); }
    public function update(Request $request, Headline $headline) {
        $request->validate(['title' => 'required|string', 'url' => 'nullable|url', 'is_active' => 'nullable', ]);
        $headline->update([
'title' => $request->title, 'url' => $request->url, 'is_active' => $request->has('is_active'),  
'published_at' => $request->published_at ?? now(),
 
]);
        return redirect()->route('admin.headlines.index')->with('success', 'Updated successfully.');
    }
    public function destroy(Headline $headline) { $headline->delete(); return redirect()->route('admin.headlines.index')->with('success', 'Deleted successfully.'); }
}
