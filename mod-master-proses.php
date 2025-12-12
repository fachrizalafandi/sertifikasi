<?
  if($sub=="user-akses")
  {
      if($act=="add")
      {
        $username = input($_POST["username"]);
        $nama = input($_POST["nama"]);
        $hak_akses = input($_POST["hak_akses"]);

        if($sha=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into m_user_akses (username,password,nama,hak_akses,sha,id_lsp) values('".$username."','".$angka."','".$nama."','".$hak_akses."','".$sha."','".$_SESSION["id_lsp"]."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update m_user_akses set username='".$username."',nama='".$nama."',hak_akses='".$hak_akses."' where sha='".$sha."'"); 
        }
      }
      else
      {
        $str_hapus = "delete from m_user_akses where sha='".$sha."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);
      }

      ?>
      <script>
        top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
  else if($sub=="tuk")
  {
      if($act=="add")
      {
        $nama_tuk = input($_POST["nama_tuk"]);
        $alamat = input($_POST["alamat"]);

        if($sha=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into m_tuk (id_lsp,nama_tuk,alamat,sha) values('".$_SESSION['id_lsp']."','".$nama_tuk."','".$alamat."','".$sha."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update m_tuk set nama_tuk='".$nama_tuk."',alamat='".$alamat."' where sha='".$sha."'"); 
        }
      }
      else
      {
        $str_hapus = "delete from m_tuk where sha='".$sha."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);
      }

      ?>
      <script>
        top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
  else if($sub=="asessor")
  {
      if($act=="add")
      {
        $met = input($_POST["met"]);
        $nama = input($_POST["nama"]);

        if($sha=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into m_asessor (id_lsp,met,password,nama,sha) values('".$_SESSION['id_lsp']."','".$met."','".$angka."','".$nama."','".$sha."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update m_asessor set met='".$met."',nama='".$nama."' where sha='".$sha."'"); 
        }
      }
      else
      {
        $str_hapus = "delete from m_asessor where sha='".$sha."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);
      }

      ?>
      <script>
        top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
?>