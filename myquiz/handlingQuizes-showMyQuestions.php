<?php
  session_start();
  include("connect.php");

  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);

  $sql = "SELECT Question FROM galderak WHERE Email='$email'";
  $query = mysqli_query($connect,$sql);

  echo "<table><tr id=\"tr1\"><th>".$email." - Questions</th></tr>";

  while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    echo "<tr>";
    echo "<td>".$row['Question']."</td>";
    echo "</tr>";
  }
  echo "</table>";

  mysqli_close($connect);
?>
