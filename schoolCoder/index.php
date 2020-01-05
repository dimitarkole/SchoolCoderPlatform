<!DOCTYPE html>
<html lang="bg" class="">
<head>
	<?php
		include('head.php');
	 	include('headers/gostHeader.php');
	 	include('gostJS.js');
	?>
</head>
	<body>
		<!-- start <b></b>anner Area -->
		<section class="banner-area relative" id="home">
			<div class="overlay overlay-bg"></div>
			<div class="container">
				<div class="row fullscreen d-flex justify-content-center align-items-center">
					<div class="banner-content col-lg-12 col-md-12 justify-content-center">
						<h6 class="text-uppercase">School Coder</h6>
						<h1>
							Програмирай, като се състезаваш с връсници!
						</h1>
						<p class="text-white mx-auto">
							За да можеш да решаваш задачи по информатика, решавай задачи!
						</p>
					</div>
				</div>
			</div>
		</section>
		<!-- End banner Area -->

		<!-- Start open-hour Area -->
		<section class="open-hour-area">
			<div class="container">
				<div class="row justify-content-center d-flex align-items-center">
					<div class="open-hour-wrap">
						<div class="row  justify-content-end">
							<div class="col-lg-5 col-md-5 single-team">
								<div class="thumb">
									<form>
										<h2>Вход<br></h2>
										<div id="messageForLogin"></div>
										<div class="row">
												<div class="col-lg-11 d-flex flex-column">
														<input type="text" id="login_userName" class="form-control mt-20" required="" onblur="this.placeholder = 'Потребителско име'"   placeholder="Потребителско име">
												</div>
												<div class="col-lg-11 d-flex flex-column">
													<input type="password" id="login_password" placeholder="Парола"  onblur="this.placeholder = 'Парола'" class="form-control mt-20">
												</div>
												<div class="col-lg-11 d-flex justify-content-end send-btn">
													<div class="row">
														<div class="col-lg-7 d-flex justify-content-end send-btn">
															<a class="forgottenPassword">Забравена парола</a>
														</div>

														<div class="col-lg-2 d-flex justify-content-end send-btn">
														</div>

														<div class="col-lg-3 d-flex justify-content-end send-btn">
															<input type="submit" class="btn primary-btn primary mt-20 text-uppercase" id="login_user" value="Влез" onclick="return loginPerson()">
														</div>
													</div>
												</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-lg-6 no-padding appoinment-right">
								<h2>Нямаш регистрация!<br></h2>
			  				<form>
									<div id="messageForRegistration"></div>
									<div class="row">
											<div class="col-lg-11 d-flex flex-column">
												<input type="text" id="userName" name="userName"  class="form-control mt-20" onblur="this.placeholder = 'Потребителско име'"   placeholder="Потребителско име">
											</div>
											<div class="col-lg-11 d-flex flex-column">
												<input type="email" id="email"  placeholder="E-mail адрес"  onblur="this.placeholder = 'E-mail адрес'" class="form-control mt-20" required="">
											</div>
											<div class="col-lg-11 d-flex flex-column">
												<input type="password" id="password_1" placeholder="Парола" onblur="this.placeholder = 'Парола'" class="form-control mt-20" required="">
											</div>
											<div class="col-lg-11 d-flex flex-column">
												<input id="password_2" placeholder="Повтори парола"  onblur="this.placeholder = 'Повтори парола'" class="form-control mt-20" required="" type="password">
											</div>
											<div class="col-lg-11 d-flex justify-content-end send-btn">
												<input type="submit" id="registration_user" class="btn primary-btn primary mt-20 text-uppercase"  value="Регистрирай се!" onclick="return registrationPerson()">
											</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End open-hour Area -->

		<br>
		<!-- Start feature Area -->
		<section class="feature-area section-gap">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content pb-60 col-lg-8">
						<div class="title text-center">
							<h1 class="mb-10">Защо да използвате тази платформа</h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-rocket"></span>
							</div>
							<div class="details">
								<h4>24/7 Поддръжка</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-heart-pulse"></span>
							</div>
							<div class="details">
								<h4>Бърза проверка</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-chart-bars"></span>
							</div>
							<div class="details">
								<h4>Автоматично оценяване</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-paw"></span>
							</div>
							<div class="details">
								<h4>Развиване на умения</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-bug"></span>
							</div>
							<div class="details">
								<h4>Леснодостъпна</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="single-feature d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-users"></span>
							</div>
							<div class="details">
								<h4>Безплатна платформа</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End feature Area -->
		<!-- Start home-about Area -->
		<section class="home-about-area section-gap relative">
			<div class="container">
				<div class="row align-items-center justify-content-end">
					<div class="col-lg-6 no-padding home-about-right">
						<h1 class="text-white">
							Кой напрви тази платформа <br>
						</h1>
						<p style="color:rgb(255, 255, 255)">
						  Димитър Колев и Величка Илчева, ученици от ППМГ "Васил Левски" град Смолян 10 клас.
							Година на започване на платформата: 2018 година.
						</p>
						<div class="row no-gutters" style="color:rgb(255, 255, 255)">
							<div class="single-services col">
								<span class="lnr lnr-diamond"></span>
								<a href="#">
									<h4 class="text-white">Достъпно</h4>
								</a>
								<p>
									Платформата предлага<br> достъп от всички устройства.
								</p>
							</div>
							<div class="single-services col">
								<span class="lnr lnr-diamond"></span>
								<a href="#">
									<h4 class="text-white">Полезно</h4>
								</a>
								<p>
							    	Платформата предостявя<br> възможност за бърза провека на задачи.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End home-about Area -->
		<?php
		 include('footer.php');
		 include('scripts.php');
		?>
	</body>
</html>
