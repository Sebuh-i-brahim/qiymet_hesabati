<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Qiymet Hesablanmasi</title>
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
			<div class="formQeyd <?php ?>">	
				<div class="row">
					<div class="col-md-8">
						<h3 style="text-align: center">Şagirdlərin Qeydiyyatı</h3>
						<ul>
							<?php
								if ($_REQUEST !== null) {
									if(isset($_GET['errName'])){
										echo $_GET['errName'];
									}
								}

							?>
						</ul>
						<form id="form1" method="post" action="back.php">
							<div id="fennElave">
								<div class="md-form">
									<input type="text" name="name" class="form-control" id="adSoyad" onfocus="lfocus(this.id, this.id+'label');" onblur="lblur(this.id, this.id+'label');" required>
									<label for="adSoyad" id="adSoyadlabel">Ad/Soyad/Ata adı:</label>
								</div>
								<div class="md-form">
									<input type="text" class="form-control" onfocus="lfocus(this.id, this.id+'label');" onblur="lblur(this.id, this.id+'label');" required name="fenn1" id="fenn1" onkeyup="yukle(this.id);">
									<label for="fenn1" id="fenn1label">Fənn 1</label>
								</div>
							</div>
						<button type="submit" class="btn btn-primary ml-auto" id="submit">Qeydiyyat</button>			
						</form>
						
					</div>
					<div class="col-md-3 ml-auto mt-auto">
						<button id="add" class="btn btn-primary">Fənn Əlavə Et</button>
					</div>
					<input type="hidden" id="gizliFenn">
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
		<script type="text/javascript">
			function lfocus(id, labelId){
				document.getElementById(labelId).classList.add('labelDesign');
				document.getElementById(id).classList.add('benovse');
			}
			function lblur(id, labelId){
				if(document.getElementById(id).value == ""){
					document.getElementById(labelId).classList.remove('labelDesign');
				}
				document.getElementById(id).classList.remove('benovse');
			}
			$(document).ready(function(){	
				$("#add").on("click", function(){
					var count = $("input").length - 1;
					var text = '<div class="md-form">'+ '<input type="text" class="form-control" onfocus="lfocus(this.id, this.id+\'label\');" onkeyup="yukle(this.id);" onblur="lblur(this.id, this.id+\'label\');" required name="fenn'+ count + '" id="fenn'+count+'"><label for="fenn'+count+'" id="fenn'+count+'label">Fənn '+count+'</label></div>';
					$("#fennElave").append(text)
				});

			});
			function yukle(id) {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						axtar(this.response, id);
					}
				};
				xhttp.open("GET", "fenn.json", true);
				xhttp.send();
			}
			function axtar(data, id){
				data2 = JSON.parse(data);
				var valu = document.getElementById(id).value.toLowerCase();
				var a = 0;
				var b = [];
				var c;
				for(; a < data2['fenn'].length; a++){
					if(data2['fenn'][a].toLowerCase().indexOf(valu)>-1){
						b.push(valu);
						c = a; 
					}
				}
				if(b.length == 1){
				 	document.getElementById(id).value = data2['fenn'][c];	
				}
			}
		</script>
	</body>
</html>