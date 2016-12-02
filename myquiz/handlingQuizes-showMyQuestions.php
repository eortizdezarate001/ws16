<?php
  session_start();
  include('security.php');
  include('connect.php');
  $email = mysqli_real_escape_string($connect,$_SESSION['user-email']);

  //$sql = "SELECT Question FROM galderak WHERE Email='$email'";
  $sql = "SELECT * FROM tests WHERE Creator='$email'";
  $query = mysqli_query($connect,$sql);

  echo "<div class='panel-group' id='accordion'>";
  while($test=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $testid = $test['ID'];
    $sqlg = "SELECT * FROM galderak WHERE TestID='$testid'";
    $queryg = mysqli_query($connect,$sqlg);
    echo "
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <h4 class='panel-title'>
          <a id='testname' data-toggle='collapse' data-parent='#accordion' href='#collapse".$testid."'><strong>".$test['Name']."</strong></a>
        </h4>
      </div>
      <div id='collapse".$testid."' class='panel-collapse collapse'>
        <ul class='list-group' style='text-align:left'>";
          while($row=mysqli_fetch_array($queryg,MYSQLI_ASSOC)){
            echo "<li class='list-group-item'>".$row['Question']."</li>";
          }
      echo "
        </ul>
      </div>
    </div>
    ";
  }
  echo "</div>";


  //echo "<table><tr id='tr1'><th>".$email." - Questions</th></tr>";

  /*while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    echo "<tr>";
    echo "<td>".$row['Question']."</td>";
    echo "</tr>";
  }
  echo "</table>";*/

  mysqli_close($connect);
?>
