<?php session_start(); include('security.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Handle questions</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<style>
		body	  {font-family: 'Roboto', sans-serif; font-weight: 400;}
		#header  {
			font-size: 300%; text-align: center; font-weight: 100;
		}
		#count {
			margin-bottom: 12px;
			font-size: 110%;
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
		#difficulties{
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
      margin-bottom: 10px;
		}
		.button:hover {
			border:solid;
			border-color:rgb(8,79,138);
		}
		table	{border-collapse: collapse; width: 100%; }
		th		{text-align: center;padding: 8px; border-bottom: 1px solid #ddd;}
		td 		{padding: 8px; text-align: left; border-bottom: 1px solid #ddd;}
		tr:hover{background-color:#f5f5f5}
		#tr1:hover{background-color: #ffffff};
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript">
    xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange= function(){
       if((xhttp1.readyState==4)&&(xhttp1.status==200)){
         var obj = document.getElementById("div-addquestion");
         obj.innerHTML = xhttp1.responseText;
       }
    }
    xhttp2 = new XMLHttpRequest();
    xhttp2.onreadystatechange=function(){
			if((xhttp2.readyState==4)&&(xhttp2.status==200)){
				var obj = document.getElementById("div-showquestions");
				obj.innerHTML = xhttp2.responseText;
			}
    }
		xhttp3 = new XMLHttpRequest();
    xhttp3.onreadystatechange=function(){
			if((xhttp3.readyState==4)&&(xhttp3.status==200)){
				var obj = document.getElementById("div-php");
				obj.innerHTML = xhttp3.responseText;
			}
    }

		function addQuestion(){
			document.getElementById("div-showquestions").style.display="none";
			var div = document.getElementById("div-addquestion");
			if(div.style.display=="none"){
				div.style.display="block";
				document.getElementById("div-php").innerHTML="";
				document.getElementById("div-php").style.display="block";
				xhttp1.open("GET","handlingQuizes-insertQuestion.txt");
	      xhttp1.send(null);
			} else if(div.style.display=="block"){
				div.style.display="none";
				document.getElementById("div-php").style.display="none";
				document.getElementById("div-php").innerHTML="";
			}
		}
		function showQuestions(){
			document.getElementById("div-addquestion").style.display="none";
			document.getElementById("div-php").style.display="none";
			document.getElementById("div-php").innerHTML="";
			var div = document.getElementById("div-showquestions");
			if(div.style.display=="none"){
				div.style.display="block";
				xhttp2.open("GET","handlingQuizes-showMyQuestions.php");
	      xhttp2.send(null);
			} else if(div.style.display=="block"){
				div.style.display="none";
			}
		}
		function submitForm(){
			var question = document.getElementById("question").value;
			var answer = document.getElementById("answer").value;
			var subject = document.getElementById("subject").value;
			var diff = document.getElementsByName("difficulty");
			if(question !== "" && answer !== ""){
				document.getElementById("div-php").innerHTML = "...";
				var difficulty="";
				for(var i=0;i<5;i++){
					if(diff[i].checked){
						difficulty = diff[i].value;
					}
				}

				xhttp3.open("POST","handlingQuizes-insertPHP.php");
				xhttp3.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xhttp3.send("question="+question+"&answer="+answer+"&subject="+subject+"&difficulty="+difficulty);
			} else{
				document.getElementById("div-php").innerHTML = "<font color='black'>Question or Answer fields are empty.</font>";
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
    <h1 id="header">Handle your questions</h1>
		<div id="main">
			<div id="count">
				My questions/Total questions : <span id="questioncount"></span>
			</div>
      <input class="button" type="button" id="addquestion" name="addquestion" value="Add question" onclick="addQuestion()">
      <input class="button" type="button" id="showquestions" name="showquestions" value="Show my questions" onclick="	showQuestions()"><br>
      <div class="form-group" id="div-addquestion" style="display:none"></div>
      <div class="form-php" id="div-php" style="display:none"></div>
      <div class="form-group" id="div-showquestions" style="display:none"></div>
		</div>
</body>
</html>
