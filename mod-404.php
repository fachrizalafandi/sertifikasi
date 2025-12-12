<?
    session_start();
    include("include/domain.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Inti Media Grafika">

    <title>Sertifikasi LSP IPI</title>
    <link rel="icon" href="<?=$_SESSION["domain"];?>/img/favicon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=$_SESSION['domain'];?>/css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid" style='height:100vh;'>

                    <!-- 404 Error Text -->
                    <br><br><br>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 mb-0">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <!-- Card Body -->
                                <div class="card-body" style='padding:100px;'>
                                    <center>
                                    <img src='<?=$_SESSION['domain'];?>/img/logo_lsp_ipi.png' width='250'>
                                    <br><br><hr><p class="lead">Halaman Tidak Ditemukan</p>
                                    <a href="<?=$_SESSION["domain"];?>/">&larr; Kembali Ke Home</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>