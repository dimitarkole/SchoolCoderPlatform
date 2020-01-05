<!DOCTYPE html>
<?php include('../server.php') ?>
<?php include('userServer.php') ?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>
</head>
	<body>
		<div id="resultOfSearch">
			<?php
				include('../headers/userHearder.php');
			?>
			<!-- start banner Area -->
			<section class="banner-area relative about-banner" >
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Резултати от търсенето за
							</h1>
							<a href="#">{{searchText}}</a>
						</div>
					</div>
				</div>
			</section>

			<!-- End banner Area -->
			<!-- Start feature Area -->
			<section class="feature-area section-gap" >
				<div class="container jumbotron" >
					<ul class="nav nav-tabs" role="tablist">
						<li class="active">
							<a href="#test" role="tab" data-toggle="tab">Тестове</a>
						</li>
						<li>
							<a href="#user" role="tab" data-toggle="tab">Потребители</a>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane " id="user">
							<div v-if="resultSearchUsers.length>0">
								<h4>Потребители</h4>
								<div class="" v-for="result in resultSearchUsers">
									<div class="row">
										<button class="col-lg-5 col-md-5 btn primary-btn primary" data-toggle="modal" data-target="#viewProfileMessage" v-on:click="getUserData(result.left)">
											<div class="row">
												<img :src="'../img/userImg/'+[result.left.avatar]" alt=""
												 		class="col-lg-3 col-md-3 align-items-center justify-content-between d-flex"
														style="height:90px;">
												<div class="col-lg-9 col-md-9 align-items-center justify-content-between d-flex" >
													<div class="content">
														<div class="row">
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Потребителско име: {{result.left.userName}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Име: {{result.left.name}} {{result.left.family}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Тип: {{result.left.type}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Email: {{result.left.e_mail}}
															</div>
														</div>
													</div>
												</div>
											</div>
										</button>
										<div class="col-lg-2 col-md-2">

										</div>
										<button class="col-lg-5 col-md-5 btn primary-btn primary"
												v-if="result.rigth.userName" class="col-lg-5 col-md-5 btn primary-btn primary" data-toggle="modal" v-on:click="getUserData(result.rigth)" data-target="#viewProfileMessage">
											<div class="row">
												<img :src="'../img/userImg/'+[result.rigth.avatar]" alt=""
														class="col-lg-3 col-md-3 align-items-center justify-content-between d-flex"
														style="height:90px;">
												<div class="col-lg-9 col-md-9 align-items-center justify-content-between d-flex" >
													<div class="content">
														<div class="row">
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Потребителско име: {{result.rigth.userName}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Име: {{result.rigth.name}} {{result.rigth.family}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Тип: {{result.rigth.type}}
															</div>
															<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
																Email: {{result.rigth.e_mail}}
															</div>
														</div>
													</div>
												</div>
											</div>
										</button>
									</div>
									<?php include('viewProfileMessage.php');?>
									<br>
								</div>
							</div>

							<div v-else>
								<h4>Няма намерени резултати за потребители</h4>
							</div>
						</div>

						<div class="tab-pane active" id="test" >
							<div v-if="resultSearchTests.length>0">
								Търсене на тестове:<br><br>
									<div class="row">
										 <div class=" col-lg-5 col-md-5"  >
											 <div class="form-group row">
												 <label class="col-lg-5 col-md-5 control-label profilLabels">Търсене по име:</label>
												 <div class="col-lg-7 col-md-7">
													 <input type="text" class="form-control"  v-model="searchTestTittle" value="" class="form-control" placeholder="Име на теста">
												 </div>
											 </div>
											 <div class="form-group row">
											 	<label class="col-lg-5 col-md-5 control-label profilLabels">Дата от/до:</label>
												<div class="col-lg-7 col-md-7">
													<div class="form-group row">
														<div class="col-lg-6 col-md-6">
															<input type="date" class="form-control" v-model="dateTestFrom" class="form-control">
														</div>
														<div class="col-lg-6 col-md-6">
															<input type="date" class="form-control" v-model="dateTestTo" class="form-control">
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
														 <select class="col-lg-11 col-md-11"v-model="selected">
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
												<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="searchSolution()">Търсене</button>
												<div class="col-lg-2 col-md-2">
												</div>
												<button type="button" class="col-lg-3 col-md-3 btn primary-btn" v-on:click="cancelTest()">Анолиране</button>
											</div>
									 </div>
								</div>
								<h4>Тестове</h4>
								<div  v-for="result in resultSearchTests">
									<div class="row">
										<button class="col-lg-5 col-md-5 btn primary-btn primary" v-on:click="goTest(result, 'left')">
											<div class="row">
												<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
													Име на теста: {{result.left.test_name}}
												</div>
												<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
													Качен от: {{result.left.user}}
												</div>
											</div>
										</button>

										<div class="col-lg-2 col-md-2">

										</div>

											<button class="col-lg-5 col-md-5 btn primary-btn primary" v-on:click="goTest(result, 'rigth')"
												v-if="result.rigth.test_name">
												<div class="row">
													<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
														Име на теста: {{result.rigth.test_name}}
													</div>
													<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
														Качена от: {{result.rigth.user}}
													</div>
												</div>
										</button>
									</div>
									<br>
								</div>
							</div>
							<div v-else>
								<h4>Няма намерени резултати за задачи</h4>
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
			include('jsForPages/searchPageJS.js');
		?>
	</body>
</html>
