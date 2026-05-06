@extends('layouts.admin')
@section('content')
<div class="card"><div class="card-header"><h4>Add Category</h4></div><div class="card-body">
<form action="{{ route('admin.categories.store') }}" method="POST">@csrf <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $item->name ?? old('name') }}" required></div> <button type="submit" class="btn btn-success">Save</button></form>
</div></div>@endsection