<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

$fennJ = file_get_contents("fenn.json");

if(empty($_SESSION['sagird'])){
	header("Location: back.php?page=four");
	exit();
}

if (isset($_SESSION['all'])) {
	$table = array_filter($_SESSION['all']);
	$tbltarix1 = array_column($table, "create_date");
	$tbltarix2 = array_unique($tbltarix1);
	$fenns1 = array_column($table, "fenn");
	$fenns2 = array_unique($fenns1);
	$tblqiymet = array_column($table, "qiymet");
	$tblname1 = array_column($table, "name");
	$tblname2 = array_unique($tblname1);
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
		th,td{
			min-width: 100px;
		}
		.sagirdTd{
			min-width: 200px;
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
				<?php if(isset($_GET['errName'])):?>
					<div class="alert alert-danger p-2">
						<ul class="m-auto">
							<?php echo $_GET['errName']; ?>
						</ul>
					</div>
				<?php endif;?>
				<?php if(isset($tblqiymet) && empty($tblqiymet)):?>
					<div class="alert alert-danger p-2">
						<ul class="m-auto">
							<?php echo "Axtarışa uyğun neticə tapılmadı"; ?>
						</ul>
					</div>
				<?php endif;?>
				<form action="back.php" method="get">
					<div class="row mt-3" style="width: 100% !important;">
						<div class="col-md">
							<select class="custom-select" id="Sec" name="sagirdler[]" multiple>
								<option value="" disabled selected>Şagird Seç</option>
								<?php
									foreach ($_SESSION['sagird'] as $sagird) {
										echo "<option value='".$sagird['user_id']."'>".$sagird['name']."</option>";
									}
								?>
							</select>
						</div>
						<div class="col-md">
							<div class="form-group">
								<select class="custom-select" name="fenns[]" multiple id="fenns">
									<option value="" disabled selected>Fənn Seç</option>
								</select>
							</div>
						</div>
						<div class="col-md">
							<div class="md-form mt-3">
									<input type="date" name="tarix1" value="" id="tarix1" class="form-control">
									<label for="tarix1">Başlanğıc Tarix</label>
							</div>
						</div>
						<div class="col-md">
							<div class="m-3 md-form">
								<input type="date" name="tarix2" value="" id="tarix2" class="form-control">
								<label for="tarix2">Bitmə tarixi</label>
							</div>
							<div class="ml-auto">
								<button type="submit" class="btn btn-primary sag">Axtar</button>
							</div>
						</div>					
					</div>
				</form>
				<div>
					<?php if (isset($tblqiymet) && !empty($tblqiymet)): ?>
						<table class="table table-bordered table-primary table-striped table-hover">
							<thead >
								<h3 style="text-align: center;">Jurnal</h3>
							</thead>
						  	<tbody style="width: 100%">
						  		<tr>
						      		<th>Şagirdlər</th>
					      			<?php for ($k=0; $k < count($table); $k++):  ?>
					      				<?php if(isset($tbltarix2[$k])): ?>

					      					<th colspan="<?php echo count($fenns2);?>"><?php echo date("m-d-Y", strtotime($tbltarix2[$k])); ?></th>

					      				<?php endif;?>
					      			<?php endfor;?>
					      			<th colspan="<?php echo count($fenns2);?>"><?php echo "ortalama";?></th>	
						    	</tr>
						    	<tr>
						    		<td></td>
						    		<?php for ($h=0; $h < (count($tbltarix2))*count($fenns2); $h++ ): ?>
						    			<td>

						    				<?php 

						    					 echo $fenns1[$h];

						    				?> 

						    			</td>
						    		<?php endfor;?>
						    		<?php foreach ($fenns2 as $ders): ?>	
										<td><?php echo $ders;?></td>
								<?php endforeach;?>
						    	</tr>
								<?php for ($m = 0; $m < count($table); $m++): ?>

									<?php if (isset($tblname2[$m])): ?>
								  		<tr>
								  			<td class="sagirdTd"><?php echo $tblname2[$m]; ?></td>

											<?php for ($t=0; $t < count($table); $t++): ?>
										    	<?php if ($tblname1[$t]==$tblname2[$m]): ?>
										      		<td><?php echo $tblqiymet[$t]; ?></td>
										      		
										   		<?php endif;?>
											<?php endfor; ?>
											<?php for($f=0; $f< count($fenns2);$f++):?>
												<?php  $cem = 0; for ($k=$f; $k < count($table); $k +=count($fenns2)): ?>
										    		<?php if ($tblname1[$k]==$tblname2[$m]): ?>
										      			
										      			<?php $cem += $tblqiymet[$k]; ?>
										 
										   			<?php endif;?>
												<?php endfor; ?>
												<td><?php echo $cem * count($fenns2)*count($tblname2)/count($tblqiymet); ?></td>
											<?php endfor; ?>
											
										</tr>

									<?php endif;?>

								<?php endfor;?>		
						  	</tbody>
						</table>
					<?php endif; ?>
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

	document.getElementById('Sec').addEventListener('change', function()
	{
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
		// arrayg = new Object();
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	var arrayg = JSON.parse(this.response);
		    	
		    	var key = Object.keys(arrayg);


		    	
		    	if (val.length > 1) {
		    		
		    		var don = '<option value="" disabled selected>Fənn Seç</option>';
		    		for(x in arrayg){
		    		
		    			if( Object.prototype.toString.call( arrayg[x] ) === '[object Array]' ) {				  	 
						  	if (arrayg[x].length == val.length) {
						  		don += "<option value ='"+arrayg[x]+"'>"+x+"</option>";
						  	}
						  	else{
						  		don +="";
						  	}
						}
		    			
		    		}
		    		document.getElementById('fenns').innerHTML = don;
		    	}
		    	else{
		    		var son;
		    		son ='<option value="" disabled selected>Fənn Seç</option>';
		    		for (var i = 0; i < key.length; i++) {
		    			son += "<option value='"+arrayg[key[i]]+"'>"+key[i]+"</option>";
		    		}
		    		//console.log("String val");
		    		document.getElementById('fenns').innerHTML = son;
		    	}
		    	
		    	
		    			    	
		    }
		};
		xhttp.open("GET", "back.php?ajax="+val2, true);
		xhttp.send();
	});
	function abc() 
	{
	    var select1 = document.getElementById("Sec");
	    var selected1 = [];
	    for (var i = 0; i < select1.length; i++) {
	        if (select1.options[i].selected){
	        	selected1.push(select1.options[i].value);
	        }
	        
	    }
	    return selected1;
	}
	function find_duplicate_in_array(arra1) 
	{
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

	Date.prototype.toDateInputValue = (function() 
	{
	    var local = new Date(this);
	    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
	    return local.toJSON().slice(0,10);
	});
	$(document).ready(function(){
		$('#tarix1').val(new Date().toDateInputValue());
		$('#tarix2').val(new Date().toDateInputValue());
	});
	    
</script>

</body>
</html>
<?php
if(isset($_SESSION['all']) ){
	session_destroy();
}
?>
