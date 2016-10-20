<?php
  include("connect.php");

  if(empty($_POST['email'])){
    die('ERROR: Email must not be empty.');
  }

  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    echo("$_POST['email'] is not a valid email address");
  }

  if($_POST['specialty'] == 'Others'){
    $spec = $_POST['others'];
  } else{
    $spec = $_POST['specialty'];
  }

  $sql = "INSERT INTO erabiltzailea
          VALUES ('$_POST[firstname]','$_POST[lastname]','$_POST[email]','$_POST[password]','$_POST[phone]','$spec','$_POST[interests]')";
  $query = mysqli_query($connect,$sql);
  if (!$query){
    die('ERROR at query execution:' . mysqli_error($connect));
  }

  echo "One row was added to the database.";
  echo "<p><a href='ShowUsers.php'>Click here to check it out.</a></p>";

  mysqli_close($connect);
?>
