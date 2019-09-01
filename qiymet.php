<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['sagird'])){
	header("Location: back.php?page=qiymet");
	exit();
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
		table {
	    table-layout: fixed !important;
	    border: 1px solid;
		}

		tbody {
		    display: block !important;
		    overflow: auto;
		}

		tr,td{
			border: 1px solid;
			text-align: center;
		}
		th,tr{
			min-width: 150px;
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
				
				<?php

					if(isset($_REQUEST['errName'])){
						echo "<ul><li>".$_REQUEST['errName']."</li></ul>";
					}

				?>
				<div class="row">
					<div class="col-md-3 mr-auto">
						<div class="m-3">
							<form action="back.php" method="get" id="sagirdForm">
								<div class="form-group">
									<label for="sagirdSec">Şagird</label>
									<select class="form-control" id="sagirdSec" name="sagird">
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
								</div>
							</form>
						</div>
					</div>
					<form action="back.php" method="get" class="col-md-9">
						<div class="form-row">
							<div class="col-md-3 ml-auto mr-auto">
								<div class="mt-3 form-group">
									<label for="fennSec">Fənn</label>
									<select name="fenn" class="form-control" id="fennSec">
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
							<div class="col-md-3 ml-auto mr-auto">
								<div class="form-group mt-3">
									<label for="tarix1">Başlanğıc Tarix</label>
									<input type="date" name="tarix1" value="" multiple id="tarix1" class="form-control">
								</div>
							</div>
							<div class="col-md-3 ml-auto">
								<div class="form-group mt-3">
									<label for="tarix2">Bitmə Tarixi</label>
									<input type="date" name="tarix2" value="" id="tarix2" class="form-control">
								</div>
								<button type="submit" class="btn btn-primary sol">Axtar</button>
							</div>
							<div class="alert-warning p-2" style="border-radius: 5px; float: left;">
								<h6 style="text-align: center;">QEYD: Əgər aralıq intervalı boşdursa intervalı yaradır</h6>
							</div>
						</div>
					</form>
				</div>
				<form method='post' action='back.php' id='qiymet' class="<?php if(!isset($_SESSION['tarix'])){
					echo("gorunus");} if(isset($_SESSION['tarix']) && $_SESSION['tarix'] == ""){echo("gorunus");}?>">
					<button type='submit' class='btn btn-primary btn-sm sag'>Qeyd Elə</button>
					<input type='hidden' name='_method' value='PUT'/>
				</form>
				<div>
				<?php if(isset($_SESSION['tarix']) && $_SESSION['tarix'] != ""):?>
					<table class="table table-primary table-striped table-hover">
						<tbody>
							<?php 
								$tbl = "<tr><th>Sagird</th><th>Fənn</th>";
								for($c=0; $c < count($_SESSION['table']);$c++){
									
									$tbl .= "<th>".date("m-d-Y", strtotime($_SESSION['table'][$c]['create_date']))."</th>";

								}
							
								$tbl .= "</tr>";
								$tbl .= "<tr><td>".$abc."</td><td>".$qala;

								for($d=0; $d < count($_SESSION['table']);$d++){
									$tbl .="<td><input class='form-control' style='text-align: right;' form='qiymet' type='number' name='".$_SESSION['table'][$d]['qiymet_id']."' value ='".$_SESSION['table'][$d]['qiymet']."'></td>";
								}
								$tbl .= "</tr>";
								echo $tbl;		
							?>
						</tbody>
					</table>
				<?php endif;?>
				</div>
			</div>	
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#sagirdSec").on('change', function(){
					$("#sagirdForm").submit();
				})
				$('#tarix1').val(new Date().toDateInputValue());
				$('#tarix2').val(new Date().toDateInputValue());
			});
			Date.prototype.toDateInputValue = (function() {
			    var local = new Date(this);
			    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
			    return local.toJSON().slice(0,10);
			});
		</script>
	</body>
</html>

<?php

if (isset($_SESSION['tarix'])) {
	$_SESSION['tarix'] = "";
}
?>
