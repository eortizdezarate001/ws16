<?php
  include("connect.php");

  if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  } else{
    $image = "";
  }

  $email = mysqli_real_escape_string($connect,$_POST['email']);
  $firstname = mysqli_real_escape_string($connect,$_POST['firstname']);
  $lastname = mysqli_real_escape_string($connect,$_POST['lastname']);
  $password = mysqli_real_escape_string($connect,$_POST['password']);
  $phone = mysqli_real_escape_string($connect,$_POST['phone']);
  $interests = mysqli_real_escape_string($connect,$_POST['interests']);

  if($_POST['specialty'] == 'Others'){
    $spec = $_POST['others'];
  } else{
    $spec = $_POST['specialty'];
  }

  if(empty($email){
    die('ERROR: Email must not be empty.');
  }
  if(filter_var($email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[a-z]*[0-9]{3}@ikasle\.ehu\.e(u?)s/"))) === false) {
    die('$email is not a valid email address');
  }
  if(filter_var($firstname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[A-ZÁÉÍÓÚÑ][A-Za-z\sáéíóúüñ]+/"))) === false){
    die('First name - syntax error.');
  }
  if(filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[A-ZÁÉÍÓÚÑ][A-Za-z\sáéíóúüñ]+/"))) === false){
    die('Last name - syntax error.');
  }
  if(filter_var($phone, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[0-9]{9}/"))) === false){
    die('Invalid phone number.');
  }
  if(strlen($password)<6){
    die('Password length must be higher than 6.');
  }


  $sql = "INSERT INTO erabiltzailea
          VALUES ('$firstname','$lastname','$email','$password','$phone','$spec','$interests','$image')";
  $query = mysqli_query($connect,$sql);
  if (!$query){
    die('ERROR at query execution:' . mysqli_error($connect));
  }

  echo "One row was added to the database.";
  echo "<p><a href='ShowUsersWithImage.php'>Click here to check it out.</a></p>";

  mysqli_close($connect);
?>
