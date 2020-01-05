<!DOCTYPE html>
<?php
	include('../server.php');
  include('userServer.php');
?>
<html lang="bg" class="">
<head>
	<?php include('../head.php') ?>
	<script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script src="jsForPages/jquery-linenumbers.js"></script>
	<script>
		$('document').ready(function(){
			$("[id='line_numbers']").linenumbers({col_width:'10px'});
		});
	</script>
</head>
	<body>
		<?php
			include('../headers/userHearder.php');
		?>
		<!-- start banner Area -->
		<div id="solution">
			<section class="banner-area relative about-banner" id="home">
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								{{testTitle}}
							</h1>
							<a href="#">Изпит</a>
						</div>
					</div>
				</div>
			</section>
			<!-- End banner Area -->

			<!-- Start feature Area -->
			<section class="feature-area section-gap">
				<div class="container">
						<div class="panel panel-success row" >
							<div class="panel-heading">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li class="active">
										<a href="#hometab" role="tab" data-toggle="tab">Начало</a>
									</li>
									<li v-for="task in tasks">
										<a :href="'#'+[task.taskName]" role="tab" data-toggle="tab" v-on:click="changeTask(task)" >{{task.count+1}}.{{task.taskName}}</a>									</li>
								</ul>
							</div>
							<div class="panel-body col-lg-12 col-md-12">
								<div class="container">
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active" id="hometab">
											<h5 class="underlineGreen">Информация за теста:</h5> <br>
											<div class="row">
													<div class="col-lg-2 col-md-2">
														Брой задачи: <br>
													</div>
													<div class="col-lg-4 col-md-4">
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

													<div class="col-lg-4 col-md-4">
														Брой задачи: <br>
														Скала за оценяване: <br>
													</div>
											</div>
										</div>

										<div class="tab-pane" :id="[task.taskName]" v-for="task in tasks" >
											<div class="row">
												<div class="col-lg-12 col-md-12">
													<div class="row">
														<div class="col-lg-7 col-md-7 underlineGreen">
															<h5>Име на задачата: {{task.taskName}}</h5><br>
														</div>
														<div class="col-lg-5 col-md-5">
															Вашият най-добър резултат: {{task.bestSolution}} от 100 точки <br>
														</div>
													</div>
													<h6>Условие на задачата:</h6>
													<div class="panel-success">
														<div class="panel-heading">
															{{task.taskText}}
															<div class="row">
																<div class="col-lg-12 col-md-12" v-if="task.simpleTests!=''">
																	<br>
																	Примерни данни: <br>
																	<table class="table table-striped">
																		<thead>
																			<tr>
																				<th>№</th>
																				<th>Примерен вход</th>
																				<th>Примерен изход</th>
																				<th>Обяснение</th>
																			</tr>
																		</thead>
																	 <tbody>
																		 <tr v-for="test in task.simpleTests">
																			 <td>{{test.count}}</td>
																			 <td>{{test.input}}</td>
																			 <td>{{test.output}}</td>
																			 <td>{{test.explanation}}</td>
																		 </tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div><br>
												</div>
											</div>

											<form class="row" method="post">
												<div class="col-lg-8 col-md-8">
													<div class="row">
														<div class="col-lg-12 col-md-12">
															<textarea :name="[task.taskName]+'line_numbers'" :id="[task.taskName]+'line_numbers'" rows="12" cols="80" v-model="task.solution" style="width: 100%"></textarea>
															<br>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-lg-5 col-md-5">
															Допустимо работно време: {{task.allowedWorkingTime}} сек<br>
															Позволена памет: {{task.allowedMemory}} MB<br>
															Ограничение за размер: {{task.sizeLimit}} KB<br>
														</div>
														<div class="col-lg-4 col-md-4">
															<br>
															<select name="languageSelect" class="col-lg-12 col-md-12" onchange="changeSelectedLanguage()">
																<option :value="[language]" v-for="language in task.languages">{{language}}</option>
															</select>
														</div>
														<div class="col-lg-3 col-md-3">
															<button type="submit" class="btn primary-btn primary mt-20"  onclick="return exsecuteFile('addToDB','')">Изпрати решение</button>
														</div>
													</div>
												</div>

												<div class="col-lg-4 col-md-4">
													<table class="table table-striped">
														<thead>
															<tr>
																<th>№</th>
																<th>Име на задача</th>
															</tr>
														</thead>
													 <tbody>
														 <!--<tr v-for="task in tasks">
															 <td>
																 {{task.count}}
															 </td>
															 <td>{{task.taskName}}</td>
														 </tr>
													 -->
														</tbody>
													 <tfoot>
														 <tr>
															 <td colspan="2">
																 <div class="btn-toolbar" role="toolbar" aria-label="...">
																	 <div v-for="page in pages">
																		 <button  class="btn primary-btn" v-on:click="changePage(page)">{{page}}</button>
																			<pre>	</pre>
																	 </div>
																 </div>
															 </td>
														</tr>
													 </tfoot>
												 </table>
												</div>
											</form>


											<h5>Решения:</h5>
											<div class="row">
												<div class="col-lg-12 col-md-12">
													<table class="table table-striped">
														<thead>
															<tr>
																<th>№</th>
																<th>Точки</th>
																<th>Дата на тестване</th>
																<th>Език</th>
																<th>Детайли</th>
															</tr>
														</thead>
													 <tbody>
														 <tr v-for="solution in solutions.resultSolutions">
															 <td>
																 {{solution.count}}
															 </td>
															 <td>

																 <span  v-for="test in solution.resultWithTests">
																	 <img class="img-fluid" src="../img/correct.png" v-if="test=='correct'">
																	 <img class="img-fluid" src="../img/wrong.png" v-else-if="test=='wrong'">
																	 <img class="img-fluid" src="../img/crash.png" v-else-if="test=='crash'">
																	 <img class="img-fluid" src="../img/overtime.png" v-else="test=='overtime'">
																 </span>
																 <span>{{solution.points}}/100</span>

															 </td>
															 <td>{{solution.date}}</td>
															 <td>{{solution.language}}</td>
															 <td>
																 <button type="button" name="button" data-toggle="modal" data-target="#viewSolutionResultMessage" v-on:click="viewTaskSolution(solution)">Виж тук!</button>
															 </td>
														 </tr>
														</tbody>
													 <tfoot>
														 <td colspan="3">
															<div class="btn-toolbar" role="toolbar" aria-label="...">
																Страници: <pre>	</pre>
																<div v-for="page in solutions.pages">
																	<button  class="btn primary-btn" v-on:click="changePage(page)">{{page}}</button>
																	 <pre>	</pre>
																</div>
															</div>
														</td>
													 </tfoot>
												</table>
											</div>
										</div>
										<?php
											include('viewSolutionResultMessage.php');
										 ?>
								   </div>
									</div>
								</div>
							</div>
						</div>
					</div>

			</section>
		</div>

		<!-- End feature Area -->
		<?php
			include('../footer.php');
		  include('../scripts.php');
			include('user.js');
    	include('jsForPages/solutionPageJS.js');
		?>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36251023-1']);
			_gaq.push(['_setDomainName', 'jqueryscript.net']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

		</script>
	</body>


</html>
