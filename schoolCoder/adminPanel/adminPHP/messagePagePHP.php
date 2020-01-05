<?php
  if(isset($_POST['getMessagesFromDB'])){
    getMessagesFromDB();
  }
  //getMessagesFromDB();
  function getMessagesFromDB(){
    global $DB;
    $userId=$_SESSION['id'];
    $user_check_query = "Select  user_id_send, user_id_accept, date from messages
        where user_id_accept='$userId' group by user_id_send order by date desc;";
    $result = mysqli_query($DB, $user_check_query);
    $allMessages= array();
    while ($row=mysqli_fetch_row($result))
    {
      $messageLeft=array("senderUserName" => getUserNameOfDB($row[0]),
        "senderUserId" => $row[0],
        "acceptUserName" => getUserNameOfDB($row[1]),
        "acceptUserId" => $row[1],
        "lastMessage" =>getLastMessageOfDB($row[0],$row[1]),
        "date" =>$row[2]);
      try {
        $row=mysqli_fetch_row($result);
        $messageRight=array("senderUserName" => getUserNameOfDB($row[0]),
          "senderUserId" => $row[0],
          "acceptUserName" => getUserNameOfDB($row[1]),
          "acceptUserId" => $row[1],
          "lastMessage" =>getLastMessageOfDB($row[0],$row[1]),
          "date" =>$row[2]);
      } catch (\Exception $e) {
        $messageRight=array("senderUserName" => "",
          "acceptUserName" =>"",
          "acceptUserId" => "",
          "lastMessage" =>"",
          "date" =>"");
      }
      $twoMessage= array("left" => $messageLeft,"rigth" => $messageRight);
      array_push($allMessages,$twoMessage);
    }
    echo json_encode($allMessages);
  }

  function getUserNameOfDB($id){
		global $DB;
		$user_check_query = "Select* from users where id='$id';";
		$result = mysqli_query($DB, $user_check_query);
		while ($rowWhitUser=mysqli_fetch_row($result))
		{
				return $rowWhitUser[1];
		}
	}

  function getLastMessageOfDB($idUserSender, $idUserAccept){
		global $DB;
		$user_check_query = "Select message_text from messages where user_id_send='$idUserSender' and user_id_accept='$idUserAccept' order by date desc;";
		$result = mysqli_query($DB, $user_check_query);
		$rowWhitUser=mysqli_fetch_row($result);
		$message=$rowWhitUser[0];
		if (strlen($message)>30)$message=substr($message, 0, 29)."...";
		return $message;
  }

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


 ?>
