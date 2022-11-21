<?php require_once('header.php');

if (!isset($_REQUEST['id'])) {
  header('location: index.php');
  exit;
} else {
  if (!is_numeric($_REQUEST['id'])) {
    header('location: index.php');
    exit;
  } else {
    $q = $pdo->prepare("SELECT * FROM feature WHERE feature_id=?");
    $q->execute([$_REQUEST['id']]);
    $total = $q->rowCount();

    if (empty($total)) {
      header('location: index.php');
      exit;
    }
  }
}

$q = $pdo->prepare("DELETE FROM feature WHERE feature_id=?");
$q->execute([$_REQUEST['id']]);

$_SESSION['d_msg'] = 'Feature item is delete successfully!';

header('location: feature_view.php');
