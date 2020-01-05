<?php
  if(isset($_POST['getAddedProblemsFromDB'])){

    $fromProblemsNumber= $_POST['fromProblemsNumber'];
    $countProblemsOnOnePage= $_POST['countProblemsOnOnePage'];
    getAddedProblemsFromDB($fromProblemsNumber ,$countProblemsOnOnePage);
  }

  function getAddedProblemsFromDB($fromProblemsNumber,$countProblemsOnOnePage){
    global $DB;
    $user_check_query = "Select* from updatewebsitemessages;";
    $result = mysqli_query($DB, $user_check_query);

    $resultProblems= array();
    $rowsCount=  mysqli_num_rows($result);
    $count=1;

    while ($row=mysqli_fetch_row($result))
    {
      if (($count>=$fromProblemsNumber) && ($count<$fromProblemsNumber+$countProblemsOnOnePage)){
        array_push($resultProblems,
            array("count" => $count,
            "purpose" => $row[2], "close_time" => $row[3],
            "open_time" => $row[4]));
      }
      else if ($count>$fromProblemsNumber+$countProblemsOnOnePage)break;
      $count=$count+1;
    }
    $results= array('resultProblems' => $resultProblems,'rowsCount'=> $rowsCount);
    echo json_encode($results);
  }

  if(isset($_POST['addProblemAtDB'])){
    addProblemAtDB();
  }

  function addProblemAtDB(){
    global $DB;

    $adminId=$_SESSION['id'];
    $ProblemId=findMaxIdInDataTable("updatewebsitemessages");
    $ProblemData=$_POST['ProblemData'];
    $purpose=$_POST['purpose'];
    $close_time=$_POST['close_time'];
    $open_time=$_POST['open_time'];

    $user_check_query = "INSERT INTO  updatewebsitemessages (id, user_id, purpose,close_time,open_time)
          VALUES('$ProblemId','$adminId','$purpose', '$close_time' ,  '$open_time');";
    mysqli_query($DB, $user_check_query);

    echo json_encode("Успешно добавен стоп на системата!");
  }
/*



  if (isset($_POST['getMessageDataFromDB'])) {
    getMessageDataFromDB();
  }

  function getMessageDataFromDB(){
    global $DB;
    $adminId=$_SESSION['id'];
    $userSenderId=$_POST['userSenderId'];
    $query = "SELECT* from messages WHERE (user_id_send='$userSenderId' and user_id_accept='$adminId')
        or (user_id_send='$adminId' and user_id_accept='$userSenderId') ORDER by date DESC;";
    $result = mysqli_query($DB, $query);
    $messages= array();

    while ($row=mysqli_fetch_row($result))
    {
      $messageFrom="admin";
      if ($row[1]==$userSenderId) $messageFrom="user";
      $message=array("messageFrom" => $messageFrom, "message_text" =>   $row[3],
            "user_id_send" => $row[1]);

      array_push($messages,$message);
    }
    echo json_encode($messages);
  }


  if (isset($_POST['makeUserTeacherAtDB'])) {
    updateProfile('teacher');
    sendMessageForTeacherUser("Вашият статус бе променен на учител!");
  }

   function updateProfile($type){
     global $DB;
     $userId=$_POST['userId'];
     $query = "UPDATE users SET type='$type' WHERE id='$userId';";
     mysqli_query($DB, $query);
   }

   function sendMessageForTeacherUser($message){
     global $DB;
     $user_id_send=$_SESSION['id'];
     $user_id_accept=$_POST['userId'];
     $messageId=findMaxIdInDataTable("messages");
     $date=date("Y-m-d h:i:s");

     $query = "INSERT INTO messages(id,user_id_send,user_id_accept,message_text,seen, type,date)
        VALUES('$messageId','$user_id_send','$user_id_accept', '$message' ,  '0','notification', '$date');";
     mysqli_query($DB, $query);
   }

   if (isset($_POST['makeUserStudentAtDB'])) {
     updateProfile('student');
     sendMessageForTeacherUser("Вашият статус бе променен на ученик!");
   }

   if (isset($_POST['deleteUserAtDB'])) {
     $deleteUserId=$_POST['userId'];
     $query = "Delete from users WHERE id='$deleteUserId';";
     mysqli_query($DB, $query);
   }

*/
 ?>
