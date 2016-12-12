<?php
  session_start();
  include('connect.php');
  include('security.php');
  if($_SESSION['user-email']!=='web000@ehu.es'){
    header('Location: layout.php');
  }

  $sql = "SELECT * FROM tests ORDER BY ID";
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
      .form-control {
    		border: 1px solid #000;
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
  			<h1>Review quizes and questions</h1>
        Hey teacher, here you can review and edit your students' quizes and questions.
  		</div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel-group" id="accordion">
            <?php while($test=mysqli_fetch_array($query,MYSQLI_ASSOC)){ ?>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="<?php echo "#collapse".$test['ID']; ?>" class="btn-block" id="testname"><?php echo $test['Name'].' ('.$test['Creator'].')'; ?></a>
                  </h4>
                </div>
                <div id="<?php echo "collapse".$test['ID']; ?>" class="panel-collapse collapse">
                  <div class="panel-body table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th width="40%">Question</th>
                          <th width="40%">Answer</th>
                          <th width="10%">Difficulty</th>
                          <th width="10%"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $qsql = "SELECT * FROM galderak WHERE TestID='$test[ID]'";
                          $qquery = mysqli_query($connect,$qsql);
                          while($question=mysqli_fetch_array($qquery,MYSQLI_ASSOC)){
                            echo "<tr>";
                            echo "<td class='q'>".$question['Question']."<input type='hidden' class='number' value='".$question['Number']."'></td>";
                            echo "<td class='a'>".$question['Answer']."</td>";
                            echo "<td class='d'>".$question['Difficulty']."</td>";
                            echo "<td><input type='button' class='btn btn-primary btn-block' value='Edit' data-toggle='modal' data-target='#myModal' onclick='edit(this)'></td>";
                            echo "</tr>";
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit question</h4>
          </div>
          <div class="modal-body">
            <form id="edit-question">
              <input type="hidden" name="number" id="number">
              <input type="hidden" name="testid" id="testid">
              <div class="form-group">
                <label for="question">Question:</label>
                <input class="form-control" type="text" name="question" id="question" placeholder="Question" required>
              </div>
              <div class="form-group">
                <label for="answer">Answer:</label>
                <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" required>
              </div>
              <div id="difficulty" style="text-align:center">
                <label class="radio-inline"><input type="radio" name="difficulty" value="1"> 1</label>
                <label class="radio-inline"><input type="radio" name="difficulty" value="2"> 2</label>
                <label class="radio-inline"><input type="radio" name="difficulty" value="3"> 3</label>
                <label class="radio-inline"><input type="radio" name="difficulty" value="4"> 4</label>
                <label class="radio-inline"><input type="radio" name="difficulty" value="5"> 5</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="btn-group">
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
        var question = row.find(".q").text();
        var number = row.find(".number").val();
        var answer = row.find(".a").text();
        var difficulty = row.find(".d").text();

        $('#save').val("Save");
        $('#save').prop('disabled',false);
        $('#delete').val("Delete");
        $('#delete').prop('disabled',false);

        $('#question').val(question);
        $('#number').val(number);
        $('#answer').val(answer);
        if(difficulty !== "") {
          $("input[name=difficulty][value="+difficulty+"]").prop("checked", true);
        } else {
          $("input[type=radio]").prop("checked",false);
        }
      }

      $('#save').click(function(){
        var form = $('#edit-question').serialize();
        $.post(
          "editQuestion.php",
          form,
          function(response){
            if(response === "edited"){
              $('#save').val("Saved");
              $('#save').prop('disabled',true);

              selectedRow.find(".btn").val("Edited");
              selectedRow.find(".btn").prop('disabled',true);
              selectedRow.find(".q").text($('#question').val());
              selectedRow.find(".a").text($('#answer').val());
              selectedRow.find(".d").text($('input[name=difficulty]:checked').val());
            }
          }
        );
      });

      $('#delete').click(function(){
        var form = $('#edit-question').serialize();
        $.post(
          "deleteQuestion.php",
          form,
          function(response){
            if(response === "deleted"){
              $('#delete').val("Deleted");
              $('#delete').prop('disabled',true);

              selectedRow.remove();
            }
          }
        );
      });

      function close(){
        $('#myModal').css("display","none");
        if(changed) location.reload();
      }
    </script>
  </body>
</html>
