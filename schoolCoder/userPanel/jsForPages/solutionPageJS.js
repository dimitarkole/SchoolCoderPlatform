<script type="text/javascript" Language='Javascript'>
  var secretID="";
  window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    secretID=urlParams.get('secretID');
    getSolutionDataFromDB();
    getUserDataForHeader();
  }

  var appCode= new Vue({
    el: '#solution',
    data: {
      testTitle:"",
      tasks:"",
      messages: "",
      pages: "",
      ratingScale:"",
      solutions:"",
      viewTaskData:"",
      viewSolutionData:""
    },
    methods: {
      changeTask: function (task) {
        appCode._data.viewTaskData=task;
        var tasks= appCode._data.tasks
        for (var i = 0; i < tasks.length; i++) {
          var e = document.getElementById(tasks[i].taskName+"line_numbers");
          e.name = e.id;
        }
        var e = document.getElementById(task.taskName+"line_numbers");
        e.name = "line_numbers";
        getTaskSolutionsFromDB(1,10);
      },

      viewTaskSolution: function(solution) {
        exsecuteFile(' ', solution);
      },
      changePage: function(page) {
        var fromSolutionNumber=(page-1)*10+1;
        var countSolutionOnOnePage=10;
        getTaskSolutionsFromDB(fromSolutionNumber, countSolutionOnOnePage);
      }
    }
  });

  function getSolutionDataFromDB() {
    var data= "getTestDataFromDB=getTestDataFromDB&secretID="+secretID;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appCode._data.tasks=result.resultsTasks;
         appCode._data.testTitle=result.testName;

         var points=result.resultsTasks.length*100;
         appCode._data.ratingScale=[{
             purpose:"Двойка",
             point:"0-"+Math.round(0.50*points-1)
           },
           {
               purpose:"Тройка",
               point:Math.round(0.50*points) +"-"+Math.round((0.58333333*points-1))
           },
           {
               purpose:"Четворка",
               point:Math.round(0.583333333*points)+"-"+Math.round(0.75*points-1)
           },
           {
               purpose:"Петица",
               point:Math.round(0.75*points)+"-"+Math.round(0.916666667*points-1)
           },
           {
               purpose:"Шестица",
               point:Math.round(0.916666667*points)+"-"+points
           }
         ];
       }
    })
    return false;
  }

  function getTaskSolutionsFromDB(fromSolutionNumber,countSolutionOnOnePage) {
    var task= appCode._data.viewTaskData;
    var taskId= task.taskId;
    var data= "getTaskSolutionsFromDB=getTaskSolutionsFromDB&taskId="+taskId;
    data+="&fromSolutionNumber="+fromSolutionNumber + "&countSolutionOnOnePage="+countSolutionOnOnePage;
    var solution={
      resultSolutions:"",
      pages:""
    };
    appCode._data.solutions=solution;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         if (result.resultSolutions.length>0) {
           if (appCode._data.viewTaskData.points<result.resultSolutions[0].points) {
             appCode._data.viewTaskData.point=result[0].points;
            }
         }

         var pages=[];
         for (var i = 0; i < result.rowsCount/countSolutionOnOnePage; i++) {
           pages.push(i+1);
         }
         var solution={
           resultSolutions:result.resultSolutions,
           pages:pages
         };
         appCode._data.solutions=solution;
       }
    })
    return false;
  }

  function exsecuteFile(type,solution) {
    var task= appCode._data.viewTaskData, data="";
    if (type =='addToDB')  data+=$('form').serialize()+"&taskName="+task.taskName;
    else data+="&languageSelect='"+solution.language+ "'&solutionId="+solution.id;
    data+="&sendSolution=sendSolution&method="+type+"&taskId="+task.taskId;
    $.ajax({
      type:"post",
      url:"userPHP/userPHP.php",
      data: data,
      dataType : 'json',
      cache:false,
      success:function(result){
        if (type =='addToDB') alert(result);
        else getTaskSolution(solution,result);
        getTaskSolutionsFromDB(1, 10);
      }
    });
    return false;
  }

  function getTaskSolution(solution,testResults) {
    var solutionData={
      id: solution.id,
      date:solution.date,
      points: solution.points,
      code: testResults.code,
      exampleTaskTest:testResults.exampleTaskTest,
      realTaskTest:testResults.realTaskTest,
    }
    appCode._data.viewSolutionData=solutionData;
  }
</script>
