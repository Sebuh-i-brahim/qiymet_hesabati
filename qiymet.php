<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Qiymetlendirme</title>
	</head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css"/>
	<style type="text/css">
		.gorunus{
			display: none !important;
			-webkit-transition: all .5s ease;
		  	-moz-transition: all .5s ease;
			transition: all .5s ease;
		}
	</style>
	<body style="font-family: 'Nunito', sans-serif;">
		<div class="jumbotron" style="width: 100% !important; text-align: center;">
			<h2 style="width: auto;">Şagirdlərin Qiymətləndirilməsi</h2>
		</div>
		<div class="container">
			<div class="formQeyd">
				<h3 style="text-align: center">Qiymetlendirme</h3>
				<div class="row">
					<div class="col-md-4">
						<div class="m-3">
							<form action="back.php" method="get" id="sagirdForm">
								<select class="" id="sagirdSec" name="sagird">
									<option value="" disabled selected>Şagird Seç</option>
									<?php
										if (isset($_SESSION['sagird'])) {
											if (isset($_SESSION['sg_id'])) {
												$id = $_SESSION['sg_id'];
												foreach ($_SESSION['sagird'] as $sagird) {
													if ($sagird['id']==$id) {
														echo "<option value='".$sagird['id']."' selected>".$sagird['name']."</option>";
														$abc = $sagird['name'];
													}
													else{
														echo "<option value='".$sagird['id']."'>".$sagird['name']."</option>";
													}
												}
											}
											else{
												foreach ($_SESSION['sagird'] as $sagird) {
													echo "<option value='".$sagird['id']."'>".$sagird['name']."</option>";
												}
											}
										}
									?>
								</select>
							</form>
						</div>
					</div>
					<form action="back.php" method="get">
						<div class="col-md-4">
							<div class="m-3">
								<select class="" name="fenn">
									<option value="" disabled selected>Fənn Seç</option>
									<?php
										if (isset($_SESSION['fenn'])) {
											if (isset($_SESSION['tarix']['fenn'])) {
												$id = $_SESSION['tarix']['fenn'];
												foreach ($_SESSION['fenn'] as $fenn) {
													if ($fenn['id']==$id) {
														echo "<option value='".$fenn['id']."' selected>".$fenn['name']."</option>";
														$qala = $fenn['name'];
													}
													else{
														echo "<option value='".$fenn['id']."'>".$fenn['name']."</option>";
													}
												}
											}else{
												foreach ($_SESSION['fenn'] as $fenn) {
													echo "<option value='".$fenn['id']."'>".$fenn['fenn']."</option>";
												}
											}
										}
									?>

								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="m-3">
								<input type="date" name="tarix1">
								<input type="date" name="tarix2">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Axtar</button>
					</form>
				</div>
				<table class="table">
					<?php

						if (isset($_SESSION['tarix'])) {
							$tbl = "<tr><th>Sagird</th><th>Fənn</th>";
							$i = 0;
							$qiymet = [];
							$td_id = [];
							foreach ($_SESSION['table']['create_date'] as $vaxt) {
								$tbl .= "<th>".$vaxt."</th>";
							}
							foreach($_SESSION['table']['qiymet'] as $qiy){
								if($qiy === null){
									$qiymet[] = "";
								}else{
									$qiymet[] = $qiy;
								}
								$i++;
							}
							foreach($_SESSION['table']['id'] as $t_id){
								$td_id[] = $t_id;
							}
							$tbl .= "</tr>";
							$tbl .= "<tr><td>".$abc."</td><td>".$qala;
							for ($b=0; $b <= $i; $b++) { 
								$tbl .="<td><input name='".$td_id[$b]."' value ='".$qiymet[$b]."'></td>";
							}
							$tbl .= "</tr>";
						}

					?>
				</table>
			</div>	
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
				$("#sagirdSec").on('change', function(){
					$("#sagirdForm").submit();
				})
			})
		</script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
	</body>
</html>