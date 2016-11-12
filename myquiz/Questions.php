<?php
  include('connect.php');

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
      #header  {
        font-size: 300%; text-align: center; font-weight: 100;
        padding-top: 20px;
      }
      #question-table {margin-top: -30px;}
      a:link, a:visited{color: #0772C6; text-decoration:none}
      table	{border-collapse: collapse; width: 100%; }
	    th		{text-align: center;padding: 8px; border-bottom: 1px solid #ddd;}
	    td 		{padding: 8px; text-align: center; border-bottom: 1px solid #ddd;}
      .q {text-align: left; border-right: 1px solid #ddd;;}
	    tr:hover{background-color:#f5f5f5}
      #tr1:hover{background-color: #ffffff};
    </style>
  </head>
  <body>
    <div id="question-table">
      <h1 id='header'> Questions </h1>
      <table>
        <tr id='tr1'>
          <th width='65%'>Question</th>
          <th width='5%'>Difficulty</th>
          <th width='20%'>Subject</th>
        </tr>
        <?php
          while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td class='q'>".$row['Question']."</td>";
            echo "<td>".$row['Difficulty']."</td>";
            echo "<td>".$row['Subject']."</td>";
            echo "</tr>";
          }
        ?>
      </table>
    </div>
  </body>
</html>
