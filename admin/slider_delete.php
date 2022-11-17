<?php require_once('header.php');

if (!isset($_REQUEST['id'])) {
  header('location: index.php');
  exit;
} else {
  if (!is_numeric($_REQUEST['id'])) {
    header('location: index.php');
    exit;
  } else {
    $q = $pdo->prepare("SELECT * FROM slider WHERE slider_id=?");
    $q->execute([$_REQUEST['id']]);
    $total = $q->rowCount();

    if (empty($total)) {
      header('location: index.php');
      exit;
    }
  }
}

//find the selected photo
$q = $pdo->prepare("SELECT * FROM slider WHERE slider_id=?");
$q->execute([$_REQUEST['id']]);
$result = $q->fetchALL();

foreach ($result as $row) {
  $slider_photo = $row['slider_photo'];
}

unlink('../uploads/' . $slider_photo);

$q = $pdo->prepare("DELETE FROM slider WHERE slider_id=?");
$q->execute([$_REQUEST['id']]);

header('location: slider_view.php');
