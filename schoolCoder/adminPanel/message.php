<div class="container">
  <div class="modal fade" id="message" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            Съобщение от: messagesFrom
          </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="content">
            <div class="row">
              <div class="col-lg-2 col-md-2 ">
                <!--<img class="img-fluid" src="../img/t2.jpg" alt="">-->
                <label for="inputName" class="control-label profilLabels">Фамилия</label>
              </div>

              <div class="col-lg-5 col-md-5">
                <div class="form-group row">
                  <label for="inputName" class="col-lg-3 col-md-3 control-label profilLabels">Име:</label>
                  <label for="inputName" class="col-lg-9 col-md-9 control-label profilLabels">UserName}}</label>
                </div>
                <div class="form-group row">
                  <label for="inputName" class="col-lg-3 col-md-3 control-label profilLabels">Фамилия:</label>
                  <label for="inputName" class="col-lg-9 col-md-9 control-label profilLabels">Фамилия</label>
                </div>
              </div>

              <div class="col-lg-5 col-md-5">
                Направи потребителя:<br>
                <div class="row">
                  <button type="submit" class="primary-btn col-lg-5 col-md-5" v-on:click="makeUserTeacher(viewMessages.userId)">Учител</button><br>
                  <span class="col-lg-1 col-md-1"></span>
                  <button type="submit" class="primary-btn col-lg-5 col-md-5" v-on:click="makeUserStudent(viewMessages.userId)">Ученик</button><br>
                </div>
                <br>
                <div class="row">
                  <button type="submit" class="primary-btn col-lg-11 col-md-11" v-on:click="deleteUser(viewMessages.userId)">Изтрий потребителя</button>
                </div>
              </div>
            </div>
          </div>


          <br>
          <div class="container">
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class = "panel panel-success ">
                   <div class = "panel-heading primary-btn">
                      <h3 class = "panel-title">История на съобщенията</h3>
                   </div>
                   <div class = "panel-body   col-lg-12 col-md-12">
                      <div class="" v-for="message in viewMessages.messages">
                        <div class="row" v-if="message.messageFrom=='user'">
                          <div class="col-lg-7 col-md-7">
                            <span class="">{{message.message_text}}</span>
                          </div>
                        </div>
                        <div class="row" v-else>
                          <div class="col-lg-5 col-md-5">

                          </div>
                          <div class="col-lg-7 col-md-7">
                            <span class="">{{message.message_text}}</span>


                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        <div class="modal-footer">
          &emsp;<button type="button" class="btn btn-default"  data-dismiss="modal">Изход</button>
        </div>
      </div>
    </div>
  </div>
</div>
