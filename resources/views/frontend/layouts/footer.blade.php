
<!--============================
=            Footer            =
=============================-->

<footer class="footer-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <div class="footer-logo">
              <img src="images/footer-logo.png" alt="logo" class="img-fluid">
            </div>
            <ul class="social-links-footer list-inline">
              <li class="list-inline-item">
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><i class="fa fa-instagram"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><i class="fa fa-rss"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#"><i class="fa fa-vimeo"></i></a>
              </li>
            </ul>
          </div>
          
        </div>
      </div>
    </div>
</footer>
<!-- Subfooter -->
<footer class="subfooter">
  <div class="container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <div class="copyright-text">
          <p><a href="#">Eventre</a> &#169; 2017 All Right Reserved</p>
        </div>
      </div>
      <div class="col-md-6">
          <a href="#" class="to-top"><i class="fa fa-angle-up"></i></a>
      </div>
    </div>
  </div>
</footer>



  <!-- JAVASCRIPTS -->
  <!-- jQuey -->
{{-- Start of JAVASCRIPTS Section --}}

{{-- Core Dependencies --}}
<script src="{{asset('plugins/jquery/jquery.js') }}"></script>
<script src="{{asset('plugins/popper/popper.min.js') }}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- UI Enhancement Plugins --}}
<script src="{{asset('plugins/smoothscroll/SmoothScroll.min.js') }}"></script>  
<script src="{{asset('plugins/isotope/mixitup.min.js') }}"></script>  
<script src="{{asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

{{-- Slider and Timer Plugins --}}
<script src="{{asset('plugins/slick/slick.min.js') }}"></script>  
<script src="{{asset('plugins/syotimer/jquery.syotimer.min.js') }}"></script>

{{-- Google Maps Integration --}}
{{-- Note: Replace the API key with an environment variable for security in production --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
<script src="{{asset('plugins/google-map/gmap.js') }}"></script>

{{-- Main Application Logic --}}
<script src="{{asset('js/custom.js') }}"></script>

{{-- End of JAVASCRIPTS Section --}}