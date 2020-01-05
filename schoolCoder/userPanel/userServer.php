<?php
  if (!isset($_SESSION['id'])) {
   header('location: ../non-existent_page.php');
  }

  if (isset($_GET['logout'])) {
   session_destroy();
  }
  $errorsImportanInfo= array();
  $errorsTeacher = array();
  $rowNumberInUserCode= array();
  $resultUserDecideTest= array();

  function changeTypeToTeacher() {
    global $errorsTeacher;
    if ($_SESSION['type']=="student") {
      echo  printErrorChangeType()."<form method='post' action='#' >
        <div class='form-group row'>
          <label for='inputName' class='col-lg-6 col-md-6 control-label changeTypeLabel' >Искам да стана:</label>
          <div class='col-lg-6 col-md-6'>
            <button type='submit' class='btn primary-btn primary mt-20' name='changeType'>Учител</button>
          </div>
        </div>
      </form>";
    }
  }


  if (isset($_POST['changeType'])) {
    global $DB,$errorsTeacher;
    $userId=$_SESSION['id'];
    $query = "SELECT* from messages where	user_id_send='$userId' and	message_text='Искам да стана учител!';";
    $result = mysqli_query($DB, $query);
    $mesaggeFlag = mysqli_fetch_assoc($result);
    if ($mesaggeFlag==0) {
      $query = "SELECT* from users where	type='admin';";
      mysqli_query($DB, $query);
      $today=date("Y/m/d ")." ".date("h:i:s");
      $result = mysqli_query($DB, $query);
      $mesagge='Искам да стана учител!';
      while ($row=mysqli_fetch_row($result))
      {
        $id=findMaxIdInDataTable("messages");

        $query_Insert = "INSERT INTO messages (id, user_id_send, 	user_id_accept, 	message_text,	seen,		type,	date)
              VALUES('$id','$userId', '$row[0]' , '$mesagge', '0', 'message','$today');";
        mysqli_query($DB, $query_Insert);
        array_push($errorsTeacher, "<div class='sucssesMessage'>");
        array_push($errorsTeacher, $query_Insert);
        array_push($errorsTeacher, "Успешно подаванe на искане!");
        array_push($errorsTeacher, "</div>");
      }
    }
    else {
      array_push($errorsTeacher, "<div class='dangerousMessage'>");
      array_push($errorsTeacher, "Вие сте подавали искане преди!");
      array_push($errorsTeacher, "</div>");
    }
  }

  function printErrorChangeType()  {
    /*global $errorsTeacher;
    if (count($errorsTeacher) > 0) {
      foreach ($errorsTeacher as $error){
        echo $error;
      }
    }-*/
  }


 ?>
