<script>
  function registrationPerson() {
    var userName= document.getElementById('userName').value;
    var e_mail= document.getElementById('email').value;
    var password_1= document.getElementById('password_1').value;
    var password_2= document.getElementById('password_2').value;
    var registrationUser= document.getElementById('registration_user').value;
    var data= "userName="+userName+"&email="+e_mail+
        "&password_1="+password_1+"&password_2="+password_2+
        "&registration_user="+registrationUser;

    $.ajax({
      type:"post",
      url:"server.php",
      data: data,
      cache:false,
      success:function(html){
        $('#messageForRegistration').html(html);
        //
      }
    });
    return false;
  }

  function loginPerson() {
    var userName= document.getElementById('login_userName').value;
    var password= document.getElementById('login_password').value;
    var loginUser= document.getElementById('login_user').value;
    var data= "userName="+userName+"&password="+password+
        "&login_user="+loginUser;

    $.ajax({
      type:"post",
      url:"server.php",
      data: data,
      cache:false,
      success:function(html){
        if (html.substr(0, 8)=="location") {
          window.location.href=html.slice(10,html.length);
        }
        else {
          $('#messageForLogin').html(html);
        }
      }
    });
    return false;
  }
</script>
