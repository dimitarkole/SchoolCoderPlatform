
<!DOCTYPE html>
<?php include('../server.php') ?>
<?php include("adminServer.php")?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>
</head>
	<body>
		<?php
			include('../headers/adminHeader.php');
			dataForIndex();
		?>
		<!-- Single button -->

		<!-- start banner Area -->
		<section class="banner-area relative about-banner" id="home">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Информация за платформа
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
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div id="userInSystem" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">

						</div>
					</div>
				</div> <br><br><br>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
								<div id="bestStudent" style="height: 370px; width: 100%;"></div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div id="worseStudent" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div id="bestTeacher" style="height: 370px; width: 100%;"></div>
						</div>
					</div>

					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div id="worseTeacher" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- End feature Area -->
		<?php
			include('../footer.php');
			include('admin.js');
			include('adminJS/indexPageJS.js');
		 	include('../scripts.php');
		?>
	</body>
</html>
