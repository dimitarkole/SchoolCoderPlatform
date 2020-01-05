  <div class="container">

    <div class="modal fade" id="addTestMessage" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"  v-if="method === 'newTest'">
              Създаване на нов тест
            </h4>
            <h4 class="modal-title" v-else>
              Редактиране на тест
              <input type="hidden" name="editTaskId" v-model="viewTestId">
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body scroow">
            <div class="form-group row">
              <label class="col-lg-3 col-md-3 control-label profilLabels">Име на теста:</label>
              <div class="col-lg-9 col-md-9">
                <input type="text" class="form-control"  name="testName" value="" class="form-control" placeholder="Име на теста" id="testName" v-model="viewTestName">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-md-3 control-label profilLabels">Парола</label>
              <div class="col-lg-9 col-md-9">
                <input type="text" class="form-control"  name="testName" value="" class="form-control" placeholder="Име на теста" id="testName" v-model="viewTestPassword">
              </div>
            </div>
            <br>

            <div class = "panel panel-success ">
              <div class = "panel-heading primary-btn">
                <h3 class = "panel-title">Добавени задачи към теста</h3>
              </div>
              <div class = "panel-body row">
                <table class="table table-striped " id="taskForTestTable">
                  <thead>
                    <tr>
                       <th>№</th>
                       <th>Име на задачата</th>
                       <th>Условие</th>
                       <th>Премахни</th>
                     </tr>
                  </thead>
                  <tbody class="col-lg-12 col-md-12">
                    <tr v-for="task in viewAddedTaskForTest">
                      <td>{{task.count}}</td>
                      <td :name="'taskForTestTableRow'+[task.count]+'Col0'">
                        {{task.taskName}}
                      </td>
                      <td :name="'taskForTestTableRow'+[task.count]+'Col1'">
                        {{task.taskText}}
                      </td>
                      <td>
                        <button class="btn primary-btn" v-on:click="deleteAddedTask(task)"  >
                          <img src="../img/x.jpg" alt="">
                        </button>
                      </td>
    								 </tr>
                   </tbody>
                </table>
              </div>
            </div>

            <div class = "panel panel-success ">
              <div class = "panel-heading primary-btn">
                <h3 class = "panel-title">Добавяне на нова задача към теста</h3>
              </div>
              <div class = "panel-body">
                  <div class="form-group row">
                    <div class="col-lg-3 col-md-3">Име на задача:</div>
                    <div class="col-lg-9 col-md-9">
                      <select id="taskSelect" class="col-lg-12 col-md-12" onchange="changeSelectedTaskForTest()">
                        <option :value="[task.taskName]" v-for="task in allTasks">{{task.taskName}}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-3 col-md-3">Условие на задача:</div>
                    <div class="col-lg-9 col-md-9">
                      {{viewTaskTextForAdd}}
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-7 col-md-7"></div>
                    <div class="col-lg-5 col-md-5">
                      <button class="col-lg-12 col-md-12 btn primary-btn" v-on:click="addTaskTest()">Добвавяне на задача към теста</button>
                    </div>
                  </div>
              </div>
            </div>
            <br>
          </div>
          <div class="modal-footer">
            &emsp;<button type="submit"  v-if="method === 'newTest'" class="btn primary-btn" onclick="saveTest()">Добави теста</button>
            &emsp;<button type="submit" v-else  name="editTest" class="btn primary-btn" onclick="editTestFromDB()">Запази промените</button>
            &emsp;<button type="button"   class="btn primary-btn" data-dismiss="modal">Изход</button>
          </div>
        </div>
      </div>
    </div>
  </div>
