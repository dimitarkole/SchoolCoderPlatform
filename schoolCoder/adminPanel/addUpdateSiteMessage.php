<div class="container">
  <form method="POST">
    <div class="modal fade" id="addUpdateSiteMessage" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Спиране на сайта за подръжка</h4>
            <button type="button" class="close" data-dismiss="modal" v-on:click="exitMessage()">&times;</button>
          </div>
          <div class="modal-body scroow">
            <div class="form-group row">
              <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                  <label class="col-lg-4 col-md-4 control-label profilLabels">Дата от:</label>
                  <div class="col-lg-8 col-md-8">
                    <input type="datetime-local" class="form-control" placeholder="Дата от"v-model="newProblem.close_time">
                  </div>
                </div>
              </div>

              <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                  <label class="col-lg-4 col-md-4 control-label profilLabels">Дата до:</label>
                  <div class="col-lg-8 col-md-8">
                    <input type="datetime-local" class="form-control" placeholder="Дата до"v-model="newProblem.open_time">
                  </div>
                </div>
              </div>
            </div>
            <label for="login_username" class="control-label profilLabels">Цел на актуалицацията:</label>
            <textarea class="form-control" rows="11" placeholder="Цел на актуалицацията"  name="taskCondition" v-model="newProblem.purpose"></textarea>
            <br>
          </div>
          <div class="modal-footer">
            &emsp;<input type="submit"  v-if="newProblem.method === 'newProblem'" class="btn primary-btn primary" value="Добави задачата" onclick="return addProblemAtDB()">
        <!--    &emsp;<input type="submit" v-else class="btn primary-btn primary" name="editTask" value="Запази промените" onclick="return editTaskFromDB()">-->
            &emsp;<input type="submit"  class="btn primary-btn primary" data-dismiss="modal" v-on:click="exitMessage()" value="Изход">
          </div>
        </div>
    </div>
  </form>
</div>
