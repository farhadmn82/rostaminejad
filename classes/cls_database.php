<?php

class KW_DataBase
{
	static function Connect()
	{
		$con=mysqli_connect("localhost","rostamin_admin","farhadmn","rostamin_db");
		if (mysqli_connect_errno($con))
		  {  echo "Failed to connect to MySQL: " . mysqli_connect_error();  }
		mysqli_set_charset($con, "utf8"); 
		
		return $con	;
	}
	
	static function GetLastRecordID($table)
	{
		$con = self::Connect();
		$selq = "SELECT * FROM ".$table." ORDER BY ID DESC LIMIT 1";
		if($result = mysqli_query($con,$selq))
		{
			$row = mysqli_fetch_array($result);
			return $row['ID'];
		}
		
		return 0;
	}
}

?>