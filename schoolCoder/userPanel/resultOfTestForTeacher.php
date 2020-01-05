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
		<?php
			include('../headers/userHearder.php');
		?>
		<div id="resultsOfTest">
			<!-- start banner Area -->
			<section class="banner-area relative about-banner" id="home">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Резултати
							</h1>
							<a href="#">{{testData.name}}</a>
						</div>
					</div>
				</div>
			</section>
			<!-- End banner Area -->

			<!-- Start feature Area -->
			<section class="feature-area section-gap">
				<div class="container">
					<div class="jumbotron">
						<div class="row">
							<div class="col-lg-5 col-md-5">
								<div class="row">
									<span class="col-lg-7 col-md-7">Име на теста:</span>
									 <b class="col-lg-5 col-md-5">{{testData.name}}</b>
								</div>
								<div class="row">
									<span class="col-lg-7 col-md-7">Дата на създаване на теста:</span>
									 <b class="col-lg-5 col-md-5">{{testData.date}}</b>
								</div>
								<div class="row">
									<span class="col-lg-7 col-md-7">Парола за теста:</span>
									 <b class="col-lg-5 col-md-5">{{testData.password}}</b>
								</div>
								<div class="row">
									<span class="col-lg-7 col-md-7">Брой на задачите:</span>
									 <b class="col-lg-5 col-md-5">{{testData.countTasks}}</b>
								</div>
								<div class="row">
									<span class="col-lg-7 col-md-7">Среднен брой точки:</span>
									 <b class="col-lg-5 col-md-5">Не работи</b>
								</div>
								<div class="row">
									<span class="col-lg-7 col-md-7">Средна оценка:</span>
									 <b class="col-lg-5 col-md-5">Не работи</b>
								</div>

								<br>
								<div class="row">
									<!--<div class="col-lg-12 col-md-12">
										<div class="single-feature d-flex flex-row">
												<div id="solutionChart" style="height: 250%; width: 150%;"></div>
										</div>
									</div>-->
								</div>
							</div>
							<div class="col-lg-2 col-md-2">

							</div>
							<div class="col-lg-5 col-md-5">
								Скала за оценяване: <br>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Оценка</th>
											<th>Точки (от-до)</th>
										</tr>
									</thead>
								 <tbody>
									 <tr v-for="purpose in ratingScale">
										 <td>{{purpose.purpose}}</td>
										 <td>{{purpose.point}}</td>
									 </tr>
									</tbody>
								</table>
								Формула за оценяване: <br>
								Оценка=(x*6)/общият брой точки от теста
								*Оценката е примерна! Учителят не е длъжен да се съобрази с нея!
							</div>
						</div>
						<br>
							<div class="panel panel-success row" >
								<div class="panel-heading">
										 Резултати
									</div>
									<div class = "panel-body col-lg-12 col-md-12">
										Търсене на потребител:<br><br>

										<div class="row">
											 <div class=" col-lg-5 col-md-5"  >
												 <div class="form-group row">
													 <label class="col-lg-5 col-md-5 control-label profilLabels">Потребителско име:</label>
													 <div class="col-lg-7 col-md-7">
														 <input type="text" class="form-control"  v-model="searchUserName" value="" class="form-control" placeholder="Потребителско име">
													 </div>
												 </div>

												 <div class="form-group row">
													<label class="col-lg-5 col-md-5 control-label profilLabels">Име:</label>
													<div class="col-lg-7 col-md-7">
														<input type="text" class="form-control"  v-model="searchName" value="" class="form-control" placeholder="Име">
													</div>
												</div>

												 <div class="form-group row">
													 <label class="col-lg-5 col-md-5 control-label profilLabels">Фамилия:</label>
													 <div class="col-lg-7 col-md-7">
														 <input type="text" class="form-control"  v-model="searchFamily" value="" class="form-control" placeholder="Фамилия">
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
																 <!--option value="putpose26">Оценки възходящ ред (2-6)</option>
															 	 <option value="putpose62">Оценки низходящ ред (6-2)</option>-->
																 <option value="userNameAZ">Азбучен ред	потребителско име (А-Я)</option>
																 <option value="userNameZA">Азбучен ред	потребителско име (Я-А)</option>
																 <option value="nameFamilyAZ">Азбучен ред	име и фамилия(А-Я)</option>
																 <option value="nameFamilyZA">Азбучен ред	име и фамилия(Я-А)</option>


			  											 </select>
														 </div>
													 </div>
												 </div>


												 <div class="form-group row">
													 <div class="col-lg-2 col-md-2">
			 										</div>
													<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="searchSolution()">Търсене</button>
													<div class="col-lg-2 col-md-2">
													</div>
													<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="cancel()">Анолиране</button>
												</div>

											 </div>
										</div>
										<table class="table table-striped row" style="width:100%;margin:0px;">
											<tr class="panel-body col-lg-12 col-md-12">
												<th>№</th>
												<th>Потребителско име</th>
												<th>Име и фамилия</th>
												<th v-for="taskName in tasksName">{{taskName.countTask}}. {{taskName.name}}</th>
											  <th>Общ брой точки</th>
												<th>Оценка</th>
											</tr>
											<tr v-for="userSolutuon in userSolutuons" class="panel-body col-lg-12 col-md-12">
												 <td>{{userSolutuon.count}}</td>
												 <td >{{userSolutuon.userName}}</td>
												 <td>{{userSolutuon.usersNames}}</td>
												 <td v-for="solution in userSolutuon.userSolutionForTasks">
													 {{solution.point}}
												 </td>
												 <td>{{userSolutuon.sumPoint}}</td>
												 <td>{{userSolutuon.purpose}}</td>
											</tr>
											<tr class="col-lg-12 col-md-12">
												<td colspan="3">
	 												<div class="btn-toolbar" role="toolbar" aria-label="...">
	 													Страници: <pre>	</pre>
	 													<div v-for="page in solutionsPages">
	 														<button  class="btn primary-btn" v-on:click="changePage(page)">{{page}}</button>
	 														 <pre>	</pre>
	 													</div>
	 												</div>
	 											</td>
											</tr>
										</table>
								 </div>
							</div>
					</div>
				</div>
			</section>
			<!-- End feature Area -->
		</div>

		<?php
			include('../footer.php');
		 	include('../scripts.php');
			include('user.js');
			include('jsForPages/resultOfTestForTeacherPage.js');
		?>
	</body>
</html>
