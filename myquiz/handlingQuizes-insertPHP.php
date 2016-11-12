<?php
  session_start();
  include('security.php');
  include('connect.php');

  $question = mysqli_real_escape_string($connect,$_POST['question']);
  $answer = mysqli_real_escape_string($connect,$_POST['answer']);
  $subject = mysqli_real_escape_string($connect,$_POST['subject']);
  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);
  if($_POST['difficulty']!==''){
    $difficulty = $_POST['difficulty'];
    $sql = "INSERT INTO galderak VALUES (0,'$email','$question','$answer','$subject','$_POST[difficulty]')";
  } else{
    $difficulty = "";
    $sql = "INSERT INTO galderak VALUES (0,'$email','$question','$answer','$subject', NULL)";
  }
  $query = mysqli_query($connect,$sql);
  if (!$query){
    die('ERROR at query execution:' . mysqli_error($connect));
  }

  // ADD TO XML FILE
  $file = 'galderak.xml';
  $xml = simplexml_load_file($file);

  $assessmentItem = $xml->addChild('assessmentItem');
  $assessmentItem->addAttribute('complexity', $difficulty);
  $assessmentItem->addAttribute('subject',$subject);
  $itemBody = $assessmentItem->addChild('itemBody');
  $itemBody->addChild('p',$question);
  $correctResponse = $assessmentItem->addChild('correctResponse');
  $correctResponse->addChild('value', $answer);

  $xml->asXML($file);

  echo "Your question was added successfully.<br>";
  echo "<a href='Questions.php'>See questions.</a>";

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
