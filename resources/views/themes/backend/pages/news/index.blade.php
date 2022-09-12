@extends('themes.backend.layouts.app')

@section('breadcrumb')
{{ Breadcrumbs::render('news.index')  }}
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card m-b-0">
      <div class="card-header">
        <h5>{{ __('news.all_txt') }}</h5>
        @if($roleRights['add'])
        <!-- Add New -->
        <x-link_add_new url="{{ route('admin.news.create') }}" />
        @endif
        @if($roleRights['delete'])
        @if( count( $dataListModel ) > 0 )
        <!-- Multi Delete -->
        <x-form.btn_multi_delete />
        &nbsp;
        @endif
        @endif
      </div>
      <div class="card-block">
        <!-- Show message. -->
        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
        <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.news.delete') }}">
          {{ csrf_field() }}
          <div class="table-responsive dt-responsive">
            <table id="dom-jqry" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  @if($roleRights['delete'])
                  @if( count( $dataListModel ) > 0 )
                  <th class="cc-w-35 no-sort-del">
                    <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                  </th>
                  @endif
                  @endif
                  <th>{{ __('admin.title_txt') }}</th>
                  <th class="cc-w-70">{{ __('news.media_txt') }}</th>
                  <th>{{ __('news.source_txt') }}</th>
                  <th class="cc-w-60 no-sort">{{ __('admin.status_txt') }}</th>
                  <th class="cc-w-150">{{ __('admin.mdfy_date_txt') }}</th>
                  <th class="cc-w-95 no-sort">{{ __('admin.mdfy_by_txt') }}</th>
                </tr>
              </thead>
              <tbody>
                @if( count($dataListModel) > 0 )
                @foreach( $dataListModel as $key => $record )
                <tr role="row" class="">
                  @if($roleRights['delete'])
                  <td class="sorting_{{ $record->n_id }}">
                    <x-form.field.checkbox style="default" name="checkbox[]" value="{{ $record->n_id }}" fldclass="del-chkbx" />
                  </td>
                  @endif
                  <td>
                    @if($roleRights['edit'])
                    <x-link_tooltip url="{{ route('admin.news.edit', $record->n_id) }}" title="{{ $listDataAtrArr['edit_txt'] }}">
                      {!! \App\Lib\Core\Useful::getShortContent( strip_tags($record->title), $moduleAtrArr['title_char_lngth']) !!}
                    </x-link_tooltip>
                    @else
                    {{ $record->title }}
                    @endif
                  </td>
                  <td>
                    @switch($record->media_type)
                    @case($moduleAtrArr['media_type']['value']['0'])
                    @if($record->image)
                    <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$record->image }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" placement="right">
                      <x-img src="{{ $moduleAtrArr['media_folder'].$record->image }}" width="{{ $moduleAtrArr['img_width']['small'] }}" class="img-fluid img-thumbnail w-70" />
                    </x-link_tooltip>
                    @endif
                    @break
                    @case($moduleAtrArr['media_type']['value']['1'])
                    @switch($record->video_from)
                    @case($moduleAtrArr['video_type']['value']['0'])
                    @if($record->video_data)
                    <x-link_tooltip url="{{ $moduleAtrArr['media_folder'].$record->video_data }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" class="f-30">
                      <i class="fa fa-file-movie-o"></i>
                    </x-link_tooltip>
                    @endif
                    @break
                    @case($moduleAtrArr['video_type']['value']['1'])
                    @if($record->video_data)
                    <x-link_tooltip url="{{ $record->video_data }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}" class="f-30">
                      <i class="ti-youtube"></i>
                    </x-link_tooltip>
                    @endif
                    @break
                    @endswitch
                    @break
                    @endswitch
                  </td>
                  <td>
                    @if($record->news_source)
                    @if($record->news_source_link)
                    <x-link_tooltip url="{{ $record->news_source_link }}" title="{{ $moduleAtrArr['view_txt'] }}" target="{{ $moduleAtrArr['target'] }}">
                      {{ $record->news_source }}
                    </x-link_tooltip>
                    @else
                    {{ $record->news_source }}
                    @endif
                    @endif
                  </td>
                  <td>
                    @if($roleRights['edit'])
                    <label id="change_status{{ $record->n_id }}" onclick="return changeStatus('n_id', {{ $record->n_id }}, 'news', {{ $record->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }}">{{ $statusAtrArr['label'][$record->status] }}</label>
                    @else
                    <label class="label btn-{{ $listDataAtrArr['alert_css'][$record->status] }} no-drop">{{ $statusAtrArr['label'][$record->status] }}</label>
                    @endif
                  </td>
                  <td>{{ date($listDataAtrArr['mdfy_dt_frmt'], strtotime($record->updated_at)) }}</td>
                  <td>{{ $record->updatedby->display_name ?? $listDataAtrArr['unknown_txt'] }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7">{{ __('message.data_not_available') }}</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop