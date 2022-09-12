@extends('themes.backend.layouts.app')
@section('editor') @stop
@section('fancybox') @stop

@section('breadcrumb')
{{ Breadcrumbs::render($editDataAtrArr['route'], $dataArr) }} 
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
            
            <form name="eDataFrm" id="eDataFrm" action="{{ route('admin.page.update', $dataArr->page_id) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}

                <x-form.section_label>
                  {{ __('admin.general_lbl') }}
                </x-form.section_label>
              
              @if(isset($templateAssoc)  && count($templateAssoc)>0)
                <x-form.group_lyt1_2_10 label="{{ __('admin.template_txt') }}" for="template_id" 
                    error="{{ $errors->first('template_id') }}" required="true">
                  <select id="template_id" class="form-control" name="template_id">
                    <option value="">{{ __('admin.def_drop_optn_styl1_txt') }}</option>
                    @foreach( $templateAssoc as $tid => $template )
                    <option value="{{ $tid }}" {{ ( $templateId > 0 && $tid == $templateId ) ? 'selected' : '' }}>{{ $template }}</option>
                    @endforeach
                  </select>
                </x-form.group_lyt1_2_10>
              @endif

              <x-form.group_lyt1_2_10 label="{{ __('admin.title_txt') }}" for="title" error="{{ $errors->first('title') }}" required="true">
                  <x-form.field.text id="title" name="title" value="{{ $dataArr->title }}" />
              </x-form.group_lyt1_2_10>

              @if( $moduleAtrArr['flds_hide']['slug'] == $moduleAtrArr['bool_false'] )
              <x-form.group_lyt1_2_10 label="{{ __('admin.slug_txt') }}" for="slug" error="{{ $errors->first('slug') }}" required="true" info="{{ __('admin.info.add_slug') }}">
                  <x-form.field.text id="slug" name="slug" value="{{ $dataArr->slug }}" readonly="true" onclick="updateSlugValue();" />
              </x-form.group_lyt1_2_10>
              @endif

              <x-form.group_lyt1_2_10 label="{{ __('admin.description_txt') }}" for="descp" error="{{ $errors->first('descp') }}">
                  <x-form.field.textarea id="descp" name="descp" value="{!! $dataArr->descp !!}" class="editor_full" />
              </x-form.group_lyt1_2_10>

              @if( $moduleAtrArr['flds_hide']['image'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.featured_img_txt') }}" for="media_id" error="{{ $errors->first('media_id') }}" info="{!! __('admin.info.featured_img') !!}">
                  <div class="media_img_area">
                    <x-link_media_popup href="0" src="{{ route('admin.media.gallery', 0) }}">
                      @if( $dataArr->media_id > 0 && !empty( $dataArr->media ) )
                        <x-img src="{{ $dataArr->media->getModuleVars()['media_folder'].$dataArr->media->path }}" class="img-fluid img-thumbnail img-100 display-media" alt="{{ $dataArr->media->alt }}" title="{{ $dataArr->media->title }}" data_id="{{ $dataArr->media_id }}" />
                      @else
                        {{ __('admin.browse_media_txt') }}
                      @endif
                    </x-link_media_popup>
                    <x-form.field.hidden value="{{ $dataArr->media_id }}" name="media_id" id="featuredImgVal-0"/>
                    <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10{{ ( $dataArr->media_id > 0 &&  !empty( $dataArr->media ) ) ? '' : ' d-none' }}" id="featuredImgRemov-0" text="{{ __('admin.remove_media_txt') }}"/>
                  </div>
                </x-form.group_lyt1_2_10>
              @endif

              @if($templateCfObj && count($templateCfObj) > 0)
                <x-form.section_label>
                  {{ __('admin.custom_fields_lbl') }}
                </x-form.section_label>

                @foreach( $templateCfObj as $key => $cfgroup )
                  @if(isset($cfgroup->cfgrouptypes) && $cfgroup->cfgrouptypes->count()>0)
                    <x-form.section_label>
                    {{ $cfgroup->title }} 
                    </x-form.section_label>
                    @foreach($cfgroup->cfgrouptypes as $key => $cf_gt)
                      @if(isset($cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id) && $cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id>0 && $cf_gt_class_template_id = $cf_gt->cfgtclasstemplates[0]->cf_gt_class_template_id)
                        <x-form.group_lyt1_2_10 label="{{ $cf_gt->field_options['label'] }}" field_for="{{ $cf_gt->getCfFor() }}" field_for_class="{{ $cf_gt->field_for }}" for="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" error="{{ $errors->first('cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id) }}" info="{!! $cf_gt->field_options['description'] !!}" required="{{ $cf_gt->field_options['required']?'true':'false' }}">
                          @switch($cf_gt->field_type)
                            @case($moduleAtrArr['field_type'][1])
                              <div class="media_img_area">
                                <x-link_media_popup href="{{ $loop->iteration }}" src="{{ route('admin.media.gallery', $loop->iteration) }}">
                                  @if( $media_id = $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) )
                                    @if($media_id>0 && $mediaObj = $cf_gt->getCfGrouptypeMediaValue($media_id))
                                      <x-img src="{{ $moduleAtrArr['media_folder'].$mediaObj->path }}" class="img-fluid img-thumbnail img-100 display-media" alt="{{ $mediaObj->alt }}" title="{{ $mediaObj->title }}" data_id="{{ $mediaObj->media_id }}" />
                                    @endif
                                  @else
                                    {{ __('admin.browse_media_txt') }}
                                  @endif
                                </x-link_media_popup>
                                <x-form.field.hidden value="{{ $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) }}" name="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" id="featuredImgVal-{{ $loop->iteration }}"/>
                                @if($cf_gt->field_options['required'] == false)
                                  <x-form.field.button_def class="btn-danger btn-mini waves-effect waves-light remove_featured show-scn m-t-10{{ $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) ? '' : ' d-none' }}" id="featuredImgRemov-{{ $loop->iteration }}" text="{{ __('admin.remove_media_txt') }}"/>
                                @endif
                              </div>
                              @break
                            @case($moduleAtrArr['field_type'][2])
                              <x-form.field.text id="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" name="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" value="{!! $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) ? $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) : '' !!}" />
                              @break
                            @case($moduleAtrArr['field_type'][3])
                              <x-form.field.textarea id="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" name="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" value="{!! $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) ? $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) : '' !!}" rows="{{ $cf_gt->field_options['rows'] ?? 8 }}" />
                              @break
                            @case($moduleAtrArr['field_type'][4])
                              <x-form.field.textarea id="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" name="{{ 'cf_'.$cf_gt->field_type.'_'.$cf_gt->cf_group_type_id.'_'.$cf_gt_class_template_id }}" value="{!! $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) ? $cf_gt->getCfGrouptypeValue($cf_gt_class_template_id,$dataArr->page_id) : '' !!}" class="editor" />
                              @break
                          @endswitch
                        </x-form.group_lyt1_12>
                      @endif                    
                    @endforeach
                  @endif
                @endforeach
              @endif

              @if( $moduleAtrArr['flds_hide']['c_order'] == $moduleAtrArr['bool_false'] || $moduleAtrArr['flds_hide']['parent'] == $moduleAtrArr['bool_false'] )

                <x-form.section_label>
                  {{ __('admin.attributes_lbl') }}
                </x-form.section_label>

                @if( $moduleAtrArr['flds_hide']['parent'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.parent_txt') }}" for="parent" 
                    error="{{ $errors->first('parent') }}">
                  <select id="parent" class="form-control" name="parent">
                    <option value="">{{ __('admin.def_drop_optn_styl5_txt') }}</option>
                    @foreach( $moduleAtrArr['parent'] as $pid => $parent )
                    <option value="{{ $pid }}" @if( old('parent') == $pid ) {{ 'selected' }} @elseif( $dataArr->parent == $pid ) {{ 'selected' }} @endif>{{ $parent }}</option>
                    @endforeach
                  </select>
                </x-form.group_lyt1_2_10>
                @endif
                  
                @if( $moduleAtrArr['flds_hide']['c_order'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.order_txt') }}" for="c_order" 
                    error="{{ $errors->first('c_order') }}">
                    <x-form.field.text id="c_order" name="c_order" value="{{ $dataArr->c_order > 0 ? $dataArr->c_order : '' }}" />
                </x-form.group_lyt1_2_10>    
                @endif

              @endif

              @if( $moduleAtrArr['flds_hide']['meta_title'] == $moduleAtrArr['bool_false'] || $moduleAtrArr['flds_hide']['meta_key'] == $moduleAtrArr['bool_false'] || $moduleAtrArr['flds_hide']['meta_descp'] == $moduleAtrArr['bool_false'] )

                <x-form.section_label>
                  {{ __('admin.seo_lbl') }}
                </x-form.section_label>

                @if( $moduleAtrArr['flds_hide']['meta_title'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.seo_title_txt') }}" for="meta_title"
                    error="{{ $errors->first('meta_title') }}">
                    <x-form.field.text id="meta_title" name="meta_title" value="{{ $dataArr->meta_title }}" />
                </x-form.group_lyt1_2_10>
                @endif

                @if( $moduleAtrArr['flds_hide']['meta_key'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.meta_key_txt') }}" for="meta_key" 
                    error="{{ $errors->first('meta_key') }}">
                    <x-form.field.text id="meta_key" name="meta_key" value="{{ $dataArr->meta_key }}"/>
                </x-form.group_lyt1_2_10>
                @endif

                @if( $moduleAtrArr['flds_hide']['meta_descp'] == $moduleAtrArr['bool_false'] )
                <x-form.group_lyt1_2_10 label="{{ __('admin.meta_descp_txt') }}" for="meta_descp"
                    error="{{ $errors->first('meta_descp') }}">
                    <x-form.field.textarea id="meta_descp" name="meta_descp" value="{!! $dataArr->meta_descp !!}" rows="3" />
                </x-form.group_lyt1_2_10>    
                @endif

              @endif

              <x-form.section_label>
                {{ __('admin.publish_lbl') }}
              </x-form.section_label>

              <x-form.group_lyt1_2_10 label="{{ __('admin.note_txt') }}" for="note" 
                  error="{{ $errors->first('note') }}" info="{{ __('admin.page.note_info') }}">
                  <x-form.field.textarea id="note" name="note" value="{!! $dataArr->note !!}" rows="2" />
              </x-form.group_lyt1_2_10>  

              <x-form.group_lyt1_2_10 label="{{ __('admin.status_txt') }}" for="status" 
                  error="{{ $errors->first('status') }}" required="true">
                <select id="status" class="form-control" name="status">
                  @foreach( $moduleAtrArr['status'] as $sid => $status )
                  <option value="{{ $sid }}" @if((old('status') > 0) && ($sid == old('status'))) {{ 'selected' }} @elseif((($dataArr->status > 0) && ($sid == $dataArr->status))) {{ 'selected' }} @endif>{{ $status }}</option>
                  @endforeach
                </select>
              </x-form.group_lyt1_2_10>

              <div class="row">
                <div class="col-sm-12">
                  <x-form.group_lyt1_2_10 class="m-t-10">
                    <x-form.field.button id="submit" name="submit" />
                    <x-form.field.button type="reset" id="cancel" name="cancel" class="btn-danger" text="{{ __('admin.cancel_txt') }}" />
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
@push('scripts') 
  <script>
  $('#template_id').bind('change', function() {
    var template_id = $(this).val();
    var url = '';
    if(template_id > 0){
      url = '{{ route("admin.page.edit.custom", ["id" => $dataArr["page_id"], "tid" => ":template_id"]) }}';
      url = url.replace(':template_id', template_id);
    }
    else{
      url = '{{ route("admin.page.edit.custom", $dataArr["page_id"]) }}';
    }
    window.location.href = url;
  });
  </script>
@endpush