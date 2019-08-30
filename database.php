
<?php

class YeniSQL 
{

	private $hostname = "localhost";

	private $username = "root";

	private $password = "";

	private $db = "menim_tablem";

	private $conn;

	function __construct()
	{

		$table1 = "CREATE TABLE sagirdler (
					user_id INT AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(100) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$table2 = "CREATE TABLE fenns (
					fenn_id INT AUTO_INCREMENT PRIMARY KEY,
					user_id INT,
					KEY fn_user_idx (user_id),
					CONSTRAINT fn_user FOREIGN KEY (user_id) 
 					REFERENCES sagirdler (user_id),
					fenn VARCHAR(100) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$table3 = "CREATE TABLE qiymets (
					qiymet_id INT AUTO_INCREMENT PRIMARY KEY,
					user_id INT,
					fenn_id INT,
					KEY qy_fenn_idx (fenn_id),
					KEY qy_user_idx (user_id),
					CONSTRAINT qy_fenn FOREIGN KEY (fenn_id) 
 					REFERENCES fenns (fenn_id),
 					CONSTRAINT qy_user FOREIGN KEY (user_id) 
 					REFERENCES sagirdler (user_id),
 					qiymet INT,
					create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$conn = new mysqli($this->hostname, $this->username, $this->password);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$yoxla = $conn->select_db ($this->db); 

		if ($yoxla !== true) {
			$conn->query("CREATE DATABASE ".$this->db);
		}
		$conn->close();

		$conn2 = new mysqli($this->hostname, $this->username, $this->password, $this->db);

		$net = $conn2->query("SHOW TABLES LIKE sagirdler");

		if($net == false){
			$conn2->query($table1);
			$conn2->query($table2);
			$conn2->query($table3);
		}
		$this->conn = $conn2;
	}

	public function last_id($sql)
	{
		if ($this->conn->query($sql) === TRUE) {
		  	$last_id = $this->conn->insert_id;
		} else {
		    die($this->conn->error);
		}
		return $last_id;
	}

	public function yarat($sql)
	{
		if ($this->conn->query($sql) === TRUE) {
		  
		} else {
		    die($this->conn->error);
		}
	}
	public function all($sql)
	{
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		$netice=[];
		$result = $this->conn->query($sql);
		
		for($i=0; $i < $result->num_rows; $i++){
			$netice[$i] = $result->fetch_assoc();
		}
		return $netice;	
	}
	public function yoxla($sql)
	{
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		
		$result = $this->conn->query($sql);
		
		return $result;
	}
	public function server()
	{
		$mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->db);
		if ($mysqli->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
		}
		return $mysqli;
	}
	
}


class db 
{

	static public function addFenn($data)
	{
		$sql = "INSERT INTO sagirdler (name) VALUES ('".$data[0]."')";

		$conn = new YeniSQL();
		$last_id = $conn->last_id($sql);

		$sql2 = "INSERT INTO fenns (user_id, fenn) VALUES ('";
		for($i = 1; $i < count($data); $i++){
			if($i == count($data)-1){
				$sql2 .= $last_id."', '".$data[$i]."')";
			}
			else{
				$sql2 .= $last_id."', '".$data[$i]."'),('";
			}
		}
		$conn->yarat($sql2);
	}


	static public function all()
	{
		$sql = "SELECT * FROM sagirdler";
		$conn = new YeniSQL();
		$data = $conn->all($sql);
	}

	static public function sagird()
	{
		$sql = "SELECT * FROM sagirdler";
		$conn = new YeniSQL();
		return $conn->all($sql);
	}

	static public function fenn($id)
	{
		$sql = "SELECT * FROM fenns WHERE user_id = ".$id;
		$conn = new YeniSQL();
		return $conn->all($sql);
	}
	static public function yoxlama($name)
	{
		$sql = "IF EXISTS (SELECT * FROM sagirdler WHERE name = ".$name.");";
		$conn = new YeniSQL();
		$netice = $conn->yoxla($sql);

		if ($netice == false){
			return true;
		}
		else{
			return false;
		}
	}
	
