<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
  <title>Quizzes</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/style.css" />
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
          <li class="active"><a href="layout.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
          <?php if(isset($_SESSION['auth'])){ ?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span> Questions
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="Questions.php">Show questions</a></li>
              <li><a href="handlingQuizes.php">Handle questions</a></li>
              <?php if(isset($_SESSION['auth']) && $_SESSION['user-email']==='web000@ehu.es'){ ?>
                <li><a href="reviewingQuizes.php">Review questions</a></li>
              <?php } ?>
            </ul>
          </li>
          <li><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
          <?php } ?>
          <li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
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
  <div class="container" style="margin-top: 150px;">
    <div class="jumbotron text-center">
      <h1>Quiz: crazy questions</h1>
    </div>
  </div>
  <footer>
    <div class="navbar navbar-inverse navbar-fixed-bottom" style="border-radius:0px">
      <div class="container">
          <div class="navbar-collapse collapse" id="footer-body">
              <ul class="nav navbar-nav navbar-right">
                  <li><a href='https://github.com/eortizdezarate001/ws16' target="_blank">Github</a></li>
              </ul>
          </div>
        </div>
    </div>
  </footer>
</body>
</html>
