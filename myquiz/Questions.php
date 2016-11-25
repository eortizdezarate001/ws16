<?php
  session_start();
  include('connect.php');

  $sql = "SELECT * FROM galderak";
  $query = mysqli_query($connect,$sql);

  $type = "Check questions";
  $date = date ("Y-m-d H:i:s");
  $ip = $_SERVER['REMOTE_ADDR'];

  if(isset($_SESSION['user-email'])){
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
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <style>
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
    <link rel="stylesheet" href="./css/style.css"/>
    <script src="./js/jquery-3.1.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse" style="border-radius:0px">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="layout.php">Quizes</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="layout.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li class="dropdown active">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Questions.php">Show questions</a></li>
                <?php if(isset($_SESSION['auth'])){ ?>
                  <li><a href="handlingQuizes.php">Handle questions</a></li>
                <?php } ?>
                <?php if(isset($_SESSION['auth']) && $_SESSION['user-email']==='web000@ehu.es'){ ?>
                  <li><a href="reviewingQuizes.php">Review questions</a></li>
                <?php } ?>
              </ul>
            </li>
            <li><a href="getUserInform.php">Get user information</a></li>
            <li><a href="credits.html"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(!isset($_SESSION['auth'])){ ?>
              <li><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li><a href="SignIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } else if(isset($_SESSION['auth'])){ ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
                <?php echo $_SESSION['user-firstname'].' '.$_SESSION['user-lastname']; ?>
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Settings</a></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>
              </li>
              <?php } ?>
          </ul>
        </div>
      </div>
    </nav>

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
