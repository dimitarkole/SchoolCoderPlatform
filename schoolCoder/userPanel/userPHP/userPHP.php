<?php
  include('../../DBConfigoration.php');
  include('../../server.php');
  include('../../commonResources/profilePagePHP.php');
  include('solutionPagePHP.php');
  include('searchPagePHP.php');
  include('indexPagePHP.php');

  if (isset($_POST['logout'])){
    session_destroy();
  }

  if (isset($_POST['getUserDataForHeader'])) {
    $userName= $_SESSION['userName'];
    $user_id=$_SESSION['id'];
    $name=$_SESSION['name'];
    $family= $_SESSION['family'];
    $email= $_SESSION['email'];
    $id= $_SESSION['id'];
    $type= $_SESSION['type'];
    $avatar=$_SESSION['avatar'];
    $query = "SELECT users.user_name, users.name, users.family,users.avatar, messages.message_text
          FROM messages
          INNER JOIN users ON messages.user_id_send = users.id
          Where messages. user_id_accept = '$user_id' and messages.message_text like '%иска да сте приятели!%';";
    $result = mysqli_query($DB, $query);
    $resultsFriend=array();
    while ($row=mysqli_fetch_row($result))
    {
      array_push($resultsFriend,
        array("userName" => $row[0],
         "name" => $row[1], "family" => $row[2],
         "avatar"=>$row[3],"message_text" => $row[4]));
    }

    $resultFun= array('userName' => $userName, 'name'=> $name,
        'family' =>$family,'email' =>$email, 'id' =>$id,
        'friends'=>$resultsFriend,'type' =>$type,'avatar' =>$avatar);

    echo json_encode($resultFun);
  }

  if(isset($_POST['аddFriendAtDB']))
  {
    makeFriends();
    deleteMessages();
  }



  function makeFriends()
  {
    global $DB;
    $friendId=findMaxIdInDataTable("friends");
    $user_id_1=$_SESSION['id'];
    $user_name_Friend=$_POST['friendUserName'];
    $user_id_2=getUserIdFromDBWithUserName($user_name_Friend);
    $query = "INSERT INTO  friends (id,user_id_1, user_id_2)
          VALUES('$friendId','$user_id_1','$user_id_2');";
    mysqli_query($DB, $query);
    echo json_encode("Успешно сприятеляване!");
  }

  if(isset($_POST['deleteFriend']))
  {
    deleteMessages();
  }

  function deleteMessages()
  {
    global $DB;
    $user_id_1=$_SESSION['id'];
    $user_name_Friend=$_POST['friendUserName'];
    $user_id_2=getUserIdFromDBWithUserName($user_name_Friend);
    $message="$user_name_Friend иска да сте приятели!";
    $query = "DELETE FROM messages WHERE user_id_send='$user_id_2'
        and user_id_accept='$user_id_1' and message_text='$message';";
    mysqli_query($DB, $query);
  }


 ?>
