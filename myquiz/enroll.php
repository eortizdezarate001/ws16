<?php
  //$connect = mysqli_connect("localhost","root","", "quiz");
  $connect = mysqli_connect("mysql.hostinger.es","u102514866_eneko","eortizdezarate001","u102514866_quiz");

  if(empty($_POST['email'])){
    die('ERROR: Email must not be empty.');
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
