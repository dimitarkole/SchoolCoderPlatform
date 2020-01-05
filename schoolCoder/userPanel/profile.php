<!DOCTYPE html>
<?php include('../server.php') ?>
<?php include('userServer.php') ?>
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
							Профил
						</h1>
						<a href="#"><?php echo  $_SESSION['userName']; ?></a>
					</div>
				</div>
			</div>
		</section>
	<!-- End banner Area -->
	<div id="profilPage">
		<?php include("../commonResources/profilePage.php") ?>

	</div>


	<!-- Start feature Area -->
	<?php
		include('../footer.php');
	 	include('../scripts.php');
		include('user.js');
		include("../headers/jsForHeader/userHearderJS.js");
		include("../commonResources/profilePageJS.js");

	?>
</body>
</html>
