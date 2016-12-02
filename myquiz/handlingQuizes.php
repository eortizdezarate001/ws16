<?php session_start(); include('security.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Handle questions</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
		#count {
			margin-bottom: 12px;
			font-size: 110%;
		}
		.form-php{
			color: green;
		}
		.form-control {
			border: 1px solid #000;
		}
		.form-group {
    	margin-bottom: 7px;
		}
		#difficulties{
			margin-bottom: 7px;
		}
		.button {
			width: 100%;
			height:35px;
			background-color: rgb(19,122,212);
			font-size: 100%;
			border:none;
			color:white;
      margin-bottom: 10px;
		}
		.button:hover {
			border:solid;
			border-color:rgb(8,79,138);
		}
		a#testname:hover, a#testname:active, a#testname:link, a#testname:visited {
			text-decoration: none;
		}
	</style>
	<link rel="stylesheet" href="./css/style.css" />
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
  <script type="text/javascript">
		function addQuestion(){
			$('#div-showquestions').css('display','none');
			if($('#div-addquestion').css('display') == 'none'){
				$('#div-addquestion').css('display','block');
				$('#div-php').empty();
				$('#div-php').css('display','block');
				$('#div-addquestion').load("handlingQuizes-insertQuestion.txt");
			} else if($('#div-addquestion').css('display') == 'block'){
				$('#div-addquestion').css('display','none');
				$("#div-php").css('display','none');
				$("#div-php").empty();
			}
		}
		function showQuestions(){
			$("#div-addquestion").css('display','none');
			$("#div-php").css('display','none');
			$("#div-php").empty();
			if($('#div-showquestions').css('display') == 'none'){
				$('#div-showquestions').css('display','block');
				$('#div-showquestions').load("handlingQuizes-showMyQuestions.php");
			} else if($('#div-showquestions').css('display') == 'block'){
				$('#div-showquestions').css('display','none');
			}
		}
		function submitForm(){
			var question = $("#question").val();
			var answer = $("#answer").val();
			var subject = $("#subject").val();
			var diff = document.getElementsByName("difficulty");
			if(question !== "" && answer !== ""){
				$("#div-php").html("...");
				var difficulty="";
				for(var i=0;i<5;i++){
					if(diff[i].checked){
						difficulty = diff[i].value;
					}
				}
				$.post(
					"handlingQuizes-insertPHP.php",
					{
						question: question,
						answer: answer,
						subject: subject,
						difficulty: difficulty
					},
					function(result){
						$('#div-php').html(result);
					}
				);
			} else{
				$("#div-php").html("<font color='black'>Question or Answer fields are empty.</font>");
			}
		}

		window.onload = function(){load();};
		function refresh(){
			$("#questioncount").load("handlingQuizes-questionCount.php");
		}
		function load(){
			refresh();
			setInterval(refresh,5000);
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
	        <li class="dropdown active">
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

  <h1 style="font-size: 300%">Handle your questions</h1>
	<div class="container" style="text-align: center">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<div id="count">
					My questions/Total questions : <span id="questioncount"></span>
				</div>
		    <input class="button" type="button" id="addquestion" name="addquestion" value="Add question" onclick="addQuestion()">
		    <input class="button" type="button" id="showquestions" name="showquestions" value="Show my questions" onclick="	showQuestions()"><br>
		    <div class="form-group" id="div-addquestion" style="display:none"></div>
		    <div class="form-php" id="div-php" style="display:none"></div>
		    <div class="form-group" id="div-showquestions" style="display:none"></div>
			</div>
		</div>
	</div>
</body>
</html>
