<?php session_start(); ?>
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
      color: #cc0000;
			margin-top: 8px;
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
					<li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
						<li><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li class="active"><a href="SignIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron text-center">
			<h1>Reset password</h1>
		</div>
		<div class="row">
      <p align="center">Introduce your email and your new password will be sent to you.</p>
			<div class="col-sm-4 col-sm-offset-4">
        <form id="reset" name="reset" method="post" action="resetPassword.php">
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
					</div>
					<input class="btn btn-primary btn-block" type="submit" id="submit" name="submit" value="Reset password">
          <p align="center" id="output">
            <?php
            if(isset($_POST['submit'])){
            	$to = $_POST['email'];
            	$subject = "New password";
            	$newPass = uniqid();
            	$enctPass = sha1($newPass);

            	$message = "
            	<html>
              	<head>
              	 <title>New password</title>
              	</head>
              	<body>
                	<p> Your password has been reset.</p>
                	<p> Use this password to login: $newPass</p>
                	<br>
                  <p> We suggest that you change your password as soon as you login.</p>
                	<br>
              	</body>
            	</html>
            	";

            	// Always set content-type when sending HTML email
            	$headers = "MIME-Version: 1.0" . "\r\n";
            	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            	// More headers
            	$headers .= 'From: Quizes <quizes@ehu.es>' . "\r\n";

            	$sentmail = mail($to,$subject,$message,$headers);

            	if($sentmail){
            		include("connect.php");
            		$sql = "SELECT * FROM erabiltzailea WHERE Email = '$to'";
            		$query = mysqli_query($connect,$sql);
            		$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            		$count = mysqli_num_rows($query);

            		if($count == 1){
            			$sql2 = "UPDATE erabiltzailea
            			SET Password = '$enctPass'
            			WHERE Email = '$to'";
            			$ema2=mysqli_query($connect, $sql2);
            			if(!$ema2)
            				die('ERROR: ' . mysqli_error($connect));

                  echo "<font color='#00cc00'>The email was sent to <strong>$to</strong>.</font>";

            		} else {
                  echo "This email does not exist in our database.";
            		}
            	} else {
                echo "The email could not be sent.";
            	}
            }
            ?>
          </p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
