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
			<h2 style="width: auto;">Şagirdlərin Qeydiyyati</h2>
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
				<div class="row">
					<div class="col-md-8">
						<h3 style="text-align: center">Şagirdlərin Qeydiyyatı</h3>
						<?php if(isset($_GET['errName'])):?>
							<div class="alert alert-danger p-2">
								<ul class="m-auto">
									<?php echo $_GET['errName']; ?>
								</ul>
							</div>
						<?php endif;?>
						<form id="form1" method="post" action="back.php">
							<div id="fennElave">
								<div class="md-form">
									<input type="text" name="name" class="form-control" id="adSoyad" onfocus="lfocus(this.id, this.id+'label');" onblur="lblur(this.id, this.id+'label');" required autocomplete="off">
									<label for="adSoyad" id="adSoyadlabel">Ad/Soyad/Ata adı:</label>
								</div>
								<div class="md-form">
									<input type="text" class="form-control" onfocus="lfocus(this.id, this.id+'label');" onblur="lblur(this.id, this.id+'label');" required name="fenn1" id="fenn1" onkeyup="yukle(this.id,'tm'+this.id);" autocomplete="off">
									<label for="fenn1" id="fenn1label">Fənn 1</label>
									<div class="tamamlayici" id="tmfenn1" onclick="beraber('fenn1',this);"></div>
								</div>
							</div>

							<button style="margin-top: 20px;" type="submit" class="btn btn-primary ml-auto" id="submit">Qeydiyyat</button>			
						</form>
						
					</div>
					<div class="col-md-3 ml-auto mt-5">
						<div class="alert alert-warning p-2" style="border-radius: 5px; text-align: center;">
							<h6 style="text-align: center;">QEYD: Ad/Soyad/Ata adı hamısı doldurulmaldı misal: Azər Əliyev Mirzə</h6>
						</div>
						<div class="mt-auto">
							<button id="add" class="btn btn-primary">Fənn Əlavə Et</button>
						</div>
					</div>
					<input type="hidden" id="gizliFenn">
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/js/mdb.min.js"></script>
		<script type="text/javascript">

			function lfocus(id, labelId)
			{
				document.getElementById(labelId).classList.add('labelDesign');
				document.getElementById(id).classList.add('benovse');
			}
			function lblur(id, labelId)
			{
				if(document.getElementById(id).value == ""){
					document.getElementById(labelId).classList.remove('labelDesign');
				}
				document.getElementById(id).classList.remove('benovse');
			}
			$(document).ready(function()
			{	
				$("#add").on("click", function(){
					var count = $("input").length - 1;
					var text = '<div class="md-form">'+ '<input type="text" class="form-control" onfocus="lfocus(this.id, this.id+\'label\');" onkeyup="yukle(this.id,\'tm\'+this.id);" onblur="lblur(this.id, this.id+\'label\');" required name="fenn'+count+'" id="fenn'+count+'" autocomplete="off"><label for="fenn'+count+'" id="fenn'+count+'label">Fənn '+count+'</label><div class="tamamlayici" id="tmfenn'+count+'" onclick="beraber(\'fenn'+count+'\',this);"></div></div>';
					$("#fennElave").append(text);
				});
			});
			function yukle(id, tm_id) 
			{

				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						axtar(this.response, id, tm_id);
					}
				};
				xhttp.open("GET", "fenn.json", true);
				xhttp.send();
			}
			function axtar(data, id, tm_id)
			{
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
					$(document).ready(function(){
						$("#"+tm_id).show();
					});
				 	document.getElementById(tm_id).innerHTML = data2['fenn'][c];	
				}
			}
			function on_blur(id)
			{
				$(document).ready(function(){
					$("#"+id).hide();
				});
			}
			function beraber(id,element)
			{
				document.getElementById(id).value = element.innerHTML;
				element.style.display = "none";
			}
			
			window.onclick = function(event) 
			{
				var tooltip = document.querySelectorAll('.tamamlayici');
			  	for (var v = 0; v < tooltip.length; v++) {
			  		if (event.target != tooltip[v]) {
				    	tooltip[v].style.display = "none";
				  	}
			  	}
			}
			
		</script>
	</body>
</html>