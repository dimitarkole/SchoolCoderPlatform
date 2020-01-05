<?php
  $DB = mysqli_connect('localhost', 'root', '123456' , 'school_coder');

  mysqli_set_charset($DB,"utf8");



getTableRows('users');
getTableRows('tasks');
getTableRows('messages');
getTableRows('friends');
getTableRows('tasks_for_tests');
getTableRows('solution');
getTableRows('tests_for_tasks');
getTableRows('tests');
getTableRows('tests');
getTableRows('experience');




  function getTableRows($dataTable)
  {
    global $DB;
    $query = "SELECT * FROM $dataTable;";
    $result = mysqli_query($DB, $query);
    echo "<br>$dataTable<br>";
    $count=0;
    while ($row=mysqli_fetch_row($result))
    {
      echo "$row[0] $row[1] $row[2]<br>";
      $count++;
    }
    echo "<br> $dataTable count=$count";
  }
 ?>
