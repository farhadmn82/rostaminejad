<?php

class SpecType
{
	static function AddSpecType($title)
	{
		$con = KW_DataBase::Connect();
		$insq="INSERT INTO spectypes (Name) VALUES ('".$title."')";
		mysqli_query($con,$insq);
		
		mysqli_close($con);	
	}

	static function GetSpecTypeName($id)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM spectypes WHERE ID=".$id;
		$result = mysqli_query($con,$selq);
		
		$specTypeName="";
		if($row = mysqli_fetch_array($result))
		{
			$specTypeName = $row['Name'];
		}
	
		mysqli_close($con);	
		
		return $specTypeName;	
	}
	
	static function GetSpecID($name)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM spectypes WHERE AND Name='".$name."'";
		$result = mysqli_query($con,$selq);
		
		$specTypeID=0;
		if($row = mysqli_fetch_array($result))
		{
			$specTypeID = $row['ID'];
		}
	
		mysqli_close($con);	
		
		return $specTypeID;	
	}

	static function GetSpecTypesTable()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM spectypes";
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<table border="0" width="300">';
		$htmlTag .=  '<thead><th>شناسه</th><th>عنوان</th></thead>';
		while($row = mysqli_fetch_array($result))
		{
			$htmlTag .= '<tr style="height:30px;text-align:center;">';
			$htmlTag .= '<td>'.trim($row['ID']).'</td>';
			$htmlTag .= '<td>'.trim($row['Name']).'</td>';
			$htmlTag .= '</tr>';
		}
		$htmlTag .= '</table>';
	
		mysqli_close($con);	
		
		return $htmlTag;
	
	}
}

?>