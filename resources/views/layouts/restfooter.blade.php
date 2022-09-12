@php
  $arrCity = Common::getCommonCityList();;
@endphp
<div class="modal fade bs-example-modal-lg" id="citymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="select_city_main modal-dialog">
    <div class="select_city_inner modal-content cf" style="border:0px;">
      <!-- <div style="position:relative;">
        <select class="form-control kt-select2" id="kt_select2_4" name="param" style="width:100%;padding:20px;">
					@if(isset($arrCity) && !empty($arrCity))
            @foreach($arrCity as $keyCity => $valCity)
              @if(Session::get("city_name") == $valCity->name)
                <option value="{{$valCity->id}}" selected>{{$valCity->name}}</option>
              @else
              <option value="{{$valCity->id}}">{{$valCity->name}}</option>
              @endif
            @endforeach
          @endif
        </select>                  
        <i class="fa fa-search"></i> 
      </div> -->
      <div>
        <ul class="cf">
          @if(isset($arrCity) && !empty($arrCity))
            @foreach($arrCity as $keyCity=>$valCity)
              <li class="pickcity" data-id='{{$valCity->id}}' data-name='{{$valCity->name}}'>
                <div class="selectcity_buttons">
                  <a href="javascript:void(0);">{{$valCity->name}}</a>
                </div>
              </li>
            @endforeach
          @endif
        </ul>
        </div>
      </div>    
  </div>
</div>
<footer class="footer module">
  <div class="footer_section_inner">
    
    <div class="footer_bottom_main_inner">
      <div class="container">
        <div class="cf">
          <div class="footer_left">
            <div class="footer_menu_main">
              <ul class="cf">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/about-us') }}">About Us</a></li>
                <li><a href="{{ url('/our-usps') }}">What's Magical?</a></li>
                <li><a href="{{ url('/our-offerings') }}">Magical Packages</a></li>
                <li><a href="#">Gallery</a></li>
                <li><a href="#">Media</a> </li>
                <li><a href="{{ url('/contact-us') }}">Contact Us</a> </li>
              </ul>
              <div class="copyright_main"> <span>Copyright © 2019 WantaSanta. All Rights Reserved.</span> <span class="privacypolicy">
			  <a title="Privacy Policy" href="{{url('/privacy-policy')}}">Privacy Policy</a></span>
			  <span class="termsconditions">
			  <a title="Terms & Conditions" href="{{url('/terms-conditions')}}">Terms & Conditions</a>
			  </span>
			  </div>
            </div>
          </div>
          <div class="footer_right">
            <div class="footer_social_main">
              <div class="social-main">
                <ul>
                  <li><a target="_blank" title="Facebook" class="facebook" href="https://www.facebook.com/Want-A-Santa-120023729406523/"><img src="{{ asset('assets/images/facebook.png') }}" alt=""></a></li>
                  <li><a target="_blank" title="Instagram" class="linkedin" href="https://www.instagram.com/want_a_santa/"><img src="{{ asset('assets/images/insta.png') }}" alt=""></a></li>
                  <!--<li><a target="_blank" title="linkedin" class="linkedin" href="https://www.twitter.com/"><img src="{{ asset('assets/images/twitter.png') }}" alt=""></a></li>
                  <li><a target="_blank" title="linkedin" class="linkedin" href="https://www.linkedin.com/"><img src="{{ asset('assets/images/linkedin.png') }}" alt=""></a></li>-->
                  <li><a target="_blank" title="YouTube" class="linkedin" href="https://www.youtube.com/channel/UCI6R2SC3WPXCHbKXj4u8QYQ"><img src="{{ asset('assets/images/youtube.png') }}" alt=""></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>