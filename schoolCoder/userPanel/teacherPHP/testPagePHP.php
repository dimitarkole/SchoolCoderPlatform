<?php
  if (isset($_POST['searchAddedTest'])){
    $fromTestNumber= $_POST['fromTestNumber'];
    $countTestsOnOnePage= $_POST['countTestOnOnePage'];
    searchAddedTest($fromTestNumber ,$countTestsOnOnePage);
  }

  function searchAddedTest($fromTestNumber,$countTestsOnOnePage){
    global $DB;
    $resultAddedTests= array();
    $user_id=$_SESSION['id'];
    $query = "Select tests.id, tests.test_name, tests.password,
      tests.secret_identifier, count(tasks_for_tests.id),tests.date FROM
      tests Inner join tasks_for_tests ON tests.id=
      tasks_for_tests.test_id  where user_id='$user_id'";
    if($_POST['searchAddedTest']=="searchAddedTest1"){
      $taskName=$_POST['testName'];
      $dateFrom=$_POST['dateFrom'];
      $dateTo=$_POST['dateTo'];
      $searchString=" and";
      if ($taskName!="") $searchString.=" test_name LIKE '%".$taskName."%' and";
      if ($dateFrom!="") $searchString.=" date>='".$dateFrom."' and";
      if ($dateTo!="") $searchString.=" date<='".$dateTo."' and";
      $query.=substr($searchString,0, strlen ($searchString )-3);
    }
    $query.="Group by tests.test_name";
    if($_POST['sortMethod']=='date')$query.=" order by date desc;";
    else if($_POST['sortMethod']=='alphabetAZ')$query.=" order by test_name asc;";
    else if($_POST['sortMethod']=='alphabetZA')$query.=" order by test_name desc;";

    $resultWithTests = mysqli_query($DB, $query);
    $count=1;
    $rowsCount=  mysqli_num_rows($resultWithTests);
    $result="";
    while ($rowWithTest=mysqli_fetch_row($resultWithTests))
    {
      $result.=$count." ";
      if (($count>=$fromTestNumber) && ($count<$fromTestNumber+$countTestsOnOnePage)){
        $idTests= $rowWithTest[0];
        array_push($resultAddedTests, array("id"=>$count, "testId" => $rowWithTest[0],
           "testName"=>  $rowWithTest[1],  "testPassword"=>  $rowWithTest[2],
           "secret_identifier"=>  $rowWithTest[3], "countTasks" => $rowWithTest[4],
           "date"=>$rowWithTest[5]));
      }
      elseif ($count>$fromTestNumber+$countTestsOnOnePage) {
        break;
      }
      $count=$count+1;
    }
    $results= array('resultAddedTests' => $resultAddedTests,'resultTestCount'=> $rowsCount,
        "fromTestNumber"=>$fromTestNumber, "countTestsOnOnePage" =>$countTestsOnOnePage, "query"=>$query );
    echo json_encode($results);
  }

  if (isset($_POST['getAllTasksFromDB'])){
    getAllTasksFromDB();
  }

  function getAllTasksFromDB(){
    global $DB;
    $resultAllTasks= array();
    $user_id=$_SESSION['id'];
    $query = "SELECT tasks.id,tasks.task_name, count(explanation), count(task_id), sum(points), task_text FROM tasks Inner join
              tests_for_tasks ON tasks.id= tests_for_tasks.task_id WHERE tasks.user_id='2' Group by task_name
              order by date desc;";
    $resultWithAllTasks = mysqli_query($DB, $query);
    $count=1;
    while ($rowWithTask=mysqli_fetch_row($resultWithAllTasks))
    {
      array_push($resultAllTasks, array("taskId" => $rowWithTask[0],"count" => $count,
          "taskName" => $rowWithTask[1], "countVisableTest" => $rowWithTask[2],"taskText"=> $rowWithTask[5],
          "countSystemInput" => $rowWithTask[3]-$rowWithTask[2],"sumPoint" => $rowWithTask[4]));
        $count=$count+1;
    }

    $resultAddedTasksToTest=array();
    if ($_POST['method']=="editTest") {
      $testId=$_POST['testId'];
      $query = "SELECT tasks.id, tasks.task_name,
       tasks.task_text FROM tasks
       Inner join tasks_for_tests ON tasks.id=tasks_for_tests.task_id
       where tasks_for_tests.test_id='$testId' order by tasks.task_name;";
      $resultWithAddedTasks = mysqli_query($DB, $query);
      $count=1;
      while ($rowWithTask=mysqli_fetch_row($resultWithAddedTasks))
      {
        array_push($resultAddedTasksToTest,
            array("taskId" => $rowWithTask[0],"count" => $count,
            "taskName" => $rowWithTask[1], "taskText" => $rowWithTask[2]));
          $count=$count+1;
      }
    }
    $results= array('resultAllTasks' => $resultAllTasks,'resultAddedTasksToTest'=> $resultAddedTasksToTest);
    echo json_encode($results);
  }

  if(isset($_POST['saveTest'])){
    addTestToDB();
  }

  function addTestToDB(){
    global $DB;
    if (checkDublicateTestToDB("newTest")=="nonDublicate") {
      $testName=$_POST['testName'];
      $testPassword=$_POST['password'];
      $user_id=$_SESSION['id'];
      $testId=findMaxIdInDataTable("tests");
      $userName=$_SESSION['userName'];
      $secretKey=$user_id.substr($userName, 0, 2).substr($testName, 0, 2);
      $secretKey.= rand(1, 1000).chr(rand(65,90));
      $date=date("Y-m-d H:i:s");
      $query = "INSERT INTO  tests (id,test_name, user_id, password, secret_identifier, date)
            VALUES('$testId','$testName','$user_id', '$testPassword','$secretKey' ,'$date')";
      mysqli_query($DB, $query);
      addTaskForTestToDB($testId);
      echo json_encode("Успешно добавен тест!");
    }
    else {
      echo json_encode("Тестет се дублира с друг!");
    }
  }

  function checkDublicateTestToDB($method){
    global $DB;
    $testName=$_POST['testName'];
    $user_id=$_SESSION['id'];
    $query = "SELECT * from  tests Where test_name='$testName' and user_id='$user_id';";
    $result=mysqli_query($DB, $query);
    if (($method=="newTest")&&(mysqli_num_rows($result)>0)) {
      return "dublicate";
    }
    else if  (($method=="editTest")&&(mysqli_num_rows($result)>0)) {
    }
    return "nonDublicate";
  }

  function addTaskForTestToDB($testId){
    global $DB;
    $i=0;
    while (isset($_POST['taskId'.$i])){
      $taskForTestId=findMaxIdInDataTable("tasks_for_tests");
      $taskId=$_POST['taskId'.$i];
      $query = "INSERT INTO tasks_for_tests (id, test_id, task_id)
            VALUES ('$taskForTestId', '$testId', '$taskId');";
      mysqli_query($DB, $query);
      $i++;
    }

  }

  if(isset($_POST['deleteTest'])){
    deleteTestFromDB();
  }

  function deleteTestFromDB(){
    global $DB;
    $testId=$_POST['testId'];
    $query = "Delete from tests where id='$testId';";
    mysqli_query($DB, $query);
    echo json_encode("Успешно изтрит тест!");
  }

  if(isset($_POST['editTest'])){
    editTestFromDB();
  }

  function editTestFromDB(){
    global $DB;
    if (checkDublicateTestToDB("editTest")=="nonDublicate") {
      $testName=$_POST['testName'];
      $testId=$_POST['testId'];
      $testPassword=$_POST['password'];
      $query="UPDATE  tests set test_name='$testName', password='$testPassword' where id='$testId';";
      mysqli_query($DB, $query);
      $query = "Delete from  tasks_for_tests where test_id='$testId';";
      mysqli_query($DB, $query);
      addTaskForTestToDB($testId);
      echo json_encode("Успешно редактиран тест!");
    }
    else  echo json_encode("Тестет се дублира с друг!");
  }

  if (isset($_POST['resultOfTest'])) {
    $user_id=$_SESSION['id'];
    $testName =  $_POST['testName'];
    $query = "SELECT * FROM tests WHERE user_id='$user_id' and test_name='$testName';";
    $results = mysqli_query($DB, $query);
    $resultRow= mysqli_num_rows($results);
    if ($resultRow>0) {
      $resultData="location: resultOfTestForTeacher.php";
    }
    else $resultData="Тъкъв тест не съществува!";
    echo json_encode($resultData);
  }

?>
