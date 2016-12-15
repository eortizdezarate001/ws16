<?php
  session_start();
  include('security.php');
  if($_SESSION['user-email'] !== 'web000@ehu.es'){
    header("Location: layout.php");
  }
  include('connect.php');


  $firstname = mysqli_real_escape_string($connect,$_POST['firstname']);
  $lastname = mysqli_real_escape_string($connect,$_POST['lastname']);
  $email = mysqli_real_escape_string($connect,$_POST['email']);
  $phone = mysqli_real_escape_string($connect,$_POST['phone']);
  $specialty = mysqli_real_escape_string($connect,$_POST['specialty']);

  $sql = "SELECT * FROM erabiltzailea WHERE Email = '$email' limit 1";
  $query = mysqli_query($connect,$sql);
  $row=mysqli_fetch_array($query,MYSQLI_ASSOC);

  if($firstname !== $row['First name']){
    $update = "UPDATE erabiltzailea SET `First name`='$firstname' WHERE `Email`='$email'";
    $updatequery = mysqli_query($connect,$update);
  }
  if($lastname !== $row['Last name']){
    $update = "UPDATE erabiltzailea SET `Last name`='$lastname' WHERE `Email`='$email'";
    $updatequery = mysqli_query($connect,$update);
  }
  if($phone !== $row['Phone']){
    $update = "UPDATE erabiltzailea SET `Phone`='$phone' WHERE `Email`='$email'";
    $updatequery = mysqli_query($connect,$update);
  }
  if($specialty !== $row['Specialty']){
    $update = "UPDATE erabiltzailea SET `Specialty`='$specialty' WHERE `Email`='$email'";
    $updatequery = mysqli_query($connect,$update);
  }

  mysqli_free_result($query);
  mysqli_close($connect);

  echo "edited";

?>
