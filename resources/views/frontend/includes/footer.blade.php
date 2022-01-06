<!-- ======= Footer ======= -->
<footer id="footer">

  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-6 footer-contact">
          <h3>Elytesol Supplies</h3>
          <p>
            A.D.D. Building <br>
            Mamlaka/Lower State House Road <br><br>
            <strong>Phone:</strong> +254 753 942 350<br>
            <strong>Email:</strong> info@elytesupplies.com<br>
          </p>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Shop</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Product Categories</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Ironsheets</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Finishes</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Plumbing</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Welding</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Building Materials</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-newsletter">
          <h4>Join Our Newsletter</h4>
          <p>Sign up for our newsletter today</p>
          <form action="" method="post">
            <input type="email" name="email"><input type="submit" value="Subscribe">
          </form>
        </div>

      </div>
    </div>
  </div>

  <div class="container d-lg-flex py-4">

    <div class="mr-lg-auto text-center text-lg-left">
      <div class="copyright">
        &copy; Copyright <strong><span>Elytesol Supplies</span></strong>. All Rights Reserved
      </div>
<!--       <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">Elytes</a>
      </div> -->
    </div>
<!--     <div class="social-links text-center text-lg-right pt-3 pt-lg-0">
      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
    </div> -->
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('frontend/vendor/jquery-sticky/jquery.sticky.js') }}"></script>
<script src="{{ asset('frontend/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/aos/aos.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>
<!-- <script src="assets/js/script.js"></script> -->
<script>
  $(document).ready(function(){
    $('.owl').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
  });
</script>

</body>

</html>