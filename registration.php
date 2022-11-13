<?php require_once('header.php'); ?>

<!-- Parallax Effect -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#parallax-pagetitle').parallax("50%", -0.55);
  });
</script>

<section class="parallax-effect">
  <div id="parallax-pagetitle" style="background-image: url(images/parallax/parallax-01.jpg);">
    <div class="color-overlay">
      <!-- Page title -->
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li><a href="index.php">Home</a></li>
              <li class="active">Registration</li>
            </ol>
            <h1>Registration</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <div class="row">

    <!-- Registration Form -->
    <section id="contact-form" class="mt50">
      <div class="col-md-7">

        <form class="clearfix mt50" method="post" action="">
          <!-- Name -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name"><span class="required">*</span> Name</label>
                <input name="name" type="text" id="name" class="form-control" value="">
              </div>
            </div>
          </div>
          <!-- Phone -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name"> Phone Number</label>
                <input name="name" type="text" id="name" class="form-control" value="">
              </div>
            </div>
          </div>
          <!-- Email Id -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name"><span class="required">*</span> Email Address</label>
                <input name="email" type="email" id="name" class="form-control" value="">
              </div>
            </div>
          </div>
          <!-- Password -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name"><span class="required">*</span> Password</label>
                <input name="password" type="password" id="password" class="form-control" value="">
              </div>
            </div>
          </div>
          <!-- Re-type Password -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name"><span class="required">*</span> Re-type Password</label>
                <input name="password" type="password" id="password" class="form-control" value="">
              </div>
            </div>
          </div>
          <button type="submit" class="btn  btn-lg btn-primary" name="form_login">Register Now!</button>
        </form>
      </div>
    </section>
  </div>
</div>

<!-- Footer -->
<?php require_once('header.php'); ?>