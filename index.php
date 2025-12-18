<?
    session_start();
    require_once("include/conn.php");
    include("include/fungsi.php");
    include("include/domain.php");

    $mod=input($_GET["mod"]);
    $sub=input($_GET["sub"]);

    include("mod-route.php");

    if(preg_match("/proses/i", $_SERVER['HTTP_REFERER'])) 
    {   
      $code=($_SERVER['HTTP_REFERER']);
      if (strpos($code, 'add') !== false) 
      { 
          $code="simpan";
      }
      else
      {
          $code="delete";
      }
    }
?>
<?
    if($_SESSION["hak_akses"]<>"" && $_SESSION["sha"]<>"")
    {
        $q_lsp = mysqli_query($conn,"select * from m_lsp where id='".$_SESSION["id_lsp"]."'");
        $d_lsp = mysqli_fetch_array($q_lsp);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Inti Media Grafika">

    <title>Sertifikasi <?=$d_lsp["nama_lsp"];?></title>
    <link rel="icon" href="<?=$_SESSION["domain"];?>/img/<?=$d_lsp["logo_lsp_kecil"];?>">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=$_SESSION['domain'];?>/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom plugin-->
    <link href="<?=$_SESSION['domain'];?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?=$_SESSION['domain'];?>/vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?=$_SESSION['domain'];?>/include/sweetalert.css" type="text/css">
    <script src="<?=$_SESSION['domain'];?>/include/sweetalert.min.js"></script>
    <script src="<?=$_SESSION['domain'];?>/vendor/chart.js/Chart.min.js"></script>
    <link rel="stylesheet" href="<?=$_SESSION['domain'];?>/include/shadowbox.css" type="text/css">
    <script src="<?=$_SESSION['domain'];?>/include/shadowbox.js"></script>
    <script>
        Shadowbox.init();
    </script>
</head>

<body id="page-top">
    <iframe name="inframe" style='display:none;'></iframe>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <?
                if($_SESSION["hak_akses"]=="administrator")
                {
            ?>
            <div class="sidebar-heading">
                Master
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Master</span>
                </a>
                <div id="collapseTwo" class="collapse <?if($mod=="master"){echo "show";}?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/master/user-akses">User Akses</a>
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/master/tuk">TUK</a>
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/master/asessor">Asessor</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_skema_sertifikasi"
                    aria-expanded="true" aria-controls="collapse_skema_sertifikasi">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Skema Sertifikasi</span>
                </a>
                <div id="collapse_skema_sertifikasi" class="collapse <?if($mod=="skema-sertifikasi"){echo "show";}?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/skema-sertifikasi/skema">Skema</a>
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/skema-sertifikasi/klaster">Klaster</a>
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/skema-sertifikasi/unit-kompetensi">Unit Kompetensi</a>
                        <a class="collapse-item" href="<?=$_SESSION['domain'];?>/skema-sertifikasi/elemen-kuk">Elemen & KUK</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Sertifikasi
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/registrasi">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Registrasi</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/apl-01">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Form APL-01</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/apl-02">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Form APL-02</span></a>
            </li>
            <hr class="sidebar-divider">
            <?
                }
                else if($_SESSION["hak_akses"]=="asessi")
                {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/profil">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Profil</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/apl-01">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Form APL-01</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/apl-02">
                    <i class="fas fa-fw fa-folder"></i>
                <span>Form APL-02</span></a>
            </li>
            <hr class="sidebar-divider">
            <?
                }
            ?>
            <div class="sidebar-heading">
                Lain-Lain
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/lain-lain/bantuan">
                    <i class="fas fa-fw fa-file-video"></i>
                <span>Bantuan</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=$_SESSION['domain'];?>/lain-lain/tentang-aplikasi">
                    <i class="fas fa-fw fa-file-video"></i>
                <span>Tentang Aplikasi</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><div id='tnotif'></div></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header" style='background-color: #1e3a8a;border:1px solid #119694;'>
                                    Notifikasi
                                </h6>
                                <br>
                                <center>Tidak Ada Notifikasi</center>
                                <br>
                                <script>
                                    document.getElementById("tnotif").innerHTML="0";
                                </script>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 large" style='text-align: right;'><b><font style='font-size: 15px;'><?=$_SESSION['nama'];?></font></b><br><span><?=ucwords($_SESSION["hak_akses"]);?></span>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="<?=$_SESSION["domain"];?>/img/undraw_profile.svg" style='margin-left:10px;'>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?=$_SESSION['domain'];?>/ubah-password">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ubah Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=$_SESSION["domain"];?>/logout" target='inframe'>
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?
                        if($mod=="")
                        {
                            if($_SESSION["hak_akses"]=="administrator")
                            {
                                include("mod-dashboard-admin.php");
                            }
                            else if($_SESSION["hak_akses"]=="asessi")
                            {
                                include("mod-dashboard-asessi.php");
                            }
                        }
                        else
                        {
                            ?>
                            <script>
                              function add()
                              {
                                  $(document).ready(function(){
                                      $('#window-modal').modal('show');
                                      $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>");
                                  });
                              }

                              function edit(sha, act="")
                              {
                                  $(document).ready(function(){
                                      $('#window-modal').modal('show');
                                      $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha="+sha+"&act="+act);
                                  });
                              }

                              function del(sha)
                              {
                                  return swal({ title: 'Hapus Data', text: 'Yakin akan menghapus data ?', type: 'info', showCancelButton: true, confirmButtonColor: 'red', confirmButtonText: 'Hapus',   closeOnConfirm: false }, function(){ inframe.location.href='<?=$_SESSION["domain"];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=delete&sha='+sha; });
                              }
                            </script>                   
                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 large"><i class="fas fa-home fa-sm text-gray-800-50"></i>  &nbsp;&nbsp;/&nbsp;&nbsp; <?=ucwords(str_replace("-"," ",$mod));?> &nbsp;&nbsp;/&nbsp;&nbsp; <?if($sub){echo ucwords(str_replace("-"," ",$sub));}?></span>

                                <div id='add_data'><button class="btn btn-secondary btn-user" onclick='add()'><i class="fas fa-edit fa-sm text-white-50"></i> Tambah Data</button></div>
                            </div>
                            <?
                            include("mod-".$mod.".php");
                        }
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>v1.0 Copyright &copy; 2025 - <?=$d_lsp["nama_lsp"];?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!------- Modal Window ---------->
    <div class="modal fade" id="window-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style='max-width: 800px;'>
        <div class="modal-content">
          <div class="modal-body" style="padding:30px;">
            <div id='content-modal'></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
       </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=$_SESSION['domain'];?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=$_SESSION['domain'];?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=$_SESSION['domain'];?>/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?=$_SESSION['domain'];?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$_SESSION['domain'];?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>

</html>
<?
      if($error_status<>"")
      {
        ?>
        <script>
          swal("Informasi","<?=$error_status;?>","info")
        </script>    
        <?
      }

      if($code=="simpan")
      {
        ?>
        <script>
          swal("Sukses","Data Berhasil Disimpan","success")
        </script>    
        <?
      }
      else if($code=="delete")
      {
        ?>
        <script>
          swal("Sukses","Data Berhasil Dihapus","success")
        </script>    
        <?
      }
    }
    else
    {
        include("mod-login.php");
    }
?>