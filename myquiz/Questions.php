<?php
  session_start();
  include('connect.php');

  $sql = "SELECT * FROM tests ORDER BY ID";
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
    <title>Quizes and questions</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <style>
      a#testname:hover, a#testname:active, a#testname:link, a#testname:visited {
  			text-decoration: none;
  		}
      .panel-body {
        padding: 10px;
        padding-bottom: 0px;
      }
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
  					<?php if(isset($_SESSION['auth'])){ ?>
            <li class="dropdown active">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span> Quizes
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Questions.php">See all quizes</a></li>
                <li><a href="createQuiz.php">Create quiz</a></li>
                <li><a href="handlingQuizes.php">Handle quizes</a></li>
                <li><a href="insertQuestion.php">Insert question</a></li>
                <?php if(isset($_SESSION['auth']) && $_SESSION['user-email']==='web000@ehu.es'){ ?>
                  <li><a href="reviewingQuizes.php">Review quizes</a></li>
                <?php } ?>
              </ul>
            </li>
            <?php if($_SESSION['user-email'] === 'web000@ehu.es'){ ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Users
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="users.php">Registered users</a></li>
                <li><a href="getUserInform.php">Get user information</a></li>
              </ul>
            </li>
            <?php } else{ ?>
            <li><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
            <?php }} ?><li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
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
  	              <li><a href="changePassword.php">Change password</a></li>
  	              <li><a href="logout.php">Logout</a></li>
  	            </ul>
  	          </li>
  	          <?php } ?>
  	      </ul>
  	    </div>
  	  </div>
  	</nav>

    <div class="container">
      <div class="jumbotron text-center">
  			<h1>Quizes and questions</h1>
  		</div>
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="panel-group" id="accordion">
            <?php while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){ ?>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="<?php echo "#collapse".$row['ID']; ?>" class="btn-block" id="testname"><?php echo $row['Name']; ?></a>
                    </h4>
                  </div>
                  <div id="<?php echo "collapse".$row['ID']; ?>" class="panel-collapse collapse">
                    <div class="panel-body table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                          <th>Question</th>
                          <th width="10%">Difficulty</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qsql = "SELECT * FROM galderak WHERE TestID='$row[ID]'";
                            $qquery = mysqli_query($connect,$qsql);
                            while($qrow=mysqli_fetch_array($qquery,MYSQLI_ASSOC)){
                              echo "<tr>";
                              echo "<td>".$qrow['Question']."</td>";
                              echo "<td>".$qrow['Difficulty']."</td>";
                              echo "</tr>";
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              <?php }
              mysqli_free_result($query);
              mysqli_close($connect);
             ?>
        </div>
      </div>
    </div>
  </body>
</html>
