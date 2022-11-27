<?php require_once('header.php'); ?>

<?php
// Slider information
if (isset($_POST['update_service_form'])) {
  try {
    if (empty($_POST['service_title'])) {
      throw new Exception("Service title can not be empty!");
    }
    if (empty($_POST['service_text'])) {
      throw new Exception('Service text can not be empty!');
    }

    $q = $pdo->prepare("UPDATE service SET 
    service_title=?,
    service_text=?
    WHERE service_id=?");
    $q->execute([
      $_POST['service_title'],
      $_POST['service_text'],
      $_REQUEST['id']
    ]);

    $success_message = 'Service information is update successfully';
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

// exeisting slider info
$q = $pdo->prepare("SELECT * FROM service WHERE service_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $service_title = $row['service_title'];
  $service_text = $row['service_text'];
}

?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Edit Service</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Service Form Elements
      </div>
      <div class="panel-body">
        <?php
        if (isset($error_message)) {
          echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }
        if (isset($success_message)) {
          echo '<div class="alert alert-success">' . $success_message . '</div>';
        }
        ?>

        <form class="form-horizontal" action="" method="post">

          <!-- Service Title -->
          <div class="form-group">
            <label for="service_title" class="col-sm-2 control-label">Service Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="service_title" name="service_title" value="<?php echo $service_title; ?>">
            </div>
          </div>
          <!-- Service Text -->
          <div class="form-group">
            <label for="service_text" class="col-sm-2 control-label">Service Text</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="service_text" id="service_text" cols="30" rows="10"><?php echo $service_text; ?></textarea>
              <script>
                CKEDITOR.replace('service_text');
              </script>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary" name="update_service_form">Update</button>
            </div>
          </div>
        </form>

      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php require_once('footer.php'); ?>