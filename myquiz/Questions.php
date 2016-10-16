<?php
  //$connect = mysqli_connect("localhost","root","", "quiz");
  $connect = mysqli_connect("mysql.hostinger.es","u102514866_eneko","eortizdezarate001","u102514866_quiz");

  $sql = "SELECT * FROM galderak";
  $query = mysqli_query($connect,$sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Questions</title>
    <style>
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
        <th>#</th>
        <th>Question</th>
        <th>Difficulty</th>
      </tr>
      <?php
        while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
          echo "<tr>";
          echo "<td>".$row['Number']."</td>";
          echo "<td>".$row['Question']."</td>";
          echo "<td>".$row['Difficulty']."</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </body>
</html>
