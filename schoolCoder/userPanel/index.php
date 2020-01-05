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
		<!-- start banner Area -->
		<section class="banner-area relative about-banner" id="home">
			<div class="overlay overlay-bg"></div>
			<div class="container">
				<div class="row d-flex align-items-center justify-content-center">
					<div class="about-content col-lg-12">
						<h1 class="text-white">
							Начало
						</h1>
						<a href="#">Начало</a>
					</div>
				</div>
			</div>
		</section>
		<!-- End banner Area -->

		<!-- Start feature Area -->
	  <section class="feature-area section-gap">

			<div class="container">
				<div class="row" id="tests">
					<div class="col-lg-5 col-md-5 jumbotron">
						<div class="row underlineGreen">
							<span class="col-lg-1 col-md-1"></span>
							<h4 class="col-lg-10 col-md-10">Последно добавени задачи</h4>
							<span class="col-lg-1 col-md-1"></span>
						</div>
						<br>
						<div v-for="result in lastAddedTests">
							<div class="row" >
								<span class="col-lg-1 col-md-1"></span>
								<button class="col-lg-10 col-md-10 btn primary-btn primary" v-on:click="goTest(result)">
									<div class="row">
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Име на теста: {{result.test_name}}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Качен от: {{result.user}}
										</div>
									</div>
								</button>
								<span class="col-lg-1 col-md-1"></span>
							</div>
							<br>
						</div>
					</div>
					<div class="col-lg-2 col-md-2">

					</div>
					<div class="col-lg-5 col-md-5	jumbotron">
						<div class="row underlineGreen">
							<span class="col-lg-1 col-md-1"></span>
							<h4 class="col-lg-10 col-md-10">Задачи от учители, приятели</h4>
							<span class="col-lg-1 col-md-1"></span>
						</div>
						<br>
						<div v-if="lastFriendAddedTests" v-for="result in lastFriendAddedTests">
							<div class="row" >
								<span class="col-lg-1 col-md-1"></span>
								<button class="col-lg-10 col-md-10 btn primary-btn primary" v-on:click="goTest(result)">
									<div class="row">
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Име на теста: {{result.test_name}}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Качен от: {{result.user}}
										</div>
									</div>
								</button>
								<span class="col-lg-1 col-md-1"></span>

							</div>
							<br>
						</div>

						<div v-if="lastFriendAddedTests==''">
							<div class="row" >
								<span class="col-lg-1 col-md-1"></span>

								<span class="col-lg-10 col-md-10">Няма добавени задачи от Вашите приятели!</span>
								<span class="col-lg-1 col-md-1"></span>

							</div>
						</div>

					</div>
				</div>
				</div>
			</div>
		</section>
		<!-- End feature Area -->
		<?php
			include('../footer.php');
		 	include('../scripts.php');
			include('user.js');
			include('jsForPages/indexPageJS.js');
		?>
	</body>
</html>
