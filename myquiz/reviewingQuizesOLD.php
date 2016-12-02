<?php
  session_start();
  include('connect.php');
  include('security.php');
  if($_SESSION['user-email']!=='web000@ehu.es'){
    header('Location: layout.php');
  }

  $sql = "SELECT * FROM galderak";
  $query = mysqli_query($connect,$sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Review questions</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <style>
      #header  {
        font-size: 300%; text-align: center; font-weight: 100;
      }
      #question-table {text-align: center;}
      a:link, a:visited{color: #0772C6; text-decoration:none}
      table	{border-collapse: collapse; width: 100%; }
	    th		{text-align: center;padding: 8px; border-bottom: 1px solid #ddd;}
	    td 		{padding: 8px; text-align: center; border-bottom: 1px solid #ddd;}
      .em, .q, .a {text-align: left; border-right: 1px solid #ddd;}
      .b {border-left: 1px solid #ddd;}
	    tr:hover{background-color:#eee}
      #tr1:hover{background-color: #ffffff;}
      .button, .modal-button {
        width: 100%;
        height:1.8rem;
        background-color: rgb(19,122,212);
        font-size: 100%;
        border:none;
        color:white;
        display: inline;
      }
      .button:hover, .modal-button:hover:enabled {
        border:solid;
        border-color:rgb(8,79,138);
      }
      /* modal form */
      form {margin-bottom: -16px;}
      .form-group {
        width: 60%;
        margin: 0 auto;
      }
      .form-input {
  			margin-bottom: 6px;
  			background-color: rgba(255, 255, 255, 0.4);
  			border-color: rgba(0, 0, 0, 0.4);
  			border-style: solid;
  			border-width: 2px;
  			height: 2.2rem;
  			padding: 4px 8px 8px;
  		}
  		input.q-a 	{
  			border-width: 0;
  			padding: 0;
  			margin: 0;
  			width: 100%;
  			outline: none;
  		}
      #difficulty {
        text-align: center;
        margin-top: 10px;
      }
    </style>
    <style>
      /* The Modal (background) */
      .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        -webkit-animation-name: fadeIn; /* Fade in the background */
        -webkit-animation-duration: 0.5s;
        animation-name: fadeIn;
        animation-duration: 0.5s
      }
      /* Modal Content */
      .modal-content {
        position: fixed;
        top: 25%;
        left: 25%;
        background-color: #fefefe;
        width: 50%;
      }
      /* The Close Button */
      .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
      }
      .close:hover,
      .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
      }
      .modal-header {
        padding: 2px 16px;
        background-color: #222;
        color: white;
      }
      .modal-body {
        padding-top: 20px;
        padding-bottom: 30px;
      }
      .modal-footer {
        padding: 2px 16px;
        background-color: #222;
        color: white;
        height: 3.3rem;
        text-align: center;
      }
      #save, #delete {
        height: 2rem;
        margin: 10px;
        margin-left: 2px;
        margin-right: 2px;
        width: 30%;
      }
      #edited, #deleted {
        display: inline;
        visibility: hidden;
      }
      /* Animation */
      @-webkit-keyframes fadeIn {
        from {opacity: 0}
        to {opacity: 1}
      }
      @keyframes fadeIn {
        from {opacity: 0}
        to {opacity: 1}
      }
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
  	        <li class="dropdown active">
  	          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span> Quizes
  	          <span class="caret"></span></a>
  	          <ul class="dropdown-menu">
  	            <li><a href="Questions.php">See all quizes</a></li>
  	            <?php if(isset($_SESSION['auth'])){ ?>
  	              <li><a href="handlingQuizes.php">Handle quizes</a></li>
  	            <?php } ?>
  	            <?php if(isset($_SESSION['auth']) && $_SESSION['user-email']==='web000@ehu.es'){ ?>
  	              <li><a href="reviewingQuizes.php">Review quizes</a></li>
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

    <div id="question-table">
      <h1 id='header'> Review questions </h1>
      <p>Hey teacher, here you can review and edit your students' questions.</p>
      <table id="questions">
        <tr id='tr1'>
          <th width='10%'>Student</th>
          <th width='10%'>Question</th>
          <th width='10%'>Answer</th>
          <th width='10%'>Difficulty</th>
          <th width='10%'>Subject</th>
          <th width='10%'></th>
        </tr>
        <?php
          while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td class='em'>".$row['Email']."</td>";
            echo "<td class='q'>".$row['Question']."<input type='hidden' class='number' value='".$row['Number']."'></td>";
            echo "<td class='a'>".$row['Answer']."</td>";
            echo "<td class='d'>".$row['Difficulty']."</td>";
            echo "<td class='s'>".$row['Subject']."</td>";
            echo "<td class='b'><input type='button' class='button' value='Edit'></td>";
            echo "</tr>";
          }
        ?>
      </table>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2 align="center">EDIT QUESTION</h2>
        </div>
        <div class="modal-body">
          <form id="edit-question">
            <div class="form-group">
              Student: <span id="student"></span><br>
              <input type="hidden" name="student" id="student-email">
              <input type="hidden" name="number" id="number">
              <label for="question">Question:</label>
              <div class="form-input">
                <input class="q-a" type="text" name="question" id="question" placeholder="Question" required>
              </div>
              <label for="answer">Answer:</label>
              <div class="form-input">
                <input class="q-a" type="text" name="answer" id="answer" placeholder="Answer" required>
              </div>
              <label for="subject">Subject:</label>
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
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div id='deleted'>Deleted </div>
          <input type="button" class="modal-button" name="delete" id="delete" value="Delete">
          <input type="button" class="modal-button" name="save" id="save" value="Save">
          <div id='edited'> Edited</div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $('.button').click(function(){
        var row = $(this).closest("tr");
        var student = row.find(".em").text();
        var question = row.find(".q").text();
        var number = row.find(".number").val();
        var answer = row.find(".a").text();
        var difficulty = row.find(".d").text();
        var subject = row.find(".s").text();

        $('#student').html(student);
        $('#student-email').val(student);
        $('#question').val(question);
        $('#number').val(number);
        $('#answer').val(answer);
        $('#subject').val(subject);
        if(difficulty !== "") {
          $("input[name=difficulty][value="+difficulty+"]").prop("checked", true);
        } else {
          $("input[type=radio]").prop("checked",false);
        }
        $('#myModal').css("display","block");
      });

      var changed = false;
      $('#save').click(function(){
        var form = $('#edit-question').serialize();
        $.ajax({
          url: "editQuestion.php",
          type: "post",
          data: form,
          success: function(response){
            if(response === "edited"){
              $('#edited').css("visibility","visible");
              changed = true;
            }
          }
        });
      });

      $('#delete').click(function(){
        var form = $('#edit-question').serialize();
        $.ajax({
          url: "deleteQuestion.php",
          type: "post",
          data: form,
          success: function(response){
            if(response === "deleted"){
              $('#deleted').css("visibility","visible");
              $('#edit-question')[0].reset();
              changed = true;
            }
          }
        })
      });

      function close(){
        $('#myModal').css("display","none");
        if(changed) location.reload();
      }
      // Close when clicked on the X
      var span = $('.close').eq(0);
      span.click(function(){
        close();
      });
      // Close when clicked outside the modal
      window.onclick = function(event) {
        if (event.target == $('#myModal')[0]) close();
      }
      // Close when ESC key pressed
      $(document).keyup(function(e){
        if(e.keyCode == 27) close();
      });
    </script>
  </body>
</html>
