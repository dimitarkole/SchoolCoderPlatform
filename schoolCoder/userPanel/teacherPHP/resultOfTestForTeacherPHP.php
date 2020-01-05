<?php
   $tasksIdArr= array();

   if (isset($_POST['getDataOfResultsFromDB'])) {
     getDataOfResultsFromDB();
   }
   function getDataOfResultsFromDB(){
    global $DB,$tasksIdArr;
    if(checkCurrentSecretIdentifier()=='Невалидна страница!') echo json_encode('location: index.php');
     $secretIdentifier= $_POST['secretID'];
     $query="SELECT tasks.id, tasks.task_text, tasks.allowed_working_time,
       tasks.allowed_memory, tasks.size_limit, tasks.task_name FROM tasks_for_tests
       INNER JOIN tasks ON tasks_for_tests.task_id = tasks.id
       INNER JOIN tests ON tasks_for_tests.test_id = tests.id
       Where tests.secret_identifier= '$secretIdentifier'
       Group by tasks.id;";
     $result = mysqli_query($DB, $query);
     if (mysqli_num_rows($result)) {
       $testData=getTestOfResultDataFromDB(mysqli_num_rows($result));
       $tasksName= array();
       $countTask=1;

       while ($row=mysqli_fetch_row($result)) {
         array_push($tasksIdArr,$row[0]);
         array_push($tasksName,array('name' => $row[5], 'countTask' =>$countTask));
         $countTask++;
       }
       $tasksIdArr=sortTasksId();
       $userSolutuons=getSolutionDataForTasksFromDB($tasksIdArr);
    //   echo  json_encode($userSolutuons);

       $resultFunction = array('testData'=> $testData, "tasksId" => $tasksIdArr,
              "tasksName" => $tasksName, 'userSolutuons'=>$userSolutuons, "tasksIdArr" =>$tasksIdArr );
       echo  json_encode($resultFunction);
     }
   }

   function getTestOfResultDataFromDB($coutTasks){
     global $DB;
     $secretIdentifier= $_POST['secretID'];
     $query="Select tests.id, tests.test_name, tests.password,
       tests.secret_identifier, count(tasks_for_tests.id), tests.date FROM
       tests Inner join tasks_for_tests ON tests.id=
       tasks_for_tests.test_id  where secret_identifier='$secretIdentifier';";
     $result = mysqli_query($DB, $query);
     $row=mysqli_fetch_row($result);
     $resultData= array('name' => $row[1],'password' => $row[2],
           'countTasks'=>$coutTasks,'date' => $row[5]);
     return $resultData;

   }


   function getSolutionDataForTasksFromDB($tasksIdArr) {
     global $DB;
     $tasksIdStr="";
     $fromSolutionNumber =$_POST['fromSolutionNumber'];
     $countSolutionOnOnePage =$_POST['countSolutionOnOnePage'];
     for ($i=0; $i <count($tasksIdArr) ; $i++) {
       $taskId=$tasksIdArr[$i];
       $tasksIdStr.="solution.task_id='$taskId' or ";
     }
     $tasksIdStr="and (".substr($tasksIdStr, 0, strlen ($tasksIdStr )-4).")";
     $query="Select max(temp.count_result),  temp.user_name, temp.task_name, temp.id, temp.names from
          (SELECT  count(experience.result) as count_result,
                       users.user_name, CONCAT(name,' ', family) as names,tasks.task_name,tasks.id
          FROM solution
          INNER JOIN tasks ON solution.task_id = tasks.id
          INNER JOIN users ON solution.user_id = users. id
          INNER JOIN experience ON solution.id = experience. solution_id
          where experience.result=1  ".$tasksIdStr;

     if($_POST['getDataOfResultsFromDB']=="getDataOfResultsFromDB1"){
       $userName=$_POST['userName'];
       $name=$_POST['name'];
       $family=$_POST['family'];
       $searchString=" and";
       if ($userName!="") $searchString.=" user_name LIKE '%".$userName."%' and";
       if ($name!="") $searchString.=" name LIKE '%".$name."%' and";
       if ($family!="") $searchString.=" family LIKE '%".$family."%' and";
       $query.=substr($searchString,0, strlen ($searchString )-3);
     }
     $query.="  Group by solution.id,user_name) as temp
       Group by temp.id, temp.user_name ";
    // if($_POST['sortMethod']=='putpose26')$query.=" order by date desc;";
     //else if($_POST['sortMethod']=='putpose62')$query.=" order by task_name asc;";
     if($_POST['sortMethod']=='userNameAZ')$query.=" order by user_name asc;";
     else if($_POST['sortMethod']=='userNameZA')$query.=" order by user_name desc;";
     else if($_POST['sortMethod']=='nameFamilyAZ')$query.=" order by names аsc;";
     else if($_POST['sortMethod']=='nameFamilyZA')$query.=" order by names desc;";



    // $query.=" Order by user_name;";
     $myQuery= $query;
     $results= array('query'=>$myQuery);
    // return $results;
     $result = mysqli_query($DB, $query);
     if (mysqli_num_rows($result)) {
       $resultData= array();
       $userSolutionForTasks = array();
       $count=1;
       $userName="";
       $sumPoint=0;
       $countTask=0;
       $usersNames="";
       $taskId=0;
       while ($row=mysqli_fetch_row($result)){
         if ($userName=="") $userName=$row[1];
         if ($userName<>$row[1]) {
           if (($count>=$fromSolutionNumber) && ($count<$fromSolutionNumber+$countSolutionOnOnePage)) {
             $purpose=($sumPoint*6)/(100*count($tasksIdArr));
             array_push($resultData,array('count' => $count,'userName' => $userName,
               "userSolutionForTasks" => $userSolutionForTasks,'sumPoint' =>$sumPoint,
               'usersNames'=> $usersNames,'purpose'=> $purpose, 'taskId'=>$taskId));
           }
           $count++;
           $userSolutionForTasks = array();
           $sumPoint=0;
           $countTask=0;
         }
         $taskId=$row[3];
         $query="SELECT* from tests_for_tasks WHERE task_id='$taskId' and points>0;";
         $resultTask = mysqli_query($DB, $query);
         $countTests= mysqli_num_rows($resultTask);
         $points= (100*$row[0])/$countTests;
         while ($countTask<count($taskId)) {
           if($taskId==$tasksIdArr[$countTask])break;

           array_push($userSolutionForTasks,array('taskName' => $row[2],'point' =>0,
            'taskId' =>$taskId,"tasksIdArr[countTask]"=>$tasksIdArr[$countTask]));
           $countTask++;
         }
         array_push($userSolutionForTasks,array('taskName' => $row[2],'point' =>$points));
         $countTask++;
         $sumPoint+=$points;
         $userName= $row[1];
         $usersNames=$row[4];
       }

       if ($userName<>$row[1]){
         if(($count>=$fromSolutionNumber)&&($count<$fromSolutionNumber+$countSolutionOnOnePage)) {
           $countTask=count($tasksIdArr)-1;
           while ($taskId!=$tasksIdArr[$countTask]) {
             array_push($userSolutionForTasks,array('taskName' => "",'point' =>0));
             $countTask--;
           }
           $purpose=($sumPoint*6)/(100*count($tasksIdArr));
           array_push($resultData,array('count' => $count,'userName' => $userName,
             "userSolutionForTasks" => $userSolutionForTasks,'sumPoint' =>$sumPoint,
             'usersNames'=> $usersNames,'purpose'=> $purpose));
         }
       }

       $results= array('resultSolutions' =>$resultData,'rowsCount'=>$count);
       return $results;
     }
     return 0;

   }

   function sortTasksId() {
     global $tasksIdArr;
     for ($i=0; $i <count($tasksIdArr)-1 ; $i++) {
       for ($j=$i+1; $j <count($tasksIdArr) ; $j++) {
         if ($tasksIdArr[$i]>$tasksIdArr[$j]) {
           $taskId=$tasksIdArr[$i];
           $tasksIdArr[$i]=$tasksIdArr[$j];
           $tasksIdArr[$j]=$taskId;
         }
       }
     }
     return $tasksIdArr;
   }


?>
