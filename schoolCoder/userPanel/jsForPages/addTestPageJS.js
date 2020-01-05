<script type="text/javascript" Language='Javascript'>
  window.onload = function() {
    getAddedTetsFromDB(0);
    getUserDataForHeader();

  }

  var appTest= new Vue({
    el: '#viewAllAddedTest',
    data: {
      tests: "",
      pages: [],
      viewTestName:"",
      viewTestId:"",
      viewTestPassword:"",
      viewAddedTaskForTest:[],
      viewTaskTextForAdd:"",
      viewTestPassword:"",
      changePageParameters:{
        countTestsOnOnePage:10,
        numberTestStartFromOnPage:1,
      },
      searchTestTittle:"",
      dateFrom:"",
      dateTo:"",
      allTasks:[],
      method:"newTest"
    },
    methods: {
      newTest: function (){
        appTest._data.viewTestName="";
        appTest._data.viewTestPassword="";
        appTest._data.method="newTest";
        appTest._data.viewAddedTaskForTest=[];
        appTest._data.viewTaskTextForAdd="";
        getAllTasksFromDB();
      },

      addTaskTest: function (){
        var e= document.getElementById("taskSelect");
        var selectedTaskName=e.options[e.selectedIndex].value;
        addTaksToTest();
        //премахване на задачата  от падащото меню
        var index =0;
        do {
          if (appTest._data.allTasks[index].taskName==selectedTaskName) {
            break;
          }
          index++;
        } while (index<appTest._data.allTasks.length);
        //appTest._data.allTasks.length- appTest._data.allTasks.indexOf(selectedTaskName);
        appTest._data.allTasks.splice(index,1);
        changeSelectedTaskForTest()
      },

      deleteTest: function (test) {
        deleteTestFromDB(test.testId);
      },

      changePage: function (page) {
        var pageNumber= page.value;
        appTest._data.changePageParameters.numberTestStartFromOnPage=pageNumber*10-9;
        getAddedTetsFromDB(0);
      },

      editTest: function(test) {
        appTest._data.viewTestName=test.testName;
        appTest._data.viewTestPassword=test.testPassword;
        appTest._data.method="editTest";
        appTest._data.viewAddedTaskForTest=[];
        appTest._data.viewTaskTextForAdd="";
        appTest._data.viewTestId= test.testId;
        getAllTasksFromDB()
      },

      deleteAddedTask: function(task) {
        var source = appTest._data.viewAddedTaskForTest;
        if (source.length>0) {
          var index = source.indexOf(task);
          source.splice(index,1);
          for (var i = index; i < source.length; i++) {
            source[i].count--;
          }
        }
      },

      viewResultOfTest: function (test) {
        resultOfTest(test);
      },

      searchTest: function () {
        getAddedTetsFromDB(1);
      },

      cancel: function () {
        appTest._data.dateTo="";
        appTest._data.dateFrom="";
        appTest._data.searchTestTittle="";
        var e= document.getElementById('sortSelect');
        e.selectedIndex= 0;
        getAddedTetsFromDB(0);
      }
    }
  });

  function getAddedTetsFromDB(type) {
    var fromTestNumber= appTest._data.changePageParameters.numberTestStartFromOnPage;
    var countTestOnOnePage=appTest._data.changePageParameters.countTestsOnOnePage;
    var data= "fromTestNumber="+fromTestNumber+
        "&countTestOnOnePage="+countTestOnOnePage;
    if (type==0)data+="&searchAddedTest=searchAddedTest";
    else {
      var dateTo= appTest._data.dateTo;
      var dateFrom= appTest._data.dateFrom;
      var testName= appTest._data.searchTestTittle;
      data+="&searchAddedTest=searchAddedTest1&dateTo="+dateTo;
      data+="&dateFrom="+dateFrom+"&testName="+testName;
    }
    var e=document.getElementById('sortSelect');
    var sortMethod= e.options[e.selectedIndex].value;
    data+="&sortMethod="+sortMethod;
    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appTest._data.tests= result['resultAddedTests'];
         var testCount= result['resultTestCount'];
         appTest._data.pages=[];
         appTest._data.query=result['query'];
         for (var i = 0; i < testCount/10; i++) {
           var page = {
              value: i+1,
              text: i+1
           }
           appTest._data.pages.push(page);
         }
       }
    })
    return false;
  }

  function getAllTasksFromDB() {
    var method=appTest._data.method;
    var data= "getAllTasksFromDB=getAllTasksFromDB&method="+method;
    if (method=="editTest") {
      var testId= appTest._data.viewTestId;
      data+="&testId="+testId;
    }

    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appTest._data.allTasks= result['resultAllTasks'];
         var tastText=appTest._data.allTasks[0].taskText;
         appTest._data.viewTaskTextForAdd=tastText;
         appTest._data.viewAddedTaskForTest= result['resultAddedTasksToTest'];
       }
    })
    return false;
  }

  function changeSelectedTaskForTest() {
    var e= document.getElementById("taskSelect");
    var selectedTaskName=e.selectedIndex;
    alert(selectedTaskName);
    var taskText=appTest._data.allTasks[selectedTaskName].taskText;
    appTest._data.viewTaskTextForAdd=taskText;
    return false;
  }

  function addTaksToTest() {
    var e= document.getElementById("taskSelect");
    var addedTasksCount= appTest._data.viewAddedTaskForTest.length+1;
    var addTaskName= e.options[e.selectedIndex].value;
    var addTaskText=appTest._data.viewTaskTextForAdd;
    var index=0,taskId= 0;
    do {
      taskId=appTest._data.allTasks[index].taskId;
      if (appTest._data.allTasks[index].taskName==addTaskName) {
        break;
      }
      index++;
    } while (index<appTest._data.allTasks.length);
    var taskData={
      count:addedTasksCount,
      taskName:addTaskName,
      taskText:addTaskText,
      taskId:taskId
    };
    appTest._data.viewAddedTaskForTest.push(taskData);
    return false;
  }

  function saveTest() {
    var method=appTest._data.method;
    var testName=appTest._data.viewTestName;
    var correctTaskData=1;
    if (testName.length<3) {
      correctTaskData=0;
      alert("Името на теста трябва да има минимум 3 символа!");
    }
    var password=appTest._data.viewTestPassword;
    if (password=="") {
       var result = confirm("Сигурни ли сте, че този тест няма да има парола.");
       if (result==false) correctTaskData=0;
    }
    if (appTest._data.viewAddedTaskForTest.length==0) {
      alert("Тестът трябва да съдържа минимум 1 задача!");
      correctTaskData=0;
    }

    if (correctTaskData==1) {
      var data= "saveTest=saveTest&testName="+testName;
      data+="&password="+password;
      data+=getAddedTasksToTest();
      $.ajax({
         url : 'teacherPHP/teacherPHP.php',
         type : 'POST',
         data : data,
         cache:false,
         dataType : 'json',
         success : function (result) {
           alert(result);
         }
      })
      getAddedTetsFromDB(0);
    }
    return false;
  }

  function getAddedTasksToTest() {
    var addedTasks=appTest._data.viewAddedTaskForTest;
    var data="";
    for (var i = 0; i < addedTasks.length; i++) {
      data+="&taskId"+i+"="+addedTasks[i].taskId;
    }
    return data;
  }

  function deleteTestFromDB(testId){
    var data= "deleteTest=deleteTest&testId="+testId;
    $.ajax({
       url : 'teacherPHP/teacherPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         alert(result);
       }
    })
    getAddedTetsFromDB(0);

    return false;
  }

  function editTestFromDB() {
    var method=appTest._data.method;
    var testName=appTest._data.viewTestName;
    var editTestId= appTest._data.viewTestId;
    var correctTaskData=1;
    if (testName.length<3) {
      correctTaskData=0;
      alert("Името на теста трябва да има минимум 3 символа!");
    }
    var password=appTest._data.viewTestPassword;
    if (password=="") {
       var result = confirm("Сигурни ли сте, че този тест няма да има парола.");
       if (result==false) correctTaskData=0;
    }
    if (appTest._data.viewAddedTaskForTest.length==0) {
      alert("Тестът трябва да съдържа минимум 1 задача!");
      correctTaskData=0;
    }

    if (correctTaskData==1) {
      var data= "editTest=editTest&testId="+editTestId+"&testName="+testName;
      data+="&password="+password;
      data+=getAddedTasksToTest();
      $.ajax({
         url : 'teacherPHP/teacherPHP.php',
         type : 'POST',
         data : data,
         cache:false,
         dataType : 'json',
         success : function (result) {
           alert(result);
         }
      })
      getAddedTetsFromDB(0);
    }
  }

  function resultOfTest(test) {
    var data= "resultOfTest=resultOfTest&testName="+test.testName;

    $.ajax({
      type:"post",
      url:"teacherPHP/teacherPHP.php",
      data: data,
      cache:false,
      success:function(result){
        if (result.substr(1, 8)=="location") {
          var location=result.slice(10,result.length-1)+"?secretID="+test.secret_identifier;
          window.location.href=location;
        }
        else alert(result);
      }
    });
    /*return false;*/
  }
</script>
