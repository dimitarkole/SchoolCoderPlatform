<script type="text/javascript" Language='Javascript'>

  window.onload = function() {
    getAddedProblemsFromDB();
  }

  var appProblem = new Vue({
    el: '#viewAllAddedProblempedWebSite',
    data: {
      problems:"",
      pages:[],
      newProblem:"",
      fromProblemsNumber:1,
      numberProblemsStartFromOnPage:10
    },
    methods: {
      newProblemFunction:function () {
        appProblem._data.newProblem={
          method:"newProblem",
          close_time:"",
          open_time:"",
          purpose:""
        }
      },
      changePage: function (page) {
        var pageNumber= page.value;
        appProblem._data.fromProblemsNumber=pageNumber*10-9;
        getAddedProblemsFromDB();
      },
    }
  });

  function getAddedProblemsFromDB() {
    var countProblemsOnOnePage= appProblem._data.numberProblemsStartFromOnPage;
    var fromProblemsNumber= appProblem._data.fromProblemsNumber;

    var data= "getAddedProblemsFromDB=getAddedProblemsFromDB";
    data+="&fromProblemsNumber="+fromProblemsNumber;
    data+="&countProblemsOnOnePage="+countProblemsOnOnePage;
  //  alert(data);
    $.ajax({
       url : 'adminPHP/adminPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appProblem._data.problems=result.resultProblems;
         var problemsCount= result.rowsCount;
         appProblem._data.pages=[];
         for (var i = 0; i < problemsCount/10; i++) {
           var page = {
              value: i+1,
              text: i+1
           }
           appProblem._data.pages.push(page);
         }
       }
    })
    return false;
  }


  function addProblemAtDB() {
    var newProblem=appProblem._data.newProblem;
    var data= "addProblemAtDB=addProblemAtDB";
    data+="&purpose="+newProblem.purpose;
    data+="&open_time="+newProblem.open_time;
    data+="&close_time="+newProblem.close_time;
    $.ajax({
       url : 'adminPHP/adminPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         alert(result);
       }
    });
    return false;
  }
</script>
