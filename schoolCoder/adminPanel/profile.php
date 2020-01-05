<!DOCTYPE html>
<?php
	include('../server.php');
	include('../adminPanel/adminServer.php');
 ?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>

</head>
<body>
	<?php
			include('../headers/adminHeader.php');
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
					</div>
				</div>
			</div>
		</section>
	<!-- End banner Area -->



	<?php include("../commonResources/profilePage.php") ?>



	<?php
		include('../footer.php');
		//include('admin.js');
	 	include('../scripts.php');
	?>
</body>
</html>
