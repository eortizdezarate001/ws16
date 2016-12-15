<?php session_start();	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign in</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<script type="text/javascript" src="functions.js" charset="utf-8"></script>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<style media="screen">
	.form-php{
		text-align: center;
		margin: 4px;
		color: #cc0000;
	}
	.btn-fb{
		color: #fff;
		background-color:#3b5998;
	}
	.btn-fb:hover{
		color: #fff;
		background-color:#496ebc
	}
	.btn-tw{
		color: #fff;
		background-color:#55acee;
	}
	.btn-tw:hover{
		color: #fff;
		background-color:#59b5fa;
	}
	.form-control {
		border: 1px solid #000;
	}
	</style>
	<link rel="stylesheet" href="./css/style.css" />
</head>
<?php
if(isset($_SESSION['user-email'])){
	die("You're already logged in. <a href='logout.php'>Log out</a> or <a href='layout.php'> go back</a>.");
} ?>
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
			<h1>Login</h1>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<!--<div class="social-buttons" align="center">
					<a href="#" class="btn btn-fb"> <i class="fa fa-facebook fa-lg" style="vertical-align: middle; padding:3px;"></i> Login with Facebook</a>
					<a href="#" class="btn btn-tw"><i class="fa fa-twitter fa-lg" style="vertical-align: middle; padding:3px;"></i> Login with Twitter</a>
				</div>-->
				<form action="SignIn.php" id="login" name="login" method="post">
	        <div class="form-php">
	          <p style="margin-bottom:5px">
	          <!-- php code -->
	          <?php
	            if(isset($_POST["submit"])){
	              include('connect.php');

							  $email = mysqli_real_escape_string($connect,$_POST['email']);
	              $password = mysqli_real_escape_string($connect,$_POST['password']);
								$enct = sha1($password);

								if(!empty($email) && !empty($password)){

									$sql5 = "SELECT Attempts FROM erabiltzailea WHERE Email = '$email' limit 1";
									$attemptsquery = mysqli_query($connect,$sql5);
									$attempts = mysqli_fetch_row($attemptsquery);

									if($attempts[0] < 3){

			              $sql = "SELECT * FROM erabiltzailea WHERE Email = '$email' AND Password = '$enct'";
			              $query = mysqli_query($connect,$sql);
			              $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
			              $count = mysqli_num_rows($query);

			              if($count == 1){
			                $_SESSION['user-email'] = $email;
			                $_SESSION['user-firstname'] = $row['First name'];
			                $_SESSION['user-lastname'] =  $row['Last name'];
											$_SESSION['auth'] = "YES";

											$date = date("Y-m-d H:i:s");
											$sql2 = "INSERT INTO konexioak VALUES (0, '$email','$date')";
											$query2 = mysqli_query($connect, $sql2);
											$sql3 = "SELECT MAX(ID) FROM konexioak WHERE Email = '$email'";
											$query3 = mysqli_query($connect,$sql3);
											$row3 = mysqli_fetch_row($query3);
											$_SESSION['user-connection'] = $row3[0];

											mysqli_query($connect,"UPDATE erabiltzailea SET Attempts = 0 WHERE Email = '$email'");

											mysqli_close($connect);
											header('Location: layout.php');
			                exit;
			              } else if($count == 0) {
			                $sql4 = "SELECT * FROM erabiltzailea WHERE Email = '$email'";
			                $query4 = mysqli_query($connect,$sql4);
			                $row4 = mysqli_fetch_array($query4,MYSQLI_ASSOC);
			                $count4 = mysqli_num_rows($query4);
			                if($count4 == 1){
			                  echo "Password is incorrect.";
			                } else{
			                  echo "This username doesn't exist.";
			                }
											if($email !== 'web000@ehu.es'){
												$tries = (int) $attempts[0]+1;
												mysqli_query($connect,"UPDATE erabiltzailea SET Attempts = '$tries' WHERE Email = '$email'");
												mysqli_close($connect);
											}
			              } else{
			                echo "Error.";
			              }
									} else {
										echo "This account has been blocked due to numerous attempts to sign in.";
									}
								}
	            } else echo "<br>";
	          ?></p>
	        </div>
					<div class="form-group">
	          <input class="form-control" type="email" name="email" id="email" placeholder="Email" required autofocus autocomplete="off">
	        </div>
	        <div class="form-group">
	          <input class="form-control" type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
	        </div>
					<div class="checkbox">
						<label><input type="checkbox"> Remember me</label>
					</div>
					<button class="btn btn-primary btn-block" size=40 type="submit" value="Submit" name="submit">Login</button>
					<br>
					<div class="col-sm-6">
						<div class="row">
							<span>No account? <a href='signUp.php'>Create one!</a></span>
						</div>
					</div>
					<div class="col-sm-6" align="right">
						<div class="row">
							<span><a href='resetPassword.php'>Forgot your password?</a></span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
</body>
</html>
