<?php
  include('../../DBConfigoration.php');
  include('../../server.php');
  if ($_SESSION['type']!="teacher") {
    header('location: index.php');
  }
  include('taskPagePHP.php');
  include('testPagePHP.php');
  include('resultOfTestForTeacherPHP.php');

  function checkCurrentSecretIdentifier(){
    global $DB;
    $secretIdentifier= $_POST['secretID'];
    $query = "SELECT * FROM tests  WHERE secret_identifier='$secretIdentifier';";
    $result = mysqli_query($DB, $query);
    if ( mysqli_num_rows($result)==0) {
      return "Невалидна страница!";
    }
    return "";
  }
 ?>
