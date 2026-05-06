<?php
// Models
file_put_contents('app/Models/Tag.php', '<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class Tag extends Model { protected $fillable = ["name", "slug"]; }');
file_put_contents('app/Models/Headline.php', '<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class Headline extends Model { protected $fillable = ["title", "url", "is_active"]; }');
file_put_contents('app/Models/HelpVideo.php', '<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class HelpVideo extends Model { protected $fillable = ["title", "video_url"]; }');

function generateController($model, $fields, $table, $varName) {
    $plural = $table;
    $fieldsValidation = "";
    $fieldsData = "";
    foreach($fields as $field => $rules) {
        $fieldsValidation .= "'$field' => '$rules', ";
        if ($field == 'slug') continue;
        if ($field == 'is_active') {
            $fieldsData .= "'$field' => \$request->has('$field'), ";
        } else {
            $fieldsData .= "'$field' => \$request->$field, ";
        }
    }
    
    $slugLogic = isset($fields['slug']) ? "'slug' => \Illuminate\Support\Str::slug(\$request->name)," : "";

    return "<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\\$model;
use Illuminate\Http\Request;

class {$model}Controller extends Controller {
    public function index() { \$items = $model::paginate(10); return view('admin.{$plural}.index', compact('items')); }
    public function create() { return view('admin.{$plural}.create'); }
    public function store(Request \$request) {
        \$request->validate([$fieldsValidation]);
        $model::create([\n$fieldsData \n $slugLogic\n]);
        return redirect()->route('admin.{$plural}.index')->with('success', 'Created successfully.');
    }
    public function edit($model \$$varName) { \$item = \$$varName; return view('admin.{$plural}.edit', compact('item')); }
    public function update(Request \$request, $model \$" . $varName . ") {
        \$request->validate([$fieldsValidation]);
        \$" . $varName . "->update([\n$fieldsData \n $slugLogic\n]);
        return redirect()->route('admin.{$plural}.index')->with('success', 'Updated successfully.');
    }
    public function destroy($model \$" . $varName . ") { \$" . $varName . "->delete(); return redirect()->route('admin.{$plural}.index')->with('success', 'Deleted successfully.'); }
}
";
}

file_put_contents('app/Http/Controllers/Admin/TagController.php', generateController('Tag', ['name'=>'required|string', 'slug'=>'nullable'], 'tags', 'tag'));
file_put_contents('app/Http/Controllers/Admin/HeadlineController.php', generateController('Headline', ['title'=>'required|string', 'url'=>'nullable|url', 'is_active'=>'nullable'], 'headlines', 'headline'));
file_put_contents('app/Http/Controllers/Admin/HelpVideoController.php', generateController('HelpVideo', ['title'=>'required|string', 'video_url'=>'required|string'], 'help_videos', 'help_video'));
file_put_contents('app/Http/Controllers/Admin/CategoryController.php', generateController('Category', ['name'=>'required|string', 'slug'=>'nullable'], 'categories', 'category'));

function generateViews($model, $plural, $fields) {
    @mkdir("resources/views/admin/$plural", 0777, true);
    
    $ths = ""; $tds = "";
    foreach($fields as $f) { 
        if ($f == 'slug') continue;
        $ths .= "<th>".ucfirst($f)."</th>"; 
        $tds .= "<td>{{ \$item->$f }}</td>"; 
    }
    $index = "@extends('layouts.admin')\n@section('content')\n<div class=\"d-flex justify-content-between align-items-center mb-4\"><h2>Manage $model</h2><a href=\"{{ route('admin.{$plural}.create') }}\" class=\"btn btn-primary\">Add New</a></div>\n<div class=\"card\"><div class=\"card-body\"><div class=\"table-responsive\"><table class=\"table table-hover align-middle\"><thead class=\"table-light\"><tr><th>ID</th>$ths<th>Actions</th></tr></thead>\n<tbody>@foreach(\$items as \$item)<tr><td>{{ \$item->id }}</td>$tds<td>\n<a href=\"{{ route('admin.{$plural}.edit', \$item->id) }}\" class=\"btn btn-sm btn-info text-white\">Edit</a>\n<form action=\"{{ route('admin.{$plural}.destroy', \$item->id) }}\" method=\"POST\" class=\"d-inline-block\" onsubmit=\"return confirm('Are you sure?');\">@csrf @method('DELETE')<button type=\"submit\" class=\"btn btn-sm btn-danger\">Delete</button></form>\n</td></tr>@endforeach</tbody></table></div>{{ \$items->links('pagination::bootstrap-5') }}</div></div>\n@endsection";
    file_put_contents("resources/views/admin/$plural/index.blade.php", $index);

    $inputs = "";
    foreach($fields as $f) {
        if ($f == 'slug') continue;
        $label = ucfirst($f);
        if ($f == 'is_active') {
            $inputs .= "<div class=\"mb-3 form-check\"><input type=\"hidden\" name=\"$f\" value=\"0\"><input type=\"checkbox\" name=\"$f\" class=\"form-check-input\" value=\"1\" {{ (isset(\$item) && \$item->$f) ? 'checked' : '' }}><label class=\"form-check-label\">$label</label></div>";
        } else {
            $inputs .= "<div class=\"mb-3\"><label class=\"form-label\">$label</label><input type=\"text\" name=\"$f\" class=\"form-control\" value=\"{{ \$item->$f ?? old('$f') }}\" required></div>";
        }
    }

    $create = "@extends('layouts.admin')\n@section('content')\n<div class=\"card\"><div class=\"card-header\"><h4>Add $model</h4></div><div class=\"card-body\">\n<form action=\"{{ route('admin.{$plural}.store') }}\" method=\"POST\">@csrf $inputs <button type=\"submit\" class=\"btn btn-success\">Save</button></form>\n</div></div>@endsection";
    file_put_contents("resources/views/admin/$plural/create.blade.php", $create);

    $edit = "@extends('layouts.admin')\n@section('content')\n<div class=\"card\"><div class=\"card-header\"><h4>Edit $model</h4></div><div class=\"card-body\">\n<form action=\"{{ route('admin.{$plural}.update', \$item->id) }}\" method=\"POST\">@csrf @method('PUT') $inputs <button type=\"submit\" class=\"btn btn-success\">Update</button></form>\n</div></div>@endsection";
    file_put_contents("resources/views/admin/$plural/edit.blade.php", $edit);
}

generateViews('Tag', 'tags', ['name']);
generateViews('Headline', 'headlines', ['title', 'url', 'is_active']);
generateViews('HelpVideo', 'help_videos', ['title', 'video_url']);
generateViews('Category', 'categories', ['name']);

echo "Done generating code files.";
