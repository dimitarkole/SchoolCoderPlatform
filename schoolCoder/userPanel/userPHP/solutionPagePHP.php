<?php
  $command_error="";
  $filename_error="";
  if (isset($_POST['getTestDataFromDB'])){
    getTestDataFromDB();
  }

  function getTestDataFromDB(){
    global $DB;
    $resultAddedTasks=  array();
    $user_id=$_SESSION['id'];
    $secretID=$_POST['secretID'];
    $query = "SELECT tasks.id, tasks.task_name, tasks.task_text, tasks.allowed_working_time,
      tasks.allowed_memory, tasks.size_limit, tests.test_name FROM tasks_for_tests
      INNER JOIN tasks ON tasks_for_tests.task_id = tasks.id
      INNER JOIN tests ON tasks_for_tests.test_id = tests.id
      Where tests.secret_identifier= '$secretID'
      Group by tasks.id;";
    $result = mysqli_query($DB, $query);
    $testName="";
    $resultsTasks=array();
    $count=0;
    while ($row=mysqli_fetch_row($result))
    {
      $task_id=$row[0];
      $bestSolution=getTheBestSolutionForTaskFromDB($task_id);
      array_push($resultsTasks,
        array("taskId" => $task_id,"taskName" => $row[1],
        "taskText" => $row[2], "allowedWorkingTime" => $row[3],
        "allowedMemory" => $row[4],"sizeLimit" => $row[5],
        "solution" =>"", "count" =>$count,"languages" => array('c++', 'c#','java'),
        "simpleTests"=>getSimpleTestsFromDB($task_id), 'bestSolution'=> $bestSolution));
      $testName=$row[6];
      $count++;
    }
    $results= array('resultsTasks' =>$resultsTasks,'testName'=>$testName);
    echo json_encode($results);
  }

  function getSimpleTestsFromDB($task_id) {
    global $DB;
    $user_id=$_SESSION['id'];
    $query = "SELECT * FROM tests_for_tasks WHERE
        task_id='$task_id' and explanation>0;";
    $sipleTests = mysqli_query($DB, $query);
    $sipleTestsArrey= array();
    $count=1;
    while ($row=mysqli_fetch_row($sipleTests))
    {
      array_push($sipleTestsArrey,array("input" => $row[2],"output" => $row[3],
        "explanation" => $row[5], "count"=>$count));
      $count++;
    }
    return $sipleTestsArrey;
  }

  function getTheBestSolutionForTaskFromDB($task_id) {
    global $DB;
    $user_id=$_SESSION['id'];
    $query = "SELECT count(experience.result) as correct, solution.id FROM solution
          INNER JOIN tasks ON solution.task_id = tasks.id
          INNER JOIN experience ON solution.id = experience.solution_id
          where solution.user_id='$user_id' and solution.task_id='$task_id'
          and experience.result=1 Group by id order by correct desc;";
    $result = mysqli_query($DB, $query);

    if (mysqli_num_rows($result)) {
      $row=mysqli_fetch_row($result);
      $correctTest=$row[0];
      $query = "SELECT count(id) from tests_for_tasks where tests_for_tasks.task_id='$task_id' and points>0";
      $result = mysqli_query($DB, $query);
      $row=mysqli_fetch_row($result);
      $pointOfOneTest=100/$row[0];
      return $correctTest*$pointOfOneTest;
    }
    return 0;
  }

  if (isset($_POST['getTaskSolutionsFromDB'])){
    getTaskSolutionsFromDB();
  }

  function getTaskSolutionsFromDB(){
    global $DB;
    $resultSolution=  array();
    $user_id=$_SESSION['id'];
    $taskId=$_POST['taskId'];
    $query = "SELECT experience.id, experience.result, solution.date,  solution.language,solution.id, solution.code FROM solution
      INNER JOIN tasks ON solution.task_id = tasks.id
      INNER JOIN experience ON solution.id = experience. solution_id
      where solution.user_id='$user_id' and solution.task_id='$taskId' order by date desc;";
    $result = mysqli_query($DB, $query);
    $resultSolutions=array();
    $count=1;
    $solutionId=-1;
    $fromSolutionNumber=$_POST['fromSolutionNumber'];
    $countSolutionOnOnePage=$_POST['countSolutionOnOnePage'];
    $date="";
    $language="";
    $query = "SELECT COUNT(id) from tests_for_tasks WHERE task_id='$taskId' and points>0;";
    $resultWithCountTestForTask= mysqli_query($DB, $query);
    $countTestForTask=mysqli_fetch_row($resultWithCountTestForTask);
    $point=100/$countTestForTask[0];
    $points=0;
    if (mysqli_num_rows($result)) {
      while ($row=mysqli_fetch_row($result)){
        if ($solutionId==-1) $solutionId=$row[4];
        if ($solutionId<>$row[4]) {
          if (($count>=$fromSolutionNumber) && ($count<$fromSolutionNumber+$countSolutionOnOnePage)){
            array_push($resultSolutions,array('count' => $count,'resultWithTests' => $resultSolution,
              "date" => $date,"language" => $language,
              'points' => round($points), 'id'=>$solutionId));
          }
          $solutionId=$row[4];
          $resultSolution=array();
          $points=0;
          $count++;
        }
        $date=$row[2];
        $code= $row[5];
        $language=$row[3];
        array_push($resultSolution,$row[1]);
        if ($row[1]=='correct') $points+=$point;
      }
      if (($count>=$fromSolutionNumber) && ($count<$fromSolutionNumber+$countSolutionOnOnePage)){
        array_push($resultSolutions,array('count' => $count,'resultWithTests' => $resultSolution,
          "date" => $date,"language" => $language,'points' => $points, 'id'=>$solutionId));
      }

      $results= array('resultSolutions' =>$resultSolutions,'rowsCount'=>$count);
      echo json_encode($results);
    }
    else {
      echo json_encode("");
    }
  }

  if (isset($_POST['sendSolution'])) {
    $language="";

    if ($_POST['method']=='addToDB') $language=$_POST['languageSelect'];
    else {
      $solutionId=$_POST['solutionId'];
      $language=getSolutionLenguage($solutionId);
    }
    switch($language)
    {
      case "c++":{
        createCPPFile();
        break;
      }
      case "c#":{
        createCSharpFile();
        break;
      }
    }
    if ($_POST['method']=='addToDB') {
      echo json_encode("Успешно проверена задача!");
    }
  }

  function createFileNameForTesting(){
    $user_id=$_SESSION['id'];
    $userName=$_SESSION['userName'];
    $fileName=$user_id.substr($userName, 0, 2).rand(1, 1000).chr(rand(65,90));
    return $fileName;
  }

  function createCPPFile(){
    global $command_error,$filename_error,$DB;
    $fileName=createFileNameForTesting();
    putenv("PATH=C:\Program Files (x86)\CodeBlocks\MinGW\bin");
    //putenv("PATH= .../.../usr/share/codeblocks/compilers");
   // /usr/share/codeblocks/compilers
    $CC="g++";
    $out="a.exe";
    $code="";
    $solutionId=0;
    if ($_POST['method']=='addToDB') {
      $taskId=$_POST["taskId"];
      $solutionId=findMaxIdInDataTable("solution");
      $userId=$_SESSION['id'];
      $date=date("Y-m-d H:i:s");
      $code=$_POST["line_numbers"];
      $query = "INSERT INTO  solution (id,user_id, code, language,task_id, date)
            VALUES('$solutionId','$userId','$code','c++','$taskId','$date');";
      mysqli_query($DB, $query);
    }
    else {
      $solutionId=$_POST['solutionId'];
      $code=getSolutionCode($solutionId);
    }
    $filename_code="$fileName.cpp";
    $command=$CC." -lm ".$filename_code;
    $filename_error="error$fileName.txt";
    $command_error=$command." 2>".$filename_error;
    $file_code=fopen($filename_code,"w+");
    fwrite($file_code,$code);
    fclose($file_code);
    executableFile($out,$solutionId,$fileName);
    exec("del $filename_error");
    exec("del $fileName.txt");
    exec("del $filename_code");
  }

  function executableFile($executable,$solutionId,$fileName)  {
    global $command_error, $DB,$filename_error;
    $taskId=$_POST['taskId'];
    $code="";
    $query = "SELECT * FROM tests_for_tasks WHERE task_id='$taskId'";
    if ($_POST['method']=='addToDB') {
      $query.= " and points>0 order by points;";
      $code=$_POST["line_numbers"];
    }
    else {
      $solutionId=$_POST["solutionId"];
      $code=getSolutionCode($solutionId);
      $query .= " order by points;";
    }
    $result = mysqli_query($DB, $query);
    $filename_in="$fileName.txt";
    $exampleTaskTest= array();
    $realTaskTest= array();
    $countExampleTaskTest=1;
    $countRealTaskTest=1;
    $echoText="";

    while ($row=mysqli_fetch_row($result))  {
      $input=$row[2];
      $echoText.=$input."   ";
      doInputFile($filename_in,$input,$executable);
      shell_exec($command_error);
      $error=file_get_contents($filename_error);
      $output="";
      $flagBug=0;
      $dateStart=date("s");
      $outputMessage="";

      if(trim($error)==""){
        if(trim($input)==""){
          $result=shell_exec($out);
        }
        else{
          $executable=$executable." < ".$filename_in;
          $output=shell_exec($executable);
        }
      }
      else if(!strpos($error,"error")){
        if(trim($input)==""){
          $output=shell_exec($executable);
        }
        else{
          $executable=$executable." < ".$filename_in;
          $output=shell_exec($executable);
        }
      }
      else{
        $outputMessage="crash";
        $flagBug=1;
      }
      if (($output!="crash")&&($flagBug!=1)) {
        if($output==$row[3])$outputMessage="correct";
        else $outputMessage="wrong";
      }

      $dateEnd=date("s");
      $sec=$dateEnd-$dateStart;
      if ($sec<0) $sec*=(-1);
      if ($sec>1) $outputMessage="overtime";

      if ($_POST['method']=='addToDB') {
        $experienceId=findMaxIdInDataTable("experience");
        $query = "INSERT INTO  experience (id,solution_id, test_for_task_id, result)
              VALUES('$experienceId','$solutionId','$row[0]','$outputMessage');";
        mysqli_query($DB, $query);
      }
      else{
        if (is_null($row[4])) {
          array_push($exampleTaskTest,
            array("count" => $countExampleTaskTest,"input" => $row[2],
            "output" => $row[3], "yourOutput" => $output));
          $countExampleTaskTest++;
        }
        else {
          array_push($realTaskTest,
            array("count" => $countRealTaskTest,"result" => $outputMessage,
                  "time" =>$sec));
          $countRealTaskTest++;
        }
      }

      exec("del $executable");
    }

    if ($_POST['method']!='addToDB') {
      $result = array('exampleTaskTest' => $exampleTaskTest,'realTaskTest'=>$realTaskTest,
        'code'=>$code);
      echo json_encode($result);
    }

  }

  function doInputFile($filename_in, $input,$executable){
    global $filename_error;
    $file_in=fopen($filename_in,"w+");
    fwrite($file_in,$input);
    fclose($file_in);
    exec("cacls  $executable /g everyone:f");
    exec("cacls  $filename_error /g everyone:f");
  }

  function getSolutionCode($solutionId)  {
    global $DB;
    $code="";
    $query = "SELECT code from solution Where id= '$solutionId';";

    $result = mysqli_query($DB, $query);
    try {
      $row=mysqli_fetch_row($result);
      $code=$row[0];
    } catch (\Exception $e) {

    }

    return $code;
  }

  function getSolutionLenguage($solutionId)  {
    global $DB;
    $language="";
    $query = "SELECT language from solution Where id= '$solutionId';";
    $result = mysqli_query($DB, $query);
    try {
      $row=mysqli_fetch_row($result);
      $language=$row[0];
    } catch (\Exception $e) {

    }
    return $language;
  }
?>
