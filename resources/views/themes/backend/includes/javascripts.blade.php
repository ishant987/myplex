<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
  <div class="ie-warning">
     <h1>Warning!!</h1>
     <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
     <div class="iew-container">
        <ul class="iew-download">
           <li>
              <a href="http://www.google.com/chrome/">
                 <img src="{{asset('themes/backend/files/assets/images/browser/chrome.png')}}" alt="Chrome">
                 <div>Chrome</div>
              </a>
           </li>
           <li>
              <a href="https://www.mozilla.org/en-US/firefox/new/">
                 <img src="{{asset('themes/backend/files/assets/images/browser/firefox.png')}}" alt="Firefox">
                 <div>Firefox</div>
              </a>
           </li>
           <li>
              <a href="http://www.opera.com">
                 <img src="{{asset('themes/backend/files/assets/images/browser/opera.png')}}" alt="Opera">
                 <div>Opera</div>
              </a>
           </li>
           <li>
              <a href="https://www.apple.com/safari/">
                 <img src="{{asset('themes/backend/files/assets/images/browser/safari.png')}}" alt="Safari">
                 <div>Safari</div>
              </a>
           </li>
           <li>
              <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                 <img src="{{asset('themes/backend/files/assets/images/browser/ie.png')}}" alt="">
                 <div>IE (9 & above)</div>
              </a>
           </li>
        </ul>
     </div>
     <p>Sorry for the inconvenience!</p>
  </div>
  <![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script src="{{asset('themes/backend/files/bower_components/jquery/js/jquery.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/popper.js/js/popper.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- waves js -->
<script src="{{asset('themes/backend/files/assets/pages/waves/js/waves.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script src="{{asset('themes/backend/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
<!-- modernizr js -->
<script src="{{asset('themes/backend/files/bower_components/modernizr/js/modernizr.js')}}"></script>
<!-- slimscroll js -->
<script src="{{asset('themes/backend/files/assets/js/SmoothScroll.js')}}"></script>
<script src="{{asset('themes/backend/files/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

@if(View::hasSection('select2'))
<script src="{{asset('themes/backend/files/bower_components/select2/js/select2.full.min.js')}}"></script>
<!-- <script src="{{asset('themes/backend/files/assets/pages/advance-elements/select2-custom.js')}}"></script> -->
<script>
  $(document).ready(function() {
    $(".js-example-basic-single").select2();
  });
</script>
@endif

@if(View::hasSection('admin-vue-js'))
<script src="{{ asset('/js/admin-vue.js')}}"></script>
@endif

@if(View::hasSection('dataTables'))
<script src="{{asset('themes/backend/files/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('themes/backend/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('themes/backend/files/assets/pages/data-table/js/data-table-custom.js')}}"></script>
@endif

@if(!View::hasSection('menu'))
<!-- menu js -->
<script src="{{asset('themes/backend/files/assets/js/pcoded.min.js')}}"></script>
<script src="{{asset('themes/backend/files/assets/js/vertical/vertical-layout.min.js')}}"></script>
@endif

<!-- custom js -->
<script src="{{asset('themes/backend/files/assets/js/script.js')}}"></script>
<script src="{{asset('themes/backend/js/custom-functions.js')}}"></script>

@if(View::hasSection('tinymceEditor'))
<!-- Editor TINYMCE Starts-->
<script src="{{asset('themes/backend/assets/tinymce/tinymce.dev.js')}}"></script>
<script src="{{asset('themes/backend/assets/tinymce/plugins/table/plugin.dev.js')}}"></script>
<script src="{{asset('themes/backend/assets/tinymce/plugins/paste/plugin.dev.js')}}"></script>
<script src="{{asset('themes/backend/assets/tinymce/plugins/spellchecker/plugin.dev.js')}}"></script>
<script src="{{asset('themes/backend/assets/tinymce/tinymce.script.js')}}"></script>
@endif

@if(View::hasSection('editor'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
  $(document).ready(function() {
    $('.editor').summernote({
      toolbar: [
        ['para', ['ul']],
        ['view', ['codeview']],
      ],
      height: 200,
    });
    $('.editor_full').summernote({
      toolbar: [
        ['style', ['style']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        // ['table', ['table']],
        ['view', ['codeview']],
      ],
      height: 200,
    });
  });
</script>
@endif

@if(View::hasSection('autocomplete'))
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
@endif

@if(View::hasSection('datetimeRangePicker'))
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script>
  $(function() {
    // Period(Start and End Date)
    $('.period').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'DD-MM-YYYY'
      },
      /*startDate: "",*/
      maxDate: "{{ date(config('commonconstants.d_m_y_frmt')) }}"
    });
    $('.period').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });
    $('.period').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  });
</script>
@endif

@if(View::hasSection('datetimePicker'))
<script src="{{asset('themes/assets/datetime-picker/jquery-ui.min.js')}}"></script>
<script src="{{asset('themes/assets/datetime-picker/jquery-ui-timepicker-addon.js')}}"></script>
<script>
  $(document).ready(function() {
    /*Date and Datetime picker*/
    $(".datetime").datetimepicker({
      dateFormat: 'dd-mm-yy',
      timeFormat: "HH:mm:ss"
    });
    $(".date").datepicker({
      dateFormat: 'dd-mm-yy'
    });
    $(".def-date").datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    });
    $(".date-w-min").datepicker({
      minDate: 0,
      dateFormat: 'dd-mm-yy'
    });
    $.datepicker.setDefaults({
      dateFormat: 'dd-mm-yy',
      firstDay: 1
    });
    $('.start_date').datepicker({
      minDate: 0,
      onSelect: function(selectedDate) {
        var minDate = $(this).datepicker('getDate');
        if (minDate) {
          minDate.setDate(minDate.getDate() + 1);
        }
        $('.end_date').datepicker('option', 'minDate', minDate || 1); // Date + 1 or tomorrow by default
      }
    });
    $('.end_date').datepicker({
      minDate: 1,
      onSelect: function(selectedDate) {
        var maxDate = $(this).datepicker('getDate');
        if (maxDate) {
          maxDate.setDate(maxDate.getDate() - 1);
        }
        $('.start_date').datepicker('option', 'maxDate', maxDate); // Date - 1
      }
    });
  });
