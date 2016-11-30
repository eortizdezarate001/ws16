<?php session_start(); include ("security.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Change Password</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<style type="text/css">
    #output {
      color: #ee0000;
    }
    .form-group{
      margin-bottom: 10px;
    }
    .form-control {
      border: 1px solid #000;
    }
	</style>
  <link rel="stylesheet" href="./css/style.css" />
  <script type="text/javascript">
    function password(){
      $('#output').html("<br>");
      if($('#pass').val() == "" || $('#pass2').val() == ""){
        $('#output').html("<br>");
        $('#pass').css("border-color","#000");
        $('#pass2').css("border-color","#000");
        $('#submit').prop("disabled",true);
      } else{
        $.post(
          "egiaztatuPasahitzaBez.php",
          {password : $('#pass').val()},
          function(result){
            if(result == "BALIOZKOA"){
              $('#pass').css("border-color","#000");
              if($('#pass2').val() === $('#pass').val()){
                $('#pass2').css("border-color","#000");
                $('#submit').prop("disabled",false);
              } else if($('#pass2').val() == ""){
                $('#pass2').css("border-color","#000");
                $('#submit').prop("disabled",true);
              } else{
                $('#pass').css("border-color","#cc0000");
                $('#pass2').css("border-color","#cc0000");
                $('#submit').prop("disabled",true);
                $('#output').html("Passwords aren't equal.");
              }
            } else if(result == "BALIOGABEA"){
              $('#pass').css("border-color","#cc0000");
              $('#submit').prop("disabled",true);
              $('#output').html("Your new password is too weak.");
            }
          }
        );
      }
    }
  </script>
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
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span> Questions
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
	        <li><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
	        <li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <?php if(!isset($_SESSION['auth'])){ ?>
	          <li><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
	          <li><a href="SignIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	        <?php } else if(isset($_SESSION['auth'])){ ?>
	          <li class="dropdown active">
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
			<h1>Change your password</h1>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
        <p align="center" id="output">
          <?php
            if(isset($_POST["submit"])){
              $old = $_POST['old'];
              $pass = $_POST['pass'];
              $pass2 = $_POST['pass2'];
              $email = $_SESSION['user-email'];
              $encOld = sha1($old);
              $encNew = sha1($pass);
              if(empty($old) || empty($pass2) || empty($pass)){
                echo "Some fields are empty.";
              } else{
                include("connect.php");
                $sql = "SELECT * FROM erabiltzailea WHERE Email = '$email' AND Password = '$encOld'";
                $query = mysqli_query($connect,$sql);
                $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
                $count = mysqli_num_rows($query);
                if($count == 1){
                  $sql2 = "UPDATE erabiltzailea SET Password = '$encNew' WHERE Email = '$email'";
                  $ema2=mysqli_query($connect, $sql2);
                  if(!$ema2){
                    echo "ERROR.";
                  } else{
                    echo "<font color='#00cc00'>Your password was successfully changed.</font>";
                  }
                } else if($count == 0){
                  echo "You inserted the wrong password.";
                }
                mysqli_free_result($query);
                mysqli_close($connect);
              }
            } else{echo "<br>";}

           ?>
        </p>
				<form id="change-password" name="change-password" method="post" action="changePassword.php">
					<div class="form-group">
						<input type="password" name="old" id="old" class="form-control" placeholder="Old password" required>
					</div>
					<div class="form-group">
						<input type="password" name="pass" id="pass" class="form-control" placeholder="New password" required onchange="password()">
					</div>
					<div class="form-group">
						<input type="password" name="pass2" id="pass2" class="form-control" placeholder="New password" required onchange="password()">
					</div>
					<input class="btn btn-primary btn-block" type="submit" id="submit" name="submit" value="Change password" disabled>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
