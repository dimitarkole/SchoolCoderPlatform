<script type="text/javascript" Language='Javascript'>

  var secretID="";
  window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    secretID=urlParams.get('secretID');
    getDataOfResultsFromDB(1,10,0);
    getUserDataForHeader();

  }

  var appResultOfTest= new Vue({
    el: '#resultsOfTest',
    data: {
      testData:"",
      ratingScale:"",
      tasks_id:"",
      tasksName:"",
      userSolutuons:"",
      solutionsPages:"",
      tasksIdArr:"",
      searchUserName:"",
      searchFamily:"",
      searchName:"",
      query : ""
    },
    methods: {
      changePage: function(page) {
        var countSolutionOnOnePage=10;

        var fromSolutionNumber=(page-1)*countSolutionOnOnePage+1;
        getDataOfResultsFromDB(fromSolutionNumber, countSolutionOnOnePage,0);
      },
      searchSolution: function () {
        getDataOfResultsFromDB(1,10,1);
      },

      cancel: function () {
        appResultOfTest._data.searchUserName="";
        appResultOfTest._data.searchName="";
        appResultOfTest._data.searchFamily="";
        var e= document.getElementById('sortSelect');
        e.selectedIndex= 0;
        getDataOfResultsFromDB(1,10,0);
      }
    }
  });

  function getDataOfResultsFromDB(fromSolutionNumber, countSolutionOnOnePage, type) {
    var data= "secretID="+secretID;
    data+="&fromSolutionNumber="+fromSolutionNumber + "&countSolutionOnOnePage="+countSolutionOnOnePage;
    if (type==0)data+="&getDataOfResultsFromDB=getDataOfResultsFromDB";
    else {
      var userName= appResultOfTest._data.searchUserName;
      var name=appResultOfTest._data.searchName;
      var family=appResultOfTest._data.searchFamily;
      data+="&getDataOfResultsFromDB=getDataOfResultsFromDB1&userName="+userName;
      data+="&name="+name+"&family="+family;
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
         appResultOfTest._data.tasksIdArr=result.tasksIdArr;
         appResultOfTest._data.testData=result.testData;
         appResultOfTest._data.tasks_id=result.tasksId;
         appResultOfTest._data.tasksName=result.tasksName;
         var points=result.testData.countTasks*100;
         var pages=[];
         for (var i = 0; i < result.userSolutuons.rowsCount/countSolutionOnOnePage; i++) {
           pages.push(i+1);
         }
         appResultOfTest._data.solutionsPages= pages;
         appResultOfTest._data.userSolutuons=result.userSolutuons.resultSolutions;
         appResultOfTest._data.query=result.userSolutuons.query;
         var chartData;

      /*  var chart = new CanvasJS.Chart("solutionChart", {
          animationEnabled: true,
          title: {
            text: "Резултати"
          },
          data: [{
            type: "pie",
            yValueFormatString: "#0",
            indexLabel: "{label} ({y})",
            dataPoints: result.userSolutuons.resultSolutions
          }]
        });
        try {
            chart.render();
        } catch (e) {
        }*/
/*

         appResultOfTest._data.ratingScale=[{
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
           }];*/
       }
    })
    return false;
  }


</script>
