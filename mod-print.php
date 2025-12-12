<?
	session_start();
	include ("include/conn.php");
	include ("include/fungsi.php");
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
  	@media print 
  	{
		body 
		{
			-webkit-print-color-adjust: exact;
			margin:0px;
		}
	}

	body
	{
		font-family: arial;
		font-size: 14px;
		font-weight: bold;
		color: #000000;
	}

	th
	{
		font-family: arial;
		font-size: 12px;
		font-weight: bold;
		color: #000000;
	}

	td
	{
		font-family: arial;
		font-size: 12px;
		font-weight: normal;
		color: #000000;
	}

	table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
  </style>
 </head>

 <body onload='window.print()'>
<?
	if($_GET["mod"]=="jurnal")
	{
		include("ku_jurnal_print.php");
	}
	else if($_GET["mod"]=="absensi")
	{
		include("ku_absensi_print.php");
	}
	else if($_GET["mod"]=="clocking")
	{
		include("sdm_rekap-clocking-print.php");
	}
	else if($_GET["mod"]=="ibps")
	{
		include("k_ibps_print.php");
	}
	else if($_GET["mod"]=="iaps")
	{
		include("k_iaps_print2.php");
	}
	else if($_GET["mod"]=="formulir")
	{
		include("ppdb_formulir.php");
	}
	else if($_GET["mod"]=="kuitansi")
	{
		include("ppdb_kuitansi.php");
	}
	else if($_GET["mod"]=="kuitansi_mundur")
	{
		include("ppdb_kuitansi-mundur.php");
	}
	else if($_GET["mod"]=="kuitansi_iaps")
	{
		include("ppdb_kuitansi-iaps.php");
	}
	else if($_GET["mod"]=="kuitansi_daftar-ulang")
	{
		include("ppdb_kuitansi-daftar-ulang.php");
	}
	else if($_GET["mod"]=="kuitansi_mundur2")
	{
		include("ppdb_kuitansi-mundur2.php");
	}
	else if($_GET["mod"]=="rekap-clocking")
	{
		include("sdm_rekap-clocking-print2.php");
	}
	else if($_GET["mod"]=="surat-pemberitahuan")
	{
		include("k_surat-pemberitahuan-print.php");
	}
?>
</body>
</html>
