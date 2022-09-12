<footer class="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-sm-9 col-sm-12">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 f-col-cn f-col-1">
              @if(isset($optsDbArr['quick_link_1']))
              <h6>{{ $optsDbArr['quick_link_1'] }}</h6>
              @endif
              {!! $webfootermenu !!}
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 f-col-cn f-col-2">
              @if(isset($optsDbArr['quick_link_2']))
              <h6>{{ $optsDbArr['quick_link_2'] }}</h6>
              @endif
              {!! $webfooterquicklinkmenu !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 f-col-cn f-col-3">
              @if(isset($optsDbArr['quick_contact_label']))
              <h6>{{ $optsDbArr['quick_contact_label'] }}</h6>
              @endif
              <div class="col-12 p-0 f-dd">
                @if(isset($optsDbArr['address']))
                <div class="f-icon"><img src="{{asset('themes/frontend/assets/images/location-icon.png')}}" alt="location"></div>
                <div class="f-content">
                  <p>{!! nl2br($optsDbArr['address']) !!}</p>
                </div>
                <div class="clear"></div>
                @endif
              </div>
              <div class="col-12 p-0 f-dd">
                @if( isset($optsDbArr['contact1']) || isset($optsDbArr['contact2']) )
                <div class="f-icon"><img src="{{asset('themes/frontend/assets/images/call-icon.png')}}" alt="call-icon"></div>
                <div class="f-content">
                  @if( isset($optsDbArr['contact1']) )
                  <p>{!! $optsDbArr['contact1'] !!}</p>
                  @endif
                  @if( isset($optsDbArr['contact2']) )
                  <p>{!! $optsDbArr['contact2'] !!}</p>
                  @endif
                </div>
                <div class="clear"></div>
                @endif
              </div>
              <div class="col-12 p-0 f-dd">
                <div class="f-icon"><img src="{{asset('themes/frontend/assets/images/web-icon.png')}}" alt="web-icon"></div>
                <div class="f-content">
                  <p>{{ __('web.ftr_email_txt') }}
                    <x-link url="mailto:{{ $optsDbArr['to_email'] }}">{{ $optsDbArr['to_email'] }}</x-link>
                  </p>
                  <p>{{ __('web.ftr_web_txt') }}
                    <x-link url="{{ config('app.url') }}">{{ str_replace(['http://', 'https://'], '', config('app.url')) }}</x-link>
                  </p>
                </div>
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 footer-last">
          <div class="col-12 f-col-logo p-0 text-right">
            <x-link url="/" class="img-fluid">
              @if(isset($optsDbArr['media_folder']) && isset($optsDbArr['logo']))
              <x-img src="{{ $optsDbArr['media_folder'].$optsDbArr['logo'] }}" />
              @endif
            </x-link>
          </div>
          <div class="col-12 f-col-social p-0">
            @if( isset( $optsDbArr['facebook'] ) || isset( $optsDbArr['twitter'] ) || isset( $optsDbArr['linkedin'] ) )
            <div class="d-flex justify-content-end">
              @if( isset( $optsDbArr['facebook'] ) )
              <div class="social-div">
                <x-link url="{{ $optsDbArr['facebook'] }}" target="_blank">
                  <x-img src="{{asset('themes/frontend/assets/images/facebook-icon.png')}}" alt="facebook" />
                </x-link>
              </div>
              @endif
              @if( isset( $optsDbArr['twitter'] ) )
              <div class="social-div">
                <x-link url="{{ $optsDbArr['twitter'] }}" target="_blank">
                  <x-img src="{{asset('themes/frontend/assets/images/twiiter-icon.png')}}" alt="twitter" />
                </x-link>
              </div>
              @endif
              @if( isset( $optsDbArr['linkedin'] ) )
              <div class="social-div">
                <x-link url="{{ $optsDbArr['linkedin'] }}" target="_blank">
                  <x-img src="{{asset('themes/frontend/assets/images/linkedin-icon.png')}}" alt="linkedin" />
                </x-link>
              </div>
              @endif
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom bg-b">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 co-sm-12 f-b-lft">
          <p>{{ __('common.copyright_txt') }} {{date('Y')}} {{ __('common.right_resrv_txt') }}</p>
        </div>
        <div class="col-lg-6 col-md-6 co-sm-12 f-b-rgt">
          {!! $webfooterlegallinkmenu !!}
        </div>
      </div>
    </div>
  </div>
</footer>