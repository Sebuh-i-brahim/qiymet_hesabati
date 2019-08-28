
<?php

class YeniSQL 
{

	private $hostname = "localhost";

	private $username = "root";

	private $password = "";

	private $db = "qiymet";

	private $conn;

	private $create = "";


	function __construct()
	{

		$conn2 = new mysqli($this->hostname, $this->username, $this->password, $this->db);
		if ($conn2->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
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
		$conn->yarat($sql2, $last_id);
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
		$sql = "SELECT * FROM sagirdler WHERE name = ".$name;
		$conn = new YeniSQL();
		$netice = $conn->yoxla($sql);

		if ($netice === false){
			return true;
		}
		else{
			return false;
		}
	}
	static public function($request)
	{
		$sql = "SELECT * FROM qiymets WHERE fenn_id =".$request['fenn']." AND (create_date >".$request['tarix1']." AND create_date <".$request['tarix2'].")";

		$conn = new YeniSQL();
		return $conn->all($sql);
	}
}



?>