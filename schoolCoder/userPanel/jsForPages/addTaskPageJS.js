<script type="text/javascript" Language='Javascript'>
  window.onload = function() {
    getAddedTaskFromDB(0);
    getUserDataForHeader();

  }

  var appTask= new Vue({
    el: '#viewAllAddedTasks',
    data: {
      tasks: "",
      pages:[],
      viewTaskName:"",
      viewTaskId:"",
      viewTaskCondition:"",
      viewExampleTaskTest:[],
      viewRealTaskTest:[],
      method:"",
      countTasksOnOnePage:10,
      numberTaskStartFromOnPage:1,
      searchTaskTittle:"",
      dateTo:"",
      dateFrom:""
    },
    methods: {
      editTask: function (task){
        var taskName=task.taskName;
        appTask._data.viewTaskName=taskName;
        appTask._data.method="edit";
        appTask._data.viewTaskId=task.taskId;
        editTaskDataFromDB(task.taskId);
      },

      newTask: function (){
        appTask._data.viewTaskName="";
        appTask._data.viewTaskCondition="";
        appTask._data.viewExampleTaskTest=[{
          count:"1",
          input:"",
          output:"",
          explanation:""
        }];
        appTask._data.viewRealTaskTest=[{
          count:"1",
          input:"",
          output:"",
          points:100
        }];
        appTask._data.method="newTask";
      },

      deleteTask: function (task) {
        deleteTaskFromDB(task);
      },

      deleteTestForTask: function (test, source){
        if (source.length>0) {
          var index = source.indexOf(test);
          source.splice(index,1);
          for (var i = index; i < source.length; i++) {
            source[i].count--;
          }
          if (source==appTask._data.viewRealTaskTest) {
            var point=100/(source.length);
            for (var i = 0; i < source.length; i++) {
              source[i].points=point;
            }
          }
        }
      },

      exitMessage: function (){
        appTask._data.tests= appTask._data.allTasks;
        appTask._data.viewTaskName="";
        appTask._data.viewTaskCondition="";
        appTask._data.viewExampleTaskTest="";
        appTask._data.viewRealTaskTest="";
        appTask._data.method="";
        appTask._data.viewTaskId="";
      },

      addTest: function (typeTest, tests){
        var newTest;
        if(typeTest=="example"){
          var countRow=tests.length;
          newTest={
            count:countRow+1,
            input:"",
            output:"",
            explanation:"",
          };
          var message="Моля въведете: ";
          if (tests.length>0)
          {
            if (tests[countRow-1].input=="") message+="вход";
            if (tests[countRow-1].output=="") {
              if (message=="Моля въведете: ") message+="изход";
              else message+=" ,изход";
            }
            if (tests[countRow-1].explanation==""){
              if (message=="Моля въведете: ") message+="обяснение";
              else message+=" ,обяснение";
            }
            if (message!="Моля въведете: ") message+=" за тест с номер преди да добавите нов тест!";
          }
          if (message=="Моля въведете: ") tests.push(newTest);
          else alert(message);
        }
        else {
          var countRow=tests.length;
          newTest={
            count: countRow+1,
            input:"",
            output:"",
            points:10,
          };
          var message="Моля въведете: ";
          if (tests.length>0)
          {
            if (tests[countRow-1].input=="") message+="вход";
            if (tests[countRow-1].output=="") {
              if (message=="Моля въведете: ") message+="изход";
              else message+=" ,изход";
            }
            if (message!="Моля въведете: ") message+=" за тест с номер преди да добавите нов тест!";
          }
          if (message=="Моля въведете: "){
            tests.push(newTest);
            var point=100/(countRow+1);
            for (var i = 0; i < tests.length; i++) {
              tests[i].points=point;
            }
          }
          else alert(message);
        }
      },

      changePage: function (page) {
        var pageNumber= page.value;
        appTask._data.numberTaskStartFromOnPage=pageNumber*10-9;
        getAddedTaskFromDB(0);
      },

      searchTask: function () {
        getAddedTaskFromDB(1);
      },

      cancel: function () {
        appTask._data.dateTo="";
        appTask._data.dateFrom="";
        appTask._data.searchTaskTittle="";
        var e= document.getElementById('sortSelect');
        e.selectedIndex= 0;
        getAddedTaskFromDB(0);

      }
    }
  });

  function editTaskDataFromDB(taskId) {
    var editTaskId= taskId;
    var data= "editTaskDataFromDB=sd&editTaskId="+editTaskId;
    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       cache:false,
       data : data,
       dataType : 'json',
       success : function (result) {
         appTask._data.viewTaskCondition=result.taskCondition;
         appTask._data.viewExampleTaskTest=result.taskTests.exsampleTaskTests ;
         appTask._data.viewRealTaskTest=result.taskTests.realTaskTests;
       }
    })
  }

  function getAddedTaskFromDB(type) {
    var fromTaskNumber= appTask._data.numberTaskStartFromOnPage;
    var countTasksOnOnePage=appTask._data.countTasksOnOnePage;
    var data= "fromTaskNumber="+fromTaskNumber+
        "&countTasksOnOnePage="+countTasksOnOnePage;
    if (type==0)data+="&searchAddedTask=searchAddedTask";
    else {
      var dateTo= appTask._data.dateTo;
      var dateFrom= appTask._data.dateFrom;
      var taskName= appTask._data.searchTaskTittle;
      data+="&searchAddedTask=searchAddedTask1&dateTo="+dateTo;
      data+="&dateFrom="+dateFrom+"&taskName="+taskName;
    }
    var e= document.getElementById('sortSelect');
    var sortMethod= e.options[e.selectedIndex].value;
    data+="&sortMethod="+sortMethod;
    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appTask._data.tasks= result['resultAddedTasks'];
         var taskCount= result['resultTaskCount'];
         appTask._data.pages=[];
         for (var i = 0; i < taskCount/10; i++) {
           var page = {
              value: i+1,
              text: i+1
           }
           appTask._data.pages.push(page);
         }
       }
    })
    return false;
  }

  function addTaskToDB() {
    var taskName= appTask._data.viewTaskName;
    var condition=appTask._data.viewTaskCondition;

    var correctTaskData=1;
    if (taskName.length<3) {
      correctTaskData=0;
      alert("Името на задачата трябва да има минимум 3 символа!");
    }
    if (condition.length<20) {
      correctTaskData=0;
      alert("Условието на задачата трябва да има минимум 20 символа!");
    }
    var data="saveTask=saveTask&taskCondition="+condition;
    data+="&taskName="+taskName+"&"+$('form').serialize();
    if (correctTaskData==1){
      $.ajax({
         url : 'teacherPHP/teacherPHP.php',
         type : 'POST',
         cache:false,
         data : data,
         dataType : 'json',
         success : function (result) {
           alert(result);
           getAddedTaskFromDB(0);
         }
       })
    }
    return false;
  }

  function getDataOfTests(testsData,testTableDataText ) {
    var errorText="Моля попълнете:", errorFlag;
    for (var i = 0; i < testsData.length; i++) {
      var input = testsData[i].input;
      errorFlag=0;
      if (input=="") {
        errorText+=" входът";
        errorFlag=1;
      }
      var output = testsData[i].output;
      if (output=="") {
        if (errorFlag==0) errorText+=" изходът";
        else errorText+=", изходът";
        errorFlag=1;
      }
      if (testTableDataText=="real") {
        var points = testsData[i].points;
        data+="&" + testTableDataText+"TaskTestTableRow"+i+"Col2=" + points;
        if (points=="") {
          if (errorFlag==0) errorText+=", обяснение";
          else errorText+=", обяснение";
          errorFlag=1;
        }
      }
      else {
        var explanation = testsData[i].output;
        data+="&" + testTableDataText+"TaskTestTableRow"+i+"Col2=" + explanation;
        if (explanation=="") {
          if (errorFlag==0) errorText+=", обяснение";
          else errorText+=", обяснение";
          errorFlag=1;
        }
      }
      if (errorFlag==1) errorText+=" за тест с №"+(i+1)+";";
    }
    return errorText;
  }

  function editTaskFromDB() {
    var taskId= appTask._data.viewTaskId;
    var taskName= appTask._data.viewTaskName;
    var taskCondition=appTask._data.viewTaskCondition;
    var correctTaskData=1;
    if (taskName.length<3) {
      correctTaskData=0;
      alert("Името на задачата трябва да има минимум 3 символа!");
    }
    if (taskCondition.length<20) {
      correctTaskData=0;
      alert("Условието на задачата трябва да има минимум 20 символа!");
    }
    var data="editTask=editTask";
    data+="&editTaskId=" + taskId;
    data+="&taskName=" + taskName;
    data+="&taskCondition=" + taskCondition+"&";
    data+=$('form').serialize();
    if (correctTaskData==1){
      $.ajax({
         url : 'teacherPHP/teacherPHP.php',
         type : 'POST',
         cache:false,
         data : data,
         dataType : 'json',
         success : function (result) {
           alert(result);
           getAddedTaskFromDB(0);
         }
       })
    }
    return false;
  }

  function deleteTaskFromDB(task) {
    var taskId= task.taskId;
    var data= "deleteTaskFromDB=deleteTaskFromDB&taskId="+taskId;
    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       cache:false,
       data : data,
       dataType : 'json',
       success : function (result) {
         alert(result);
         getAddedTaskFromDB(0);

       }
    })
    return false;
  }
</script>
