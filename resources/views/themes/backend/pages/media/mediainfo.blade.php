@extends('themes.backend.layouts.app-modal')

@section('content')
  <div data-id="{{ $dataModel->media_id }}" class="attachment-details">
      <h3 class="f-14">Attachment Details</h3>
      <div class="attachment-info">
         <div class="thumbnail-image">
            <img class="img-thumbnail" draggable="false" src="{{ $imgSrc }}" width="100">
            <input type="hidden" id="media_full_url" value="{{ $moduleAtrArr['media_folder'].$dataModel->path }}">
         </div>
         <div class="details">
            <div class="filename">{{ $dataModel->path }}</div>
            <div class="uploaded">{{ $dataModel->created_at }}</div>
            <div class="file-size">{{ $mediaInfoArr->size }}</div>
            {!! $dimension !!}
            @if($roleRights['edit'])
              <a target="_blank" href="{{ route('admin.media.edit',$dataModel->media_id) }}" class="text-primary f-left">Edit</a>
            @endif
            @if($roleRights['delete'])
              <a href="javascript:void(0)" class="text-danger delete-attachment f-right" data-id="{{ $dataModel->media_id }}" data-url="{{ route('admin.media.ajaxdelete',$dataModel->media_id) }}">Delete</a>
            @endif
         </div>
      </div>
      <form name="saveSingleMedia" method="post" id="saveSingleMedia" action="{{ route('admin.media.ajaxupdate')}}">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="form-group">
          <label>Full Path</label>
          <input type="text" class="form-control" readonly="readonly" value="{!! $moduleAtrArr['media_folder'].$dataModel->path !!}">
        </div>
        @if($roleRights['edit'])
           <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" name="title" value="{!! $dataModel->title !!}">
           </div>
           {!! $altAttr !!}
        @endif
        <input type="hidden" value="{{ $dataModel->media_id }}" name="hidMediaId" id="hidMediaId">
      </form>
   </div>
   <div id="respMsg"></div>
   <div class="btn-area">
      <button type="button" class="btn btn-primary btn-mini waves-effect waves-light media-button-select" onclick="setImageID();" data-dismiss="modal">Insert Media</button>
   </div>
@stop
@push('scripts') 
<script>
$(document).ready(function () {
        $("a.delete-attachment").click(function (e) {
            e.preventDefault();
            var cnf = confirm("want to remove?");
            if (cnf == true) {
                var dataId = $(this).data("id");
                var url = $(this).data("url");
                if (dataId > 0 && url) {
                    $.ajax({
                        url: url,
                        cache: false
                    })
                    .done(function (response) {
                        if (response == 1) {
                            //ajaxMediaPopupListPagi(1, "{{ route('admin.login')}}");
                            $("#media_pop_feat_list #media_"+dataId).addClass('d-none');
                            $("#mediaDetail").empty();
                            $("#mediaDetail").html('<span class="text-success f-12 m-l-10"> Successfully deleted</span>');
                        } else {
                            $("#respMsg").html('<span class="text-danger f-12 m-l-10"> Fail message</span>');
                        }
                    });
                }
            }
        });
        $("#saveSingleMedia").change(function () {
          var form = $(this);
          var method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                type: method,
                url: form.prop('action'),
                data: form.serialize(),
                beforeSend: function () {
                    $('#respMsg').append('<span class="waiting">&nbsp;<img src="{{asset('themes/backend/images/ajax-loader-small.gif')}}" alt="" /></span>');
                },
                complete: function () {
                    $('.waiting').remove();
                },
                success: function (data) {
                    $("#respMsg").html(data);
                    setTimeout(function () {
                        $('#respMsg span').fadeOut();
                    }, 8000);
                }
            });

        });
    });
</script>
@endpush