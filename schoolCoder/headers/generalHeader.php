<div class="header-top">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
          <a href="index.php"><img src="../img/logo.png" alt="School coder" title="School coder" /></a>
      </div>
      <div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
          <?php
            if (isset($_SESSION['type'])) {
              echo "<a class='btns'>Вие сте: ".$_SESSION['type']."</a>";
            }
          ?>
      </div>
    </div>
  </div>
</div>
