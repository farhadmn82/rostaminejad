<?php 
	require 'includes/imglist.php';
for($i=0;$i<count($img);$i=$i+4){ ?>

<table border="1"  style="border-color:black; border-style:solid; color:white" align="center">
<tr bgcolor="teal">
	<?php for($j=$i;$j<$i+4;$j++){ ?>
		<td align="center">
	<?php echo $descr[$j]; ?>
		</td>
	<?php } ?>
</tr>
<tr bgcolor="white">
<?php for($k=$i;$k<$i+4;$k++){ ?>
	<td>
<img src="<?php echo htmlspecialchars($img[$k]); ?>" width="200" align="middle" alt="" />
	</td>
<?php }  ?>
</tr>
</table>
<hr/>
<?php } ?>


