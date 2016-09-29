<?php
  //$connect = mysqli_connect("localhost","root","", "quiz");
  $connect = mysqli_connect("mysql.hostinger.es","u102514866_eneko","eortizdezarate001","u102514866_quiz");
  $sql = "INSERT INTO Erabiltzailea
          VALUES ('$_POST[firstname]','$_POST[lastname]','$_POST[email]','$_POST[password]','$_POST[phone]','$_POST[specialty]','$_POST[interests]')";
  $query = mysqli_query($connect,$sql);
  if (!$query){
    die('ERROR at query execution:' . mysqli_error($connect));
  }

  echo "One row was added to the database.";
  echo "<p><a href='ShowUsers.php'>Click here to check out the database.</a></p>";

  mysqli_close($connect);
?>
