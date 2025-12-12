<?
    session_start();
    require_once ("include/conn.php");
    include ("include/fungsi.php");
    include ("include/domain.php");

    $mod=input($_GET["mod"]);
    $sub=input($_GET["sub"]);
    $sha=input($_GET["sha"]);
    $id=input($_GET["id"]);

    if($_SESSION["hak_akses"]<>"" && $_SESSION["sha"]<>"")
    {
        include("mod-".$mod."-form.php");
    }
    else
    {
        if($mod=="registrasi")
        {
            include("mod-registrasi-form.php");
        }
    }
?>
