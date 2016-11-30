<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Get user information</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
		.form-group{
			margin-bottom: 10px;
		}
		.form-control {
			border: 1px solid #000;
		}
		input[type="text"]:disabled {
			border-width: 0;
			padding: 0;
			margin: 0;
			width: 100%;
			outline: none;
			background-color: white;
			margin-bottom: 7px;
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
								$('#email').css("border-color","#cc0000");
								$('#firstname').val("");
								$('#lastname').val("");
								$('#phone').val("");
							} else{
								$('#email').css("border-color","#000");

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
	        <li class="active"><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
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

	<div class="container">
		<div class="jumbotron text-center">
			<h1>Get user information</h1>
		</div>
		<div class="row">
			<p align="center">Insert a user's e-mail to get their personal information.</p>
			<div class="col-sm-4 col-sm-offset-4">
				<form>
					E-mail:
					<div class="form-group">
						<input class="form-control" type="email" name="email" id="email" required autocomplete="off">
					</div>
					<input type="text" name="firstname" id="firstname" placeholder="First name" disabled>
					<input type="text" name="lastname" id="lastname" placeholder="Last name" disabled>
					<input type="text" name="phone" id="phone" placeholder="Phone" disabled>
					<input class="btn btn-primary btn-block" type="button" value="Get info" onClick="javascript:getInfo()">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