	static public function edit($request)
	{	

		$sql = "SELECT * FROM qiymets WHERE fenn_id = '".$request['fenn']."' AND create_date BETWEEN '".$request['tarix1']."' AND '".$request['tarix2']."';";

		$conn = new YeniSQL();
		
		$netice = $conn->yoxla($sql);
		
		if($netice->num_rows == o){
			self::qiymet($request);
		}

		
		
		return $conn->all($sql);
	}

	static public function update($data)
	{
		$conn = new YeniSQL();


		
		foreach ($data as $key => $value) {
			if($key!="_method"){
				if($value != ""){
					$conn->yarat("UPDATE qiymets SET qiymet ='".$value."' WHERE qiymet_id = '".$key."'");
				}
			}
		}
		
	}
	static public function qiymet($request)
	{
		$conn = new YeniSQL();

		$a = date($request['tarix1']);

		$b = date($request['tarix2']);
		$date1=date_create($a);
		$date2=date_create($b);
		$diff=date_diff($date1,$date2);
		$ferq = $diff->format("%a");
		
		if ($ferq > 60) {
			$error = "Intervalin muddeti 60 gunden cox ola bilmez";
			header("Location: qiymet.php? errName=".$error);
			die();
		}
		
		for ($i=1; $i < $ferq; $i++) { 
			$date = date("Y-m-d H:i:s", strtotime("+".$i." day", strtotime($a)));
			$sql = "INSERT INTO qiymets (user_id,fenn_id, create_date) VALUES ('".$request['user_id']."','".$request['fenn']."', '".$date."')";
			$conn->yarat($sql);
		}
	}
	static public function jurnal($request)
	{
	
		$sg ="";
		$fn ="";
		$a = date($request['tarix1']);

		$b = date($request['tarix2']);
		$date1=date_create($a);
		$date2=date_create($b);
		$diff=date_diff($date1,$date2);
		$ferq = $diff->format("%a");
		if ($ferq > 60) {
			$error = "Intervalin muddeti 60 gunden cox ola bilmez";
			header("Location: qiymet.php? errName=".$error);
			die();
		}
	
		if(empty($request['sagirdler'])){
			$sg = "";
		}
		if (empty($request['fenns'])) {
			$fn= "";
		}
		if(empty($request['tarix1'])){
			$error = "Tarix1 bos ola bilmez";
			header("Location: four.php? errName=".$error);
			die();
		}
		if (empty($request['tarix2'])) {
			$error = "Tarix2 bos ola bilmez";
			header("Location: four.php? errName=".$error);
			die();
		}

		$tr = "qiymets.create_date BETWEEN '".$request['tarix1']."' AND '".$request['tarix2']."'";
		if(isset($request['sagirdler']) && isset($request['fenns'])){
			if($request['sagirdler'] != "" && $request != ""){

				for($i=0; $i<count($request['sagirdler']);$i++){
					if ($i==0) {
						$sg.= "fenns.user_id = '".$request['sagirdler'][$i]."'";
					}
					else{
						$sg.= " OR fenns.user_id ='".$request['sagirdler'][$i]."'";
					}
				}

				for ($b=0; $b < count($request['fenns']); $b++) { 
					if ($b==0) {
						$fn.= "fenns.fenn = '".$request['fenns'][$b]."'";
					}
					else{
						$fn.= " OR fenns.fenn = '".$request['fenns'][$b]."'";
					}
				}
			}
		}
		if(isset($request['sagirdler[]']) && isset($request['fenns[]'])){
			if($request['sagirdler[]'] != "" && $request != ""){

				for($i=0; $i<count($request['sagirdler[]']);$i++){
					if ($i==0) {
						$sg.= "fenns.user_id = '".$request['sagirdler[]'][$i]."'";
					}
					else{
						$sg.= " OR fenns.user_id ='".$request['sagirdler[]'][$i]."'";
					}
				}

				for ($b=0; $b < count($request['fenns[]']); $b++) { 
					if ($b==0) {
						$fn.= "fenns.fenn = '".$request['fenns[]'][$b]."'";
					}
					else{
						$fn.= " OR fenns.fenn = '".$request['fenns[]'][$b]."'";
					}
				}
			}
		}
		if(isset($request['sagirdler[]']) && isset($request['fenns'])){
			if($request['sagirdler'] != "" && $request != ""){

				for($i=0; $i<count($request['sagirdler[]']);$i++){
					if ($i==0) {
						$sg.= "fenns.user_id = '".$request['sagirdler[]'][$i]."'";
					}
					else{
						$sg.= " OR fenns.user_id ='".$request['sagirdler[]'][$i]."'";
					}
				}

				for ($b=0; $b < count($request['fenns']); $b++) { 
					if ($b==0) {
						$fn.= "fenns.fenn = '".$request['fenns'][$b]."'";
					}
					else{
						$fn.= " OR fenns.fenn = '".$request['fenns'][$b]."'";
					}
				}
			}
		}
		if(isset($request['sagirdler']) && isset($request['fenns[]'])){
			if($request['sagirdler'] != "" && $request != ""){

				for($i=0; $i<count($request['sagirdler']);$i++){
					if ($i==0) {
						$sg.= "fenns.user_id = '".$request['sagirdler'][$i]."'";
					}
					else{
						$sg.= " OR fenns.user_id ='".$request['sagirdler'][$i]."'";
					}
				}

				for ($b=0; $b < count($request['fenns[]']); $b++) { 
					if ($b==0) {
						$fn.= "fenns.fenn = '".$request['fenns[]'][$b]."'";
					}
					else{
						$fn.= " OR fenns.fenn = '".$request['fenns[]'][$b]."'";
					}
				}
			}
		}
		if($sg != "" && $fn != ""){
			$sql = "SELECT *
			FROM sagirdler
			JOIN qiymets ON (qiymets.user_id = sagirdler.user_id)
			JOIN fenns ON (fenns.user_id = sagirdler.user_id)
			WHERE ".$sg." AND ".$fn." AND ".$tr;
		}if($sg == "" && $fn != ""){
			$sql = "SELECT *
			FROM sagirdler
			JOIN qiymets ON (qiymets.user_id = sagirdler.user_id)
			JOIN fenns ON (fenns.user_id = sagirdler.user_id)
			WHERE ".$fn." AND ".$tr;
		}if($sg != "" && $fn == ""){
			$sql = "SELECT *
			FROM sagirdler
			JOIN qiymets ON (qiymets.user_id = sagirdler.user_id)
			JOIN fenns ON (fenns.user_id = sagirdler.user_id)
			WHERE ".$sg." AND ".$tr;
		}if($sg == "" && $fn == ""){
			$sql = "SELECT *
			FROM sagirdler
			JOIN qiymets ON (qiymets.user_id = sagirdler.user_id)
			JOIN fenns ON (fenns.user_id = sagirdler.user_id)
			WHERE ".$tr;
		}
		


		$conn = new YeniSQL();

		$data = $conn->all($sql);

		return $data;
	} 

	static public function ajax($data)
	{	

		

		if (is_array($data)) {
			$sql = "SELECT fenn fenn_id FROM fenns WHERE user_id IN(";
			for ($i=0; $i < count($data); $i++) { 
				if($i == count($data) - 1){
					$sql .= "'".$data[$i]."')"; 
				}
				else{
					$sql .="'".$data[$i]."',";
				}
			}
		}else{
			$sql = "SELECT fenn fenn_id FROM fenns WHERE user_id = '".$data."'";
		}

		$conn = new YeniSQL();

		$data = $conn->all($sql);
		
		echo json_encode($data);
		

	}
}



?>