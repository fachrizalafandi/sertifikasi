<h3>Form Pendaftaran</h3>
<spam>Selamat datang di aplikasi sertifikasi LSP IPI, silahkan isi nama anda dengan benar dan harap menggunakan alamat email yang aktif</spam>
<hr>
<form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=registrasi" target='inframe'>
        <div class="form-group">
            Nama
        </div>
        <div class="form-group">
            <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["username"];?>" required>
        </div>
        <div class="form-group">
            Email
        </div>
        <div class="form-group">
            <input type="email" name='email' class="form-control form-control-user" value="<?=$data["nama"];?>" required>
        </div>
        <div class="form-group">
            Masukkan Kode
        </div>
        <div class="form-group">
            <?$angka=substr(md5(microtime()),rand(0,26),5);?>
            <div id='kode'></div>
            <table cellpadding='0' width='100%'>
                <tr>
                    <td width='10%'>
                        <div style='border:1px solid #eeeeee;padding:7px;background:#eeb30a;color:#666666;font-size:18px;text-align: center;border-radius:6px;' title='CAPTCHA'><?=$angka;?></div>
                    </td>
                    <td style='padding-left:20px;'>
                        <input type="text" name="kode2" class="form-control form-control-user" required></td>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="kode" value='<?=$angka;?>'>
        </div>
        <hr style='margin-top: 30px;'>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value='DAFTAR'>
        </div>
    </form>