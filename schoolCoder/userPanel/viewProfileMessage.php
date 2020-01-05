<div class="container">
  <form method="POST">
    <div class="modal fade" id="viewProfileMessage" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Профил
            </h4>
            <button type="button" class="close" data-dismiss="modal" v-on:click="exitMessage()">&times;</button>
          </div>
          <div class="modal-body scroow">
            <div class="row">
              <span class="col-lg-1 col-md-1"></span>
              <div class="col-lg-3 col-md-3">
                <img :src="'../img/userImg/'+[viewUser.avatar]" alt=""
                    class="row align-items-center justify-content-between d-flex adminAvatar"
                    style="height:150px;width:100%;">
                <br>
                <button type="button" name="button" v-if="viewUser.friend=='no'" v-on:click="sendFriendMessage()">Добавяне на приятел</button>
                <button type="button" name="button" v-if="viewUser.friend=='yes'">Премахване на приятел</button>

              </div>

              <div class="col-lg-8 col-md-8">
                <div class = "panel panel-success ">
                   <div class = "panel-heading primary-btn">
                     <h3 class = "panel-title">Основна информация</h3>
                  </div>
                   <div class = "panel-body row">
                     <div class="col-lg-12 col-md-12">
                       <div class="form-group row">
                         <label class="col-lg-5 col-md-5 control-label profilLabels">Потребителско име:</label>
                         <label class="col-lg-7 col-md-7 control-label profilLabels">{{viewUser.userName}}</label>
                       </div>
                       <div class="form-group row">
                         <label class="col-lg-5 col-md-5 control-label profilLabels">Име на потребителя:</label>
                         <label class="col-lg-7 col-md-7 control-label profilLabels">{{viewUser.name}}</label>
                       </div>
                       <div class="form-group row">
                         <label class="col-lg-5 col-md-5 control-label profilLabels">Email на потребителя:</label>
                         <label class="col-lg-7 col-md-7 control-label profilLabels">{{viewUser.e_mail}}</label>
                       </div>
                       <div class="form-group row">
                         <label class="col-lg-5 col-md-5 control-label profilLabels">Потребитска роля:</label>
                         <label class="col-lg-7 col-md-7 control-label profilLabels">{{viewUser.type}}</label>
                       </div>
                     </div>
                  </div>
                </div>
              </div>
            </div>
            <br>
          </div>
          <div class="modal-footer">
            <input type="submit"  class="btn primary-btn primary" data-dismiss="modal" v-on:click="exitMessage()" value="Изход">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
