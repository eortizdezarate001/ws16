<?php
  if(isset($_SESSION['auth'])){
    if($_SESSION['auth'] == "YES"){
      echo "<p align='right'>Hello, ".$_SESSION['user-firstname']." ".$_SESSION['user-lastname']." | <a href='layout.php'>Home</a> (<a href='logout.php'>logout</a>)</p>";
    }
  } else{
    header('Location: layout.php');
    exit();
  }

 ?>
