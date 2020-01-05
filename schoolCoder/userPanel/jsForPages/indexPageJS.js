<script type="text/javascript" Language='Javascript'>
  window.onload = function() {
    getLastAddedTestFromDB();
    getUserDataForHeader();

  }
  var appTests= new Vue({
    el: '#tests',
    data: {
      lastAddedTests: "",
      lastFriendAddedTests:""
    },
    methods: {
      goTest: function (test)
      {
        var secretID=test.secretID;
        window.location.href="solutionPage.php?secretID="+secretID;
      }
    }
  });

  function getLastAddedTestFromDB() {
    var data= "searchLastAddedTests=searchLastAddedTests";
    $.ajax({
      type:"post",
      url:"userPHP/userPHP.php",
      data: data,
      dataType : 'json',
      cache:false,
      success:function(result){
        appTests._data.lastAddedTests= result.lastAdded;
        appTests._data.lastFriendAddedTests= result.lastFriendAddedTests;

      }
    });
    return false;
  }
</script>
