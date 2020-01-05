<script>
  function logout() {
    var data="logout=logout";
    $.ajax({
      type:"post",
      url:"adminServer.php",
      data: data,
      cache:false,
      success:function(result){
        window.location.href="../index.php";
      }
    });
    return false;
  }

  

</script>
