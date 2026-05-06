@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h2>Manage Category</h2><a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New</a></div>
<div class="card"><div class="card-body"><div class="table-responsive"><table class="table table-hover align-middle"><thead class="table-light"><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
<tbody>@foreach($items as $item)<tr><td>{{ $item->id }}</td><td>{{ $item->name }}</td><td>
<a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
<form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
</td></tr>@endforeach</tbody></table></div>{{ $items->links('pagination::bootstrap-5') }}</div></div>
@endsection