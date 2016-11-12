<?php session_start();	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign in</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<style>
    body	  {font-family: 'Roboto', sans-serif; font-weight: 400;}
  	#header  {
      font-size: 300%; text-align: center; font-weight: 100;
      padding-top: 20px;
    }
    #main {
      max-width: 350px;
      padding-left: 12px;
      padding-right: 12px;
      min-height: 400px;
      width: 100%;
      margin: 0 auto;
      text-align: center;
    }
    .form-php{
      color: #e81123;
    }
  	.form-input {
      margin-bottom: 12px;
      background-color: rgba(255, 255, 255, 0.4);
      border-color: rgba(0, 0, 0, 0.4);
      border-style: solid;
      border-width: 2px;
      height: 1rem;
      padding: 4px 8px 8px;
    }
    input.login 	{
      border-width: 0;
      padding: 0;
      margin: 0;
      width: 100%;
      outline: none;
    }
    a:link, a:visited{color: #0772C6; text-decoration:none}
  	.button {
      width: 100%;
      height:35px;
      background-color: rgb(19,122,212);
      font-size: 100%;
      border:none;
      color:white;
    }
  	.button:hover {
  		border:solid;
  		border-color:rgb(8,79,138);
  	}
	</style>
</head>
<?php
if(isset($_SESSION['user-email'])){
	die("You're already logged in. <a href='logout.php'>Log out</a> or <a href='layout.html'> go back</a>.");
} ?>
<body>
  <form action="SignIn.php" id="login" name="login" method="post">
  	<div id="main">
  		<h1 id='header'> Sign In </h1>
      <div class="form-group">
        <div class="form-php">
          <p>
          <!-- php code -->
          <?php
            if(isset($_POST["submit"])){
              include('connect.php');

						  $email = mysqli_real_escape_string($connect,$_POST['email']);
              $password = mysqli_real_escape_string($connect,$_POST['password']);

              $sql = "SELECT * FROM erabiltzailea WHERE Email = '$email' AND Password = '$password'";
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

								if($email == "web000@ehu.es"){
									header('Location: reviewingQuizes.php');
								} else{
									header('Location: handlingQuizes.php');
								}
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
              } else{
                echo "Error.";
              }
            } else{echo "<br>";}
          ?></p>
        </div>
        <div class="form-input">
          <input class="login" type="email" name="email" id="email" placeholder="Email" required autofocus>
        </div>
        <div class="form-input">
          <input class="login" type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <input class="button" type="submit" id='button' name="submit" value="Sign in">
        <br>
  			<br>
  		  <p>No account? <a href='signUp.php'>Create one!</a><br>
          <a href="layout.html">Go back</a>
        </p>
      </div>
  	</div>
  </form>
</body>
</html>
