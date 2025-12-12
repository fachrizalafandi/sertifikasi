<?
  if($sub=="")
  {
      if($act=="")
      {
        $nama = input($_POST["nama"]);
        $email = input($_POST["email"]);
        $kode = input($_POST["kode"]);
        $kode2 = input($_POST["kode2"]);

        if($kode==$kode2)
        {
            $angka=substr(md5(microtime()),rand(0,26),5);
            $sha=md5(uniqid($angka, true));

            $qry_insert = mysqli_query($conn,"insert into sr_registrasi (id_lsp,email,password,nama,sha) values('".$_SESSION["id_lsp"]."','".$email."','".$angka."','".$nama."','".$sha."')");

            $q_last = mysqli_query($conn,"select * from sr_registrasi where id_lsp='".$_SESSION["id_lsp"]."' order by id desc limit 0,1");
            $d_last = mysqli_fetch_array($q_last);

            email($email,$nama,$d_last["password"],$d_last["sha"]);

            ?>
            <script>
              parent.document.getElementById("content-modal").innerHTML="<center><img src='<?=$_SESSION['domain'];?>/img/email.jpg' width='300'><br><hr><br><p class='lead'><b>Registrasi Berhasil</b></p><p>Silahkan cek inbox pada email yang telah anda daftarkan untuk verifikasi akun dan detail akun</p><a href='<?=$_SESSION["domain"];?>/'>&larr; Kembali Ke Home</a></center>";
            </script>
            <?
        }
        else
        {
          ?>
          <script>
            parent.swal("Registrasi Gagal","Kode / Captcha Yang Anda Masukkan Salah","error");
          </script>
          <?
        }
      }
      ?>
      <script>
        //top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>/<?=$sub;?>";
      </script>
      <?
  }
?>