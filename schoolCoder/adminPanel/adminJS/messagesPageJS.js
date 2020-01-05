<script type="text/javascript" Language='Javascript'>

  window.onload = function() {
    getMessagesFromDB();
  }
  var appMessages = new Vue({
    el: '#AllMessages',
    data: {
      messages:[],
      viewMessages:"",
    },
    methods: {
      changeMessage: function (message){
        getMessageDataFromDB(message.senderUserId);
      },
      makeUserTeacher: function (userId) {
        makeUserTeacherAtDB(userId);
      },
      makeUserStudent: function (userId) {
        makeUserStudentAtDB(userId);
      },
      deleteUser: function (userId) {
        deleteUserAtDB(userId);
      }
    }
  });

  function getMessagesFromDB() {
    var data="getMessagesFromDB=getMessagesFromDB";
    $.ajax({
      url:"adminPHP/adminPHP.php",
      type : 'POST',
      data : data,
      cache:false,
      dataType : 'json',
      success : function (result) {
        appMessages._data.messages=result;
      }
    });
    return false;
  }

  function getMessageDataFromDB(senderUserId) {
    var data="getMessageDataFromDB=getMessageDataFromDB&userSenderId="+senderUserId;
    $.ajax({
      url:"adminPHP/adminPHP.php",
      type : 'POST',
      data : data,
      cache:false,
      dataType : 'json',
      success : function (result) {
        var messagesData={
          messages:result.reverse(),
          userId:senderUserId
        };
        appMessages._data.viewMessages=messagesData;
      }
    });
    return false;
  }

  function makeUserTeacherAtDB(userId){
    var data="makeUserTeacherAtDB=makeUserTeacherAtDB&userId="+userId;
    $.ajax({
      url:"adminPHP/adminPHP.php",
      type : 'POST',
      data : data,
      cache:false,
      dataType : 'json',
      success : function (result) {
        getMessageDataFromDB(userId);
      }
    });
    return false;
  }

  function makeUserStudentAtDB(userId) {
    var data="makeUserStudentAtDB=makeUserStudentAtDB&userId="+userId;
    $.ajax({
      url:"adminPHP/adminPHP.php",
      type : 'POST',
      data : data,
      cache:false,
      dataType : 'json',
      success : function (result) {
        getMessageDataFromDB(userId);
      }
    });
    return false;
  }


  function deleteUserAtDB(userId) {
    var data="deleteUserAtDB=deleteUserAtDB&userId="+userId;
    $.ajax({
      url:"adminPHP/adminPHP.php",
      type : 'POST',
      data : data,
      cache:false,
      dataType : 'json',
      success : function (result) {
        alert("Успешно премахнат потребител!")
      }
    });
    return false;
  }

</script>
