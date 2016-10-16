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
              //$connect = mysqli_connect("localhost","root","", "quiz");
              $connect = mysqli_connect("mysql.hostinger.es","u102514866_eneko","eortizdezarate001","u102514866_quiz");

              $email = mysqli_real_escape_string($connect,$_POST['email']);
              $password = mysqli_real_escape_string($connect,$_POST['password']);

              $sql = "SELECT * FROM erabiltzailea WHERE Email = '$email' AND Password = '$password'";
              $query = mysqli_query($connect,$sql);
              $row = mysqli_fetch_array($query,MYSQLI_ASSOC);

              $count = mysqli_num_rows($query);

              if($count == 1){
                $_SESSION['user'] = $email;
                header('Location: layout.html');
              } else if($count == 0) {
                $sql2 = "SELECT * FROM erabiltzailea WHERE Email = '$email'";
                $query2 = mysqli_query($connect,$sql2);
                $row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
                $count2 = mysqli_num_rows($query2);
                if($count2 == 1){
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
  		  <p>No account? <a href='signUp.html'>Create one!</a></p>
      </div>
  	</div>
  </form>
</body>
</html>
