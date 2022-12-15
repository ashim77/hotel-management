<?php require_once('header.php');

if (!isset($_REQUEST['id'])) {
  header('location: index.php');
  exit;
} else {
  if (!is_numeric($_REQUEST['id'])) {
    header('location: index.php');
    exit;
  } else {
    $q = $pdo->prepare("SELECT * FROM role WHERE role_id=?");
    $q->execute([$_REQUEST['id']]);
    $total = $q->rowCount();

    if (empty($total)) {
      header('location: index.php');
      exit;
    }
  }
}

// Delete from role table
$q = $pdo->prepare("DELETE FROM role WHERE role_id=?");
$q->execute([$_REQUEST['id']]);

// Delete from role access table
$q = $pdo->prepare("DELETE FROM role_access WHERE role_id=?");
$q->execute([$_REQUEST['id']]);

// Delete from user table
$q = $pdo->prepare("DELETE FROM user WHERE role_id=?");
$q->execute([$_REQUEST['id']]);

$_SESSION['d_msg'] = 'Role item is delete successfully!';

header('location: role_view.php');
