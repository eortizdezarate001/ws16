<?php session_start(); include('security.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Handle your quizes and questions</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
		#count {
			margin-bottom: 12px;
			font-size: 110%;
		}
		#showquestions {
			margin-bottom: 5px;
		}
		.form-php{
			color: green;
		}
		.form-control, #create-quiz {
			border: 1px solid #000;
		}
		.form-group, #create-quiz {
    	margin-bottom: 7px;
		}
		#difficulties{
			margin-bottom: 7px;
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
			$('#showquestions').removeClass('active');
			$('#div-showquestions').css('display','none');
			if($('#div-addquestion').css('display') == 'none'){
				$('#addquestion').addClass('active');
				$('#addquestion').blur();
				$('#div-addquestion').css('display','block');
				$('#div-php').empty();
				$('#div-php').css('display','block');
				$('#div-addquestion').load("handlingQuizes-insertQuestion.php");
			} else if($('#div-addquestion').css('display') == 'block'){
				$('#addquestion').removeClass('active');
				$('#addquestion').blur();
				$('#div-addquestion').css('display','none');
				$("#div-php").css('display','none');
				$("#div-php").empty();
			}
		}
		function showQuestions(){
			$('#addquestion').removeClass('active');
			$("#div-addquestion").css('display','none');
			$("#div-php").css('display','none');
			$("#div-php").empty();
			if($('#div-showquestions').css('display') == 'none'){
				$('#showquestions').addClass('active');
				$('#showquestions').blur();
				$('#div-showquestions').css('display','block');
				$('#div-showquestions').load("handlingQuizes-showMyQuestions.php");
			} else if($('#div-showquestions').css('display') == 'block'){
				$('#showquestions').removeClass('active');
				$('#showquestions').blur();
				$('#div-showquestions').css('display','none');
			}
		}
		function submitForm(){
			var test = $("#tests option:selected").text();
			var question = $("#question").val();
			var answer = $("#answer").val();
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
						test: test,
						question: question,
						answer: answer,
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

	<div class="container" style="text-align: center">
		<div class="jumbotron text-center" style="margin-bottom: 12px">
			<h1>Handle quizes and questions</h1>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<div id="count">
					My questions/Total questions : <span id="questioncount"></span>
				</div>
		    <input class="btn btn-primary btn-block" type="button" id="addquestion" name="addquestion" value="Add question" onclick="addQuestion()">
		    <input class="btn btn-primary btn-block" type="button" id="showquestions" name="showquestions" value="Show my questions" onclick="showQuestions()">
		    <div class="form-group" id="div-addquestion" style="display:none"></div>
		    <div class="form-php" id="div-php" style="display:none"></div>
		    <div class="form-group" id="div-showquestions" style="display:none"></div>
			</div>
		</div>
	</div>
</body>
</html>
