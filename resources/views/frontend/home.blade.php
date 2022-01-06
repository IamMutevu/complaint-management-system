@extends('layouts.base')
@section('content')
  <section id="intro">
    <div class="intro-container">
      <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <div class="carousel-item active" style="background-image: url(frontend/img/intro-carousel/carousel1.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Talk to us about our services</h2>
                <p class="animate__animated animate__fadeInUp">Your feedback is instrumental in our service provision. Let us know how you were served.</p>
                <a href="{{ route('patient_identification') }}" class="btn-get-started scrollto animate__animated animate__fadeInUp">Talk to us</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(frontend/img/intro-carousel/carousel2.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Your complaint is our high regard</h2>
                <p class="animate__animated animate__fadeInUp">Every complaint filed by our patients is taken with high regard as it informs us of areas we can imporove on to ensure offering of better services. </p>
                <a href="{{ route('patient_identification') }}" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(frontend/img/intro-carousel/carousel3.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">What matters to you, matters to us</h2>
                <p class="animate__animated animate__fadeInUp">We are not who we are without you.Therefore, we take seriously what you think and feel about us. Also, we highly regard your interests and would like to know how better we can make our services.</p>
                <a href="{{ route('patient_identification') }}" class="btn-get-started scrollto animate__animated animate__fadeInUp">File a complaint</a>
              </div>
            </div>
          </div>

<!--           <div class="carousel-item" style="background-image: url(assets/img/intro-carousel/4.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Nam libero tempore</h2>
                <p class="animate__animated animate__fadeInUp">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(assets/img/intro-carousel/5.jpg)">
            <div class="carousel-container">
              <div class="container">
                <h2 class="animate__animated animate__fadeInDown">Magnam aliquam quaerat</h2>
                <p class="animate__animated animate__fadeInUp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <a href="#featured-services" class="btn-get-started scrollto animate__animated animate__fadeInUp">Get Started</a>
              </div>
            </div>
          </div> -->

        </div>

        <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>
    </div>
  </section>


@endsection