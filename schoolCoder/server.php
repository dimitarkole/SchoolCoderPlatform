<?php
session_start();
// initializing variables
$errorsRegist = "";
$errorsLogin=  "";
$updateProfileError= array();

date_default_timezone_set('Europe/Sofia');
// connect to the database
try {
  include('DBConfigoration.php');
} catch (\Exception $e) {
  include('..\DBConfigoration.php');
}

// REGISTER USER
if (isset($_POST['registration_user'])){
  // receive all input values from the form
  $userName = mysqli_real_escape_string($DB, $_POST['userName']);
  $email = mysqli_real_escape_string($DB, $_POST['email']);
  $password_1 = mysqli_real_escape_string($DB, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($DB, $_POST['password_2']);
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  CheckEmptyParametres($userName,"потребителско име!");
  CheckEmptyParametres($email,"e-mail адрес!");
  CheckEmptyParametres($password_1,"парола!");
  if ($password_1 != $password_2){
     $errorsRegist.="Двете пароли не съвпадат!<br>";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorsRegist.= "Невалиден формат на email!<br>";
  }

  if(strlen($password_1)<6){
     $errorsRegist.="Паролата трябва да има поне шест символа!<br>";
  }
  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  CheckEmptyRegistedInDB($userName,$email);
  // Finally, register user if there are no errors in the form
  if ($errorsRegist ==""){
    registrationPerson($userName, $password_1,  $email, '3' , '0' , '1');
    $errorsRegist= "<div class='successMessage'>Успешна регистрация!</div>";
  }
  else {
    $errorsRegist="<div class='dangerousMessage'>".$errorsRegist."</div>";
  }
  echo $errorsRegist;
}

function CheckEmptyParametres($data, $mesagge) {
    global $errorsRegist, $errorsLogin,$updateProfileError;
    if (empty($data)) {
      if (isset($_POST['registration_user'])){
        $errorsRegist.= "Моля попълнете ".$mesagge."<br>";
      }
      elseif (isset($_POST['login'])) $errorsLogin.="Моля попълнете ".$mesagge."<br>";
      elseif (isset($_POST['updateProfile']))
      {
        array_push($updateProfileError, "Моля попълнете ".$mesagge);
      }
    }
}

function CheckEmptyRegistedInDB($userName,$email){
  global $DB, $errorsRegist;
  $user_check_query = "SELECT * FROM users WHERE user_name='$userName' OR e_mail='$email';";
  $result = mysqli_query($DB, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user) { // if user exists
    if ($user['user_name'] == $userName) {
      $errorsRegist.= "Потребителско име е заето!<br>";
    }
    if ($user['e_mail'] == $email) {
      $errorsRegist.="E-mail адреса е използван!<br>";
    }
  }
}

function registrationPerson($userName,$password, $email, $type, $sesia, $approved){
  global $DB, $errors;
  $password = md5($password);//encrypt the password before saving in the database
  $id=findMaxIdInDataTable("users");
  $query = "INSERT INTO users ( id,user_name, e_mail,	password, 		type,	approved,
    rank_upload_task,rank_solved_task, name, family,avatar)
        VALUES('$id','$userName','$email', '$password' ,  '$type',  '$approved','0','0','','', 'user-default.png')";
  mysqli_query($DB, $query);
}

// LOGIN USER
  if (isset($_POST['login_user'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    CheckEmptyParametres($userName,"потребителско име!");
    CheckEmptyParametres($password,"парола!");

    if ($errorsLogin=="") {
    	$password = md5($password);
    	$query = "SELECT * FROM users WHERE user_name='$userName' and password='$password';";
    	$results = mysqli_query($DB, $query);
      $resultWithUser = mysqli_fetch_assoc($results);
      if ($resultWithUser>0) {
        $_SESSION['userName'] = $userName;
        $_SESSION['name'] = $resultWithUser['name'];
        $_SESSION['family'] = $resultWithUser['family'];
        $_SESSION['email']= $resultWithUser['e_mail'];
        $_SESSION['id'] = $resultWithUser['id'];
        $_SESSION['type'] = $resultWithUser['type'];
        $_SESSION['avatar'] = $resultWithUser['avatar'];
        if($resultWithUser['type']=="admin")$errorsLogin='location: adminPanel/index.php';
        else $errorsLogin='location: userPanel/index.php';
      }
      else $errorsLogin.="Грешено потребителско име/парола.";
    }
    echo $errorsLogin;
  }

  function findMaxIdInDataTable($dataTable)
  {
    global $DB;
    $query = "SELECT max(id) FROM ".$dataTable.";";
    $results = mysqli_query($DB, $query);
    $resultMaxId = mysqli_fetch_assoc($results);
    $maxId=-1;
    if ($resultMaxId>0) {
        $maxId=$resultMaxId['max(id)'];
    }
    return $maxId+1;
  }

  function updateSite()
  {
    global $DB;
    $date=date("Y-m-d H:i:s");
    $query = "SELECT * FROM `updatewebsitemessages` WHERE close_time<'$date' and open_time>'$date';";
    $results = mysqli_query($DB, $query);
    if (mysqli_num_rows($result)>0) {

    }
  }
?>
