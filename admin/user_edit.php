<?php require_once('header.php'); ?>

<?php
// Slider information
if (isset($_POST['edit_user_from'])) {
  try {
    if (empty($_POST['user_full_name'])) {
      throw new Exception("Name can not be empty!");
    }
    if (empty($_POST['user_email'])) {
      throw new Exception('Email Address can not be empty!');
    }
    if (empty($_POST['role_id'])) {
      throw new Exception('Role can not be empty!');
    }

    $q = $pdo->prepare("UPDATE user SET 
    user_full_name=?,
    user_email=?,
    role_id=?
    WHERE user_id=?");
    $q->execute([
      $_POST['user_full_name'],
      $_POST['user_email'],
      $_POST['role_id'],
      $_REQUEST['id']
    ]);

    $success_message = 'User information is update successfully';
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

// exeisting slider info
$q = $pdo->prepare("SELECT * FROM user WHERE user_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $user_full_name = $row['user_full_name'];
  $user_email = $row['user_email'];
  $user_password = $row['user_password'];
  $role_id = $row['role_id'];
}
?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Edit User</h1>
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

        <ul class="nav nav-tabs">
          <li class="active"><a href="#changedata" data-toggle="tab">Change Data</a>
          </li>
          <li><a href="#changepassword" data-toggle="tab">Change Password</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade in active" id="changedata">

            <form class="form-horizontal" action="" method="post">

              <!-- User Full Name -->
              <div class="form-group">
                <label for="user_full_name" class="col-sm-2 control-label">Full Name *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="user_full_name" name="user_full_name" value="<?php echo $user_full_name ?>">
                </div>
              </div>

              <!-- User Email Address -->
              <div class="form-group">
                <label for="user_email" class="col-sm-2 control-label">Email Address *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="user_email" name="user_email" value="<?php echo $user_email ?>">
                </div>
              </div>

              <!-- Select Role -->
              <div class="form-group">
                <label for="role_id" class="col-sm-2 control-label">Select Role *</label>
                <div class="col-sm-10">
                  <select name="role_id" id="role_id" class="form-control">
                    <?php
                    $q = $pdo->prepare("SELECT * FROM role WHERE role_id != ? AND role_id != ? ORDER BY role_id ASC");
                    $q->execute([1, 2]);
                    $res = $q->fetchAll();
                    foreach ($res as $row) {
                    ?>
                      <option value="<?php echo $row['role_id']; ?>" <?php if ($row['role_id'] == $role_id) {
                                                                        echo 'selected';
                                                                      } ?>>
                        <?php echo $row['role_name']; ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="edit_user_from">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="changepassword">
            <form class="form-horizontal" action="" method="post">

              <!-- New Password -->
              <div class="form-group">
                <label for="new_password" class="col-sm-2 control-label">New Password *</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="new_password" name="new_password">
                </div>
              </div>

              <!-- Retype Password -->
              <div class="form-group">
                <label for="retype_password" class="col-sm-2 control-label">Re-type Password *</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="retype_password" name="retype_password">
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="edit_user_password">Submit</button>
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