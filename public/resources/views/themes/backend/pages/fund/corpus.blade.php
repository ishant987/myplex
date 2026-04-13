@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr, $editDataAtrArr['title']) }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5 class="card-header-text">{{ $editDataAtrArr['title'] }}</h5>
      </div>
      <div class="card-block">
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />

        <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.fund.corpus.update', $dataArr->fund_id) }}" method="POST">
          {{ csrf_field() }}

            @for ($idx = 0; $idx < 12;)
            <div class="form-group has-primary row">
              <div class="col-sm-12">
                <input class="form-control" type="text" name="funds[{{ $idx++ }}]" value="{{ ($otherData['data_item'] < $otherData['total']) ? $dataListModel[$otherData['data_item']++]->fund : '' }}" placeholder="Fund {{ $idx }}">
              </div>
            </div>
              @endfor

          <div class="row">
            <div class="col-sm-12">
              <x-form.group_lyt1_2_10 class="m-t-10">
                <x-form.field.button id="submit" name="submit" onclick="return confirm('{{ __('message.confirm.save') }}')" />
                <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" onclick="return confirm('{{ __('message.confirm.cancel') }}')" />
              </x-form.group_lyt1_2_10>
            </div>
          </div>
        </form>
      </div>
      <!-- end of card-block -->
    </div>
  </div>
</div>
@stop