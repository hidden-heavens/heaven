<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Hidden Heavens">
    <meta name="author" content="potenzaglobalsolutions.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hidden Heavens</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Global Compulsory (Do not remove)-->
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/flaticon/flaticon.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!-- Template Style -->
    <link rel="stylesheet" href="css/style.css">

  </head>

<body>

<!--=================================
header -->
<?php include 'components/header.php'; ?>


<!--=================================
Page title -->
<section class="page-title page-title-bottom bg-holder bg-overlay-black-50" style="background: url(images/bg/02.jpg);">
  <div class="container">
    <div class="row position-relative">
      <div class="col-lg-6">
        <h1 class="text-white">Create an account</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create an account</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!--=================================
Page title -->

<!--=================================
Login -->
<section class="space-ptb">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <ul class="nav nav-tabs nav-tabs-02 justify-content-center" id="myTab" role="tablist">
          <li class="nav-item me-2">
            <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="false"> <span> Log in</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="true"><span>Register</span></a>
          </li>
        </ul>
        <div class="tab-content border border-radius mt-4 p-sm-5 p-4" id="myTabContent">
          <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form id="loginForm" method="POST" class="row t-sm-4 mt-2 align-items-center">
              <div class="mb-3 col-sm-12">
                <input type="email" class="form-control" name="email" placeholder="Email" >
              </div>
              <div class="mb-3 col-sm-12">
                <input type="password" class="form-control" name="password" placeholder="Password" id="passwordInput" >
                <input type="checkbox" id="togglePassword"> Show Password
              </div>
              <div id="loginError" class="text-danger mb-3"></div>
              <div class="col-sm-6 d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
            <div class="login-social-media border ps-4 pe-4 pb-4 pt-0 mt-5">
              <div class="mb-4 d-block text-center"><p class="bg-white ps-2 pe-2 mt-3 d-block">Login or Sign in with</p></div>
             <!--  <form class="row">
                <div class="col-sm-6">
                  <a class="btn facebook-bg social-bg-hover text-white d-block mb-3" href="#"><span><i class="fab fa-facebook-f"></i>Login with Facebook</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn twitter-bg social-bg-hover text-white d-block mb-3" href="#"><span><i class="fab fa-twitter"></i>Login with Twitter</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn google-bg social-bg-hover text-white d-block mb-3 mb-sm-0" href="#"><span><i class="fab fa-google"></i>Login with Google</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn linkedin-bg social-bg-hover text-white d-block" href="#"><span><i class="fab fa-linkedin-in"></i>Login with Linkedin</span></a>
                </div>
              </form>
              -->

              <form class="row">
                <div class="col-sm-6">
                  <a class="btn google-bg social-bg-hover text-white d-block mb-3 mb-sm-0" href="#"><span><i class="fab fa-google"></i>Login with Google</span></a>
                </div>
              </form>
            </div>
          </div>
          <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
          <form id="registerForm" method="POST" class="row t-sm-4 mt-2 mb-5 align-items-center">
    <div class="mb-3 col-sm-12">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
    </div>
    <div class="mb-3 col-sm-12">
        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
    </div>
    <div class="mb-3 col-sm-12">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>
    <div class="mb-3 col-sm-12">
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
    </div>
    <!-- Feedback Message -->
    <div id="registerMessage" class="text-danger mb-3"></div>
    <div class="col-sm-6 d-grid">
        <button type="submit" class="btn btn-primary" id="registerButton">Sign up</button>
    </div>
    <div class="col-sm-6 d-grid">
        <span id="loadingSpinner" class="spinner-border spinner-border-sm text-primary d-none" role="status" aria-hidden="true"></span>
    </div>
</form>

            <div class="login-social-media border ps-4 pe-4 pb-4 pt-0 mt-5">
              <div class="mb-4 d-block text-center"><p class="bg-white ps-2 pe-2 mt-3 d-block">Login or Sign in with</p></div>
             <!--  <form class="row">
                <div class="col-sm-6">
                  <a class="btn facebook-bg social-bg-hover text-white d-block mb-3" href="#"><span><i class="fab fa-facebook-f"></i>Login with Facebook</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn twitter-bg social-bg-hover text-white d-block mb-3" href="#"><span><i class="fab fa-twitter"></i>Login with Twitter</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn google-bg social-bg-hover text-white d-block mb-3 mb-sm-0" href="#"><span><i class="fab fa-google"></i>Login with Google</span></a>
                </div>
                <div class="col-sm-6">
                  <a class="btn linkedin-bg social-bg-hover text-white d-block" href="#"><span><i class="fab fa-linkedin-in"></i>Login with Linkedin</span></a>
                </div>
              </form>
              -->

              <form class="row">
                <div class="col-sm-6">
                  <a class="btn google-bg social-bg-hover text-white d-block mb-3 mb-sm-0" href="#"><span><i class="fab fa-google"></i>Login with Google</span></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Login -->

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

  <!-- Template Scripts (Do not remove)-->
  <script src="js/custom.js"></script>



</body>
</html>
