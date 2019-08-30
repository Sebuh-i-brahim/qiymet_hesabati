<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

$fennJ = file_get_contents("fenn.json");

if(empty($_SESSION['sagird'])){
	header("Location: back.php?page=four");
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
			<h2 style="width: auto;">Jurnal</h2>
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
				<h3 style="text-align: center">Siyahi</h3>
				<?php
					if(isset($_REQUEST['errName'])){
						echo "<ul><li>".$_REQUEST['errName']."</li></ul>";
					}
					if(isset($_SESSION['all']) && empty($_SESSION['all']))
					{
						echo "<ul><li>Axtarışa uyğun neticə tapılmadı</li></ul>";
					}
				?>
				<form action="back.php" method="get">
				<div class="row" style="width: 100% !important;">
					
						<div class="col-md">
							<div class="m-3">
								<select class="custom-select" id="Sec" name="sagirdler[]" multiple>
									<option value="" disabled selected>Şagird Seç</option>
									<?php
										foreach ($_SESSION['sagird'] as $sagird) {
											echo "<option value='".$sagird['user_id']."'>".$sagird['name']."</option>";
										}
									?>
								</select>
								
							</div>
						</div>
						
						<div class="col-md">
							<div class="m-3">
								<select class="custom-select" name="fenns[]" multiple id="fenns">
									<option value="" disabled selected>Fənn Seç</option>
									<?php 

									?>
									
								</select>
							</div>
						</div>
						<div class="col-md">
							<div class="m-3">
								<input type="date" name="tarix1" value="">
								<input type="date" name="tarix2" value="">
							</div>
						</div>
						<div class="col-md"><button type="submit" class="btn btn-primary sol">Axtar</button></div>
					
				</div>
				</form>
				<?php
				if (isset($_SESSION['all']) && !empty($_SESSION['all'])) {
					echo "<ul><li><h4>Netice Asagidadi</h4></li></ul>";
				}

				?>
				<div>
					<table class="table">
						<tbody>
							<?php
								if (isset($_SESSION['all'])) {
										$tbl = "<tr><th>Sagird</th>";
										for($c=0; $c < count($_SESSION['all']);$c++){
											if(is_array($_SESSION['all'][$c]['create_date'])){
												for ($e=0; $e < $_SESSION['all'][$c]['create_date']; $e++) { 
													$tbl .= "<th>".$_SESSION['all'][$c]['create_date']['$e']."</th>";
												}
											}
											else{
												$tbl .= "<th>".$_SESSION['all'][$c]['create_date']."</th>";
											}
							
										}
								
									$tbl .= "</tr>";
								// 	$tbl .= "<tr><td>".$_SESSION['all'][0]['name']."</td>";
								// 	for($d=0; $d < count($_SESSION['all']);$d++){
								// 			$tbl .="";
								// 	}
								// $tbl .= "</tr>";
									echo $tbl;
								}
					
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
<script type="text/javascript">
	if(document.getElementById('Sec').value == ""){
			var ason = '<?php echo $fennJ;?>';
			
			var json = JSON.parse(ason);
			
			var i =0;
	    	for(;i<json.fenn.length;i++){
	    		document.getElementById('fenns').innerHTML += "<option value='"+json.fenn[i]+"'>"+json.fenn[i]+"</option>";
	    	}
	    	
		}

	document.getElementById('Sec').addEventListener('change', function(){
		if (this.value === null) {
			var ason = '<?php echo $fennJ;?>';
			
			var json = JSON.parse(ason);
			
			var i =0;
	    	for(;i<json.fenn.length;i++){
	    		document.getElementById('fenns').innerHTML += "<option value='"+json.fenn[i]+"'>"+json.fenn[i]+"</option>";
	    	}
		}
		val = abc();
		val2 = JSON.stringify(val);

		
		
		var sel, del, zel = [], y,i, gel = [];
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	del = JSON.parse(this.response);
		    	i=0;
		    	y=0;
		    	if(val.length > 1){
		    		
		    		for(;i<del.length; i++){
			    		zel.push(del[i]['fenn_id']);
		    		}
		    		gel = find_duplicate_in_array(zel);
		    		for(;y<gel.length;y++){
		    			sel += "<option value='"+gel[y]+"'>"+gel[y]+"</option>";
		    		}
		    	}
		    	else{
		    		for(;i<del.length; i++){
		    			sel += "<option value='"+del[i]['fenn_id']+"'>"+del[i]['fenn_id']+"</option>";
		    		}
		    	}
		    	
		    	document.getElementById('fenns').innerHTML = sel;		    	
		    }
		};
		xhttp.open("GET", "back.php?ajax="+val2, true);
		xhttp.send();
	});
	function abc() {
	    var select1 = document.getElementById("Sec");
	    var selected1 = [];
	    for (var i = 0; i < select1.length; i++) {
	        if (select1.options[i].selected){
	        	selected1.push(select1.options[i].value);
	        }
	        
	    }
	    return selected1;
	}
	function find_duplicate_in_array(arra1) {
        var object = {};
        var result = [];

        arra1.forEach(function (item) {
          if(!object[item])
              object[item] = 0;
            object[item] += 1;
        })

        for (var prop in object) {
           if(object[prop] >= 2) {
               result.push(prop);
           }
        }

        return result;

    }
</script>

</body>
</html>
<?php
if (isset($_SESSION['all']) && !empty($_SESSION['all'])) {
	var_dump($_SESSION['all']);
}

if(isset($_SESSION['all']) ){
	session_destroy();
}
?>