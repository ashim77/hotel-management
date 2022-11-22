<?php require_once('header.php'); ?>

<?php
// Slider information
if (isset($_POST['update_testimonial_form'])) {
  try {
    if (empty($_POST['person_name_des'])) {
      throw new Exception("Testimonial Name & Des. can not be empty!");
    }
    if (empty($_POST['person_comment'])) {
      throw new Exception('Testimonial Comment text can not be empty!');
    }
    if (empty($_FILES['person_photo'])) {
      throw new Exception('Feature icon can not be empty!');
    }

    $q = $pdo->prepare("UPDATE feature SET 
    feature_title=?,
    feature_text=?,
    feature_icon=?
    WHERE feature_id=?");
    $q->execute([
      $_POST['feature_title'],
      $_POST['feature_text'],
      $_POST['feature_icon'],
      $_REQUEST['id']
    ]);

    $success_message = 'Feature information is update successfully';
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

// exeisting slider info
$q = $pdo->prepare("SELECT * FROM feature WHERE feature_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $feature_title = $row['feature_title'];
  $feature_text = $row['feature_text'];
  $feature_icon = $row['feature_icon'];
}

?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Edit Slider</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Feature Form Elements
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
          <!-- Feature Title -->
          <div class="form-group">
            <label for="feature_title" class="col-sm-2 control-label">Feature Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="feature_title" name="feature_title" value="<?php echo $feature_title; ?>">
            </div>
          </div>
          <!-- Feature Text -->
          <div class="form-group">
            <label for="feature_text" class="col-sm-2 control-label">Feature Text</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="feature_text" id="feature_text" cols="30" rows="10"><?php echo $feature_text; ?></textarea>
            </div>
          </div>
          <!-- Feature Icon -->
          <div class="form-group">
            <label for="feature_icon" class="col-sm-2 control-label">Feature Icon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="feature_icon" name="feature_icon" value="<?php echo $feature_icon; ?>">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary" name="update_testimonial_form">Update</button>
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