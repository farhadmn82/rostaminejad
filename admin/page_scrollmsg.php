<?php
require "../classes/cls_database.php";
require '../classes/cls_spectype.php';
?>

<?php

$con = KW_DataBase::Connect();

if($_SERVER['REQUEST_METHOD']=='POST'){
if(isset($_POST['txtMessage'])){
    $active="0";

    if($_POST['chkMsgActive'])
        $active="1";
    $msg = $_POST['txtMessage'];
    $updq = "UPDATE `message` SET `Active` = '".$active."', `Message` = '".$msg."' WHERE `message`.`ID` = 1;";

    echo "<div>تغییرات ذخیره شد.</div>";
    echo "<br/><a style='    display: inline-block;
                             cursor: pointer;
                             text-decoration: none;
                             border-radius: 5px;
                             background-color: lightgray;
                             padding: 10px 20px;' href='adminhome.php'>بازگشت</a>";

    $result = mysqli_query($con,$updq);
    mysqli_close($con);
}
else
{
    $selq = "SELECT * FROM message WHERE ID=1";
    $result = mysqli_query($con,$selq);

    if($row = mysqli_fetch_array($result))
    {
        $res = $row['Message'];
        $active = $row['Active'];
    }

    mysqli_close($con);

?>

<div class="main_page data_page">
	<span>تنظمیات متن متحرک</span>
	<hr/>

<form action="page_scrollmsg.php" method="post">
    <?php

    ?>
<input type="checkbox" id="chkMsgActive" name="chkMsgActive" style="height: 50px;width: 50px;" <?php if ($active=="1") echo "checked"; ?> >فعال</input>
<br/>
	<span style="line-height:50px;vertical-align: top;">متن</span> <input type="text" id="txtMessage" name="txtMessage" class="input_box" style="width:88%" value="<?php echo $res ?>" />
<br/>
<br/>
	<button type="submit" name="SaveMessage" onclick="jsAddSpec()">ثبت</button>
</form>

</div>

<?php } } ?>
