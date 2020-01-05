<script type="text/javascript" Language='Javascript'>
  var secretID="",solutionId;
  window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    secretID=urlParams.get('secretID');
    solutionId=urlParams.get('solutionId');
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
    viewTaskData:""
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
      getTaskSolutionsFromDB();
    },
    viewTaskSolution: function(solution) {
      window.location.href="viewTaskSolution.php?secretID="+secretID+"&solutionId="+solution.id;

    }
  }
});


function getTestDataFromDB() {
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
           point:"0-"+(0.50*points-1)
         },
         {
             purpose:"Тройка",
             point:(0.50*points)+"-"+(0.58333333*points-1)
         },
         {
             purpose:"Четворка",
             point:(0.583333333*points)+"-"+(0.75*points-1)
         },
         {
             purpose:"Петица",
             point:(0.75*points)+"-"+(0.916666667*points-1)
         },
         {
             purpose:"Шестица",
             point:(0.916666667*points)+"-"+points
         }

       ];
     }
  })
  return false;
}

function getTaskSolutionsFromDB() {
  var task= appCode._data.viewTaskData;
  var taskId= task.taskId;
  var data= "getTaskSolutionsFromDB=getTaskSolutionsFromDB&taskId="+taskId;
  $.ajax({
     url : 'userPHP/userPHP.php',
     type : 'POST',
     data : data,
     cache:false,
     dataType : 'json',
     success : function (result) {
       appCode._data.solutions=result.resultSolutions;
     }
  })
  return false;
}

function exsecuteFile() {
  var task= appCode._data.viewTaskData;
  var data=$('form').serialize()+"&taskName="+task.taskName+"&sendSolution=sendSolution";
  data+="&taskId="+task.taskId;
  $.ajax({
    type:"post",
    url:"userPHP/userPHP.php",
    data: data,
    cache:false,
    success:function(result){
      getTaskSolutionsFromDB();
    }
  });
  return false;
}


</script>
