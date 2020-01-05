<!DOCTYPE html>
<html lang="bg" class="">
<head>
	<?php include('head.php') ?>
	<script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script src="js/myJS/jquery-linenumbers.js"></script>
	<script>
		$('document').ready(function(){
			$("[id='line_numbers']").linenumbers({col_width:'10px'});
		});
	</script>
</head>
	<body>
		<section class="feature-area section-gap" id="solution">
			<div class="container">
				<div class="panel panel-success row" >
					<div class="panel-heading">
						Тестване на задача
					</div>
					<form method="post" class="panel-body col-lg-12 col-md-12">
						<div class="container">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<textarea name="line_numbers" id="line_numbers" rows="12" cols="60" style="width: 88%"></textarea>
									<br>
								</div>
							</div>
							<br>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<!--<div class="row">
										<div class="col-lg-6 col-md-6">
											Допустимо работно време:
										</div>
										<div class="col-lg-3 col-md-3">
												<input type="number" v-model="allowedWorkingTime" style="width: 100px">
										</div>
										<div class="col-lg-1 col-md-1">
											сек
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-6 col-md-6">
											Позволена памет:
										</div>
										<div class="col-lg-3 col-md-3">
												<input type="number" v-model="allowedMemory" style="width: 100px">
										</div>
										<div class="col-lg-1 col-md-1">
											 MB
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-6 col-md-6">
											Ограничение за размер:
										</div>
										<div class="col-lg-3 col-md-3">
											<input type="number" v-model="sizeLimit" style="width: 100px">
										</div>
										<div class="col-lg-1 col-md-1">
											 KB<br>
										</div>
									</div>-->

									</div>
									<div class="col-lg-4 col-md-4">
										<br>
										<select name="languageSelect" class="col-lg-12 col-md-12">
											<option :value="[language]" v-for="language in languages">{{language}}</option>
										</select>
									</div>
									<div class="col-lg-3 col-md-3">
										<button type="submit" class="btn primary-btn primary mt-20"  onclick="return exsecuteFile()">Изпрати решение</button>
									</div>
							</div>

							<br>

							<div class="row">
								<div class="col-lg-12 col-md-12">
									 <h4>Пробни тестове</h4>
									 <table class="table table-striped">
		                 <thead>
		                   <tr>
		                     <th>№</th>
		                     <th>Примерен вход</th>
		                     <th>Примерен изход</th>
												 <th>Премахни теста</th>
		                   </tr>
		                 </thead>
										 <tbody>
											 <tr v-for="test in tests">
												 <td>{{test.count}}</td>
		  									 <td><textarea :name="'input'+[test.count]" rows="3" cols="25" v-model="test.input"></textarea></td>
												 <td><textarea :name="'output'+[test.count]" rows="3" cols="25" v-model="test.output"></textarea></td>
												 <td><button type="button" v-on:click="removeTest(test)">Премахни този тест</button></td>
											 </tr>
		                 </tbody>
										 <tfoot>
											<tr>
												<td	colspan="4">
													 <button type="button" class="col-lg-12 col-md-12 btn primary-btn" data-toggle="modal" v-on:click="newTest()">Добвавяне на нов тест</button>
												 </td>
											 </tr>
										 </tfoot>
		               </table>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
 		</section>

		<!-- End feature Area -->
		<?php
		  include('scripts.php');
    	include('js/myJS/solutionPageJS.js');
		?>

		<script type="text/javascript">
		/*	var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36251023-1']);
			_gaq.push(['_setDomainName', 'jqueryscript.net']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();*/

		</script>
	</body>


</html>
