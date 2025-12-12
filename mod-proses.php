<?
	session_start();
	require_once ("include/conn.php");
	include ("include/fungsi.php");

	$mod=input($_GET["mod"]);
	$sub=input($_GET["sub"]);
	$act=input($_GET["act"]);
	$id=input($_GET["id"]);
	$sha=input($_GET["sha"]);
?>
<script src="<?=$_SESSION['domain'];?>/vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="<?=$_SESSION['domain'];?>/include/sweetalert.css" type="text/css">
<script src="<?=$_SESSION['domain'];?>/include/sweetalert.min.js"></script>
<?
	if($_SESSION["hak_akses"]<>"" && $_SESSION["sha"]<>"")
    {
		include("mod-".$mod."-proses.php");
	}
	else
	{
		include("mod-registrasi-proses.php");
	}
?>