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
              <li class="active">Payment History</li>
            </ol>
            <h1>Payment History</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <div class="row">
    <!-- Dashboard Sidebar -->
    <section class="contact-details">
      <div class="col-md-3">
        <h2 class="lined-heading  mt50"></h2>
        <!-- Panel -->
        <div class="panel panel-default text-center">
          <div class="panel-body">
            <?php require_once('c-sidebar.php'); ?>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact form -->
    <section id="contact-form" class="mt50">
      <div class="col-md-9">
        <table class="table table-bordered responsive-table">
          <thead>
            <tr>
              <th>Serial</th>
              <th>Room Type</th>
              <th>Room Number</th>
              <th>Adult</th>
              <th>Child</th>
              <th>Payment Method</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Single Room</td>
              <td>205</td>
              <td>2</td>
              <td>0</td>
              <td>PayPal</td>
              <td>
                <a href="" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal">Details</a>
              </td>

              <!-- Room Details Modal -->
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Details Information</h4>
                    </div>
                    <div class="modal-body">
                      <b>Payment Method:</b> PayPal <br>
                      <b>Total Paid:</b> $340 <br>
                      <b>Payment ID:</b> 895431452 <br>
                      <b>Payment Date:</b> 22 January, 2023 <br>
                      <b>Check In Date:</b> 24 january, 2023 <br>
                      <b>Check Out Date:</b> 25 january, 2023 <br>
                      <b>Number of Days:</b> 2
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>

<!-- Footer -->
<?php require_once('header.php'); ?>