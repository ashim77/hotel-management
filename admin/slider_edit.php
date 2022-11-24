<?php require_once('header.php'); ?>

<?php
// Slider information
if (isset($_POST['update_sinfo_form'])) {

  $q = $pdo->prepare("UPDATE slider SET 
slider_title=?,
slider_subtitle=?,
slider_button_text=?,
slider_button_url=?
WHERE slider_id=?
");
  $q->execute([
    $_POST['slider_title'],
    $_POST['slider_subtitle'],
    $_POST['slider_button_text'],
    $_POST['slider_button_url'],
    $_REQUEST['id']
  ]);

  $success_message = 'Slider information is update successfully';
}

// Slider Photo
if (isset($_POST['update_sphoto_form'])) {
  // Requeired input field validation
  $valid = 1;
  $current_photo = isset($_POST['current_photo']) ? $_POST['current_photo'] : '';
  $path = $_FILES['slider_photo']['name'];
  $path_tmp = $_FILES['slider_photo']['tmp_name'];

  // Check error
  if (empty($path)) {
    $valid = 0;
    $error_message = 'You must have to slect a photo ( If you want to update it )';
  } else {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $path_tmp);
    if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
      $valid = 0;
      $error_message = 'Only jpg, png and gif file are allowed for slider photo <br>';
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
    unlink('../uploads/' . $current_photo);

    // Uploaded photo name with extention
    $final_name = 'slider_' . $_REQUEST['id'] . '.' . $ext;

    // Upload the photo location
    move_uploaded_file($path_tmp, '../uploads/' . $final_name);

    // Update query 
    $q = $pdo->prepare("UPDATE slider SET slider_photo=? WHERE slider_id=?");
    $q->execute([$final_name, $_REQUEST['id']]);
    $success_message = 'Slider photo is update successfully';
  }
}

// exeisting slider info
$q = $pdo->prepare("SELECT * FROM slider WHERE slider_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $slider_title = $row['slider_title'];
  $slider_subtitle = $row['slider_subtitle'];
  $slider_button_text = $row['slider_button_text'];
  $slider_button_url = $row['slider_button_url'];
  $slider_photo = $row['slider_photo'];
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
        Slider Form Elements
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
              <!-- Slider Title -->
              <div class="form-group">
                <label for="slider_title" class="col-sm-2 control-label">Slider Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="slider_title" name="slider_title" value="<?php echo $slider_title; ?>">
                </div>
              </div>
              <!-- Slider Sub Title -->
              <div class="form-group">
                <label for="slider_subtitle" class="col-sm-2 control-label">Slider Sub Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="slider_subtitle" name="slider_subtitle" value="<?php echo $slider_subtitle; ?>">
                </div>
              </div>
              <!-- Slider Button Text -->
              <div class="form-group">
                <label for="slider_button_text" class="col-sm-2 control-label">Slider Button Text</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="slider_button_text" name="slider_button_text" value="<?php echo $slider_button_text; ?>">
                </div>
              </div>
              <!-- Slider Button URL -->
              <div class="form-group">
                <label for="slider_button_url" class="col-sm-2 control-label">Slider Button URL</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="slider_button_url" name="slider_button_url" value="<?php echo $slider_button_url; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="update_sinfo_form">Update</button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="photo">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="current_photo" value="<?php echo $slider_photo; ?>">
              <!-- Slider Sub Title -->
              <div class="form-group">
                <label for="slider_subtitle" class="col-sm-2 control-label">Existing Photo</label>
                <div class="col-sm-10">
                  <img src="../uploads/<?php echo $slider_photo; ?>" alt="" style="width:200px">
                </div>
              </div>
              <!-- Slider Button URL -->
              <div class="form-group">
                <label for="slider_photo" class="col-sm-2 control-label">Change the Slider Photo</label>
                <div class="col-sm-10">
                  <input type="file" name="slider_photo" id="slider_photo">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="update_sphoto_form">Update</button>
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