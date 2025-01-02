<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - HiddenHeavens</title>
    <!-- Include necessary styles -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<!--=================================
Page title -->
<section class="page-title bg-holder bg-overlay-black-50" style="background: url(images/bg/02.jpg);">
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6">
                <h1 class="text-white">Contact Us</h1>
            </div>
        </div>
    </div>
</section>
<!--=================================
Page title -->

<!--=================================
Let’s Get In Touch -->
<section class="space-ptb contact-section">
  <div class="container">
    <div class="row bg-white">
      <div class="col-lg-4">
      <div class="section-title">
  <h2>Let’s Get In Touch!</h2>
  <div class="sub-title">
    <span>
      We'd love to hear from you! Whether you have a question, feedback, or just want to say hello, feel free to reach out to us. Fill in the form below, and we'll get back to you as soon as possible.
    </span>
  </div>
</div>

        <ul class="list-unstyled mb-0 d-flex mb-3">
          <li><a class="me-2" href="#"><i class="fab fa-facebook-f"></i></a></li>
          <li><a class="me-2" href="#"><i class="fab fa-twitter"></i></a></li>
          <li><a class="me-2" href="#"><i class="fab fa-linkedin-in"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-8">       
        <div class="row">
          <div class="col-lg-12">
            <div id="formmessage"></div>
            <form id="contactform" role="form" method="post" action="php/contact-form.php">
    <div class="contact-form clearfix">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Your name</label>
                <input id="name" type="text" placeholder="Name*" class="form-control" name="name" required>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Your email</label>
                <input type="email" placeholder="Email*" class="form-control" name="email" required>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Subject</label>
                <input id="subject" type="text" placeholder="Subject*" class="form-control" name="subject" required>
            </div>
            <div class="mb-3 col-md-12">
                <label class="form-label">Your message</label>
                <textarea class="input-message form-control" placeholder="Message*" rows="7" name="message" required></textarea>
            </div>
        </div>
        <div class="section-field submit-button">
            <input type="hidden" name="action" value="sendEmail" />
            <button id="submit" name="submit" type="submit" value="Send" class="button btn btn-primary">
                <span>Send message</span>
            </button>
        </div>
    </div>
</form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
Let’s Get In Touch -->

<?php include 'components/footer.php'; ?>

<!-- Include necessary scripts -->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
