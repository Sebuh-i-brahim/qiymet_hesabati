<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['sagird'])){
	header("Location: back.php?page=qiymet");
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
		table {
		    table-layout: fixed;
		}

		tbody {
		    display: block;
		    overflow: scroll;
		}
	</style>
	<body style="font-family: 'Nunito', sans-serif;">
		<div class="jumbotron" style="width: 100% !important; text-align: center;">
			<h2 style="width: auto;">Şagirdlərin Qiymətləndirilməsi</h2>
		</div>
		<div class="navbar bg-light ml-auto mr-auto" style="width: 60%">
			<div class="nav-item ml-auto mr-3">
				<a href="back.php?page=index">Qeydiyyat</a>
			</div>
			<div class="nav-item mr-3 ml-3">
				<a href="back.php?page=qiymet">Qiymetlendirme</a>
			</div>
			<div class="nav-item mr-auto ml-3 mr-auto">
				<a href="back.php?page=four">Jurnal</a>
			</div>
		</div>
		<div class="container">
			<div class="formQeyd">
				<h3 style="text-align: center">Qiymetlendirme</h3>
				<a href="back.php?geri=logout" class="btn btn-primary sag">Geri Qayit</a>
				<?php

					if(isset($_REQUEST['errName'])){
						echo "<ul><li>".$_REQUEST['errName']."</li></ul>";
					}

				?>
				<div class="row">
					<div class="col-md-3">
						<div class="m-3">
							<form action="back.php" method="get" id="sagirdForm">
								<select class="" id="sagirdSec" name="sagird">
									<option value="" disabled selected>Şagird Seç</option>
									<?php
										if (isset($_SESSION['sagird'])) {
											if (isset($_SESSION['sg_id'])) {
												$id = $_SESSION['sg_id'];
												foreach ($_SESSION['sagird'] as $sagird) {
													if ($sagird['user_id']==$id) {
														echo "<option value='".$sagird['user_id']."' selected>".$sagird['name']."</option>";
														$abc = $sagird['name']; $user_id = $sagird['user_id'];
													}
													else{
														echo "<option value='".$sagird['user_id']."'>".$sagird['name']."</option>";
													}
												}
											}
											else{
												foreach ($_SESSION['sagird'] as $sagird) {
													echo "<option value='".$sagird['user_id']."'>".$sagird['name']."</option>";
												}
											}
										}
									?>
								</select>
							</form>
						</div>
					</div>
					<form action="back.php" method="get">
						<div class="col-md-3">
							<div class="m-3">
								<select class="" name="fenn">
									<option value="" disabled selected>Fənn Seç</option>
									<?php
										$qala = "";
										if (isset($_SESSION['fenn'])) {
											if (isset($_SESSION['tarix']['fenn'])) {
												$id = $_SESSION['tarix']['fenn'];
												foreach ($_SESSION['fenn'] as $fenn) {
													if ($fenn['fenn_id']==$id) {
														echo "<option value='".$fenn['fenn_id']."' selected>".$fenn['fenn']."</option>";
														$qala = $fenn['fenn'];
													}
													else{
														echo "<option value='".$fenn['fenn_id']."'>".$fenn['fenn']."</option>";
													}
												}
											}else{
												foreach ($_SESSION['fenn'] as $fenn) {
													echo "<option value='".$fenn['fenn_id']."'>".$fenn['fenn']."</option>";
												}
											}
										}
									?>
									<input type="hidden" name="user_id" value="<?php echo($user_id);?>">
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="m-3">
								<input type="date" name="tarix1" value="">
								<input type="date" name="tarix2" value="">
							</div>
						</div>
						<button type="submit" class="btn btn-primary sol">Axtar</button>
					</form>

				</div>
				<form method='post' action='back.php' id='qiymet' class="<?php if(!isset($_SESSION['tarix'])){echo("gorunus");}?>">
					<button type='submit' class='btn btn-primary btn-sm sag'>Qeyd Elə</button>
					<input type='hidden' name='_method' value='PUT'/>
				</form>
				<div>
					
					<table class="table">
						<tbody>
							<?php

								if (isset($_SESSION['tarix'])) {
									$tbl = "<tr><th>Sagird</th><th>Fənn</th>";
									for($c=0; $c < count($_SESSION['table']);$c++){
										
										$tbl .= "<th>".$_SESSION['table'][$c]['create_date']."</th>";
	
									}
								
									$tbl .= "</tr>";
									$tbl .= "<tr><td>".$abc."</td><td>".$qala;

									for($d=0; $d < count($_SESSION['table']);$d++){
										$tbl .="<td><input form='qiymet' type='number' name='".$_SESSION['table'][$d]['qiymet_id']."' value ='".$_SESSION['table'][$d]['qiymet']."'></td>";
									}
									$tbl .= "</tr>";
									echo $tbl;	
								}
								
							?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#sagirdSec").on('change', function(){
					$("#sagirdForm").submit();
				})
			})
		</script>
	</body>
</html>
