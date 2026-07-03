@extends('themes.backend.layouts.app')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>SEO Pages</h5>
        <a href="{{ route('admin.seo-pages.create') }}" class="btn btn-primary btn-sm float-right ml-2">Create New Page</a>
        <a href="{{ route('admin.seo-pages.bulk') }}" class="btn btn-info btn-sm float-right">Bulk Upload</a>
      </div>
      <div class="card-block">
        @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif
        <form method="get" class="row mb-3">
          <div class="col-md-3"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search title, keyword or tags"></div>
          <div class="col-md-2"><select name="status" class="form-control"><option value="">All Status</option><option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option><option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option></select></div>
          <div class="col-md-2"><select name="page_type" class="form-control"><option value="">All Types</option>@foreach($pageTypes as $key => $label)<option value="{{ $key }}" {{ request('page_type') === $key ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
          <div class="col-md-2"><select name="category" class="form-control"><option value="">All Categories</option>@foreach($categories as $category)<option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>@endforeach</select></div>
          <div class="col-md-2"><select name="sort" class="form-control"><option value="updated_at" {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Last updated</option><option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date created</option><option value="seo_score" {{ request('sort') === 'seo_score' ? 'selected' : '' }}>SEO score lowest</option></select></div>
          <div class="col-md-1"><button class="btn btn-secondary btn-block">Filter</button></div>
        </form>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead><tr><th>Title</th><th>URL Slug</th><th>Type</th><th>Category</th><th>Status</th><th>SEO Score</th><th>Last Updated</th><th>Actions</th></tr></thead>
            <tbody>
              @forelse($pages as $page)
              @php $color = $page->seo_score <= 40 ? '#dc3545' : ($page->seo_score <= 70 ? '#ffc107' : '#28a745'); @endphp
              <tr>
                <td><a href="{{ route('admin.seo-pages.edit', $page) }}">{{ $page->page_title }}</a></td>
                <td><a href="{{ $page->public_url }}" target="_blank">{{ $page->public_url }}</a></td>
                <td><span class="badge badge-info">{{ $pageTypes[$page->page_type] ?? $page->page_type }}</span></td>
                <td>{{ $page->category }}</td>
                <td><span class="badge badge-{{ $page->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($page->status) }}</span></td>
                <td style="min-width:120px"><div class="progress" style="height:18px"><div class="progress-bar" style="width:{{ $page->seo_score }}%;background:{{ $color }}">{{ $page->seo_score }}</div></div></td>
                <td>{{ optional($page->updated_at)->format('Y-m-d') }}</td>
                <td>
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.seo-pages.edit', $page) }}">Edit</a>
                  <a class="btn btn-sm btn-secondary" target="_blank" href="{{ $page->public_url }}">Preview</a>
                  <form method="post" action="{{ route('admin.seo-pages.duplicate', $page) }}" class="d-inline">@csrf<button class="btn btn-sm btn-info">Duplicate</button></form>
                </td>
              </tr>
              @empty
              <tr><td colspan="8" class="text-center">No SEO pages found.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $pages->links() }}
      </div>
    </div>
  </div>
</div>
@stop
