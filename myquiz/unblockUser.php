<?php
  session_start();
  include('security.php');
  if($_SESSION['user-email'] !== 'web000@ehu.es'){
    header("Location: layout.php");
  }
  include('connect.php');

  $email = mysqli_real_escape_string($connect,$_POST['email']);
  $sql = "UPDATE erabiltzailea SET Attempts=0 WHERE `Email`='$email'";
  $query = mysqli_query($connect,$sql);
  echo "unblocked";
?>
