<?php
  if (isset($_POST['searchLastAddedTests'])) {
    $tests = array('lastAdded' => searchLastAddedTests(), 'lastFriendAddedTests' => searchLastAddedTestsFromFriend());
    echo json_encode($tests);
  }

  function searchLastAddedTests(){
    global $DB;
    $lastAddedTests=array();
    $query= "SELECT tests.test_name, users.user_name, tests.date, secret_identifier FROM tests Inner join users ON tests.user_id=users.id ORDER BY date DESC;";
    $result = mysqli_query($DB, $query);
    $rowsCount=  mysqli_num_rows($result);
    $countRow=1;
    $countTasksOnOnePage=11;
    if (count($result)>0) { // if user exists
      while ($row=mysqli_fetch_row($result))
      {
        $message=array("test_name" =>$row[0], "user" => $row[1], "secretID" =>$row[3]);
        array_push($lastAddedTests,$message);
        $countRow=$countRow+1;
        if ($countRow==$countTasksOnOnePage)break;
      }
    }
    return $lastAddedTests;
  }

//searchLastAddedTestsFromFriend();
  function searchLastAddedTestsFromFriend(){
    global $DB;
    $friendAddedTests=array();
    $friendsIds=searchFriend();
    if ($friendsIds=="") return 0;
    else{
      $query= "SELECT tests.test_name, users.user_name, tests.date, secret_identifier
          FROM tests Inner join users ON tests.user_id=users.id WHERE $friendsIds ORDER BY date DESC;";
      $result = mysqli_query($DB, $query);
      $rowsCount=  mysqli_num_rows($result);
      $countRow=1;
      $countTasksOnOnePage=11;
      if (count($result)>0) { // if user exists
        while ($row=mysqli_fetch_row($result))
        {
          $message=array("test_name" =>$row[0], "user" => $row[1], "secretID" =>$row[3]);
          array_push($friendAddedTests,$message);
          $countRow=$countRow+1;
          if ($countRow==$countTasksOnOnePage)break;
        }
      }
      return $friendAddedTests;
    }

  }

  function searchFriend()
  {
    global $DB;
    $returnText="";
    $user_id=$_SESSION['id'];
    $query= "SELECT* from friends WHERE user_id_1='$user_id';";
    $result = mysqli_query($DB, $query);
    $rowsCount=  mysqli_num_rows($result);
    if (count($result)>0) { // if user exists
      while ($row=mysqli_fetch_row($result))
      {
        $friend_id=$row[2];
        $returnText.=" and user_id='$friend_id'";
      }
    }
    $returnText = substr($returnText, 4, strlen($returnText)-1);
    //echo json_encode($returnText);
    return $returnText;
  }
 ?>
