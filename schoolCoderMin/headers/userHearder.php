<header id="header" id="home">
  <?php include('generalHeader.php') ?>
  <div class="container main-menu">
    <div class="row align-items-center justify-content-between d-flex">
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="index.php">Начало</a></li>

          <?php
            if($_SESSION['type']=="teacher")echo "
            <li>
              <div class='dropdown'>
                <a href='' class='dropdown-toggle' data-toggle='dropdown'>Учителски права</a>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuProfile'>
                  <a class='dropdown-item' href='allTasks.php' style='color:black'>Задачи</a><br>
                  <a class='dropdown-item'  href='allTests.php' style='color:black'>Тестове</a>
                </div>
              </div>
            </li>";
          ?>
          <li class="menu-active">
            <div class="input-group">
              <input type="text" id="searchInput" class="searchInput" placeholder="Търсене на тестове и потребители" aria-describedby="basic-addon2" value="">
              <button type="submit" class="searchButton" onclick="return search()"><img src="../img/magnifyingGlass.png" alt=""></button>
            </div>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
      <div class="nav-menu">
        <div class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown">
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
