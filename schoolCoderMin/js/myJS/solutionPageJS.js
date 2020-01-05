<script type="text/javascript" Language='Javascript'>

  var appCode= new Vue({
    el: '#solution',
    data: {
      allowedWorkingTime:1,
      allowedMemory:2,
      sizeLimit:2,
      languages:['c++'],
      tests:[{
        count:1,
        input:"",
        output:"",
      }]
    },
    methods: {
      newTest: function () {
        var allTests=appCode._data.tests;
        if ((allTests[length].output!="")&&(allTests[length].input!="")) {
          var newTest={
            count:allTests.length+1,
            input:"",
            output:"",
          };
          appCode._data.tests.push(newTest);
        }
        else {
          alert("Преди да добавите нов тест, трява да въведете данни за примерен вход и изход на предишния!");
        }
      },

      removeTest:function (test) {
        if (appCode._data.tests.length>1) {
          appCode._data.tests.splice(test,1);
          for (var i = 0; i < appCode._data.tests.length; i++) {
            appCode._data.tests[i].count=i+1;
          }
        }
        else {
          alert("Към задача трява да има поне един примерен тест!")
        }
      }
    }
  });


  function exsecuteFile() {
    var data="",maxTextCount=appCode._data.tests.length;
    data+=$('form').serialize()+"&sendSolution=sendSolution&maxTestCount="+maxTextCount;
    $.ajax({
      type:"post",
      url:"indexPagePHP.php",
      data: data,
      dataType : 'json',
      cache:false,
      success:function(result){
        var countAllTest=appCode._data.tests.length;
        alert("Брой верни тестове/общ брой тестове="+result+"/"+countAllTest);
      }
    });
    return false;
  }

</script>
