<?php
//	session_start();
	$bestStudent = array();
	$worseStudent= array();
	$bestTeacher= array();
	$worseTeacher=array();
	$mesaggesCount=0;
	$userSenderFamily="";
	$name="none";
	$userNameSender="";
	 $countME="j";
	if (!isset($_SESSION['id'])) {
		header('location: ../non-existent_page.php');

	}
	else {
		global $mesaggesCount;
		$id= $_SESSION['id'];
		$countMessageForAdmin_query = "Select count(*) from messages where user_id_accept ='$id' and seen=0 group by user_id_send;";
		$result = mysqli_query($DB, $countMessageForAdmin_query);
		$mesaggesCount = mysqli_num_rows($result);
		//echo "mesaggesCount".$mesaggesCount;
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['userName']);
		unset($_SESSION['id']);
	}

	$userInSystem = array(
		array("label"=>"Администартор", "y"=>getCountOfUsers("admin")),
		array("label"=>"Учители", "y"=>getCountOfUsers("teacher")),
		array("label"=>"Ученици", "y"=>getCountOfUsers("student")),
	);

	//messagesFromDB();
	function dataForIndex(){
		getBestStudent();
		getWorseStudent();
		getBestTeacher();
		getWorseTeacher();
	}

	function getCountOfUsers($typeOfUsers){
	  global $DB;
	  $user_check_query = "Select count(type) as count from users where type='$typeOfUsers';";
	  $result = mysqli_query($DB, $user_check_query);
	  $user = mysqli_fetch_assoc($result);
	  if ($user) { // if user exists
	    if ($user['count'] === "NULL")return 0;
	    else  return $user['count'];
	  }
	}

	function getBestStudent(){
	  global $DB,$bestStudent;
	  $user_check_query = "Select user_name,rank_solved_task from users where type='student' order by rank_solved_task desc;";
	  $result = mysqli_query($DB, $user_check_query);
		$count=0;
		while (($row=mysqli_fetch_row($result))&&($count<5))
	  {
			array_push($bestStudent,array("y" => $row[1], "label" => $row[0] ));
			$count++;
	  }
	}

	function getWorseStudent(){
	  global $DB,$worseStudent;
	  $user_check_query = "Select user_name,rank_solved_task from users where type='student' order by rank_solved_task;";
	  $result = mysqli_query($DB, $user_check_query);
		$count=0;
		while (($row=mysqli_fetch_row($result))&&($count<5))
	  {
			array_push($worseStudent,array("y" => $row[1], "label" => $row[0] ));
			$count++;
	  }
	}

	function getBestTeacher(){
	  global $DB,$bestTeacher;
		$user_check_query = "Select user_name,rank_solved_task from users where type='teacher' order by rank_upload_task desc;";
		$result = mysqli_query($DB, $user_check_query);
		$count=0;
		while (($row=mysqli_fetch_row($result))&&($count<5))
		{
			array_push($bestTeacher,array("y" => $row[1], "label" => $row[0] ));
			$count++;
		}
	}

	function getWorseTeacher(){
	  global $DB,$worseTeacher;
		$user_check_query = "Select user_name,rank_solved_task from users where type='teacher' order by rank_upload_task;";
		$result = mysqli_query($DB, $user_check_query);
		$count=0;
		while (($row=mysqli_fetch_row($result))&&($count<5))
		{
			array_push($worseTeacher,array("y" => $row[1], "label" => $row[0] ));
			$count++;
		}
	}










?>
