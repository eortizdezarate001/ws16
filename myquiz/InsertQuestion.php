<?php   session_start(); include('securityH.php');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Insert Question</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<style>
		body	  {font-family: 'Roboto', sans-serif; font-weight: 400;}
		#header  {
			font-size: 300%; text-align: center; font-weight: 100;
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
			color: green;/*#e81123;*/
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
		input.q-a 	{
			border-width: 0;
			padding: 0;
			margin: 0;
			width: 100%;
			outline: none;
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
</head>

<body>
	<form action="InsertQuestion.php" id="question" name="question" method="post">
		<div id="main">
			<h1 id="header"> Insert Question </h1>
			<p>
				Insert your question with its answer. <br>
				You can specify the difficulty.
			</p>
			<div class="form-group">
				<div class="form-input">
					<input class="q-a" type="text" name="question" id="question" placeholder="Question" required>
				</div>
				<div class="form-input">
					<input class="q-a" type="text" name="answer" id="answer" placeholder="Answer" required>
				</div>
				<div class="form-input">
					<input class="q-a" type="text" name="subject" id="subject" placeholder="Subject">
				</div>
				<div id="difficulty">
					1<input type="radio" name="difficulty" value="1">&nbsp;
					2<input type="radio" name="difficulty" value="2">&nbsp;
					3<input type="radio" name="difficulty" value="3">&nbsp;
					4<input type="radio" name="difficulty" value="4">&nbsp;
					5<input type="radio" name="difficulty" value="5">&nbsp;
				</div>
				<input class="button" type="submit" id='button' name="submit" value="Submit">
				<div class="form-php"><p><!-- php kodea -->
					<?php
						if(isset($_POST["submit"])){
							include('connect.php');

							$question = mysqli_real_escape_string($connect,$_POST['question']);
							$answer = mysqli_real_escape_string($connect,$_POST['answer']);
							$subject = mysqli_real_escape_string($connect,$_POST['subject']);
							$email = mysqli_real_escape_string($connect,$_SESSION['user-email']);
							if(isset($_POST['difficulty'])){
								$sql = "INSERT INTO galderak VALUES (0,'$email','$question','$answer','$subject','$_POST[difficulty]')";
							} else{
								$sql = "INSERT INTO galderak VALUES (0,'$email','$question','$answer','$subject', NULL)";
							}
							$query = mysqli_query($connect,$sql);
							if (!$query){
						    die('ERROR at query execution:' . mysqli_error($connect));
						  }

							// ADD TO XML FILE
							$file = 'galderak.xml';
							$xml = simplexml_load_file($file);

							$assessmentItem = $xml->addChild('assessmentItem');
							$assessmentItem->addAttribute('complexity', $_POST['difficulty']);
							$assessmentItem->addAttribute('subject',$subject);
							$itemBody = $assessmentItem->addChild('itemBody');
							$itemBody->addChild('p',$question);
							$correctResponse = $assessmentItem->addChild('correctResponse');
							$correctResponse->addChild('value', $answer);

							$xml->asXML($file);

							echo "Your question was added successfully.<br>";
							echo "<a href='seeXMLQuestions.php'>See questions.</a>";

							// EKINTZA
							$connection = (int)$_SESSION['user-connection'];
							$type = "Insert question";
							$date = date ("Y-m-d H:i:s");
							$ip = $_SERVER['REMOTE_ADDR'];

							$sql2 = "INSERT INTO ekintzak VALUES(0, $connection, '$email', '$type', '$date', '$ip')";
							$query2 = mysqli_query($connect,$sql2);
							if (!$query2){
						    die('ERROR at query execution:' . mysqli_error($connect));
						  }


							mysqli_close($connect);
							//header('Location: layout.php');
							exit;
						}
					 ?>
				</p></div>
			</div>
		</div>
</form>
</body>
</html>
