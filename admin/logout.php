<?php
ob_start();
session_start();
// Database connection
require_once('db.php');
require_once('functions.php');

unset($_SESSION['user']);

header('location: login.php');
