<?php
  if(!isset($_SESSION['auth'])){
    header('Location: layout.html');
    exit();
  }

 ?>
