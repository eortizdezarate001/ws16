<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Get user information</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
		#header  {
			margin: 0 auto;
			font-size: 300%;
			text-align: center;
			font-weight: 100;
			width: 500px;

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
		.form-elem {
			text-align: left;
		}
		.form-input {
			margin-bottom: 12px;
			background-color: rgba(255, 255, 255, 0.4);
			border-color: rgba(0, 0, 0, 0.4);
			border-style: solid;
			border-width: 2px;
			height: 2.2rem;
			padding: 4px 8px 8px;
		}
		input.user-info 	{
			border-width: 0;
			padding: 0;
			margin: 0;
			width: 100%;
			outline: none;
		}
		input[type="text"]:disabled {
			background-color: white;
			margin-bottom: 12px;
		}
		#difficulty{
			margin-bottom: 12px;
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
	<link rel="stylesheet" href="./css/style.css" />
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function getInfo(){
			$.ajax({
					url: "getUser.php",
					type: "post",
					data: { email: $('#email').val() },
					dataType: "xml",
					success: function(xml){
							if($(xml).find('erabiltzailea').text() == "" && $('#email').val() !=""){
								$('#wrap-email').css("border-color","#cc0000");
								$('#firstname').val("");
								$('#lastname').val("");
								$('#phone').val("");
							} else{
								$('#wrap-email').css("border-color","rgba(0, 0, 0, 0.4)");

								var firstname = $(xml).find('firstname').text();
								var lastname = $(xml).find('lastname').text();
								var phone = $(xml).find('phone').text();

								$('#firstname').val(firstname);
								$('#lastname').val(lastname);
								$('#phone').val(phone);
						}
					}
			});
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
	        <li class="active"><a href="getUserInform.php">Get user information</a></li>
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
	              <li><a href="#">Settings</a></li>
	              <li><a href="logout.php">Logout</a></li>
	            </ul>
	          </li>
	          <?php } ?>
	      </ul>
	    </div>
	  </div>
	</nav>

	<form>
		<h1 id="header"> Get user information </h1>
		<div id="main">
			<p>
				Insert a user's e-mail to get their personal information.
			</p>
			<div class="form-group">
				<div class="form-elem">E-mail:
					<div class="form-input" id="wrap-email">
						<input class="user-info" type="email" name="email" id="email" required>
					</div>
				</div>
				<div class="form-elem">
					<div >
						<input class="user-info" type="text" name="firstname" id="firstname" placeholder="First name" disabled>
					</div>
				</div>
				<div class="form-elem">
					<div>
						<input class="user-info" type="text" name="lastname" id="lastname" placeholder="Last name" disabled>
					</div>
				</div>
				<div class="form-elem">
					<div>
						<input class="user-info" type="text" name="phone" id="phone" placeholder="Phone" disabled>
					</div>
				</div>
				<input class="button" type="button" value="Get info" onClick="javascript:getInfo()">
			</div>
		</div>
</form>
</body>
</html>
