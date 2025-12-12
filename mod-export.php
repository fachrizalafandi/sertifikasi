<?
	session_start();
	include ("include/conn.php");
	include ("include/fungsi.php");

	$file=$_GET["mod"]."_".$_SESSION["tahun"]."_".date(dmYHis).".xls";

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$file."");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><?=$title;?></title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <style>
  	body,td
	{
		font-family: Arial;
		font-size: 11px;
		font-weight: normal;
		color: #000000;
	}
  </style>
 </head>

 <body>
<?
	if($_GET["mod"]=="rekap_ibps")
	{
		include("k_rekap-ibps-export.php");
	}
	else if($_GET["mod"]=="rekap_iaps")
	{
		include("k_rekap-iaps-export.php");
	}
	else if($_GET["mod"]=="ppdb")
	{
		include("ppdb-export.php");
	}
	else if($_GET["mod"]=="rekap_ibps2")
	{
		include("k_rekap-ibps2-export.php");
	}
	else if($_GET["mod"]=="rekap_ibps3")
	{
		include("k_rekap-ibps3-export.php");
	}
	else if($_GET["mod"]=="rekap-bulanan-qr")
	{
		include("sdm_report-clocking-export.php");
	}
?>
</body>
</html>
