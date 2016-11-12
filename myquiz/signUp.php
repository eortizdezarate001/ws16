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
			#specialty{
				background-color: rgba(255, 255, 255, 0.4);
	      border-color: rgba(0, 0, 0, 0.4);
	      border-style: solid;
	      border-width: 2px;
				display: block;
				width: 100%;
			}
			textarea {
				margin-bottom: 12px;
	      background-color: rgba(255, 255, 255, 0.4);
	      border-color: rgba(0, 0, 0, 0.4);
	      border-style: solid;
	      border-width: 2px;
	      height: 2rem;
	      padding: 4px 8px 8px;
				width: 94%;
			}
	    a:link, a:visited{color: #0772C6; text-decoration:none}
	  	.button {
	      width: 49.4%;
	      height:35px;
	      background-color: rgb(19,122,212);
	      font-size: 100%;
	      border:none;
	      color:white;
				display: inline;
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
									if($('#pass2').val() === $('#pass').val()){
										$('#wrap-pass2').css("border-color","#00cc00");
									} else if($('#pass2').val() == ""){
										$('#wrap-pass2').css("border-color","rgba(0, 0, 0, 0.4)");
									} else{
										$('#wrap-pass2').css("border-color","#cc0000");
									}
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
			function resetColors(){
				$('#wrap-email').css("border-color","rgba(0, 0, 0, 0.4)");
				$('#wrap-pass').css("border-color","rgba(0, 0, 0, 0.4)");
			}

    </script>
	</head>
	<body>
		<p align="right"><a href="layout.html">Home</a></p>
		<form action="EnrollWithImage.php" id="erregistro" name="erregistro" onSubmit="return validation()" method="post" enctype="multipart/form-data">
			<div id="main">
				<h1 id="header">Sign up</h1>
				<div class="form-wrap">
					<label for="firstname">First name<font color="red">*</font></label>
					<div class="form-input">
						<input class="element" type="text" id="firstname" name="firstname">
					</div>
				</div>
				<div class="form-wrap">
					<label for="lastname">Last name<font color="red">*</font></label>
					<div class="form-input">
						<input class="element" type="text" id="lastname" name="lastname">
					</div>
				</div>
				<div class="form-wrap">
					<label for="email">Email<font color="red">*</font></label>
					<div class="form-input" id="wrap-email">
						<input class="element" type="text" id="email" name="email" placeholder="example001@ikasle.ehu.eus" onchange="matrikula()" autocomplete="off">
					</div>
				</div>
				<div class="form-wrap">
					<label for="pass">Password<font color="red">*</font></label>
					<div class="form-input" id="wrap-pass">
						<input class="element" type="password" id="pass" name="password" onchange="pasahitza()">
					</div>
				</div>
				<div class="form-wrap">
					<label for="pass2">Repeat password<font color="red">*</font></label>
					<div class="form-input" id="wrap-pass2">
						<input class="element" type="password" id="pass2" name="password2" onchange="pasahitza()">
					</div>
				</div>
				<div class="form-wrap">
					<label for="phone">Phone number<font color="red">*</font></label>
					<div class="form-input">
						<input class="element" type="text" id="phone" name="phone">
					</div>
				</div>
				<div class="form-wrap" align="left" style="margin-bottom: 10px">
					<div style="margin-bottom: 12px; margin-top: 10px">
					<label for="specialty">Specialty<font color="red">*</font></label>
					<select id="specialty" name="specialty" onChange="addTextField()">
						  <option value="Software Engineering">Software Engineering</option>
						  <option value="Computer Engineering">Computer Engineering</option>
						  <option value="Computer Science">Computer Science</option>
							<option value="Others">Others</option>
					</select></div>
		      <div id="container" name="container"></div>
					<label>Technologies and tools you're interested in </label>
					<div class="textarea-border">
						<textarea name="interests"></textarea>
					</div>
					<label for="image">Upload a profile picture </label>
					<input type="file" name="image" id="image" accept="image/*">
				</div>
				<div class="buttons-wrap">
					<input class="button" type="submit" id="submit" value="Submit" disabled style="margin-bottom: 5px">
					<input class="button" type="reset" value="Reset" onclick="resetColors()">
				</div>
			</div>
		</form>
	</body>
</html>
