<?php

// 1. Update Models
function updateModel($file) {
    $content = file_get_contents($file);
    if (!str_contains($content, 'published_at')) {
        $content = preg_replace('/protected \$fillable = \[(.*?)\];/', 'protected $fillable = [$1, "published_at"]; protected $casts = ["published_at" => "datetime"];', $content);
        file_put_contents($file, $content);
    }
}
updateModel('app/Models/Blog.php');
updateModel('app/Models/Headline.php');
updateModel('app/Models/HelpVideo.php');

// 2. Update BlogController
$bc = file_get_contents('app/Http/Controllers/Admin/BlogController.php');
$bc = str_replace("'content' => 'required|string',", "'content' => 'required|string',\n            'published_at' => 'nullable|date',", $bc);
$bc = str_replace("'content' => \$request->content,", "'content' => \$request->content,\n            'published_at' => \$request->published_at ?? now(),", $bc);
file_put_contents('app/Http/Controllers/Admin/BlogController.php', $bc);

// 3. Update Headline and HelpVideo Controllers
function updateController($file) {
    $content = file_get_contents($file);
    $content = str_replace("\$request->validate([", "\$request->validate([\n            'published_at' => 'nullable|date',", $content);
    $content = preg_replace("/::create\(\[\n(.*?)\n/s", "::create([\n$1\n'published_at' => \$request->published_at ?? now(),\n", $content);
    // For update, the variable is dynamically named
    $content = preg_replace("/->update\(\[\n(.*?)\n/s", "->update([\n$1\n'published_at' => \$request->published_at ?? \$item->published_at,\n", $content);
    // Fix the $item var issue for the update method in the generated controllers:
    // the variable is $headline, $help_video, etc. So I will just use request->published_at or now() to be safe.
    $content = preg_replace("/->update\(\[\n(.*?)\n/s", "->update([\n$1\n'published_at' => \$request->published_at ?? now(),\n", file_get_contents($file)); // overwrite previous
    
    file_put_contents($file, $content);
}
updateController('app/Http/Controllers/Admin/HeadlineController.php');
updateController('app/Http/Controllers/Admin/HelpVideoController.php');

// 4. Update FrontendController
$fc = file_get_contents('app/Http/Controllers/FrontendController.php');
$fc = str_replace("Blog::latest()", "Blog::where('published_at', '<=', now())->orWhereNull('published_at')->latest('published_at')", $fc);
$fc = str_replace("Headline::where('is_active', true)->latest()", "Headline::where('is_active', true)->where(function(\$q) { \$q->where('published_at', '<=', now())->orWhereNull('published_at'); })->latest('published_at')", $fc);
$fc = str_replace("HelpVideo::latest()", "HelpVideo::where('published_at', '<=', now())->orWhereNull('published_at')->latest('published_at')", $fc);
$fc = str_replace("Blog::with('category')->latest()", "Blog::with('category')->where(function(\$q) { \$q->where('published_at', '<=', now())->orWhereNull('published_at'); })->latest('published_at')", $fc);
file_put_contents('app/Http/Controllers/FrontendController.php', $fc);

// 5. Update Views
function addInputToViews($plural) {
    // Create
    $create = file_get_contents("resources/views/admin/$plural/create.blade.php");
    if (!str_contains($create, 'published_at')) {
        $input = '<div class="mb-3"><label class="form-label">Scheduled Publish Date (Optional)</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old(\'published_at\') }}"></div>';
        $create = str_replace('<button type="submit"', $input . '<button type="submit"', $create);
        file_put_contents("resources/views/admin/$plural/create.blade.php", $create);
    }
    // Edit
    $edit = file_get_contents("resources/views/admin/$plural/edit.blade.php");
    if (!str_contains($edit, 'published_at')) {
        // Need to grab the model variable from the view name or just use the generic item
        $var = '$item';
        if ($plural == 'blogs') $var = '$blog';
        else if ($plural == 'headlines') $var = '$headline';
        else if ($plural == 'help_videos') $var = '$help_video';
        
        $val = "{{ old('published_at', isset($var->published_at) ? $var->published_at->format('Y-m-d\TH:i') : '') }}";
        $input = '<div class="mb-3"><label class="form-label">Scheduled Publish Date</label><input type="datetime-local" name="published_at" class="form-control" value="' . $val . '"></div>';
        $edit = str_replace('<button type="submit"', $input . '<button type="submit"', $edit);
        file_put_contents("resources/views/admin/$plural/edit.blade.php", $edit);
    }
}
addInputToViews('blogs');
addInputToViews('headlines');
addInputToViews('help_videos');

echo "Refactored scheduling feature successfully!";
