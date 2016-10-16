<?php
  session_start();
  if(isset($_SESSION['user-email'])){
    session_unset();
    session_destroy();
    header("Location: layout.html");
    exit;
  } else{
    header("Location: layout.html");
    exit;
  }
?>
