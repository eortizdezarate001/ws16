<?php
  session_start();
  include('security.php');
  if($_SESSION['user-email'] !== 'web000@ehu.es'){
    header("Location: layout.php");
  }
  include('connect.php');


  $question = mysqli_real_escape_string($connect,$_POST['question']);
  $number = mysqli_real_escape_string($connect,$_POST['number']);
  $answer = mysqli_real_escape_string($connect,$_POST['answer']);
  if(isset($_POST['difficulty'])){
    $difficulty = mysqli_real_escape_string($connect,$_POST['difficulty']);
  } else {
    $difficulty = '';
  }

  $sql = "SELECT * FROM galderak WHERE `Number`='$number'";
  $query = mysqli_query($connect,$sql);
  $row=mysqli_fetch_array($query,MYSQLI_ASSOC);

  if($question !== $row['Question']){
    $update = "UPDATE galderak SET Question='$question' WHERE `Number`='$number'";
    $updatequery = mysqli_query($connect,$update);
  }
  if($answer !== $row['Answer']){
    $update = "UPDATE galderak SET Answer='$answer' WHERE `Number`='$number'";
    $updatequery = mysqli_query($connect,$update);
  }
  if(isset($_POST['difficulty']) && $difficulty !== $row['Difficulty']){
    $update = "UPDATE galderak SET Difficulty='$difficulty' WHERE `Number`='$number'";
    $updatequery = mysqli_query($connect,$update);
  }

  mysqli_free_result($query);
  mysqli_close($connect);

  echo "edited";

?>
