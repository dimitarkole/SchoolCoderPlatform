<div class="modal" id="changePasswordMessage" role="dialog" style="height: 350px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          Смяна на парола
        </h4>
        <button type="button" class="close" data-dismiss="modal" v-on:click="cleanPassword()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <span class="col-lg-12 col-md-12">{{changePassword.message}}</span>

        </div>
        <form >
          <div class="form-group row">
            <label class="col-lg-5 col-md-5 control-label profilLabels">Стара парола:</label>
            <div class="col-lg-7 col-md-7">
              <input type="password" class="form-control"  v-model="changePassword.oldPassword" class="form-control" placeholder="Стара парола">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-5 col-md-5 control-label profilLabels">Нова парола:</label>
            <div class="col-lg-7 col-md-7">
              <input type="password" class="form-control" v-model="changePassword.newPassword" class="form-control" placeholder="Нова парола">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-5 col-md-5 control-label profilLabels">Повтори паролата:</label>
            <div class="col-lg-7 col-md-7">
              <input type="password" class="form-control" v-model="changePassword.renewPassword" class="form-control" placeholder="Повтори паролата">
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        &emsp;<input type="submit" class="btn primary-btn primary" value="Запази промените" onclick="return savePasswordAtDB()">
        &emsp;<input type="submit"  class="btn primary-btn primary" data-dismiss="modal" v-on:click="exitMessage()" value="Отказ">
      </div>
    </div>
  </div>
</div>
