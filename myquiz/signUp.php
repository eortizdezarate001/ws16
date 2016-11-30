<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Sign up</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
	<script type="text/javascript" src="functions.js" charset="utf-8"></script>
	<link rel="stylesheet" href="./css/bootstrap.min.css"/>
	<style>
	.form-control {
		border: 1px solid #000;
	}

	.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
		margin: 0;
		padding: 0;
		border: none;
		box-shadow: none;
		text-align: center;
	}
	.kv-avatar .file-input {
		display: table-cell;
		max-width: 220px;
	}
	.fixed {
		position: fixed;
		top: 25;
		right: 25;
	}
	.centerFix {
		position: fixed;
		left: 50%;
		top: 20%;
		transform: translate(-50%, -20%);
	}
	</style>
	<link rel="stylesheet" href="./css/style.css" />
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script type="text/javascript">
	var emailB = false;
	var passB = false;
	function matrikula(){
		var myEmail = $('#email').val();
		if(myEmail == ""){
			$('#email').css("border-color","black");
		} else{
			var values = $('#erregistro').serialize();
			$.ajax({
				url: "egiaztatuMatrikulaBez.php",
				type: "post",
				data: values,
				success: function(response){
					if(response == "BAI"){
						$('#email').css("border-color","#00cc00");
						emailB=true;
					} else{
						$('#email').css("border-color","#cc0000");
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
			$('#pass').css("border-color","black");
		} else{
			var values = $('#erregistro').serialize();
			$.ajax({
				url: "egiaztatuPasahitzaBez.php",
				type: "post",
				data: values,
				success: function(response){
					if(response == "BALIOZKOA"){
						$('#pass').css("border-color","#00cc00");
						if($('#pass2').val() === $('#pass').val()){
							$('#pass2').css("border-color","#00cc00");
							passB=true;
						} else if($('#pass2').val() == ""){
							$('#pass2').css("border-color","black");
						} else{
							$('#pass2').css("border-color","#cc0000");
						}
					} else if(response == "BALIOGABEA"){
						$('#pass').css("border-color","#cc0000");
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
		$('#email').css("border-color","black");
		$('#pass').css("border-color","black");
		$('#pass2').css("border-color","black");
		$('#submit').prop("disabled",true);
	}

	</script>
	<link href="css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
	<script src="js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
	<script src="js/plugins/sortable.min.js" type="text/javascript"></script>
	<script src="js/fileinput.min.js"></script>
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
							</ul>
						</li>
						<li><a href="getUserInform.php"><span class="glyphicon glyphicon-search"></span> Get user information</a></li>
						<li><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li><a href="SignIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="jumbotron text-center">
				<h1>Sign up</h1>
			</div>
			<div class="row">
				<form action="EnrollWithImage.php" id="erregistro" name="erregistro" onSubmit="return validation()" method="post" enctype="multipart/form-data">
					<div class="col-sm-4 col-sm-offset-2 col-sm-push-5">
						<div class="form-group">
							<div class="kv-avatar" align="center" style="">
								<label>Picture:</label>
								<input id="avatar-1" name="avatar-1" type="file" class="file-loading">
							</div>
							<script>
							$("#avatar-1").fileinput({
								overwriteInitial: true,
								maxFileSize: 1500,
								showClose: false,
								showCaption: false,
								browseLabel: '',
								removeLabel: '',
								browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
								removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
								removeTitle: 'Cancel or reset changes',
								elErrorContainer: '#kv-avatar-errors-1',
								msgErrorClass: 'alert alert-block alert-danger',
								defaultPreviewContent: '<img src="img/default_avatar_male.jpg" id="PREVIEW" alt="Your Avatar" style="width:160px">',
								layoutTemplates: {main2: '{preview} {remove} {browse}'},
								allowedFileExtensions: ["jpg", "png", "gif"]
							});
							</script>
						</div>
					</div>
					<div class="col-sm-5 col-sm-offset-1 col-sm-pull-7">
						<div class="form-group">
							<label for="firstname">First name<font color="red">*</font></label>
							<input type="text" class="form-control compulsory" id="firstname" name="firstname" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="lastname">Last name<font color="red">*</font></label>
							<input type="text" class="form-control compulsory" id="lastname" name="lastname" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="email">Email<font color="red">*</font></label>
							<input type="text" class="form-control compulsory" id="email" name="email" placeholder="example001@ikasle.ehu.eus" onchange="matrikula()" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="pass">Password<font color="red">*</font></label>
							<input type="password" class="form-control compulsory" id="pass" name="password" onchange="pasahitza()">
						</div>
						<div class="form-group">
							<label for="pass2">Repeat password<font color="red">*</font></label>
							<input type="password" class="form-control compulsory" id="pass2" name="password2" onchange="pasahitza()">
						</div>
						<div class="form-group">
							<label for="phone">Phone number<font color="red">*</font></label>
							<input type="text" class="form-control compulsory" id="phone" name="phone" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="specialty">Specialty<font color="red">*</font></label>
							<select class="form-control" id="specialty" name="specialty" onChange="addTextField()">
								<option value="Software Engineering">Software Engineering</option>
								<option value="Computer Engineering">Computer Engineering</option>
								<option value="Computer Science">Computer Science</option>
								<option value="Others">Others</option>
							</select>
						</div>
						<div class="form-group" id="container" name="container"></div>
						<div class="form-group">
							<label for="interests">Technologies and tools you're interested in </label>
							<textarea class="form-control" id="inteterests" name="interests"></textarea>
						</div>
						<div class="btn-group" role="group" style="margin-bottom: 20px">
							<input type="submit" class="btn btn-default" id="submit" value="Submit" disabled>
							<input type="reset" class="btn btn-default" value="Reset" onclick="resetColors()">
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
	</html>
