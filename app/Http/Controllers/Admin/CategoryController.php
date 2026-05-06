<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() { $items = Category::paginate(10); return view('admin.categories.index', compact('items')); }
    public function create() { return view('admin.categories.create'); }
    public function store(Request $request) {
        $request->validate(['name' => 'required|string', 'slug' => 'nullable', ]);
        Category::create([
'name' => $request->name,  
 'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
]);
        return redirect()->route('admin.categories.index')->with('success', 'Created successfully.');
    }
    public function edit(Category $category) { $item = $category; return view('admin.categories.edit', compact('item')); }
    public function update(Request $request, Category $category) {
        $request->validate(['name' => 'required|string', 'slug' => 'nullable', ]);
        $category->update([
'name' => $request->name,  
 'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
]);
        return redirect()->route('admin.categories.index')->with('success', 'Updated successfully.');
    }
    public function destroy(Category $category) { $category->delete(); return redirect()->route('admin.categories.index')->with('success', 'Deleted successfully.'); }
}
