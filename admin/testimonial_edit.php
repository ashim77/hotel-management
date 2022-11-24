<?php require_once('header.php'); ?>

<?php

// Testimonial information
if (isset($_POST['update_tinfo_form'])) {
  try {
    if (empty($_POST['person_name_des'])) {
      throw new Exception("Testimonial Name & Des. can not be empty!");
    }
    if (empty($_POST['person_comment'])) {
      throw new Exception('Testimonial Comment text can not be empty!');
    }

    $q = $pdo->prepare("UPDATE testimonial SET 
    person_name_des=?,
    person_comment=?
    WHERE testimonial_id=?");
    $q->execute([
      $_POST['person_name_des'],
      $_POST['person_comment'],
      $_REQUEST['id']
    ]);

    $success_message = 'Testimonial information is update successfully';
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

// Testimonial Photo
if (isset($_POST['update_tphoto_form'])) {
  // Requeired input field validation
  $valid = 1;
  $current_photo = isset($_POST['current_photo']) ? $_POST['current_photo'] : '';
  $path = $_FILES['person_photo']['name'];
  $path_tmp = $_FILES['person_photo']['tmp_name'];

  // Check error
  if (empty($path)) {
    $valid = 0;
    $error_message = 'You must have to slect a photo ( If you want to update it )';
  } else {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $path_tmp);
    if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
      $valid = 0;
      $error_message = 'Only jpg, png and gif file are allowed for Testimonial photo <br>';
    }
  }

  if ($valid == 1) {
    // Set image extenstion
    if ($mime == 'image/jpeg') {
      $ext = 'jpg';
    } elseif ($mime == 'image/png') {
      $ext = 'png';
    } elseif ($mime == 'image/gif') {
      $ext = 'gif';
    }

    // remove the execisting image
    unlink('../uploads/testimonial/' . $current_photo);

    // Uploaded photo name with extention
    $final_name = 'testimonial_' . $_REQUEST['id'] . '.' . $ext;

    // Upload the photo location
    // move_uploaded_file($path_tmp, '../uploads/testimonial/' . $final_name);
    $source_image = $path_tmp;
    $destination = '../uploads/testimonial/' . $final_name;
    image_handler($path_tmp, $destination, 100, 100, 100);

    // Update query 
    $q = $pdo->prepare("UPDATE testimonial SET person_photo=? WHERE testimonial_id=?");
    $q->execute([$final_name, $_REQUEST['id']]);
    $success_message = 'Testimonial photo is update successfully';
  }
}


// exeisting slider info
$q = $pdo->prepare("SELECT * FROM testimonial WHERE testimonial_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $person_name_des = $row['person_name_des'];
  $person_comment = $row['person_comment'];
  $person_photo = $row['person_photo'];
}

?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Edit Testimonial</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Testimonial Form Elements
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
        <ul class="nav nav-tabs">
          <li class="active"><a href="#information" data-toggle="tab">Informations</a>
          </li>
          <li><a href="#photo" data-toggle="tab">Photo</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade in active" id="information">
            <form class="form-horizontal" action="" method="post">

              <!-- Person Name & Designation -->
              <div class="form-group">
                <label for="person_name_des" class="col-sm-2 control-label">Name & Designation *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="person_name_des" name="person_name_des" value="<?php echo $person_name_des; ?>">
                </div>
              </div>

              <!-- Person Comment -->
              <div class="form-group">
                <label for="person_comment" class="col-sm-2 control-label">Comment *</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="person_comment" id="person_comment"><?php echo $person_comment; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="update_tinfo_form">Update</button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="photo">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="current_photo" value="<?php echo $person_photo; ?>">

              <!-- person photo -->
              <div class="form-group">
                <label class="col-sm-2 control-label">Existing Photo</label>
                <div class="col-sm-10">
                  <img src="../uploads/testimonial/<?php echo $person_photo; ?>" alt="" style="width:100px">
                </div>
              </div>
              <!-- Slider Button URL -->
              <div class="form-group">
                <label for="person_photo" class="col-sm-2 control-label">Change the Slider Photo</label>
                <div class="col-sm-10">
                  <input type="file" name="person_photo" id="person_photo">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="update_tphoto_form">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>

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