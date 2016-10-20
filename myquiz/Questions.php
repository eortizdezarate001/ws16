<?php
  session_start();
  //$connect = mysqli_connect("localhost","root","", "quiz");
  $connect = mysqli_connect("mysql.hostinger.es","u102514866_eneko","eortizdezarate001","u102514866_quiz");

  $sql = "SELECT * FROM galderak";
  $query = mysqli_query($connect,$sql);

  $type = "Check questions";
  $date = date ("Y-m-d H:i:s");
  $ip = $_SERVER['REMOTE_ADDR'];

  if(isset($_SESSION['user-email'])){
    echo "<p align='right'>Hello, ".$_SESSION['user-firstname']." ".$_SESSION['user-lastname']." | <a href='layout.html'>Home</a> (<a href='logout.php'>logout</a>)</p>";
    $connection = (int)$_SESSION['user-connection'];
    $email = "'".$_SESSION['user-email']."'";
    $sql2 = "INSERT INTO ekintzak VALUES(0, $connection, $email, '$type', '$date', '$ip')";
  } else{
    $sql2 = "INSERT INTO ekintzak (`Type`, `Time`, `IP`) VALUES('$type', '$date', '$ip')";
  }
  $query2 = mysqli_query($connect,$sql2);
  if (!$query2){
    die('ERROR at query execution:' . mysqli_error($connect));
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Questions</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
    <style>
      body  {font-family: 'Roboto', sans-serif; font-weight: 400;}
      a:link, a:visited{color: #0772C6; text-decoration:none}
      table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
      }

      td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
      }

      tr:nth-child(even) {
          background-color: #dddddd;
      }
</style>
  </head>
  <body>
    <table>
      <tr>
        <th>Question</th>
        <th>Difficulty</th>
      </tr>
      <?php
        while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
          echo "<tr>";
          echo "<td>".$row['Question']."</td>";
          echo "<td>".$row['Difficulty']."</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </body>
</html>
