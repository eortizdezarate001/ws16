<?php
  session_start();
  if(isset($_SESSION['user-email'])){
    session_unset();
    session_destroy();
    header("Location: layout.php");
    exit;
  } else{
    header("Location: layout.php");
    exit;
  }
?>
