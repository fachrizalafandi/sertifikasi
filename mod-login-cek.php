<?
	ob_start();
	session_start();
	require_once ("include/conn.php");
	include("include/fungsi.php");
    include("include/domain.php");
?>
<script src="vendor/jquery/jquery.min.js"></script>
<?
	$username = input($_POST['username']);
	$password = input($_POST['password']);
	$lsp_token = input($_POST['lsp_token']);

	if ($username<>"" && $password<>"")
	{
		$q_lsp = mysqli_query($conn,"select * from m_lsp where sha='".$lsp_token."'");
    	$d_lsp = mysqli_fetch_array($q_lsp);
    	if($d_lsp["id"]<>"")
    	{
			$cek_user = @mysqli_query($conn,"select * from m_user_akses where id_lsp='".$d_lsp["id"]."' and username='".$username."' and password='".$password."'");
			$data_user = @mysqli_fetch_array($cek_user);
			if ($data_user["username"]==$username)
			{
				$_SESSION["id_user"]=$data_user["id"];
				$_SESSION["nama"]=$data_user["nama"];
				$_SESSION["hak_akses"]=$data_user["hak_akses"];
				$_SESSION["sha"]=$data_user["sha"];
				$_SESSION["id_lsp"]=$d_lsp["id"];
				?>
				<script>
					parent.location.href="<?=$_SESSION["domain"];?>/";
				</script>
				<?
			}
			else
			{
				$cek_user = @mysqli_query($conn,"select * from sr_registrasi where id_lsp='".$d_lsp["id"]."' and email='".$username."' and password='".$password."'");
				$data_user = @mysqli_fetch_array($cek_user);
				if ($data_user["email"]==$username)
				{
					$_SESSION["id_user"]=$data_user["id"];
					$_SESSION["nama"]=$data_user["nama"];
					$_SESSION["hak_akses"]="asessi";
					$_SESSION["sha"]=$data_user["sha"];
					$_SESSION["id_lsp"]=$d_lsp["id"];
					?>
					<script>
						parent.location.href="<?=$_SESSION["domain"];?>/";
					</script>
					<?
				}
				else
				{
					?>
					<script>
						parent.swal("Gagal Login", "Username atau Password Salah", "error");
					</script>
					<?
				}
			}
		}
		else
		{
			?>
				<script>
					parent.swal("Gagal Login", "LSP Tidak Ditemukan", "error");
				</script>
			<?
		}
	}
?>
