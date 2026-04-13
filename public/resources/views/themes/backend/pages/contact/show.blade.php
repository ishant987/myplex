@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('contact.show', $id)  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('contact.show_txt') }}</h5>
      </div>
      <div class="card-block">

        <div class="row">
          <div class="col-sm-12">
            @if( $dataObj )
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label">{{ __('contact.name_txt') }}</label>
              <div class="col-9">
                <div class="col-form-label">{{ $dataObj[0]->name }}</div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label">{{ __('contact.email_txt') }}</label>
              <div class="col-9">
                <div class="col-form-label">{{ $dataObj[0]->email }}</div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label">{{ __('contact.mobile_txt') }}</label>
              <div class="col-9">
                <div class="col-form-label">{{ $dataObj[0]->mobile }}</div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label">{{ __('contact.message_txt') }}</label>
              <div class="col-9">
                <div class="col-form-label">{!! $dataObj[0]->message !!}</div>
              </div>
            </div>
            <div class="form-group has-primary row">
              <label class="col-3 col-form-label">{{ __('admin.added_date_txt') }}</label>
              <div class="col-9">
                <div class="col-form-label">{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($dataObj[0]->created_at)) }}</div>
              </div>
            </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@stop