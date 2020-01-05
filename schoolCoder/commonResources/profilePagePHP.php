<?php

  if (isset($_POST['getProfileDataFromDB'])) {
    $user_id=$_SESSION['id'];
    $query = "SELECT * FROM users  WHERE id='$user_id';";
    $result = mysqli_query($DB, $query);
    $row=mysqli_fetch_row($result);
    $result = array(  'userName' => $row[1],'avatar' => $row[10],
      'email' => $row[2],'type' => $row[4],
      'name' => $row[8],'family' => $row[9],);
    echo json_encode($result);
  }

  if (isset($_POST['changeAvatarAtDB'])) {
    changeAvatarAtDB();
  }

  function changeAvatarAtDB()
  {
    $image=$_POST['image'];
    if ($image['file']['size']>0) {
     echo json_encode("11");
    /*  if ($image['file']['size']<=153600) {
        if (move_uploaded_file($image['file']['tmp_name'],'../../img/userImg/images/'.$image['file']['name'])) {
          //upload
          echo json_encode("zdr");
          }
        }
        else {
          // size is bigger
          echo json_encode("size is bigger");

      }*/
    }
  }

  if (isset($_POST['savePasswordAtDB'])) {
    savePasswordAtDB();
  }

  function savePasswordAtDB()
  {
   if ($_POST['newPassword']!=$_POST['renewPassword']) $errors="Новите пароли не съвпадат!<br>";
    $newPassword=$_POST['newPassword'];
    $errors="";
    if(strlen($newPassword)<6)$errors.="Паролата трябва да има поне шест символа!<br>";
    if(checkOldPasswordAtDB()==0) $errors.="Грешна страра парола!<br>";
    if($errors!="")echo json_encode($errors);
    else{
      global $DB;
      $user_id=$_SESSION['id'];
      $newPassword=md5($newPassword);
      $query = "UPDATE users SET password = '$newPassword' WHERE id = '$user_id';";
      mysqli_query($DB, $query);
      echo json_encode("Успешно променена парола!");
    }

  }

  function checkOldPasswordAtDB()
  {
    global $DB;
    $user_id=$_SESSION['id'];
    $oldPassword= md5($_POST['oldPassword']);
    $query = "SELECT * FROM users  WHERE id='$user_id' and password='$oldPassword';";

    $result = mysqli_query($DB, $query);
    $row=mysqli_fetch_row($result);
    return mysqli_num_rows($result);
  }

  if (isset($_POST['updateProfile'])) {
    $name=$_POST['name'];
    $family=$_POST['family'];
    if(($name!="")&&($family!=""))updateProfile();
    else {
      echo json_encode("Моля попълнете име и фамиля, за да актуализирате профила си!");
    }
  }

  function updateProfile()
  {
    global $DB;
    $name= $_POST['name'];
    $family= $_POST['family'];
    $user_id=$_SESSION['id'];
    $query = "UPDATE  users set name='$name', family='$family' where id='$user_id';";
    mysqli_query($DB, $query);
    echo json_encode("Успешно редактирани данни!");
  }

  if(isset($_POST['makeMeTeacherAtDB']))
  {
    if (searchMakeMeTeacherMessageAtDB()==0) {
      makeMeTeacherAtDB();
    }
    else {
       echo json_encode("Вие сте подали искане по-рано!");
    }
  }

  function makeMeTeacherAtDB()
  {
    global $DB;
    $query = "SELECT* from users where type='admin';";
    $result = mysqli_query($DB, $query);

    while ($row=mysqli_fetch_row($result)) {
      $message="Искам да стана учител!";
      $user_id=$_SESSION['id'];
      $date=date("Y-m-d H:i:s");
      $adminUserId=$row[0];
      $messageId=findMaxIdInDataTable("messages");

      $query = "INSERT INTO  messages (id,user_id_send, user_id_accept, message_text, seen, type, date)
            VALUES('$messageId','$user_id','$adminUserId', '$message','0', 'message' ,  '$date');";
      mysqli_query($DB, $query);
    }
    echo json_encode("Вие изпратихте успешно Вашето искане!");

  }

  function searchMakeMeTeacherMessageAtDB()
  {
    global $DB;
    $query = "SELECT* from users where type='admin';";
    $result = mysqli_query($DB, $query);

    while ($row=mysqli_fetch_row($result)) {
      $message="Искам да стана учител!";
      $user_id=$_SESSION['id'];
      $date=date("Y-m-d H:i:s");
      $adminUserId=$row[0];
      $messageId=findMaxIdInDataTable("messages");

      $query = "SELECT* from messages where user_id_send='$user_id'
          and user_id_accept='$adminUserId' and message_text='$message';";
      $result = mysqli_query($DB, $query);
      if (mysqli_num_rows($result)>0) {
        return 1;
      }
    }
    return 0;
  }
 ?>
