<div class="container">
  <form method="POST">
    <div class="modal fade" id="addTaskMessage" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"  v-if="method === 'newTask'">
              Създаване на нова задача
            </h4>
            <h4 class="modal-title" v-else>
              Редактиране на задача
              <input type="hidden" id="editTaskId" v-model="viewTaskId">
            </h4>
            <button type="button" class="close" data-dismiss="modal" v-on:click="exitMessage()">&times;</button>
          </div>
          <div class="modal-body scroow">
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 control-label profilLabels">Име на задачата:</label>
                <div class="col-lg-9 col-md-9">
                  <input type="text" class="form-control" placeholder="Име на задачата" v-model="viewTaskName">
                </div>
              </div>
              <label for="login_username" class="control-label profilLabels">Условие на задачата:</label>
              <textarea class="form-control" rows="11" placeholder="Поставете условиет на задачата тук" v-model="viewTaskCondition"></textarea>
              <br>
              <div class = "panel panel-success ">
                 <div class = "panel-heading primary-btn">
                    <h3 class = "panel-title">Примерни тестове (видими за учениците)</h3>
                 </div>
                 <div class = "panel-body row">
                   <table class="table table-striped " name="exampleTaskTestTable">
                     <thead>
                       <tr>
                         <th>№</th>
                         <th>Вход</th>
                         <th>Изход</th>
                         <th>Обяснение</th>
                         <th>Изтрий</th>
                       </tr>
                     </thead>
                     <tbody class="col-lg-12 col-md-12">
                       <tr v-for="exsampleTest in viewExampleTaskTest">
                          <td>{{exsampleTest.count}}</td>
                          <td>
                             <textarea :name="'exampleTaskTestTableRow'+[exsampleTest.count]+'Col0'" rows="3" v-model="exsampleTest.input"></textarea>
                          </td>
                          <td>
                             <textarea :name="'exampleTaskTestTableRow'+[exsampleTest.count]+'Col1'" rows="3" v-model="exsampleTest.output"></textarea>
                          </td>
                          <td>
                             <textarea :name="'exampleTaskTestTableRow'+[exsampleTest.count]+'Col2'" rows="3" v-model="exsampleTest.explanation"></textarea>
                          </td>
                          <td>
                            <button type="button" name="button" v-on:click="deleteTestForTask(exsampleTest,viewExampleTaskTest)" class="btn primary-btn">
                              <img src="../img/x.jpg" alt="">
                            </button>
                          </td>
    									 </tr>
                     </tbody>
                     <tfoot>
                       <tr>
                         <td colspan="5">
                           <button type="button" name="button" class="col-lg-12 col-md-12 btn primary-btn" v-on:click="addTest('example',viewExampleTaskTest )">Добвавяне на нов тест</button>
                         </td>
                       </tr>
                     </tfoot>
                   </table>
                  </div>
              </div>
              <br>
              <div class = "panel panel-success ">
                 <div class = "panel-heading primary-btn">
                    <h3 class = "panel-title">Тестове (проверка от системата)</h3>
                 </div>
                 <div class = "panel-body row">
                   <table class="table table-striped"  name="realTaskTestTable">
                     <thead>
                       <tr>
                         <th>№</th>
                         <th>Вход</th>
                         <th>Изход</th>
                         <th>Брой точки</th>
                         <th>Изтрий</th>
                       </tr>
                     </thead>
                     <tbody  class="col-lg-12 col-md-12">
                       <tr v-for="realTest in viewRealTaskTest">
    										 <td>{{realTest.count}}</td>
      									 <td>
      											<textarea :name="'realTaskTestTableRow'+[realTest.count]+'Col0'" rows="3" v-model="realTest.input"></textarea>
                         </td>
                         <td>
                           <textarea :name="'realTaskTestTableRow'+[realTest.count]+'Col1'" rows="3" v-model="realTest.output"></textarea>
                         </td>
                         <td>
                           {{realTest.points}}
                         </td>
    										 <td>
                           <button type="button" name="button" v-on:click="deleteTestForTask(realTest,viewRealTaskTest)" class="btn primary-btn">
    												 <img src="../img/x.jpg" alt="">
    											 </button>
    										 </td>
    									 </tr>
                     </tbody>
                     <tfoot>
                       <tr>
                         <td colspan="5">
                           <button type="button" name="button" class="col-lg-12 col-md-12 btn primary-btn" v-on:click="addTest('real',viewRealTaskTest)">Добвавяне на нов тест</button>
                         </td>
                       </tr>
                     </tfoot>
                   </table>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            &emsp;<input type="submit"  v-if="method === 'newTask'" class="btn primary-btn primary" name="saveTask" value="Добави задачата" onclick="return addTaskToDB()">
            &emsp;<input type="submit" v-else class="btn primary-btn primary" name="editTask" value="Запази промените" onclick="return editTaskFromDB()">
            &emsp;<input type="submit"  class="btn primary-btn primary" data-dismiss="modal" v-on:click="exitMessage()" value="Изход">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
