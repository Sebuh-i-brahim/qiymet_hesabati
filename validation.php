<?php


class Validate
{	
	static public function all($request)
	{
		$name = self::name($request);
		$data = self::fenn($request);
		$data[0] = $name;
		return $data;
	}
	static public function name($request)
	{
		$error = "";
		$fullad = htmlspecialchars($request['name']);
		$full = explode(" ", $fullad);
		$ad = $full[0];
		$soyad = $full[1];
		$ataAdi = $full[2];
		if (strlen($ad) > 2 && strlen($soyad) >2 && strlen($ataAdi)>2) {
			include_once "database.php";

			$db = new db();

			$var = db::yoxlama($fullad);

			if ($var == true) {
				return $fullad;
			}else{
				$error = "<li>Bu addan istifade olunub</li>";
				header("Location: index.php?errName=".$error);
				exit();
			}

		}
		else {
			if(strlen($ad)<3){
				$error= "<li>Ad minimum 3 hərfdən ibarət ola bilər</li>";
			}
			if(strlen($soyad)<3){
				$error.= "<li>Soyad minimum 3 hərfdən ibarət ola bilər</li>";
			}
			if(strlen($ataAdi)<3){
				$error.= "<li>Ata adi minimum 3 hərfdən ibarət ola bilər</li>";
			}
			header("Location: index.php?errName=".$error);
			exit();
		}
	}
	static public function fenn($request)
	{
		$json = file_get_contents("fenn.json");
		$json = json_decode($json);
		$FENN = $json->fenn;
		$errorfn = "";
		$fullfenn = [];
		$data = [];
		$say=[];
		for ($i=1; $i < count($request); $i++) {
			$data[$i]=""; 
			$fullfenn[$i] = htmlspecialchars($request["fenn".$i]);
			for ($a=0; $a < count($FENN); $a++) { 
				if ($fullfenn[$i] == $FENN[$a]) {
					$data[$i] = $FENN[$a];
				}
			}
			if ($data[$i] == "") {
				$errorfn .= "<li>Fənn ".$i." düzgün doldurulmayıb</li>";
			}
			for ($j=1; $j < count($request); $j++) { 
				if ($request["fenn".$i] == $request["fenn".$j]) {
					$say[$i.$j] = "+";	
				}
			}
		}
		if (count($say) != count($request)-1) {
			$errorfn.="<li>Eyni fənni yalniz bir dəfə daxil etmək olar</li>";
		}
		if ($errorfn != "") {
			header("Location: index.php?errName=".$errorfn);
			exit();
		}
		return $data;
	}
	static public function qiymet($request)
	{	
		$i=0;
		$data['id']=[];
		$data['qiymet']=[];
		foreach ($request as $key => $value) {
			$error="";

			

			if(count($request)>2){
				if($key != "_method"){
					
					$data['id'][$i] = $key;

					if(empty($value) or $value >=2 or $value <= 5 && is_int($value) === true){
						$data['qiymet'][$i] = $value;
					}
					else{
						$error = "Qiymət bos vəya 2 - 5 arasi ve tam ədəd ola bilər";
					}
				}
			}else{
				if($key != "_method"){
					$qiymet->qiymet_id = $key;
					
					if($value==0 or $value >=2 or $value <= 5 && is_int($value) === true){
						$qiymet->qiymet_val = $value;
					}
					else{
						$error = "Qiymət bos vəya 2 - 5 arasi ve tam ədəd ola bilər";
					}
				}
			}
			if ($error != "") {
				header("Location: qiymet.php?errName=".$error);
				exit();
			}

		}

		return $request;
	}
}

?>