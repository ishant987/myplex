@extends('themes.backend.layouts.app')
@section('dataTables') @stop


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>All Home page latest Ads</h5>
                <!-- Add New -->

                <a href="javascript://" data-toggle="modal" data-target="#addNew" class="btn waves-effect waves-light btn-sm f-right btn-primary" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Add New">
                    <i class="icofont icofont-plus"></i>
                </a>

                <!-- Multi Delete -->

                @if($roleRights['delete'])
                <x-form.btn_multi_delete />
                @endif
                &nbsp;
            </div>
            <div class="card-block">
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.blog.delete') }}">
                    {{csrf_field()}}
                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th class="cc-w-35 no-sort-del">
                                        <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                                    </th>
                                    <th>
                                        {{__('blog.title_txt')}}
                                    </th>
                                    <th>
                                        Sub heading
                                    </th>
                                    <th>
                                        URL
                                    </th>
                                    <th>
                                        {{__('blog.status')}}
                                    </th>
                                    <th>
                                        Created By
                                    </th>
                                    <th>
                                        Created Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $list)
                                <tr role="row" class="">
                                    <td class="id">
                                        <x-form.field.checkbox style="default" name="checkbox[]" value="{{$list->id}}" fldclass="del-chkbx" />
                                    </td>
                                    <td>
                                        @if($roleRights['edit'])
                                        <x-link_tooltip url="{{ route('admin.blog.edit', $list->id) }}" title="Edit">
                                            {{$list->heading}}
                                        </x-link_tooltip>
                                        @else
                                        {{$list->heading}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$list->sub_heading}}
                                    </td>
                                   <td>
                                    {{$list->link}}
                                   </td>
                                    <td>

                                        <label id="change_status{{ $list->id }}" onclick="return changeStatus('id', {{ $list->id }}, 'lates_from_plexus', {{ $list->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$list->status] }}">{{ $statusAtrArr['label'][$list->status] }}</label>
                                    </td>
                                    <td>
                                        {{$list->creator->first_name}}
                                    </td>
                                    
                                    <td>
                                        {{$list->created_at}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addNew">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add new</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="latest_add_forn" method="post" action="{{route('admin.latest.create')}}">
                {{ csrf_field() }}
                <x-form.group_lyt1_2_10 label="{{ __('blog.heading') }}" for="heading" error="{{ $errors->first('heading') }}" required="true">
                    <x-form.field.text id="heading" name="heading" value="{{ old('heading') }}" />
                    <span id="heading_e" class="text-danger"></span>
                  </x-form.group_lyt1_2_10>
                  <x-form.group_lyt1_2_10 label="{{ __('blog.sub_heading') }}" for="sub_heading" error="{{ $errors->first('sub_heading') }}" required="true">
                    <x-form.field.text id="sub_heading" name="sub_heading" value="{{ old('sub_heading') }}" />
                    <span id="sub_heading_e" class="text-danger"></span>
                  </x-form.group_lyt1_2_10>
                  <x-form.group_lyt1_2_10 label="Link" for="tags" error="{{ $errors->first('cta_required_url') }}" required="true">
                    <x-form.field.text id="link" name="link" value="{{ old('link') }}" />
                    <span id="link_e" class="text-danger"></span>
                  </x-form.group_lyt1_2_10>
                  
            </form>
            <div class="alert alert-success add_new d-none" role="alert">
                Successfully created.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary save_latest">Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>
@stop
@push('styles')
<style>
    #spinner-div {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
</style>
@endpush
@push('scripts')
<script>
    $('.save_latest').click(function(){
        $('span[id$=\'_e\']').text('');
     jQuery.ajax({
        url: $('.latest_add_forn').attr('action'),
        type: "post",
        data:$('.latest_add_forn').serialize(),
        dataType: 'json',
        success: function(data) {
            $(this).attr('disabled',true);
            $('.add_new').removeClass();
            setTimeout(() => {
                    window.location.reload();
            }, 3000);
        },
        complete:function(){
            $('#spinner-div').hide();
        },
        error: function(data) {
            var err = data.responseJSON;
			if (err) {
				$.each(err.errors, function (k, v) {
					$('#' + k + "_e").text(v[0]);
				})
			}
        }
    });
});
</script>
@endpush
