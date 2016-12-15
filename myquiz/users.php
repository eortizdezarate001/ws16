<?php
  session_start();
  include('connect.php');
  include('security.php');
  if($_SESSION['user-email']!=='web000@ehu.es'){
    header('Location: layout.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registered users</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,400" rel="stylesheet">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <style>
      a#testname:hover, a#testname:active, a#testname:link, a#testname:visited {
        text-decoration: none;
      }
      .panel-body {
        padding: 10px;
        padding-bottom: 0px;
      }
      .table>tbody>tr>td{
        vertical-align: middle;
      }
      .form-group {
        margin-bottom: 5px;
      }
      #email {
        background-color: white;
      }
      .form-control {
    		border: 1px solid #000;
    	}
      .modal-footer>.btn-group {
        float: right;
        display: none;
      }
      .modal-footer>.btn-group>.btn{
        width: 100px;
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
  					<?php if(isset($_SESSION['auth'])){ ?>
            <li class="dropdown">
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
            <li class="dropdown active">
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
  			<h1>Registered users</h1>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel-body table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Specialty</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql = "SELECT * FROM erabiltzailea";
                  $query = mysqli_query($connect,$sql);
                  while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
                    echo "<tr>";
                    echo "<td class='fn'>".$row['First name']."</td>";
                    echo "<td class='ln'>".$row['Last name']."</td>";
                    echo "<td class='em'>".$row['Email']."</td>";
                    echo "<td class='ph'>".$row['Phone']."</td>";
                    echo "<td class='sp'>".$row['Specialty'];
                    echo "<input type='hidden' class='attempts' value='".$row['Attempts']."'>";
                    if(empty($row['Image'])){
                      echo "<input type='hidden' class='imagedata' value=''>";
                    } else{
                      echo "<input type='hidden' class='imagedata' value='".base64_encode($row['Image'])."'>";
                    }
                    echo "</td>";
                    echo "<td><input type='button' class='btn btn-primary btn-block' value='Edit' data-toggle='modal' data-target='#myModal' onclick='edit(this)'></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit user</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-5 col-sm-offset-1">
                <form id="edit-user">
                  <input type="hidden" name="attempts" id="attempts">
                  <div class="form-group">
                    <label for="question">First name:</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First name" required>
                  </div>
                  <div class="form-group">
                    <label for="answer">Last name:</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last name" required>
                  </div>
                  <div class="form-group">
                    <label for="answer">Email:</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email" readonly>
                  </div>
                  <div class="form-group">
                    <label for="answer">Phone:</label>
                    <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone" required>
                  </div>
                  <div class="form-group">
                    <label for="answer">Specialty:</label>
                    <input class="form-control" type="text" name="specialty" id="specialty" placeholder="Specialty" required>
                  </div>
                  <div class="form-group" id="status-div" style="margin-top: 10px">
                    <label for="answer">Status: </label>
                    <span id="status" style="color:#cc0000">Blocked</p>
                  </div>
                </form>
              </div>
              <div class="col-sm-offset-1 col-sm-4">
                <img src="" id="image" width="300" alt="User avatar"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group" id="btn2">
              <input type="button" class="btn btn-danger" name="delete" id="delete" value="Delete">
              <input type="button" class="btn btn-primary" name="save" id="save" value="Save">
            </div>
            <div class="btn-group" id="btn3">
              <input type="button" class="btn btn-warning" name="unblock" id="unblock" value="Unblock">
              <input type="button" class="btn btn-danger" name="delete" id="delete" value="Delete">
              <input type="button" class="btn btn-primary" name="save" id="save" value="Save">
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var selectedRow;
      function edit(b){
        var row = $(b).closest("tr");
        selectedRow = row;
        var firstname = row.find(".fn").text();
        var lastname = row.find(".ln").text();
        var email = row.find(".em").text();
        var phone = row.find(".ph").text();
        var specialty = row.find(".sp").text();
        var attempts = row.find(".attempts").val();
        var image = row.find(".imagedata").val();

        $('#image').css('display','block');
        if(image == ""){
          $('#image').css('display','none');
        } else{
          $('#image').attr('src','data:image/jpeg;base64,'+image);
        }

        $('#save').val("Save");
        $('#save').prop('disabled',false);
        $('#delete').val("Delete");
        $('#delete').prop('disabled',false);
        $('#status-div').css('display','none');
        $('#unblock').css('display','none');

        $('#firstname').val(firstname);
        $('#lastname').val(lastname);
        $('#email').val(email);
        $('#phone').val(phone);
        $('#specialty').val(specialty);

        if(attempts == 3){
          $('#status-div').css('display','block');
          $('#btn3').css('display','block');
        } else{
          $('#btn2').css('display','block');
        }

      }

      $('#save').click(function(){
        var form = $('#edit-user').serialize();
        $.post(
          "editUser.php",
          form,
          function(response){
            if(response === "edited"){
              $('#save').val("Saved");
              $('#save').prop('disabled',true);

              selectedRow.find(".btn").val("Edited");
              selectedRow.find(".btn").prop('disabled',true);
              selectedRow.find(".fn").text($('#firstname').val());
              selectedRow.find(".ln").text($('#lastname').val());
              selectedRow.find(".ph").text($('#phone').val());
              selectedRow.find(".sp").text($('#specialty').val());

            } else alert(response);
          }
        );
      });

      $('#delete').click(function(){
        var form = $('#edit-user').serialize();
        $.post(
          "deleteUser.php",
          form,
          function(response){
            if(response === "deleted"){
              $('#delete').val("Deleted");
              $('#delete').prop('disabled',true);

              selectedRow.remove();
            } else alert(response);
          }
        );
      });

      $('#unblock').click(function(){
        var form = $('#edit-user').serialize();
        $.post(
          "unblockUser.php",
          form,
          function(response){
            if(response === "unblocked"){
              $('#unblock').val("Unblocked");
              $('#unblock').prop('disabled',true);
              $('#status').html("<font color='#00cc00'>Unblocked</font>");
            } else alert(response);
          }
        )
      });
    </script>
  </body>
</html>
