<?php
  include('connect.php');
  $sql = "SELECT * FROM erabiltzailea";
  $query = mysqli_query($connect,$sql);

  echo "<p><a href='layout.php'>Home</a></p>";

  echo "<h1 align=center>Quiz database: Erabiltzaileak</h1>";

  echo "<table border=2 align=center cellpadding=5>
        <tr><th>First name</th><th>Last name</th><th>Email</th><th>Phone</th><th>Specialty</th><th>Interests</th><th>Image</th></tr>";
  while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if(empty($row['Image'])){
      echo '<tr><td>'.$row['First name'].'</td><td>'.$row['Last name'].'</td><td>'.$row['Email'].'</td><td>'.$row['Phone'].'</td><td>'.$row['Specialty'].'</td><td>'.$row['Interests'].'</td><td></td></tr>';
    } else{
      echo '<tr><td>'.$row['First name'].'</td><td>'.$row['Last name'].'</td><td>'.$row['Email'].'</td><td>'.$row['Phone'].'</td><td>'.$row['Specialty'].'</td><td>'.$row['Interests'].'</td><td><img src="data:image/jpeg;base64,'.base64_encode( $row['Image'] ).'" width="300"/></td></tr>';
    }
  }
  echo '</table>';
  mysqli_free_result($query);
  mysqli_close($connect);
?>
