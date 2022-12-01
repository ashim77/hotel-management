<?php
require_once('header.php');

$q = $pdo->prepare("SELECT * FROM role WHERE role_id=?");
$q->execute([$_REQUEST['id']]);
$res = $q->fetchALL();
foreach ($res as $row) {
  $role_name = $row['role_name'];
}
?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Setup Role for <?php echo $role_name; ?></h1>
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

      </div>
    </div>
  </div>
</div>
</div>
<?php require_once('footer.php'); ?>