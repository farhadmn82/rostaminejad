<?php

class ProductGroup
{
	static function AddGroup($title)
	{
		$con = KW_DataBase::Connect();
		$insq="INSERT INTO groups (Name) VALUES ('".$title."')";
		mysqli_query($con,$insq);
		
		mysqli_close($con);	
	}

	static function GetGroupName($id)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM groups WHERE ID=".$id;
		$result = mysqli_query($con,$selq);
		
		$groupName="";
		if($row = mysqli_fetch_array($result))
		{
			$groupName = $row['Name'];
		}
	
		mysqli_close($con);	
		
		return $groupName;	
	}
	
	static function GetGroupID($name)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM specs WHERE Name='".$name."'";
		$result = mysqli_query($con,$selq);
		
		$groupID=0;
		if($row = mysqli_fetch_array($result))
		{
			$groupID = $row['ID'];
		}
	
		mysqli_close($con);	
		
		return $groupID;	
	}


	static function GetGroupsTable()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM groups";
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<table border="0" class="data_table">';
		$htmlTag .=  '<thead  class="table_header product_table_header">';
		$htmlTag .=  '<th>شناسه</th><th>عنوان گروه</th><th>داده</th></thead>';
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

	static function GetGroupsImages()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM groups";
		$result = mysqli_query($con,$selq);
		
		while($row = mysqli_fetch_array($result))
		{
			$imgs[$row['ID']]=$row['LogoPath'];
		}
		mysqli_close($con);	
		
		return $imgs;
	}
	
	static function GetGroupsComboBox($selectedId)
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM groups";
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<select id="ProductGroup_Select">';
		while($row = mysqli_fetch_array($result))
		{
			$sel='';
			if($row['ID']==$selectedId)
				$sel=' selected';
			$htmlTag .= '<option'.$sel.' value='.$row['ID'].'>'.trim($row['Name']).'</option>';
		}
		$htmlTag .= '</select>';
	
		mysqli_close($con);	
		
		return $htmlTag;
	}

	static function GetGroupsButtons()
	{
		$con = KW_DataBase::Connect();
		$selq = "SELECT * FROM groups";
		$result = mysqli_query($con,$selq);
		
		$htmlTag = '<div class="gbutton group_gbutton" onclick="jsLoadGroupProducts(0)">همه رینگ ها</div>';
		while($row = mysqli_fetch_array($result))
		{
			$htmlTag .= '<div class="gbutton group_gbutton" onclick="jsLoadGroupProducts('.$row['ID'].')">'.$row['Name'].'</div>';
		}
	
		mysqli_close($con);	
		
		return $htmlTag;
	}
}
?>