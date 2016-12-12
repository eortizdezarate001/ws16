<?php session_start(); include('security.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create quiz</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css"/>
  <style>
    .form-php{
  		text-align: center;
  		margin: 4px;
  		color: #cc0000;
  	}
    .form-control, .btn-default, .btn-default:hover {
      border: 1px solid #000;
    }
    #submit {
      margin-bottom: 20px
    }
  </style>
  <link rel="stylesheet" href="./css/style.css" />
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script type="text/javascript">
  	$(document).ready(function() {
    	var max_fields = 20;
    	var wrapper = $(".input_fields_wrap");
    	var add_button = $(".add_field_button");
    	var delete_button = $(".remove_field_button");
    	var alert = false;
    	var x = 1;
    	$(add_button).click(function(){
      	if(x < max_fields){
          	x++;
          	$(wrapper).append('<div class="form-group form-inline" id="a"><input type="text" name="question[]" id="question" class="form-control" placeholder="Question" required>&nbsp; <input type="text" name="answer[]" id="answer" class="form-control" placeholder="Answer" required>&nbsp; <select class="form-control" name="diff[]" id="diff"><option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>'); //add input box
            if(x == max_fields){
              $(add_button).prop("disabled",true);
            }
          }
      });
    	$(delete_button).click(function(e){
    		if(x > 1){
    			e.preventDefault();
          $('#inputs div:last').remove();
          x--;
    			$(add_button).prop("disabled",false);
    		}
    	});
    });
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
              <?php if(isset($_SESSION['auth']) && $_SESSION['user-email']==='web000@ehu.es'){ ?>
                <li><a href="reviewingQuizes.php">Review quizes</a></li>
              <?php } ?>
            </ul>
          </li>
          <li><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
          <?php } ?><li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
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
			<h1>Create quiz</h1>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
        <div class="form-php">
          <?php
            if (isset($_POST["submit"])) {
              include("connect.php");
              $email = $_SESSION['user-email'];
              $name = $_POST['name'];
              $subject = $_POST['subject'];
              $question = $_POST['question'][0];
              $answer = $_POST['answer'][0];
              $diff = $_POST['diff'][0];
              if(empty($name) || empty($subject) || empty($question) || empty($answer)){
                echo "Fill in all the blanks.";
              } else{
                $sql = "INSERT INTO tests VALUES(0,'$name','$subject','$email')";
                if(!mysqli_query($connect, $sql))
            			die('ERROR in test creation: ' . mysqli_error($connect));

                $sql = "SELECT MAX(ID) FROM tests WHERE Name = '$name' AND Subject = '$subject' AND Creator = '$email' LIMIT 1";
                $query = mysqli_query($connect, $sql);
                $row = mysqli_fetch_row($query);
                $testid = $row[0];
            		$empty = false;
            		for($i=0; $i<count($_POST['question']); $i++){
            			$currentquestion = $_POST['question'][$i];
            			$currentanswer = $_POST['answer'][$i];
            			$currentdiff = $_POST['diff'][$i];
            			if(empty($currentquestion) || empty($currentanswer)){
            				$empty = true;
            			}else{
                    if($currentdiff == 0){
                      $sql2 = "INSERT INTO galderak (TestID, Question, Answer, Difficulty) VALUES ('$testid','$currentquestion','$currentanswer',NULL)";
                    } else{
                      $sql2 = "INSERT INTO galderak (TestID, Question, Answer, Difficulty) VALUES ('$testid','$currentquestion','$currentanswer','$currentdiff')";
                    }
            				if(!mysqli_query($connect, $sql2))
            					die('ERROR in question insertion: ' . mysqli_error($connect));
            			}
            		}
            		if($empty){
                  echo "Some questions could not be added because some fields were empty.";
                }
                else {
                  echo "<font color='#00cc00'>The test was successfully created.</font>";
                }
                mysqli_close($connect);
              }

            } else echo "<br>";
           ?>
        </div>
				<form id="question" name="question" method="post" action="createQuiz.php">
					<div class="form-group">
						<label for="name">Test name:</label>
						<input type="text" name="name" id="Name" class="form-control" required onfocus="del()">
					</div>
					<div class="form-group">
						<label for="subject">Test subject:</label>
						<input type="text" name="subject" id="Subject" class="form-control" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default add_field_button"><span class="glyphicon glyphicon-plus"></span> Add question</button>
						<button type="button" class="btn btn-default remove_field_button"><span class="glyphicon glyphicon-remove"></span> Remove question</button>
					</div>
					<div class="input_fields_wrap" align="center" id="inputs">
						<div class="form-group form-inline" id="a">
							<input type="text" name="question[]" id="question" class="form-control" placeholder="Question" required>&nbsp;
							<input type="text" name="answer[]" id="answer" class="form-control" placeholder="Answer" required>&nbsp;
							<select class="form-control" name="diff[]" id="diff">
								<option value="0"></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
						<!-- - - - -->
					</div>
					<input class="btn btn-primary btn-block" type="submit" value="Create quiz" id="submit" name="submit">
				</form>
			</div>
		</div>
	</div>
</body>
</html>
