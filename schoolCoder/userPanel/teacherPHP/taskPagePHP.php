<?php
  if (isset($_POST['searchAddedTask'])){
    $fromTaskNumber= $_POST['fromTaskNumber'];
    $countTasksOnOnePage= $_POST['countTasksOnOnePage'];
    searchAddedTask($fromTaskNumber ,$countTasksOnOnePage);
  }

  function searchAddedTask($fromTaskNumber,$countTasksOnOnePage){
    global $DB;
    $resultAddedTasks=  array();
    $user_id=$_SESSION['id'];
    $searchString="";
    $query = "SELECT tasks.id,tasks.task_name, count(explanation), count(task_id), tasks.date FROM tasks Inner join
              tests_for_tasks ON tasks.id= tests_for_tasks.task_id WHERE tasks.user_id='$user_id' ";
    if($_POST['searchAddedTask']=="searchAddedTask1"){
      $taskName=$_POST['taskName'];
      $dateFrom=$_POST['dateFrom'];
      $dateTo=$_POST['dateTo'];
      $searchString.=" and";
      if ($taskName!="") $searchString.=" task_name LIKE '%".$taskName."%' and";
      if ($dateFrom!="") $searchString.=" date>='".$dateFrom."' and";
      if ($dateTo!="") $searchString.=" date<='".$dateTo."' and";
      $query.=substr($searchString,0, strlen ($searchString )-3);
    }
    $query.="Group by task_name ";
    if($_POST['sortMethod']=='date')$query.=" order by date desc;";
    else if($_POST['sortMethod']=='alphabetAZ')$query.=" order by task_name asc;";
    else if($_POST['sortMethod']=='alphabetZA')$query.=" order by task_name desc;";
    $result = mysqli_query($DB, $query);
    $rowsCount=  mysqli_num_rows($result);
    $count=1;
    while ($row=mysqli_fetch_row($result))
    {
      if (($count>=$fromTaskNumber) && ($count<$fromTaskNumber+$countTasksOnOnePage)){
        $exampleTaskTest= array();
        $realTaskTest= array();
        array_push($resultAddedTasks,
            array("taskId" => $row[0],"count" => $count,
            "taskName" => $row[1], "countVisableTest" => $row[2],
            "countSystemInput" => $row[3]-$row[2],"date" => $row[4]));
      }
      elseif ($count>$fromTaskNumber+$countTasksOnOnePage) {
        break;
      }
      $count=$count+1;
    }
    $results= array('resultAddedTasks' => $resultAddedTasks,'resultTaskCount'=> $rowsCount);
    echo json_encode($results);
  }

  if (isset($_POST['saveTask'])) {
    $dublicateTask=checkDublicateTaskToDB("newTask");
    if($dublicateTask=="nonDublicate"){
      addTaskToDB();
    }
    else {
      echo json_encode("Името на задачата се дублира с друга!");
    }
  }

  function checkDublicateTaskToDB($method){
    global $DB;
    $taskName=$_POST['taskName'];
    $user_id=$_SESSION['id'];
    $query = "SELECT * from  tasks Where task_name='$taskName' and user_id='$user_id';";
    $result=mysqli_query($DB, $query);
    if (($method=="newTask")&&(mysqli_num_rows($result)>0)) {
      return "dublicate";
    }
    else if  (($method=="editTask")&&(mysqli_num_rows($result)>0)) {
    }
    return "nonDublicate";
  }

  function addTaskToDB(){
    global $DB;
    $taskName=$_POST['taskName'];
    $condition=$_POST['taskCondition'];
    $user_id=$_SESSION['id'];
    $date=date("Y-m-d H:i:s");
    $taskId=findMaxIdInDataTable("tasks");
    $query = "INSERT INTO  tasks (id,task_name, user_id, task_text, date, allowed_working_time, allowed_memory, size_limit)
          VALUES('$taskId','$taskName','$user_id', '$condition' ,  '$date','1','1','1');";
    mysqli_query($DB, $query) or die("die");

    addTestForTaskToDB("exampleTaskTestTable",$taskId,"explanation");
    addTestForTaskToDB("realTaskTestTable",$taskId,"point");
    echo json_encode("Успешно добавена задача!");
  }

  function addTestForTaskToDB($tableName,$idTask,$intended){
    global $DB;
    $row=1;
    while (isset($_POST[$tableName.'Row'.$row.'Col1'])){
      $row++;
    }
    $row--;
    $point=100/$row;
    $row=1;
    while (isset($_POST[$tableName.'Row'.$row.'Col1'])){
      $id=findMaxIdInDataTable("tests_for_tasks");
      $input=$_POST[$tableName.'Row'.$row.'Col0'];
      $output=$_POST[$tableName.'Row'.$row.'Col1'];
      if ($intended=="point") {
        $query = "INSERT INTO  tests_for_tasks (id,task_id, input, output, points)
              VALUES('$id','$idTask','$input', '$output' ,  '$point')";
      }
      else if ($intended=="explanation"){
        $explanation=$_POST[$tableName.'Row'.$row.'Col2'];
        $query = "INSERT INTO  tests_for_tasks (id,task_id, input, output, explanation)
              VALUES('$id','$idTask','$input', '$output' ,  '$explanation');";
      }
      mysqli_query($DB, $query);
      $row++;
    }
  }

  if (isset($_POST['editTask'])) {
    $dublicateTask=checkDublicateTaskToDB("editTask");
    if($dublicateTask=="nonDublicate"){
      editTaskInDB();
    }
    else {
      echo json_encode("Задачата се дублира с друга!");
    }
  }

  function editTaskInDB()  {
    global $DB;
    $taskId=$_POST['editTaskId'];
    $taskName=$_POST['taskName'];
    $condition=$_POST['taskCondition'];
    $query = "UPDATE  tasks set task_name='$taskName', task_text='$condition' where id='$taskId';";
    mysqli_query($DB, $query);

    $query = "Delete from  tests_for_tasks where task_id='$taskId';";
    mysqli_query($DB, $query);
    addTestForTaskToDB("exampleTaskTestTable",$taskId,"explanation");
    addTestForTaskToDB("realTaskTestTable",$taskId,"point");
    echo json_encode("Успешно редактирана задача!");
  }

  if (isset($_POST['deleteTaskFromDB'])) {
    $idTaskForDelete= $_POST['taskId'];
    $query = "Delete from  tasks where id='$idTaskForDelete';";
    mysqli_query($DB, $query);
    echo json_encode("Изтито успешно");

  }

  if (isset($_POST['editTaskDataFromDB'])) {
    $taskId=$_POST['editTaskId'];

    $query = "SELECT* from tasks where id='$taskId';";
    $result = mysqli_query($DB, $query);
    if (mysqli_num_rows($result)>0) {
        $row=mysqli_fetch_row($result);
        $resultFunction = array('taskCondition' => $row[3],'taskTests' => getTaskTests($taskId));
        echo json_encode($resultFunction);
    }
  }

  function getTaskTests($taskId)  {
    global $DB;
    $query = "SELECT* from tests_for_tasks WHERE task_id='$taskId';";
    $realTaskTests= array();
    $exsampleTaskTests=array();
    $resultTaskTest = mysqli_query($DB, $query);
    $countExapleTests=1;
    $countRealTests=1;
    while ($rowTaskTest=mysqli_fetch_row($resultTaskTest))
    {
      if(is_null($rowTaskTest[4])){
        array_push($exsampleTaskTests,array("idTaskTest" =>$rowTaskTest[0],"input" =>$rowTaskTest[2],
          "output" =>$rowTaskTest[3],"explanation"=>$rowTaskTest[5],
          "count" =>$countExapleTests));
        $countExapleTests++;
      }
      else {
        array_push($realTaskTests,array("idTaskTest" =>$rowTaskTest[0],"input" =>$rowTaskTest[2],
          "output" =>$rowTaskTest[3],"points"=>intval($rowTaskTest[4]),
          "count" =>$countRealTests));
        $countRealTests++;
      }
    }
    $resultArray = array('realTaskTests' => $realTaskTests,'exsampleTaskTests' =>$exsampleTaskTests);
    return $resultArray;
  }
?>
