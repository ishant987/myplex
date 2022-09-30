@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('dashboard',$errorCode)  }} 
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ $heading ? $heading:  'Not Found' }}  !</h5>
        <span>{!! $message !!}</span>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12 m-b-30">
                
        @if($errors->any())
        <h4>{{$errors->first()}}</h4>
        @endif
            </div>
        </div>
    </div>
</div>
@stop