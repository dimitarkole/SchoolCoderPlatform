<div class="container">
  <form method="POST">
    <div class="modal fade" id="viewSolutionResultMessage" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Информация за решение:  {{viewSolutionData.id}}
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body scroow">
              <div class="form-group row">
                <div class="col-lg-4 col-md-4">
                  Общ брой точки: <b>{{viewSolutionData.points}}</b>/100
                </div>
                <div class="col-lg-1 col-md-1">
                </div>
                <div class="col-lg-7 col-md-7">
                  Дата на изпращане на решението: <b>{{viewSolutionData.date}}</b>
                </div>
              </div>
              Решение:

              <div class="form-group row">
                <div class="col-lg-12 col-md-12">
                  <textarea rows="8" v-model="viewSolutionData.code" disabled style="width: 100%"></textarea>
                </div>
              </div>

              <br>
              <div class = "panel panel-success ">
                 <div class = "panel-heading primary-btn">
                    <h3 class = "panel-title">Нулеви тестове</h3>
                 </div>
                 <div class = "panel-body row">
                   <table class="table table-striped" name="realTaskTestTable">
                     <thead>
                       <tr>
                         <th>№</th>
                         <th>Вход</th>
                         <th>Очакван изход</th>
                         <th>Вашият изход</th>
                       </tr>
                     </thead>
                     <tbody  class="col-lg-12 col-md-12" v-if="viewSolutionData.exampleTaskTest">
                       <tr v-for="exampleTest in viewSolutionData.exampleTaskTest">
    										 <td>{{exampleTest.count}}</td>
      									 <td>{{exampleTest.input}}</td>
                         <td>{{exampleTest.output}}</td>
                         <td>{{exampleTest.yourOutput}}</td>
    									 </tr>
                     </tbody>
                   </table>
                  </div>
              </div>

              <div class = "panel panel-success ">
                 <div class = "panel-heading primary-btn">
                    <h3 class = "panel-title">Нулеви тестове</h3>
                 </div>
                 <div class = "panel-body row">
                   <table class="table table-striped" name="realTaskTestTable">
                     <thead>
                       <tr>
                         <th>№</th>
                         <th>Резултат</th>
                         <th>Отнето време за проверка</th>
                       </tr>
                     </thead>
                     <tbody  class="col-lg-12 col-md-12" v-if="viewSolutionData.realTaskTest">
                       <tr v-for="realTest in viewSolutionData.realTaskTest">
                        <td>{{realTest.count}}</td>
                        <td>{{realTest.result}}</td>
                        <td>{{realTest.time}} сек</td>
                       </tr>
                     </tbody>
                   </table>
                  </div>
              </div>
            </div>
          <div class="modal-footer">
            &emsp;<input type="submit"  class="btn primary-btn primary" data-dismiss="modal" value="Изход">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
