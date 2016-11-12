<?php
  session_start();
  include('security.php');
  include('connect.php');

  $myemail = mysqli_real_escape_string($connect,$_SESSION['user-email']);
  $sql1 = "SELECT COUNT(*) FROM galderak WHERE Email='$myemail'";
  $query1 = mysqli_query($connect,$sql1);
  $myquestions = mysqli_fetch_row($query1);
  echo $myquestions[0];

  echo "/";

  $sql2 = "SELECT COUNT(*) FROM galderak";
  $query2 = mysqli_query($connect,$sql2);
  $allquestions = mysqli_fetch_row($query2);
  echo $allquestions[0];

  mysqli_close($connect);
  exit;
?>
