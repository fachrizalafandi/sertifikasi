<?
  if($sub=="skema")
  {
      if($act=="add")
      {
        $skema = input($_POST["skema"]);

        if($sha=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into sk_skema (id_lsp,skema,sha) values('".$_SESSION['id_lsp']."','".$skema."','".$sha."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update sk_skema set skema='".$skema."' where sha='".$sha."'"); 
        }
      }
      else
      {
        $str_hapus = "delete from sk_skema where sha='".$sha."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);
      }

      ?>
      <script>
        top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
  else if($sub=="klaster")
  {
      if($act=="add")
      {
        $id_skema_sertifikasi = input($_POST["id_skema_sertifikasi"]);
        $nomor = input($_POST["nomor"]);
        $klaster = input($_POST["klaster"]);

        $file_skema_temp=$_FILES["file_skema"]['name'];
        if ($file_skema_temp<>"")
        {
          $ekstensi = pathinfo($file_skema_temp, PATHINFO_EXTENSION);
          if ($ekstensi<>"php" || $ekstensi<>"PHP")
          {
            $waktu=date(dmYHis);
            $uploaddir = 'data/';
            $uploadfile = $uploaddir. $_FILES['file_skema']['name'];
            if (move_uploaded_file($_FILES['file_skema']['tmp_name'], $uploadfile)) 
            {
                $file_skema="skema_".$waktu.".".$ekstensi;
                rename("data/".$file_skema_temp."", "data/".$file_skema."");

                $s_skema=",file_skema='".$file_skema."'";
            } 
          }
        }

        $file_uk_temp=$_FILES["file_uk"]['name'];
        if ($file_uk_temp<>"")
        {
          $ekstensi = pathinfo($file_uk_temp, PATHINFO_EXTENSION);
          if ($ekstensi<>"php" || $ekstensi<>"PHP")
          {
            $waktu=date(dmYHis);
            $uploaddir = 'data/';
            $uploadfile = $uploaddir. $_FILES['file_uk']['name'];
            if (move_uploaded_file($_FILES['file_uk']['tmp_name'], $uploadfile)) 
            {
                $file_uk="skema_uk_".$waktu.".".$ekstensi;
                rename("data/".$file_uk_temp."", "data/".$file_uk."");

                $s_uk=",file_uk='".$file_uk."'";
            } 
          }
        }

        if($sha=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into sk_skema_klaster (id_skema_sertifikasi,nomor,klaster,sha,file_skema,file_uk) values('".$id_skema_sertifikasi."','".$nomor."','".$klaster."','".$sha."','".$file_skema."','".$file_uk."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update sk_skema_klaster set id_skema_sertifikasi='".$id_skema_sertifikasi."',nomor='".$nomor."',klaster='".$klaster."'".$s_skema."".$s_uk." where sha='".$sha."'"); 
        }
      }
      else
      {
        $str_hapus = "delete from sk_skema_klaster where sha='".$sha."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);
      }

      ?>
      <script>
        top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
  else if($sub=="unit-kompetensi")
  {
      $query = mysqli_query($conn,"SELECT * from sk_skema_klaster where sha='".$sha."'");
      $data = mysqli_fetch_assoc($query);

      if($act=="add")
      {
        $kode = input($_POST["kode"]);
        $unit_kompetensi = input($_POST["unit_kompetensi"]);

        if($_GET["uk"]=="")
        {
          $angka=substr(md5(microtime()),rand(0,26),5);
          $sha=md5(uniqid($angka, true));

          $qry_insert = mysqli_query($conn,"insert into sk_skema_uk (id_klaster,kode,unit_kompetensi,sha) values('".$data["id"]."','".$kode."','".$unit_kompetensi."','".$sha."')");
        }
        else
        {
          $qry_update = mysqli_query($conn,"update sk_skema_uk set kode='".$kode."',unit_kompetensi='".$unit_kompetensi."' where sha='".$_GET["uk"]."'");  
        }

        ?>
        <script>
          $(document).ready(function(){
            parent.swal("Sukses","Data Berhasil Disimpan","success");
            parent.$("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha=<?=$data["sha"];?>");
          });
        </script>
        <?
      }
      else
      {
        $str_hapus = "delete from sk_skema_uk where sha='".$_GET["uk"]."'";
        $qry_hapus = @mysqli_query ($conn,$str_hapus);

        ?>
        <script>
          $(document).ready(function(){
            parent.swal("Sukses","Data Berhasil Dihapus","success");
            parent.$("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha=<?=$data["sha"];?>");
          });
        </script>
        <?
      }
  }
?>