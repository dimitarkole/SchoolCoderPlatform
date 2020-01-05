<header id="header" id="home">
  <?php include('generalHeader.php') ?>
  <div class="container main-menu">
    <div class="row align-items-center justify-content-between d-flex">
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="index.php">Начало</a></li>
          <li><a href="index.php"></a></li>
          <li><a href="messages.php">Съобщения [<?php echo $mesaggesCount;?>]</a></li>
          <li>
            <div class='dropdown'>
              <a href='' class='dropdown-toggle' data-toggle='dropdown'>Системни настройки</a>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuProfile'>
                <a class='dropdown-item' href='updateSitePage.php' style='color:black'>Актуализиране на сайта</a><br>
              </div>
            </div>
          </li>

        </ul>
      </nav><!-- #nav-menu-container -->

      <div class="nav-menu">
        <div class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo "Здравейте, ". $_SESSION['userName']; ?><span class="caret"></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuProfile">
            <a class="dropdown-item" href="profile.php" style="color:black">Прифил</a>
            <a class="dropdown-item" onclick="return logout()" style="color:black">Изход</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header><!-- #header -->
