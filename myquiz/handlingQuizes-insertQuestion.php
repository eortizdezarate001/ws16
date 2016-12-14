<?php
  session_start();
  include('connect.php');
  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);
  $sql = "SELECT Name FROM tests WHERE Creator='$email'";
  $query = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($query);

 ?>
<form id="formquestions" name="formquestions">
  <?php if($count == 0){
      echo "You can't add questions if you have no quizes.<br>";
      echo "<a href='createQuiz.php' class='btn btn-default btn-block' id='create-quiz' role='button'>Create a quiz!</a>";
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
    <?php if($count == 0){ ?>
      <input class="form-control" type="text" name="question" id="question" placeholder="Question" disabled>
    <?php } else{ ?>
      <input class="form-control" type="text" name="question" id="question" placeholder="Question" required>
    <?php } ?>
  </div>
  <div class="form-group">
    <?php if($count == 0){ ?>
      <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" disabled>
    <?php } else{ ?>
      <input class="form-control" type="text" name="answer" id="answer" placeholder="Answer" required>
    <?php } ?>
  </div>
  <?php if($count == 0){ ?>
    <input class="btn btn-primary btn-block disabled" type="button" id='button' name="submit" value="Submit">
  <?php } else{ ?>
    <div id="difficulties">
      <label class="radio-inline"><input type="radio" name="difficulty" value="1"> 1</label>
      <label class="radio-inline"><input type="radio" name="difficulty" value="2"> 2</label>
      <label class="radio-inline"><input type="radio" name="difficulty" value="3"> 3</label>
      <label class="radio-inline"><input type="radio" name="difficulty" value="4"> 4</label>
      <label class="radio-inline"><input type="radio" name="difficulty" value="5"> 5</label>
    </div>
    <input class="btn btn-primary btn-block" type="button" id='button' name="submit" value="Submit" onclick=javascript:submitForm()>
  <?php } ?>
</form>
