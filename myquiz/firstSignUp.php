<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Sign up</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
		<script type="text/javascript" src="functions.js" charset="utf-8"></script>
		<style>
			body	  {font-family: 'Roboto', sans-serif; font-weight: 400;}
	  	#header  {
	      font-size: 300%; text-align: center; font-weight: 100;
	    }
			#erregistro {
				margin-top: -50px;
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
			.form-wrap {
				text-align: left;
			}
	  	.form-input {
	      margin-bottom: 8px;
	      background-color: rgba(255, 255, 255, 0.4);
	      border-color: rgba(0, 0, 0, 0.4);
	      border-style: solid;
	      border-width: 2px;
	      height: 1rem;
	      padding: 4px 8px 8px;
	    }
	    input.element	{
	      border-width: 0;
	      padding: 0;
	      margin: 0;
	      width: 100%;
	      outline: none;
	    }
	    a:link, a:visited{color: #0772C6; text-decoration:none}
	  	.button, .button:enabled {
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
			.button:disabled {
				background-color: #444;
			}
		</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
			var emailB = false;
			var passB = false;
			function matrikula(){
				var myEmail = $('#email').val();
				if(myEmail == ""){
					$('#wrap-email').css("border-color","rgba(0, 0, 0, 0.4)");
				} else{
					var values = $('#erregistro').serialize();
		      $.ajax({
							url: "egiaztatuMatrikulaBez.php",
							type: "post",
							data: values,
							success: function(response){
								if(response == "BAI"){
									$('#wrap-email').css("border-color","#00cc00");
									emailB=true;
								} else{
									$('#wrap-email').css("border-color","#cc0000");
									emailB=false;
								}
								if(emailB && passB){
									$('#submit').prop("disabled",false);
								} else{
									$('#submit').prop("disabled",true);
								}
							}
					});
				}
			}
			function pasahitza(){
				var myPassword = $('#pass').val();
				if(myPassword == ""){
					$('#wrap-pass').css("border-color","rgba(0, 0, 0, 0.4)");
				} else{
					var values = $('#erregistro').serialize();
		      $.ajax({
							url: "egiaztatuPasahitzaBez.php",
							type: "post",
							data: values,
							success: function(response){
								if(response == "BALIOZKOA"){
									$('#wrap-pass').css("border-color","#00cc00");
									passB=true;
								} else if(response == "BALIOGABEA"){
									$('#wrap-pass').css("border-color","#cc0000");
									passB=false;
								}
								if(emailB && passB){
									$('#submit').prop("disabled",false);
								} else{
									$('#submit').prop("disabled",true);
								}
							}
					});
				}
			}

    </script>
	</head>
	<body>
		<p align="right"><a href="layout.html">Home</a></p>
		<form action="signUp.html" id="erregistro" name="erregistro" method="post">
			<div id="main">
				<h1 id="header">Sign up</h1>
				<div class="form-wrap">
					<label for="email">Email</label>
					<div class="form-input" id="wrap-email">
						<input class="element" type="text" id="email" name="email" placeholder="example001@ikasle.ehu.eus" onchange="matrikula()" autocomplete="off">
					</div>
				</div>
				<div class="form-wrap">
					<label for="pass">Password</label>
					<div class="form-input" id="wrap-pass">
						<input class="element" type="password" id="pass" name="password" onchange="pasahitza()">
					</div>
				</div>
				<input class="button" type="submit" id="submit" style="margin-bottom: 5px" disabled value="Sign up">
			</div>
		</form>
	</body>
</html>