</script>
@endif

@if(View::hasSection('multiselectAvailableSelected'))
<script src="{{asset('themes/backend/js/multiselect.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('#multiselect').multiselect({
      search: {
        left: '<input type="text" name="q" class="form-control" placeholder="{{ __('admin.def_drop_optn_styl4_txt') }}" />',
        right: '<input type="text" name="q" class="form-control" placeholder="{{ __('admin.def_drop_optn_styl4_txt') }}" />',
      },
      fireSearch: function(value) {
        return value.length > 3;
      },
      keepRenderingSort: true
    });
  });
</script>
@endif

@if(View::hasSection('commonPages'))
<script src="{{asset('themes/backend/files/assets/js/common-pages.js')}}"></script>
@endif

@if(View::hasSection('fancybox'))
<script src="{{asset('themes/assets/fancybox-v3.2.5/dist/jquery.fancybox.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $("[data-fancybox-media]").fancybox({
      toolbar: false,
      smallBtn: true,
      iframe: {
        css: {
          width: '1024px',
          height: '600px'
        }
      }
    });
  });
  $(".remove_featured").on('click', function(e) {
    e.preventDefault();
    var rmvId = $(this).attr('data-type');
    var TxtDataId = $(this).prevUntil(rmvId).prev().attr('data-href');
    $(this).prevUntil(rmvId).prev().html("{{ __('admin.browse_media_txt') }}");
    $("#featuredImgVal-" + TxtDataId).val("0");
    $(this).addClass('d-none');
  });
</script>
@endif
@yield('page-footer-scripts')
@yield('section-footer-scripts')
@stack('scripts')