<?
	$conn = mysqli_connect("localhost","root","","lsp_ipi_sertifikasi");
	if (mysqli_connect_errno()) {
	  echo "Koneksi database gagal : ".mysqli_connect_error();
	}

	ini_set("date.timezone","Asia/Jakarta");
	ini_set("error_reporting", 0);
?>
