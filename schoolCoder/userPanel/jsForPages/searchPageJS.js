<script type="text/javascript" Language='Javascript'>
  var searchInput;
  window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    searchInput=urlParams.get('searchInput');
    getUserDataForHeader();
    getSearchDataFromDB(searchInput,0);
  }


  function getSearchDataFromDB(searchText, type){
    var data= "searchText="+searchText;
    if (type==0)data+="&getSearchDataFromDB=getSearchDataFromDB";
    else {
      var dateTo= appSearch._data.dateTo;
      var dateFrom= appSearch._data.dateFrom;
      var testName= appSearch._data.searchTestTittle;
      data+="&getSearchDataFromDB=getSearchDataFromDB1&dateTo="+dateTo;
      data+="&dateFrom="+dateFrom+"&testName="+testName;
    }
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appSearch._data.resultSearchUsers=result.searchUsers.foundUsers;
         appSearch._data.resultSearchTests=result.searchTests.foundTests;
         appSearch._data.searchText=result.searchText;
         appSearch._data.searchTestTittle=result.searchText;
       }
    })
    return false;
  }

  function getUserDataFromDB(user) {
    var user={
      userName:user.userName,
      avatar:user.avatar,
      name:user.name+" "+user.family,
      type:user.type,
      friend:"",
      e_mail:user.e_mail
    }
    var data= "getUsersFrendsDataFromDB=getUsersFrendsDataFromDB&";
    data+= "userName="+user.userName;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
          user.friend= result;
       }
    })
    appSearch._data.viewUser=user;
    return false;
  }

  function sendFriendMessageAtDB() {
    var data= "sendFriendMessageAtDB=sendFriendMessageAtDB&";
    var user= appSearch._data.viewUser;
    data+= "userName="+user.userName;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
          alert(result);
       }
    })
  }

  var appSearch= new Vue({
    el: '#resultOfSearch',
    data: {
      resultSearchTests: "",
      resultSearchUsers: "",
      searchText:"",
      searchTestTittle:"",
      dateTestFrom:"",
      dateTestTo:"",
      viewUser:"",
      selected:"date",
    },
    methods: {
      search: function() {
        var searchText=appSearch._data.searchText;
        getSearchDataFromDB(searchText,0);
      },

      goTest: function (test, side)
      {
        var secretID="",userName="";
        if(side=="left") secretID=test.left.secretID;
        else if (side=="rigth")  secretID=test.rigth.secretID;
        window.location.href="solutionPage.php?secretID="+secretID;
      },

      searchSolution: function () {
        getSearchDataFromDB(searchInput,1);
      },

      cancelTest: function () {
        appSearch._data.dateTestTo="";
        appSearch._data.dateTestFrom="";
        appSearch._data.searchTestTittle="";
        var e= document.getElementById('sortSelect');
        e.selectedIndex= 0;
        getSearchDataFromDB(searchInput,0);
      },

      getUserData: function(user) {
        getUserDataFromDB(user);
      },

      exitMessage:function() {
        appSearch._data.viewUser="";
      },

      sendFriendMessage: function() {
        sendFriendMessageAtDB();
      }
    }
  });
</script>
