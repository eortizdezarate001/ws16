<?php session_start(); include('security.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Insert question</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css"/>
  <style>
    .form-php{
  		text-align: center;
  		margin: 4px;
  		color: #cc0000;
  	}
		.form-control, #create-quiz {
			border: 1px solid #000;
		}
		.form-group, #create-quiz {
    	margin-bottom: 7px;
		}
		#difficulties{
			text-align: center;
			margin-bottom: 7px;
		}
		.div-php{
			text-align: center;
			color: green;
		}

  </style>
  <link rel="stylesheet" href="./css/style.css" />
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script type="text/javascript">
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

	<div class="container">
		<div class="jumbotron text-center">
			<h1>Insert question</h1>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<?php
				  include('connect.php');
				  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);
				  $sql = "SELECT Name FROM tests WHERE Creator='$email'";
				  $query = mysqli_query($connect,$sql);
				  $count = mysqli_num_rows($query);
				 ?>
				<form id="formquestions" name="formquestions">
				  <?php if($count == 0){
				      echo "You can't add questions if you have no quizes.<br>";
				      echo "<a href='createQuiz.php' class='btn btn-default btn-block' id='create-quiz' role='button'>Create a quiz!</a>";
				      echo "<input type='hidden' name='tests' value=''>";
				  } else{?>
				  <div class="form-group" style="text-align: left">
				    <label for="tests">Quiz:</label>
				    <select class="form-control" id="tests" name="tests">
				      <?php
				        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
				          echo "<option>".$row['Name']."</option>";
				        }
				      ?>
				    </select>
				  </div><?php } ?>
				  <div class="form-group">
				    <?php if($count == 0){ ?>
				      <input class="form-control" type="text" name="question" id="question" placeholder="Question" disabled>
				    <?php } else{ ?>
				      <input class="form-control" type="text" name="question" id="question" placeholder="Question" required>
				    <?php } ?>
				  </div>
				  <div class="form-group">
				    <?php if($count == 0){ ?>
				      <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" disabled>
				    <?php } else{ ?>
				      <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" required>
				    <?php } ?>
				  </div>
				  <?php if($count == 0){ ?>
				    <input class="btn btn-primary btn-block disabled" type="button" id='button' name="submit" value="Submit">
				  <?php } else{ ?>
				    <div id="difficulties">
				      <label class="radio-inline"><input type="radio" name="difficulty" value="1"> 1</label>
				      <label class="radio-inline"><input type="radio" name="difficulty" value="2"> 2</label>
				      <label class="radio-inline"><input type="radio" name="difficulty" value="3"> 3</label>
				      <label class="radio-inline"><input type="radio" name="difficulty" value="4"> 4</label>
				      <label class="radio-inline"><input type="radio" name="difficulty" value="5"> 5</label>
				    </div>
				    <input class="btn btn-primary btn-block" type="button" id='button' name="submit" value="Submit" onclick=javascript:submitForm()>
				  <?php } ?>
				</form>
				<div class="div-php" id="div-php"></div>
			</div>
		</div>
	</div>
</body>
</html>
