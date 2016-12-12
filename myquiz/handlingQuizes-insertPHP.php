<?php
  session_start();
  include('security.php');
  include('connect.php');

  $test = mysqli_real_escape_string($connect,$_POST['test']);
  $question = mysqli_real_escape_string($connect,$_POST['question']);
  $answer = mysqli_real_escape_string($connect,$_POST['answer']);
  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);

  $testsql = "SELECT ID FROM tests WHERE Name = '$test'";
  $testquery = mysqli_query($connect,$testsql);
  $testresult = mysqli_fetch_array($testquery,MYSQLI_ASSOC);
  $testid = $testresult['ID'];

  if($_POST['difficulty']!==''){
    $difficulty = $_POST['difficulty'];
    $sql = "INSERT INTO galderak VALUES (0,'$question','$answer','$_POST[difficulty]', '$testid')";
  } else{
    $difficulty = "";
    $sql = "INSERT INTO galderak VALUES (0,'$question','$answer', NULL, '$testid')";
  }
  $query = mysqli_query($connect,$sql);
  if (!$query){
    die('ERROR at query execution:' . mysqli_error($connect));
  }

  echo "Your question was added successfully.<br>";
  echo "<a href='Questions.php'>See all questions.</a>";

  // EKINTZA
  $connection = (int)$_SESSION['user-connection'];
  $type = "Insert question";
  $date = date ("Y-m-d H:i:s");
  $ip = $_SERVER['REMOTE_ADDR'];

  $sql2 = "INSERT INTO ekintzak VALUES(0, $connection, '$email', '$type', '$date', '$ip')";
  $query2 = mysqli_query($connect,$sql2);
  if (!$query2){
    die('ERROR at query execution:' . mysqli_error($connect));
  }
  mysqli_close($connect);
  exit;
?>
