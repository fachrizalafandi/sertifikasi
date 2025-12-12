<?
    session_start();
    require_once("include/conn.php");

    $q_lsp = mysqli_query($conn,"select * from m_lsp where id='1'");
    $d_lsp = mysqli_fetch_array($q_lsp);
    $_SESSION["id_lsp"]=$d_lsp["id"];
    $_SESSION["logo"]=$d_lsp["logo_lsp"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Inti Media Grafika" />
    <title>Sertifikasi <?=$d_lsp["nama_lsp"];?></title>
    <link rel="icon" href="<?=$_SESSION["domain"];?>/img/<?=$d_lsp["logo_lsp_kecil"];?>">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom fonts for this template--> 
    <link rel="stylesheet" type="text/css" href="<?=$_SESSION["domain"];?>/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?=$_SESSION["domain"];?>/css/main.css">

    <link rel="stylesheet" href="<?=$_SESSION["domain"];?>/include/sweetalert.css" type="text/css">
    <script src="<?=$_SESSION["domain"];?>/include/sweetalert.min.js"></script>
    <script src="<?=$_SESSION['domain'];?>/vendor/jquery/jquery.min.js"></script>
    <link href="<?=$_SESSION['domain'];?>/css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">
    <iframe name="inframe" style='display:none;'></iframe>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method='POST' action="<?=$_SESSION["domain"];?>/login" target='inframe'>
                    <center><img src='<?=$_SESSION['domain'];?>/img/<?=$d_lsp["logo_lsp"];?>' width='200'></center>
                    <br><br>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="username" placeholder="username" required>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" id='pass' type="password" name="password" placeholder="password" required>
                    </div>
                    <br>
                    <div class="container-login100-form-btn">
                        <input type='hidden' name='lsp_token' value='<?=$d_lsp["sha"];?>'>
                        <input type='submit' value='Login' class='login100-form-btn'>
                    </div>
                    <div class="container-login100-form-btn" style='margin-top: 10px;'>
                        <script>
                            function add()
                            {
                                $(document).ready(function(){
                                    $('#window-modal').modal('show');
                                    $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=registrasi");
                                });
                            }
                        </script>
                        <input type='button' onclick='add()' value='Registrasi' class='login100-form-btn' style='background-color: #367b37;'>
                    </div>
                    <br>
                    <br>
                    <center>
                       <p>v1.0 Copyright &copy; 2025<br><?=$d_lsp["nama_lsp"];?></p>
                    </center>
                </form>
                <div class="login100-more" style="background-color:#ffffff;background-image: url('<?=$_SESSION['domain'];?>/img/background.jpg');padding-top:20px;background-size: 80%;background-position: center;">
                </div>
            </div>
        </div>
    </div>

    <!------- Modal Window ---------->
    <div class="modal fade" id="window-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body" style="padding:30px;">
            <div id='content-modal'></div>
          </div>
       </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=$_SESSION["domain"];?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=$_SESSION["domain"];?>/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>