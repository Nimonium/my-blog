<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller {
    public function index() { $items = Tag::paginate(10); return view('admin.tags.index', compact('items')); }
    public function create() { return view('admin.tags.create'); }
    public function store(Request $request) {
        $request->validate(['name' => 'required|string', 'slug' => 'nullable', ]);
        Tag::create([
'name' => $request->name,  
 'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
]);
        return redirect()->route('admin.tags.index')->with('success', 'Created successfully.');
    }
    public function edit(Tag $tag) { $item = $tag; return view('admin.tags.edit', compact('item')); }
    public function update(Request $request, Tag $tag) {
        $request->validate(['name' => 'required|string', 'slug' => 'nullable', ]);
        $tag->update([
'name' => $request->name,  
 'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
]);
        return redirect()->route('admin.tags.index')->with('success', 'Updated successfully.');
    }
    public function destroy(Tag $tag) { $tag->delete(); return redirect()->route('admin.tags.index')->with('success', 'Deleted successfully.'); }
}
