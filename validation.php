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
				die();
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
			die();
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
		}
		if ($errorfn != "") {
			header("Location: index.php?errName=".$errorfn);
			die();
		}
		return $data;
	}
	public function qiymet()
	{
		
	}
}

?>