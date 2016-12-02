<?php
  session_start();
  include('connect.php');
  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);
  $sql = "SELECT Name FROM tests WHERE Creator='$email'";
  $query = mysqli_query($connect,$sql);

 ?>
<form id="formquestions" name="formquestions">
  <?php if(mysqli_num_rows($query) == 0){
      echo "You can't add questions if you have no quizes.<br>";
      echo "<a href='#' class='btn btn-default btn-block' id='create-quiz' role='button'>Create a quiz!</a>";
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
    <input class="form-control" type="text" name="question" id="question" placeholder="Question" required>
  </div>
  <div class="form-group">
    <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" required>
  </div>
  <div id="difficulties">
    <label class="radio-inline"><input type="radio" name="difficulty" value="1"> 1</label>
    <label class="radio-inline"><input type="radio" name="difficulty" value="2"> 2</label>
    <label class="radio-inline"><input type="radio" name="difficulty" value="3"> 3</label>
    <label class="radio-inline"><input type="radio" name="difficulty" value="4"> 4</label>
    <label class="radio-inline"><input type="radio" name="difficulty" value="5"> 5</label>
  </div>
  <input class="button" type="button" id='button' name="submit" value="Submit" onclick=javascript:submitForm()>
</form>
