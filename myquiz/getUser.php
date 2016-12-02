<?php
  include('connect.php');

  $email = mysqli_real_escape_string($connect,$_POST['email']);

  $sql = "SELECT * FROM erabiltzailea WHERE Email='$email'";
  $query = mysqli_query($connect,$sql);
  $user = mysqli_fetch_array($query,MYSQLI_ASSOC);

  $xml = new SimpleXMLElement("<erabiltzailea></erabiltzailea>");
  $xml->addChild("email",$user['Email']);
  $xml->addChild("firstname",$user['First name']);
  $xml->addChild("lastname",$user['Last name']);
  $xml->addChild("phone",$user['Phone']);

  echo $xml->asXML();

  mysqli_close($connect);

 ?>
