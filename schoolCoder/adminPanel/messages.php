<!DOCTYPE html>
<?php
include('../server.php');

 include("adminServer.php");?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
</head>
	<body>
		<!-- start banner Area -->
		<?php  include('../headers/adminHeader.php') ?>

		<section class="col-md-12 col-md-12 banner-area relative about-banner" id="home">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Нови съобщения в системата
							</h1>
							<a href="#"> Съобщения</a>
						</div>
					</div>
				</div>
			</section>
		<!-- End banner Area -->

		<section class="feature-area section-gap">
			<div class="container" id="AllMessages">
        <div id="result">

        </div>
      	<div class="" v-for="message in messages">
					<div class="row">
						<form  class="col-lg-5 col-md-5 btn primary-btn primary" v-on:click="changeMessage(message.left)"
						  data-toggle="modal" data-target="#message">
							<div class="row">
								<div class="col-lg-10 col-md-10">
									<div class="row">
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Потребителско име: {{message.left.senderUserName}}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											До: {{ message.left.acceptUserName }}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Последно съобщение: {{ message.left.lastMessage }}
										</div>
									</div>
								</div>

								<div class="col-lg-1 col-md-1">

								</div>

								<div class="col-lg-1 col-md-1">
									<a name='delete_mesagess'>X</a>
								</div>

							</div>
							<div class='align-items-center justify-content-between d-flex'>
							 	{{message.left.date}}
							</div>
						</form>

						<div class="col-lg-2 col-md-2">
					  </div>

						<form v-on:click="changeMessage(message.rigth)" class="col-lg-5 col-md-5 btn primary-btn primary"
						  data-toggle="modal" data-target="#message" v-if="message.rigth.senderUserName">
							<div class="row">
								<div class="col-lg-10 col-md-10">
									<div class="row">
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Потребителско име: {{message.rigth.senderUserName}}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											До: {{ message.rigth.acceptUserName }}
										</div>
										<div class="col-lg-12 col-md-12 align-items-center justify-content-between d-flex">
											Последно съобщение: {{ message.rigth.lastMessage }}
										</div>
									</div>
								</div>

								<div class="col-lg-1 col-md-1">

								</div>

								<div class="col-lg-1 col-md-1">
									<a name='delete_mesagess'>X</a>
								</div>

							</div>
							<div class='align-items-center justify-content-between d-flex'>
							 	{{message.left.date}}
							</div>
						</form>
					</div>
					<br>
				</div>

				<?php include('message.php'); ?>

			</div>
		</section>
		<!-- End feature Area -->
		<?php
			include('../footer.php');
			include('../scripts.php');
			include('admin.js');
			include('adminJS/messagesPageJS.js');

		?>
	</body>
</html>
