<?php
  $command_error="";
  $filename_error="";

  if (isset($_POST['sendSolution'])) {
    $language=$_POST['languageSelect'];
    switch($language)
    {
      case "c++":{
        createCPPFile();
        break;
      }
    }
  }

  function createCPPFile(){
    global $command_error,$filename_error;
    putenv("PATH=C:\Program Files (x86)\CodeBlocks\MinGW\bin");
    $CC="g++";
    $out="a.exe";
    $code=$_POST["line_numbers"];
    $filename_code="main.cpp";
    $command=$CC." -lm ".$filename_code;
    $filename_error="error.txt";
    $command_error=$command." 2>".$filename_error;
    $file_code=fopen($filename_code,"w+");
    fwrite($file_code,$code);
    fclose($file_code);

    executableFile($out);
    /*exec("del $filename_error");
    exec("del $fileName.txt");
    exec("del $filename_code");
    exec("del *.exe");*/

  }

  function executableFile($executable)  {
    global $command_error,$filename_error;
    $code=$_POST["line_numbers"];
    $filename_in="main.txt";
    $exampleTaskTest= array();
    $realTaskTest= array();
    $countExampleTaskTest=1;
    $countRealTaskTest=1;
    $echoText="zdr";
    $maxTestCount=$_POST['maxTestCount'];
    $currectTests=0;
    for ($i=0; $i < $maxTestCount; $i++) {
      $input=$_POST["input".($i+1)];
      doInputFile($filename_in,$input,$executable);
      shell_exec($command_error);
      $error=file_get_contents($filename_error);
      $output="";
      $flagBug=0;
      $dateStart=date("s");
      $outputMessage="";

      if(trim($error)==""){
        if(trim($input)==""){
          $output=shell_exec($executable);
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
        if($output==$_POST["output".($i+1)])$outputMessage="correct";
        else $outputMessage="wrong";
      }
    /* $dateEnd=date("s");
      $sec=$dateEnd-$dateStart;
      if ($sec<0) $sec*=(-1);
      if ($sec>1) $outputMessage="overtime";*/
      if ($outputMessage=="correct") $currectTests++;
      exec("del $executable");
    }
    echo json_encode($currectTests);
  }

  function doInputFile($filename_in, $input,$executable){
    global $filename_error;
    $file_in=fopen($filename_in,"w+");
    fwrite($file_in,$input);
    fclose($file_in);
    exec("cacls  $executable /g everyone:f");
    exec("cacls  $filename_error /g everyone:f");
  }

?>
