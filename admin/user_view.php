<?php require_once('header.php'); ?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">View User</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">


      <?php

      if (isset($_SESSION['d_msg'])) {
        echo '<div class="alert alert-success">' . $_SESSION['d_msg'] . '</div>';
        unset($_SESSION['d_msg']);
      }

      ?>

      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>Serial</th>
              <th>Full Name</th>
              <th>Email Address</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $q = $pdo->prepare("SELECT * FROM user JOIN role ON user.role_id = role.role_id ORDER BY user_id ASC");
            $q->execute();
            $res = $q->fetchALL();

            foreach ($res as $row) {
              $i++;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['user_full_name']; ?></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['role_name']; ?></td>
                <td>
                  <a href="user_edit.php?id=<?php echo $row['role_id']; ?>" class="btn btn-xs btn-warning">Edit</a>
                  <?php if ($row['role_id'] != 1 && $row['role_id'] != 2) : ?>
                    <a href="user_delete.php?id=<?php echo $row['role_id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<?php require_once('footer.php'); ?>