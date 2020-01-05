<script type="text/javascript" Language='Javascript'>
  function logout() {
    var data="logout=logout";
    $.ajax({
      type:"post",
      url:"userPHP/userPHP.php",
      data: data,
      cache:false,
      success:function(result){
        window.location.href="../index.php";
      }
    });
    return false;
  }

  function search() {
    var searchInput=document.getElementById('searchInput').value;
    window.location.href="search.php?searchInput="+searchInput;
  }

  var appHeader= new Vue({
    el: '#userHeader',
    data: {
      userData:""
    },
    methods: {
      addFriend: function (friend) {
        аddFriendAtDB(friend);
      },
      deleteFriend:function (friend) {
        аddFriendMessageAtDB(friend);
      }
    }
  });

  function getUserDataForHeader() {
    var data= "getUserDataForHeader=getUserDataForHeader";
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       cache:false,
       data : data,
       dataType : 'json',
       success : function (result) {
         appHeader._data.userData=result;
       }
    })
  }

  function аddFriendAtDB(friend) {
    var data= "аddFriendAtDB=аddFriendAtDB&friendUserName="+friend.userName;
    alert(data);
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       cache:false,
       data : data,
       dataType : 'json',
       success : function (result) {
         alert(result);
         getUserDataForHeader();
       }
    })
  }

  function аddFriendMessageAtDB(friend) {
    var data= "deleteFriend=deleteFriend&friendUserName="+friend.userName;
    alert(data);
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       cache:false,
       data : data,
       dataType : 'json',
       success : function (result) {
         getUserDataForHeader();
         alert("Успешно отказана покана!");
       }
    })
  }
</script>
