<!DOCTYPE html>
<?php
	include('../server.php');
 	include('userServer.php');
?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>

</head>
	<body>
		<?php include('../headers/userHearder.php');?>
		<!-- start banner Area -->
		<section class="banner-area relative about-banner" id="home">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Учителски права
							</h1>
							<a href="#">Задачи</a>
						</div>
					</div>
				</div>
			</section>
		<!-- End banner Area -->

		<!-- Start feature Area -->
		<section class="feature-area section-gap" id="viewAllAddedTasks">
			<div class="container">
					<div class="panel panel-success row" >
					  <div class="panel-heading">
							Задачи
						</div>
					  <div class="panel-body col-lg-12 col-md-12">
							Търсене на задача:	<br><br>
							<div class="row">
								 <div class=" col-lg-5 col-md-5">
									 <div class="form-group row">
										 <label class="col-lg-5 col-md-5 control-label profilLabels">Търсене по име:</label>
										 <div class="col-lg-7 col-md-7">
											 <input type="text" class="form-control"  v-model="searchTaskTittle" value="" class="form-control" placeholder="Име на задачата">
										 </div>
									 </div>
									 <div class="form-group row">
										<label class="col-lg-5 col-md-5 control-label profilLabels">Дата от/до:</label>
										<div class="col-lg-7 col-md-7">
											<div class="form-group row">
												<div class="col-lg-6 col-md-6">
													<input type="date" class="form-control" v-model="dateFrom" class="form-control">
												</div>
												<div class="col-lg-6 col-md-6">
													<input type="date" class="form-control" v-model="dateTo" class="form-control">
												</div>
											</div>
										</div>
									 </div>
								 </div>

								 <div class=" col-lg-2 col-md-2">

								 </div>

								 <div class=" col-lg-5 col-md-5">
									 <div class="form-group row">
										 <label class="col-lg-4 col-md-4">Подреди по:</label>
										 <div class="col-lg-8 col-md-8">
											 <div class="form-group row">
												 <select class="col-lg-11 col-md-11" onchange="" id="sortSelect">
  												 <option value="date">Дата на добавяне</option>
  												 <option value="alphabetAZ">Азбучен ред	(А-Я)</option>
													 <option value="alphabetZA">Азбучен ред	(Я-А)</option>
  											 </select>
											 </div>
										 </div>
									 </div>


									 <div class="form-group row">
										 <div class="col-lg-2 col-md-2">
 										</div>
										<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="searchTask()">Търсене</button>
										<div class="col-lg-2 col-md-2">
										</div>
										<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="cancel()">Анолиране</button>
									</div>

								 </div>
							</div>

               <table class="table table-striped">
                 <thead>
                   <tr>
                     <th>№</th>
                     <th>Име на задача</th>
                     <th>Брой примерни входове</th>
                     <th>Брой системни входове</th>
                     <th>Дата на добавяне</th>
										 <th>Редактирай</th>
										 <th>Изтрий</th>
                   </tr>
                 </thead>
								 <tbody>
									 <tr v-for="task in tasks">
										 <td>
											 {{task.count}}
										 </td>
  									 <td>{{task.taskName}}</td>
  									 <td>{{task.countVisableTest}}</td>
										 <td>{{task.countSystemInput}}</td>
										 <td>{{task.date}}</td>

										 <td>
											 <button type="button" name="button " class="btn primary-btn"  v-on:click="editTask(task)" data-toggle="modal" data-target="#addTaskMessage">
												 <img src="../img/edit.png" alt="">
											 </button>
										 </td>
										 <td>
												<button type="submit" v-on:click="deleteTask(task)" class="btn primary-btn">
													 <img src="../img/x.jpg" alt="">
												</button>
										 </td>
									 </tr>
                 </tbody>
								 <tfoot>
									 <tr>
										 <td colspan="2">
										 </td>
										 <td colspan="3">
											 <div class="btn-toolbar" role="toolbar" aria-label="...">
												 Страници:
												 <div v-for="page in pages">
													 <button  class="btn primary-btn" v-on:click="changePage(page)">{{page.text}}</button>
														<pre>	</pre>
												 </div>
											 </div>
										 </td>
										 <td colspan="2">
										 </td>
									</tr>
									<tr>
										<td	colspan="7">
											 <button type="button" class="col-lg-12 col-md-12 btn primary-btn" data-toggle="modal" data-target="#addTaskMessage" v-on:click="newTask()">Добвавяне на нова задача</button>
										 </td>
									 </tr>

								 </tfoot>
               </table>
							 <?php include('addTaskMessage.php');	?>
					  </div>
					</div>
			</div>
		</section>

		<!-- End feature Area -->
		<?php
			include('../footer.php');
			include('../scripts.php');
			include('user.js');
			include('jsForPages/addTaskPageJS.js');
		?>
	</body>
</html>
