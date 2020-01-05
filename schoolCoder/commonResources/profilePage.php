<!-- Start feature Area -->
<section class="feature-area section-gap">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4 jumbotron">
          <div class="row">
            <div class="col-lg-1 col-md-1">
            </div>
            <img class="img-fluid col-lg-10 col-md-10 adminAvatar" :src="data.avatar" alt="" style="height:200px;width:100%;">
            <div class="col-lg-1 col-md-1">
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-8">
              <div v-if="!image">
                <input type="file" @change="onFileChange" class="btn primary-btn primary mt-20" value="Смени аватара">
              </div>
              <div v-else>
                <img :src="image" />
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-1 col-md-1">

            </div>
            <button v-if="data.type=='student'" type="button"  class="col-lg-10 col-md-10 btn primary-btn primary mt-20" v-on:click="goTeacher()">Стани учител
            </button>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-1 col-md-1">

            </div>
            <button type="button"  class="col-lg-10 col-md-10 btn primary-btn primary mt-20" data-toggle="modal" data-target="#changePasswordMessage" v-on:click="cleanPassword()">Смяна на парола</button>
            <?php include('changePasswordMessage.php'); ?>
          </div>
      </div>

      <div class="col-lg-1 col-md-1">

      </div>

      <div class="col-lg-7 col-md-7	jumbotron">
          <h3>Основна информация</h3><br>
          <div class="form-group row">
            <label for="inputName" class="col-lg-12 col-md-12 control-label">{{profileMessage}}</label>

          </div>
          <div class="form-group row">
            <label for="inputName" class="col-lg-4 col-md-4 control-label profilLabels">Име</label>
            <div class="col-lg-8 col-md-8">
              <input type="text" class="form-control" name="name" placeholder="Име" v-model="data.name">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputName" class="col-lg-4 col-md-4 control-label profilLabels">Фамилия</label>
            <div class="col-lg-8 col-md-8">
              <input type="text" class="form-control" name="family" placeholder="Фамилия" v-model="data.family">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputName" class="col-lg-4 col-md-4 control-label profilLabels">Email адрес</label>
            <label for="inputName" class="col-lg-8 col-md-8 control-label profilLabels">{{data.email}}</label>
          </div>
          <div class="form-group row">
            <label for="inputName" class="col-lg-4 col-md-4 control-label profilLabels">Потребителско име</label>
            <label for="inputName" class="col-lg-8 col-md-8 control-label profilLabels">{{data.userName}}</label>
          </div>
          <div class="form-group row">
            <label for="inputName" class="col-lg-4 col-md-4 control-label profilLabels">Вие сте</label>
            <label for="inputName" class="col-lg-8 col-md-8 control-label profilLabels">{{data.type}}</label>
          </div>
          <div class="form-group row">
            <div class="col-sm-offset-7 col-sm-7">
            </div>
            <div class="col-sm-offset-5 col-sm-5">
                <button type="submit" class="btn primary-btn primary mt-20" name="updateProfile" onclick="updateProfile()">Запамети промените</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
<!-- End feature Area -->
