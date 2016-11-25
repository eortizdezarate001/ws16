<?php
  session_start();
  include('security.php');
  if($_SESSION['user-email'] !== 'web000@ehu.es'){
    header("Location: layout.php");
  }
  include('connect.php');

  $number = mysqli_real_escape_string($connect,$_POST['number']);
  $sql = "DELETE FROM galderak WHERE `Number`='$number'";
  $query = mysqli_query($connect,$sql);
  echo "deleted";

?>
