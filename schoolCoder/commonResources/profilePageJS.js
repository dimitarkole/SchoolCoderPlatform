<script type="text/javascript" Language='Javascript'>

  window.onload = function() {
    getProfileDataFromDB();
    getUserDataForHeader();

  }
  var appProfile= new Vue({
    el: '#profilPage',
    data: {
      data:"",
      profileMessage:"",
      avatarPath:"",
      image: '',
      changePassword:{
        oldPassword:"",
        newPassword:"",
        renewPassword:"",
        message:""
      }

   },
   methods: {
     onFileChange(e) {
       var files = e.target.files || e.dataTransfer.files;
       if (!files.length)
         return;
       this.createImage(files[0]);
     },

     createImage(file) {
       var image = new Image();
       var reader = new FileReader();
       var vm = this;

       reader.onload = (e) => {
         vm.image = e.target.result;
       };
       reader.readAsDataURL(file);
       changeAvatarAtDB(file);
     },

     removeImage: function (e) {
       this.image = '';
     },

     goTeacher: function() {
       makeMeTeacherAtDB();
     },


     cleanPassword: function () {
       appProfile._data.changePassword={
           oldPassword:"",
           newPassword:"",
           renewPassword:"",
        };
     }
   }
  });

  function makeMeTeacherAtDB() {
    var data="makeMeTeacherAtDB=makeMeTeacherAtDB";
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
    return false;
  }

  function savePasswordAtDB() {
    var password=appProfile._data.changePassword;
    var data="savePasswordAtDB=savePasswordAtDB";
    data+="&oldPassword="+password.oldPassword;
    data+="&newPassword="+password.newPassword;
    data+="&renewPassword="+password.renewPassword;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appProfile._data.changePassword.message=result;
       }
    })
    return false;
  }

  function getProfileDataFromDB() {
    var data="getProfileDataFromDB=getProfileDataFromDB";
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         var person=result;
         person.avatar="../img/userImg/"+result.avatar;
         appProfile._data.data=person;
       }
    })
    return false;
  }

  function changeAvatarAtDB(image) {
    console.log(image['file']);
    var data="changeAvatarAtDB=changeAvatarAtDB&image="+image;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         alert(result);
         /*var person=result;
         person.avatar="../img/userImg/"+result.avatar;
         appProfile._data.data=person;*/
       }
    })
    return false;
  }

  function updateProfile() {
    var userData= appProfile._data.data;
    var data="updateProfile=updateProfile";
    data+="&name="+userData.name;
    data+="&family="+userData.family;
    $.ajax({
       url : 'userPHP/userPHP.php',
       type : 'POST',
       data : data,
       cache:false,
       dataType : 'json',
       success : function (result) {
         appProfile._data.profileMessage=result;
         getProfileDataFromDB();
       }
    })
    return false;
  }
</script>
