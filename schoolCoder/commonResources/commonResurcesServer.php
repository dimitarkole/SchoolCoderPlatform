<?php
  if (isset($_POST['changeAvatar'])) {
    global $updateAvatarError;
    array_push($updateAvatarError,"I don't work!!!");

  }

  if (isset($_POST['updateProfile'])) {
    global $updateProfileError;
    $name = mysqli_real_escape_string($DB, $_POST['name']);
    $family = mysqli_real_escape_string($DB, $_POST['family']);
    CheckEmptyParametres($name,"име!");
    CheckEmptyParametres($family,"фамилия!");
    if (count($updateProfileError)<1)updateProfile($name,$family);
  }



  function updateProfile($name, $family)
  {
    global $DB,$updateProfileError;
    $id= $_SESSION['id'];
    $query = "UPDATE users SET name='$name', family='$family' WHERE id ='$id';";
    mysqli_query($DB, $query);
    $_SESSION['name']=$name;
    $_SESSION['family']=$family;
    array_push($updateProfileError,"Успешно редакртиран профил!");
  }


  function printUpdateProfileError()
  {
    global $updateProfileError;
    if (count($updateProfileError) > 0)
    {
      $divClass="dangerousMessage";
      if($updateProfileError[0]=="Успешно редакртиран профил!")$divClass="sucssesMessage";
      echo "<div class=$divClass>";
      foreach ($updateProfileError as $error){
       echo $error."<br>";
      }
      echo "</div><br>";
    }
  }

  function printUpdateAvatarError()
  {
    global $updateAvatarError;
    if (count($updateAvatarError) > 0)
    {
      $divClass="dangerousMessage";
      if($updateAvatarError[0]=="Успешно редакртиран профил!")$divClass="sucssesMessage";
      echo "<div class=$divClass>";
      foreach ($updateAvatarError as $error){
       echo $error."<br>";
      }
      echo "</div><br>";

    }
  }


 ?>
