<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Placy - Directory and Listing Template">
    <meta name="author" content="potenzaglobalsolutions.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Placy - Directory and Listing Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Global Compulsory (Do not remove)-->
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/flaticon/flaticon.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!-- Page CSS Implementing Plugins (Remove the plugin CSS here if site does not use that feature)-->
    <link rel="stylesheet" href="css/select2/select2.css">
    <link rel="stylesheet" href="css/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="css/animate/animate.min.css">
    <link rel="stylesheet" href="css/magnific-popup/magnific-popup.css">

    <!-- Template Style -->
    <link rel="stylesheet" href="css/style.css">

  </head>

<body>

<?php include 'components/header.php'; ?>

<!--=================================
 Modal login -->
<div class="modal login fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="loginModalLabel">Log in & Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs nav-tabs-02 justify-content-center" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="false"> <span> Log in</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="true"><span>Register</span></a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form class="row mt-4 align-items-center">
              <div class="form-group mb-3 col-sm-12">
                <input type="text" class="form-control" placeholder="Username">
              </div>
              <div class="form-group mb-3 col-sm-12">
                <input type="Password" class="form-control" placeholder="Password">
              </div>
              <div class="col-sm-6 d-grid">
                <button type="submit" class="btn btn-primary">Sign up</button>
              </div>
              <div class="col-sm-6">
                <ul class="list-unstyled d-flex mb-1 mt-sm-0 mt-3">
                  <li class="me-1"><a class="text-dark" href="#"><b>Already Registered User? Click here to login</b></a></li>
                </ul>
              </div>
            </form>
            <div class="login-social-media border ps-4 pe-4 pb-4 pt-0 mt-5">
              <div class="mb-4 d-block text-center"><b class="bg-white ps-2 pe-2 mt-3 d-block">Login or Sign in with</b></div>
              <form class="row">
                <div class="col-sm-12">
                  <a class="btn btn-skew bg-facebook d-block mb-3 text-white" href="#"><span><i class="fab fa-facebook-f"></i>Login with Facebook</span></a>
                </div>
              </form>
            </div>
          </div>
          <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <form class="row mt-4 mb-5 align-items-center">
              <div class="form-group mb-3 col-sm-12">
                <input type="text" class="form-control" placeholder="Username">
              </div>
              <div class="form-group mb-3 col-sm-12">
                <input type="email" class="form-control" placeholder="Email Address">
              </div>
              <div class="form-group mb-3 col-sm-12">
                <input type="Password" class="form-control" placeholder="Password">
              </div>
              <div class="form-group mb-3 col-sm-12">
                <input type="Password" class="form-control" placeholder="Confirm Password">
              </div>
              <div class="col-sm-6 d-grid">
                <button type="submit" class="btn btn-primary">Sign up</button>
              </div>
              <div class="col-sm-6">
                <ul class="list-unstyled d-flex mb-1 mt-sm-0 mt-3">
                  <li class="me-1"><a class="text-dark" href="#"><b>Already Registered User? Click here to login</b></a></li>
                </ul>
              </div>
            </form>
            <div class="login-social-media border ps-4 pe-4 pb-4 pt-0 mt-5">
              <div class="mb-4 d-block text-center"><b class="bg-white ps-2 pe-2 mt-3 d-block">Login or Sign in with</b></div>
              <form class="row">
                <div class="col-sm-12">
                  <a class="btn btn-skew bg-facebook d-block mb-3 text-white" href="#"><span><i class="fab fa-facebook-f"></i>Login with Facebook</span></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--=================================
Modal login -->

