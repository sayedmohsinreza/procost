<?php
ob_start();
// Inialize session
include('connect.php');
include('include.php');
session_start();



// Delete certain session
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['password']);
//session_destroy();
// Delete all session variables
// session_destroy();
// Jump to login page
header('Location: login.php');
exit;
?>