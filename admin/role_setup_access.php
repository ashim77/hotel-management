<?php
require_once('header.php');

$q = $pdo->prepare("SELECT * FROM role WHERE role_id=?");
$q->execute([$_REQUEST['id']]);
$res = $q->fetchALL();
foreach ($res as $row) {
  $role_name = $row['role_name'];
}

if (isset($_POST['role_setup_update'])) {
  foreach ($_POST['role_access_ids'] as $val) {
    $arr1[] = $val;
  }
  foreach ($_POST['access_status_arr'] as $val) {
    $arr2[] = $val;
  }

  for ($i = 0; $i < count($arr1); $i++) {
    // echo $arr1[$i] . '-';
    // echo $arr2[$i] . '<br>';

    $u = $pdo->prepare('UPDATE role_access SET access_status=? WHERE role_access_id=?');
    $u->execute([$arr2[$i], $arr1[$i]]);
  }
}

?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Setup Role For <?php echo $role_name; ?></h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <form action="" method="post">
      <?php
      $i = 0;
      $q = $pdo->prepare("SELECT * FROM role_access t1 JOIN pages t2 ON t1.page_id = t2.page_id WHERE role_id=?");
      $q->execute([$_REQUEST['id']]);
      $res = $q->fetchALL();
      foreach ($res as $row) {
        $i++;
      ?>
        <input type="hidden" name="role_access_ids[<?php echo $i; ?>]" value="<?php echo $row['role_access_id']; ?>">
        <input type="hidden" name="access_status_arr[<?php echo $i; ?>]" value="0">
        <input type="checkbox" name="access_status_arr[<?php echo $i; ?>]" value="1" <?php if ($row['access_status'] == 1) {
                                                                                        echo 'checked';
                                                                                      } ?>>
        <?php echo $row['page_title']; ?><br>
      <?php

      }
      ?>
      <br>
      <input type="submit" value="Update" name="role_setup_update">
    </form>
  </div>
</div>
</div>
<?php require_once('footer.php'); ?>