<!--=================================
banner -->
<section class="banner banner-03 bg-holder bg-overlay-black-60 bg-overlay-half-top" style="background: url(images/bg/04.jpg);">
  <div class="container">
    <div class="row justify-content-center align-items-center position-relative z-index-1">
      <div class="col-lg-6">
        <h1 class="text-white banner-title mb-4">Explore Amazing Places In City You To Search</h1>
        <span class="lead text-white mb-4 text-white">We will be helping you to search for the best places.</span>
        <p class="text-white mt-3 mb-4">Making a decision to do something – this is the first step. We all know that nothing moves until someone makes a decision.</p>
        <a class="btn btn-primary btn-lg" href="#">Read More</a>
      </div>
      <div class="col-lg-5 offset-lg-1 mt-4 mt-lg-0">
        <form class="home-search-02 p-4 p-sm-5 d-grid">
          <div class="form-group mb-3">
            <label class="form-label fw-bold">What?</label>
            <div class=" form-location">
              <input type="text" class="form-control" placeholder="What are you looking for...">
              <a class="location-icon" href="#"> <i class="fas fa-search-location"></i> </a>
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label fw-bold">Where?</label>
            <div class="form-location">
              <input type="text" class="form-control" placeholder="Where...">
              <a class="location-icon" href="#"> <i class="far fa-compass"></i> </a>
            </div>
          </div>
          <div class="form-group select-border">
            <label class="form-label fw-bold">Choose Category?</label>
            <select class="form-control basic-select">
              <option>All categories </option>
              <option>Restaurant </option>
              <option>Night life </option>
              <option>Hotels </option>
              <option>Cafe</option>
              <option>Club & Bars</option>
              <option>Museum</option>
            </select>
          </div>
          <a class="btn btn-primary mt-5" href="#"> <i class="fas fa-search-location"></i> Search </a>
        </form>
      </div>
    </div>
  </div>
</section>
<!--=================================
banner -->
<section class="position-relative z-index-9">
  <div class="container">
    <div class="counter-section bg-light mt-lg-n5 mt-5">
    <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="counter">
            <div class="counter-content">
              <h2 class="timer text-dark" data-to="17" data-speed="5000">17</h2><span>k</span>
            </div>
            <div class="counter-icon">
               <h6>Total Verified Listings</h6>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="counter">
            <div class="counter-content">
              <h2 class="timer text-dark" data-to="40" data-speed="5000">40</h2><span>k</span>
            </div>
            <div class="counter-icon">
               <h6>Our Happy Clients The World</h6>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="counter">
            <div class="counter-content">
              <h2 class="timer text-dark" data-to="56" data-speed="5000">56</h2><span>k</span>
            </div>
            <div class="counter-icon">
               <h6>Places In The World</h6>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="counter">
            <div class="counter-content">
              <h2 class="timer text-dark" data-to="47" data-speed="5000">47</h2><span>k</span>
            </div>
            <div class="counter-icon">
               <h6>Happy Clients Verified Listings</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--=================================
Location cities -->
<section class="space-ptb">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title text-center">
          <h2>Fine location in these cities</h2>
          <div class="sub-title"> <span> Make a list of your achievements toward your long-term goal.</span></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="location-item text-center">
          <img class="img-fluid" src="images/location/03.jpg" alt="">
          <div class="location-info">
            <a href="#">London</a>
            <a class="listing-list" href="#">10 listing</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mt-4 mt-lg-0">
        <div class="location-item text-center">
          <img class="img-fluid" src="images/location/02.jpg" alt="">
          <div class="location-info">
            <a class="position-relative" href="#">Hong kong</a>
            <a class="position-relative listing-list" href="#">06 listing</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mt-4">
        <div class="location-item text-center">
          <img class="img-fluid" src="images/location/01.jpg" alt="">
          <div class="location-info">
            <a href="#">New York</a>
            <a class="listing-list" href="#">05 listing</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mt-4">
        <div class="location-item text-center">
          <img class="img-fluid" src="images/location/04.jpg" alt="">
          <div class="location-info">
            <a href="#">Sydney</a>
            <a class="listing-list" href="#">04 listing</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mt-4">
        <div class="location-item bg-holder text-center" style="background-image: url(images/location/05.jpg);" >
          <img class="img-fluid" src="images/location/05.jpg" alt="">
          <div class="location-info">
            <a href="#">Mumbai</a>
            <a class="listing-list" href="#">16 listing</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Location cities -->

