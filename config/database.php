<?php
class Database{
	private  $host="localhost";
	private  $db="rest_api_products";
	private  $user="root";
	private  $psd="";

	public $conn;

	public function getConnection()
	{
		$this->conn=null;

		try {
			$this->conn=new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->user,$this->psd);
			$this->conn->exec("set names utf8");
		} catch (PDOException $e) {
			echo "Connection Error".$e->getMessage();
		}
		return $this->conn;
	}
}

?>