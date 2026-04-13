@extends('themes.backend.layouts.app-modal')
@section('preloader') @stop
@push('styles') 
<link href="{{asset('themes/backend/files/assets/pages/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('themes/backend/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
@endpush

@section('content')
  <div class="card">
        <div class="card-header">
            <h5>Set Featured Media</h5>
        </div>
        <div class="card-block">
            <!-- Row start -->
            <div class="row">
                <div class="col-lg-12 col-xl-6">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs" role="tablist">
                      @if($roleRights['add'])
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab1" role="tab" aria-selected="false">Upload Files</a>
                        </li>
                      @endif
                      <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">Media Library</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs card-block p-l-0 p-r-0">
                        <div class="tab-pane" id="tab1" role="tabpanel">
                           <form name="mdaForm" id="mdaForm" action="{{ route('admin.media.ajaxupload') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                               <input type="file" name="files[]"  id="filer_input1" multiple="multiple">
                               <div class="col-form-label info">
                                  <ul>
                                     <li><i class="fa fa-info"></i> Upload only JPEG, PNG, GIF, PDF, DOC, XLS and PPT files.</li>
                                     <li><i class="fa fa-info"></i> Only 10 files are allowed to be uploaded at a time.</li>
                                     <li><i class="fa fa-info"></i> Max File uploads limit 30 MB.</li>
                                  </ul>
                               </div>
                            </form>
                        </div>
                        <div class="tab-pane active" id="tab2" role="tabpanel">
                            <div id="dataWithPagin" class="media-list-data">
                               <div class="searchWrap">
                                <form id="filterForm" name="filterForm" method="get" action="{{ route('admin.media.gallery',$typeid) }}">
                                    <div class="form-group has-primary row  ">
                                       <label for="title" class="col-sm-2 col-form-label">
                                        Search </label>
                                       <div class="col-sm-6">
                                            <input class="form-control" id="searchmedia" name="searchKey" value="{{ $searchKey }}" type="text"> 
                                        </div>
                                        <div class="col-sm-4">                                  
                                           <div class="c-f-b-f">
                                            <!-- Filter -->
                                             <button id="tp_fltr_btn" class="btn waves-effect waves-light btn-sm btn-c-p btn-info" type="submit" name="tp_fltr_btn" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Filter" onclick="return filter();">Filter</button>  
                                            <!-- Reset -->
                                             <a href="{{ $dataListModel->path() }}" id="tp_rst_btn" class="btn waves-effect waves-light btn-sm btn-c-p btn-warning" type="submit" name="tp_rst_btn" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Reset">Reset</a>
                                          </div>                                      
                                        </div>
                                    </div>
                                </form>
                               </div> 
                              <div class="media_pop_feat_list" id="media_pop_feat_list">
                                 <div class="media_img">
                                    @if( count($dataListModel) > 0 )
                                    <ul class="attachments ui-sortable ui-sortable-disabled flexItem">
                                      @foreach( $dataListModel as $key => $record )
                                        <li onclick="setMediaAtrbts('{{ $record->media_id }}','{{ route('admin.media.info',$record->media_id)}}');" tabindex="{{ $key }}" role="checkbox" aria-label="wysiwyg" id="media_{{ $record->media_id }}" aria-checked="true" class="attachment save-ready">
                                          <div class="attachment-preview type-image subtype-jpeg landscape">
                                             <div class="thumbnail">
                                                <div class="centered">
                                                    @if( in_array($record->mime_type, $imagesTypeAry))
                                                    <x-img src="{!! $moduleAtrArr['media_folder'].$record->path !!}" width="{{ $moduleAtrArr['img_width']['small'] }}" class="img-thumbnail"/>
                                                    @else
                                                    <x-img src="{{ asset('themes/backend/images/default-file.jpg') }}" width="{{ $moduleAtrArr['img_width']['small'] }}" class="img-thumbnail"/>
                                                    @endif
                                                </div>
                                             </div>
                                          </div>
                                       </li>
                                      @endforeach                                      
                                    </ul>
                                    @else
                                      {{ __('message.data_not_available') }}
                                    @endif
                                 </div>
                              </div>
                            {!! $dataListModel->appends($data)->links() !!}
                            </div>
                            <div id="mediaDetail" class="media_detail"></div>
                            <input type="hidden" name="media_id" id="media_id" value="{{ $typeid }}">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
    </div>
@stop
@push('scripts') 

<!-- jquery file upload js -->
<script src="{{asset('themes/backend/files/assets/pages/jquery.filer/js/jquery.filer.min.js')}}"></script>
<script src="{{asset('themes/backend/files/assets/pages/filer/jquery.fileuploads.init.js')}}"></script>
<script>

function deleteMediaError() 
{
    $(".media_error_div").on('click',function(){
        $(this).remove();
    });
}

function setMediaAtrbts(mediaId,url){
    var mediaLiId = "media_"+mediaId;
    if ($("#"+mediaLiId).hasClass('active')) {
        // Deselect currently selected image
        $("#"+mediaLiId).removeClass('active');
        $(".media-button-select").attr("disabled", "disabled");
    } else {
        // Deselect others and select this one
        $('.media_pop_feat_list .media_img > ul li').removeClass('active');
        $("#"+mediaLiId).addClass('active');
        $(".media-button-select").removeAttr("disabled");
        if (mediaId > 0) {
            $.ajax({
                url: url,
                cache: false
            })
            .done(function (html) {
                $("#mediaDetail").html(html);
                $(".media-button-select").removeAttr("disabled");
            });
        }
    }
}


//Finally inserted selected media.
function setImageID() {
    var ImgClickId = $("#media_id").val();
    var ImgDataId = $("#hidMediaId").val();
    var ImgThumgSrc = $("#media_full_url").val();
    var img = $('<img />', {
        class: 'display-media',
        'data-id': ImgDataId,
        src: ImgThumgSrc,
        width: '100%',
        height: 'auto',
        alt: 'media-image'
    });
    parent.$("a#featuredImg-"+ImgClickId).html(img);
    parent.$("#featuredImgVal-"+ImgClickId).val(ImgDataId);
    // parent.$("#featuredImgRemov-"+ImgClickId).css('display', 'block');
    parent.$("#featuredImgRemov-"+ImgClickId).removeClass('d-none');
    parent.$.fancybox.close();
}
</script>
@endpush