<header id="header" id="home">
  <?php include('generalHeader.php') ?>
  <div class="container main-menu" id="userHeader">
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
              <input type="text" id="searchInput" class="searchInput"  name="searchInput" placeholder="Търсене на тестове и потребители" aria-describedby="basic-addon2" value="">
              <button type="submit" class="searchButton" onclick="return search()" style="padding: 0;border: none;background: none;"><img src="../img/magnifyingGlass.png" alt="" class="searchButton"></button>
            </div>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
      <div class="nav-menu" style="width: 520px">
        <div class="container">
          <div class="row">
            <div class="col-lg-5 col-md-5">

            </div>
            <div class="col-lg-2 col-md-2">
              <div class="dropdown">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../img/friend.png" style="height:25px;width:25px;">
                </a>
                <div class="dropdown-menu" v-if="userData.friends!=''">
                  <a class="dropdown-item" style="color:black;width:350px;" v-for="friend in userData.friends">
                    <div class="container">
                      <div class="row" >
                        <div class="col-lg-2 col-md-2">
                          <img :src="'../img/userImg/'+[friend.avatar]"  alt="" style="height:50px;width:50px;">
                        </div>
                        <div class="col-lg-4 col-md-4">
                          {{friend.userName}}<br>
                          {{friend.name}}<br>
                          {{friend.family}}<br>
                        </div>
                        <span class="col-lg-1 col-md-1"> </span>
                        <div class="col-lg-1 col-md-1">
                          <button v-on:click="addFriend(friend)">
                            Добавяне
                          </button>
                        </div>
                        <span class="col-lg-1 col-md-1"> </span>

                        <div class="col-lg-1 col-md-1">
                          <button v-on:click="deleteFriend(friend)">
                            Отказ
                          </button>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="dropdown-menu" v-else>
                  <a class="dropdown-item" style="color:black;width:300px;">
                    Нямате те нови понакни за приятелство!
                  </a>
                </div>

              </div>
            </div>
            <div class="col-lg-5 col-md-5">
              <div class="dropdown">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                  Здравейте, {{userData.userName}}<span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuProfile">
                  <a class="dropdown-item" href="profile.php" style="color:black">Прифил</a>
                  <a class="dropdown-item" onclick="return logout()" style="color:black">Изход</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header><!-- #header -->