<!--=================================
listing -->
<section class="space-ptb popup-gallery overflowx-h bg-light places-blog">
  <div class="container">
    <div class="row d-flex align-items-center mb-4 mb-lg-5">
      <div class="col-md-12 col-lg-8 col-xl-6">
        <div class="section-title mb-0">
          <h2>Most visited places</h2>
          <div class="sub-title"> <span> Make a list of your achievements toward your long-term goal</span></div>
        </div>
      </div>
      <div class="col-md-12 col-lg-4 col-xl-6 text-lg-end text-start mt-4 mt-lg-0">
        <a class="btn btn-primary" href="#"><span>View All</span></a> 
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="owl-carousel testimonial-center" data-nav-dots="true" data-nav-arrow="false" data-items="3" data-md-items="3" data-sm-items="2" data-xs-items="2" data-xx-items="1" data-space="20" data-autoheight="false">
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/01.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-coffee-cup"></i> Cafe</a>
                  <a class="popup popup-single" href="images/listing/grid/01.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/01.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Melanie Byrd</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">Espresso macchiato</a></h6>
                    <span class="listing-price">$21</span>
                  </div>
                  <p class="mb-3">Remind yourself you have nowhere to go except have already been at the bottom.</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.2</span> 12 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +666 658 447</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> Piper Drive Zion</a>
                  <span class="listing-open">Open</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/02.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-megaphone"></i> Nightlife</a>
                  <a class="popup popup-single" href="images/listing/grid/02.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/02.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Alice Williams</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">Fantastic Fridaze</a></h6>
                    <span class="listing-price">$17</span>
                  </div>
                  <p class="mb-3">Give yourself the power of responsibility. Remind thing stopping you is yourself.</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.6</span> 10 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +444 656 326</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> 472 Carpenter Rd</a>
                  <span class="listing-open">Open</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/03.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-guitar"></i> Sound & music</a>
                  <a class="popup popup-single" href="images/listing/grid/03.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/03.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Paul Flavius</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">Bike Tours Hollywood</a></h6>
                    <span class="listing-price">$13</span>
                  </div>
                  <p class="mb-3">Make a list of your that intentions don’t count, only action’s.</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.1</span> 06 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +888 235 956</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> Lincolnton, NC 28092</a>
                  <span class="listing-close">Closed</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/04.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-customer"></i> Art & Museums</a>
                  <a class="popup popup-single" href="images/listing/grid/04.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/04.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Harry Russell</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">The Vatican Museums</a></h6>
                    <span class="listing-price">$15</span>
                  </div>
                  <p class="mb-3">Remind yourself of someone the fact that there that tomorrow will come.</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.9</span> 03 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +222 356 457</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> West Division Street</a>
                  <span class="listing-close">Closed</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/05.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-wine"></i> Nightclub</a>
                  <a class="popup popup-single" href="images/listing/grid/05.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/05.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Ora Bryan</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">Liberty Club</a></h6>
                    <span class="listing-price">$07</span>
                  </div>
                  <p class="mb-3">Find a picture of what epitomizes success you are in need of motivation.</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.6</span> 15 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +333 659 856</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> Fort Wayne, IN 46804</a>
                  <span class="listing-open">Open</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="listing-item">
              <div class="listing-image bg-overlay-half-top">
                <img class="img-fluid" src="images/listing/grid/06.jpg" alt="">
                <div class="listing-quick-box">
                  <a class="category" href="#"> <i class="flaticon-food-serving"></i> Restaurant</a>
                  <a class="popup popup-single" href="images/listing/grid/06.jpg" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                  <a class="like" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Like"> <i class="far fa-heart"></i> </a>
                </div>
                <div class="listing-info">
                <img class="img-fluid" src="images/listing-brand/06.png" alt="">
                <div class="info-content">
                  <p class="mb-0">Maria Fields</p>
                  <div class="listing-rating" >
                    <span class="stars-wrapper">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </span>
                  </div>
                </div>
              </div>
              </div>
              <div class="listing-details">
                <div class="listing-details-inner">
                  <div class="listing-title">
                    <h6><a href="#">Honey Restaurant</a></h6>
                    <span class="listing-price">$09</span>
                  </div>
                  <p class="mb-3">The thing that drives me most is the desire them.” ~ Richard Marcinko</p>
                  <div class="listing-rating-call">
                    <a class="listing-rating" href="#"><span class="me-1">4.2</span> 08 Rating</a>
                    <a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +999 784 578</a>
                  </div>
                </div>
                <div class="listing-bottom">
                  <a class="listing-loaction" href="#"> <i class="fas fa-map-marker-alt"></i> 442 Glenholme Street</a>
                  <span class="listing-open">Open</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
