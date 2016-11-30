<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="UTF-8">
		<title>Credits</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
		<link rel="stylesheet" href="./css/bootstrap.min.css"/>
		<style>
		  html, body  {
				font-family: 'Roboto', sans-serif; font-weight: 400;
				height: 100%;
				margin: 0;
				padding: 0;
			}
		  h1    {font-weight: 100; font-size:250%;}
			#map {height: 50%; width: 100%;}
		</style>
		<link rel="stylesheet" href="./css/style.css" />
		<script src="./js/jquery-3.1.1.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
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
		          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions
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
		        <li><a href="getUserInform.php">Get user information</a></li>
		        <li class="active"><a href="credits.php"><span class="glyphicon glyphicon-align-left"></span> Credits</a></li>
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
		              <li><a href="#">Settings</a></li>
		              <li><a href="logout.php">Logout</a></li>
		            </ul>
		          </li>
		          <?php } ?>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div  align="center">
			<h1>Credits</h1>
			<p>Eneko Ortiz de Zarate &amp; Igor Sánchez</p>
			<p><strong>Specialty:</strong> Software Engineering</p>
			<img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Informatika_fakultatea_001.JPG"
				alt="Informatika Fakultatea" width="400">
			<br><br><br>
		</div>
		<div id="map">
		</div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: -34.397, lng: 150.644},
					zoom: 6
				});
				var infoWindow = new google.maps.InfoWindow({map: map});

				// Try HTML5 geolocation.
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						var pos = {
							lat: position.coords.latitude,
							lng: position.coords.longitude
						};

						infoWindow.setPosition(pos);
						infoWindow.setContent('Location found.');
						map.setCenter(pos);
					}, function() {
						handleLocationError(true, infoWindow, map.getCenter());
					});
				} else {
					// Browser doesn't support Geolocation
					handleLocationError(false, infoWindow, map.getCenter());
				}
			}

			function handleLocationError(browserHasGeolocation, infoWindow, pos) {
				infoWindow.setPosition(pos);
				infoWindow.setContent(browserHasGeolocation ?
															'Error: The Geolocation service failed.' :
															'Error: Your browser doesn\'t support geolocation.');
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC03sfngySO2oj9SiKiwS3YfsNPdTLCOzU&signed_in=true&callback=initMap"
        async defer>
    </script>
	</body>
</html>
