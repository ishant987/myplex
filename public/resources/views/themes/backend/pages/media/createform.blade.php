@extends('themes.backend.layouts.app')
@push('styles') 
<link href="{{asset('themes/backend/files/assets/pages/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('themes/backend/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
@endpush

@section('breadcrumb')
{{ Breadcrumbs::render('media.create') }} 
@endsection

@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="card m-b-0">
         <div class="card-header">
            <h5 class="card-header-text">{{ __('media.add_txt') }}</h5>
         </div>
         <div class="card-block">
            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
            <form name="mdaForm" id="mdaForm" action="{{ route('admin.media.ajaxupload') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
               <input type="file" name="files[]"  id="filer_input1" multiple="multiple">
               <div class="col-form-label info">
                  <ul>
                     <li><i class="fa fa-info"></i> Upload only JPG / JPEG, PNG, GIF, SVG, PDF, DOC, XLS and PPT files.</li>
                     <li><i class="fa fa-info"></i> Only 10 files are allowed to be uploaded at a time.</li>
                     <li><i class="fa fa-info"></i> Max File uploads limit 30 MB.</li>
                  </ul>
               </div>
            </form>           
         </div>
         <!-- end of card-block -->
      </div>
   </div>
</div>
@stop

@push('scripts') 
<!-- jquery file upload js -->
<script src="{{asset('themes/backend/files/assets/pages/jquery.filer/js/jquery.filer.min.js')}}"></script>
<script src="{{asset('themes/backend/files/assets/pages/filer/jquery.fileuploads.init.js')}}"></script>
<script>
</script>
@endpush