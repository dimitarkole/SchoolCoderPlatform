<?php
  if (isset($_POST['getSearchDataFromDB'])){
    $fromTaskNumber=1;//$_SESSION['$fromTaskNumber'];
    $countTasksOnOnePage=10;//$_SESSION['$countTasksOnOnePage'];
    getSearchDataFromDB($fromTaskNumber ,$countTasksOnOnePage);
  }

  function getSearchDataFromDB($fromTaskNumber,$countTasksOnOnePage){
    $searchUsers=searchUsers($fromTaskNumber,$countTasksOnOnePage);
    $searchTests=searchTests($fromTaskNumber,$countTasksOnOnePage);
    $searchText=$_POST['searchText'];
    $result= array('searchUsers' => $searchUsers,
      'searchTests'=>$searchTests, "searchText"=>$searchText );
     echo json_encode($result);

  }

  function searchUsers($fromTaskNumber,$countTasksOnOnePage){
    global $DB;
    $resultSearchUsers= array();
    $searchText=$_POST['searchText'];
    $query = "SELECT * FROM users  WHERE user_name LIKE '%$searchText%' or 	e_mail LIKE '%$searchText%';";
    $result = mysqli_query($DB, $query);
    $rowsCount=  mysqli_num_rows($result);
    $countRow=1;
    if (count($result)>0) { // if user exists
      while ($row=mysqli_fetch_row($result))
      {
        if (($countRow>=$fromTaskNumber) && ($countRow<$fromTaskNumber+$countTasksOnOnePage)){
          $messageLeft=array("userName" =>$row[1],"name" => $row[8],
              "family" => $row[8],"e_mail" => $row[2],"type" => $row[4],"avatar" =>$row[10]);
          try {
            $row=mysqli_fetch_row($result);
            $messageRight=array("userName" =>$row[1],"name" => $row[8],
                  "family" => $row[8],"e_mail" => $row[2],"type" => $row[4],"avatar" =>$row[10]);
          } catch (\Exception $e) {
            $messageRight=array("userName" =>"","name" => "",
                  "family" => "","e_mail" => "","type" => "");
          }
          $twoMessage= array("left" => $messageLeft,"rigth" => $messageRight);
          array_push($resultSearchUsers,$twoMessage);
        }
        elseif ($countRow>$fromTaskNumber+$countTasksOnOnePage) {
          break;
        }
        $countRow=$countRow+1;
      }
    }
    $result = array('foundUsers' =>$resultSearchUsers , 'pages'=>$rowsCount);
    return $result;
  }

  function searchTests($fromTaskNumber,$countTasksOnOnePage){
    global $DB;
    $resultSearchTests=array();
    $searchText=$_POST['searchText'];
    $query= "SELECT tests.test_name, users.user_name,
      secret_identifier FROM tests Inner join users ON tests.user_id= users.id WHERE test_name LIKE '%$searchText%';";
    $result = mysqli_query($DB, $query);
    $rowsCount=  mysqli_num_rows($result);
    $countRow=1;
    if (count($result)>0) { // if user exists
      while ($row=mysqli_fetch_row($result))
      {
        if (($countRow>=$fromTaskNumber) && ($countRow<$fromTaskNumber+$countTasksOnOnePage)){
          $messageLeft=array("test_name" =>$row[0], "user" => $row[1], "secretID" =>$row[2]);
          try {
            $row=mysqli_fetch_row($result);
            $messageRight=array("test_name" =>$row[0], "user" => $row[1], "secretID" =>$row[2]);
          } catch (\Exception $e) {
            $messageRight=array("test_name" ,"user" => "");
          }
          $twoMessage= array("left" => $messageLeft,"rigth" => $messageRight);
          array_push($resultSearchTests,$twoMessage);
        }
        elseif ($count>$fromTaskNumber+$countTasksOnOnePage) {
          break;
        }
        $countRow=$countRow+1;
      }
    }
    $result = array('foundTests' =>$resultSearchTests , 'pages'=>$rowsCount);
    return $result;
  }


  if (isset($_POST['getUsersFrendsDataFromDB'])){
    getUsersFrendsDataFromDB();
  }
  function getUsersFrendsDataFromDB(){
    global $DB;
    $userId=$_SESSION['id'];
    $friendUserName=$_POST['userName'];
    $friendId=getUserIdFromDBWithUserName($friendUserName);
    if ($friendId==$userId) echo json_encode("none");
    else {
      $query= "SELECT* from friends WHERE (user_id_1='$friendUserName' and user_id_2='$userId') or";
      $query.="(user_id_1='$userId' and user_id_2='$friendUserName') ;";
      $result = mysqli_query($DB, $query);
      if (mysqli_num_rows($result)==0) echo json_encode("no");
      else echo json_encode("yes");
    }
  }

  function getUserIdFromDBWithUserName($userName)
  {
    global $DB;
    $userId=$_SESSION['id'];
    $query= "SELECT* from users WHERE user_name='$userName';";
    $result = mysqli_query($DB, $query);
    $row=mysqli_fetch_row($result);
    return $row[0];
  }

  if (isset($_POST['sendFriendMessageAtDB'])){
      if (checkSendedFriendMessageAtDB()==1) {
        sendFriendMessageAtDB();
      }
  }

  function sendFriendMessageAtDB(){
    global $DB;
    $userId=$_SESSION['id'];
    $friendUserName=$_POST['userName'];
    $friendId=getUserIdFromDBWithUserName($friendUserName);
    $mesageId=findMaxIdInDataTable("messages");
    $userName= $_SESSION['userName'];
    $message="$userName иска да сте приятели!";
    $date=date("Y-m-d H:i:s");
    $query= "INSERT INTO `messages` (`id`, `user_id_send`, `user_id_accept`, `message_text`, `seen`, `type`, `date`)";
    $query.="VALUES ('$mesageId', '$userId', '$friendId', '$message', '0', 'notification', '$date');";
    $result = mysqli_query($DB, $query);
    echo json_encode("Успешно испратена покана");
  }


  function checkSendedFriendMessageAtDB(){
    global $DB;
    $userId=$_SESSION['id'];
    $friendUserName=$_POST['userName'];
    $friendId=getUserIdFromDBWithUserName($friendUserName);
    $userName= $_SESSION['userName'];
    $mesage="иска да сте приятели!";
    $query= "SELECT* from messages where ((user_id_send='$userId' and  user_id_accept='$friendId')";
    $query.="Or(user_id_send='$friendId' and  user_id_accept='$userId')) and messages LIKE '%$mesage%')";
    $result = mysqli_query($DB, $query);
    if (mysqli_num_rows($result)==0)return 0;
    else return 1;
  }


 ?>
