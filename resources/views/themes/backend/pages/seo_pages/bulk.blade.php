@extends('themes.backend.layouts.app')

@section('content')
<div class="row"><div class="col-sm-12"><div class="card"><div class="card-header"><h5>Bulk Upload SEO Pages</h5></div><div class="card-block">
  @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
  <a class="btn btn-info mb-3" href="{{ route('admin.seo-pages.template') }}">Download CSV Template</a>
  <form method="post" action="{{ route('admin.seo-pages.preview-csv') }}" enctype="multipart/form-data" class="mb-4">@csrf<input type="file" name="csv_file" accept=".csv,text/csv" required><button class="btn btn-primary">Preview CSV</button></form>
  @if($rows)
  <form method="post" action="{{ route('admin.seo-pages.publish-csv') }}">@csrf<input type="hidden" name="rows" value="{{ e(json_encode($rows)) }}">
    <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th>Warnings</th></tr></thead><tbody>
      @foreach($rows as $i => $row)<tr><td>{{ $i+1 }}</td><td>{{ $row['page_title'] ?? '' }}</td><td>{{ $row['url_slug'] ?? '' }}</td><td>{{ $row['status'] ?? '' }}</td><td class="{{ empty($errorsByRow[$i+1]) ? 'text-success' : 'text-danger' }}">{{ empty($errorsByRow[$i+1]) ? 'Ready' : implode(' ', $errorsByRow[$i+1]) }}</td></tr>@endforeach
    </tbody></table></div>
    <button class="btn btn-success" name="bulk_status" value="published" {{ !empty($errorsByRow) ? 'disabled' : '' }}>Publish All</button>
    <button class="btn btn-secondary" name="bulk_status" value="draft" {{ !empty($errorsByRow) ? 'disabled' : '' }}>Save All as Draft</button>
  </form>
  @endif
</div></div></div></div>
@stop