listing -->

<!--=================================
Find places-->
<section class="space-pb overflowx-h">
  <div class="container">
    <div class="row g-0">
      <div class="col-lg-6">
        <div class="bg-dark p-4 p-sm-5 bg-overlay-left-100 mb-4 mb-lg-0">
          <div class="d-flex align-items-center mb-4 pt-4">
            <i class="display-4 flaticon-map me-3 text-white"></i>
            <h2 class="text-white mb-0">Find What you want</h2>
          </div>
          <p class="text-white mb-4">Give yourself the power of responsibility. Remind yourself the only thing stopping you is yourself.</p>
          <a class="btn btn-primary mb-4" href="#">Browse our listing</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="bg-primary p-4 p-sm-5 bg-overlay-right-100">
          <div class="d-flex align-items-center mb-4 pt-4">
            <i class="display-4 flaticon-article me-3 text-white"></i>
            <h2 class="text-white mb-0">Explore amazing places</h2>
          </div>
          <p class="text-white mb-4">Make a list of your achievements toward your long-term goal and remind yourself that intentions.</p>
          <a class="btn btn-light mb-4" href="#">Promote your Listing</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Find places -->

<!--=================================
News & Tips -->
<section class="space-pb">
  <div class="container">
    <div class="row d-flex align-items-center mb-4 mb-lg-5">
      <div class="col-md-12 col-lg-8 col-xl-6">
        <div class="section-title mb-0">
          <h2>News &amp; Tips</h2>
          <div class="sub-title"> <span>Reflect and experiment until you find the right combination.</span></div>
        </div>
      </div>
      <div class="col-md-12 col-lg-4 col-xl-6 text-lg-end text-start mt-4 mt-lg-0">
        <a class="btn btn-primary" href="#"><span>View All</span></a> 
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="blog-post blog-post-03 bg-overlay-half-bottom bg-holder h-100" style="background-image: url(images/blog/01.jpg);">
          <div class="blog-post-info">
            <div class="blog-post-category">
              <a href="#">Food & Drink,</a>
              <a href="#">Stay</a>
            </div>
            <h5 class="blog-post-title"><a href="#"> Where To Invest In listing </a></h5>
            <p class="mb-0 text-white">Commitment – understanding the price and having pay that price</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="blog-post blog-post-03 bg-overlay-half-bottom bg-holder h-100" style="background-image: url(images/blog/02.jpg);">
          <div class="blog-post-info">
            <div class="blog-post-category">
              <a href="#">Lifestyle,</a>
              <a href="#">Travels</a>
            </div>
            <h5 class="blog-post-title"><a href="#"> Cutting Your Losses In listing </a></h5>
            <p class="mb-0 text-white">Commit your decision to paper, just to bring it into focus.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="blog-post blog-post-03 bg-overlay-half-bottom bg-holder h-100" style="background-image: url(images/blog/03.jpg);">
          <div class="blog-post-info">
            <div class="blog-post-category">
              <a href="#">Drink,</a>
              <a href="#">Stay</a>
            </div>
            <h5 class="blog-post-title"><a href="#"> How To Replace A Ceiling Fan </a></h5>
            <p class="mb-0 text-white">Having clarity of purpose and a clear picture of what you desire</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
News & Tips -->

<?php include 'components/footer.php'; ?>


<!--=================================
Back To Top-->

 <div id="back-to-top" class="back-to-top">
  <a href="#"> <i class="fas fa-angle-up"></i></a>
 </div>

<!--=================================
Back To Top-->

<!--=================================
Javascript -->

  <!-- JS Global Compulsory (Do not remove)-->
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/popper/popper.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>

  <!-- Page JS Implementing Plugins (Remove the plugin script here if site does not use that feature)-->
  <script src="js/select2/select2.full.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/counter/jquery.countTo.js"></script>
  <script src="js/owl-carousel/owl.carousel.min.js"></script>
  <script src="js/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Template Scripts (Do not remove)-->
  <script src="js/custom.js"></script>

</body>
</html>
