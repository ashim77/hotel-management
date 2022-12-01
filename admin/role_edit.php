<?php require_once('header.php'); ?>

<?php

if (isset($_POST['update_role_form'])) {
  try {
    if (empty($_POST['role_name'])) {
      throw new Exception("role title can not be empty!");
    }

    $q = $pdo->prepare("UPDATE role SET role_name=? WHERE role_id=?");
    $q->execute([$_POST['role_name'], $_REQUEST['id']]);

    $success_message = 'Role information is update successfully';
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

// exeisting role info
$q = $pdo->prepare("SELECT * FROM role WHERE role_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();
foreach ($result as $row) {
  $role_name = $row['role_name'];
}

?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Edit Role</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        Role Form Elements
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
          <!-- Role Name -->
          <div class="form-group">
            <label for="role_name" class="col-sm-2 control-label">Role Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo $role_name; ?>">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary" name="update_role_form">Update</button>
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