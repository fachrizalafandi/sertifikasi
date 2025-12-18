<?
    if ($_GET['act'] == "view") {
        $query = mysqli_query($conn,"SELECT * FROM sr_registrasi where sha='".$_GET['sha']."'");
        $data = mysqli_fetch_assoc($query);
?>                    
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-group">
                    <h4>Data Pribadi</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Nama
                        </div>
                        <div class="form-group">
                            <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["nama"];?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            No. KTP / NIK / Paspor
                        </div>
                        <div class="form-group">
                            <input type="text" name='no_ktp' class="form-control form-control-user" value="<?=$data["no_ktp"];?>" disabled>
                        </div>
                        </div>
                </div>
                <div class="form-group">
                    Tempat Lahir & Tanggal Lahir
                </div>
                <div class="form-group">
                    <div class='row'>
                        <div class='col-md-6 mb-3'>
                            <input type="text" name='tempat_lahir' class="form-control form-control-user" value="<?=$data["tempat_lahir"];?>" disabled placeholder="Tempat Lahir">
                        </div>
                        <div class='col-md-6 mb-3'>
                            <input type="date" name='tgl_lahir' class="form-control form-control-user" value="<?=$data["tgl_lahir"];?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Jenis Kelamin
                        </div>
                        <div class="form-group">
                            <select class='form-control' name='jenis_kelamin' disabled>
                                <option value=''>PILIH</option>
                                <option value='laki-laki' <?if($data["jenis_kelamin"]=="laki-laki"){echo "selected";}?>>Laki-Laki</option>
                                <option value='perempuan' <?if($data["jenis_kelamin"]=="perempuan"){echo "selected";}?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Kebangsaan
                        </div>
                        <div class="form-group">
                            <input type="text" name='kebangsaan' class="form-control form-control-user" value="<?=$data["kebangsaan"];?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    Alamat Rumah
                </div>
                <div class="form-group">
                    <textarea name='alamat' class='form-control' rows="5" disabled><?=$data["alamat"];?></textarea>
                </div>
                <div class="form-group">
                    Kode Pos
                </div>
                <div class="form-group">
                    <input type="text" name='kode_pos' class="form-control form-control-user" value="<?=$data["kode_pos"];?>" disabled>
                </div>
                <div class="form-group">
                    No. Telp / Email
                </div>
                <div class="form-group">
                    <div class='row'>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='email' class="form-control form-control-user" value="<?=$data["email"];?>" readonly>
                        </div>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='no_hp' class="form-control form-control-user" value="<?=$data["no_hp"];?>" placeholder="No. Handphone" disabled>
                        </div>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='no_telp_rumah' class="form-control form-control-user" value="<?=$data["no_telp_rumah"];?>" placeholder="No. Telp Rumah" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    Kualifikasi Pendidikan
                </div>
                <div class="form-group">
                    <input type="text" name='kualifikasi_pendidikan' class="form-control form-control-user" value="<?=$data["kualifikasi_pendidikan"];?>" disabled>
                </div>
                <div class="form-group">
                    <br>
                    <h4>Data Pekerjaan</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Nama Institusi / Perusahaan
                        </div>
                        <div class="form-group">
                            <input type="text" name='nama_institusi' class="form-control form-control-user" value="<?=$data["nama_institusi"];?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Jabatan
                        </div>
                        <div class="form-group">
                            <input type="text" name='jabatan' class="form-control form-control-user" value="<?=$data["jabatan"];?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    Alamat Kantor
                </div>
                <div class="form-group">
                    <textarea name='alamat_kantor' class='form-control' rows="5" disabled><?=$data["alamat_kantor"];?></textarea>
                </div>
                <div class="form-group">
                    Kode Pos
                </div>
                <div class="form-group">
                    <input type="text" name='kode_pos_kantor' class="form-control form-control-user" value="<?=$data["kode_pos_kantor"];?>" disabled>
                </div>
                <div class="form-group">
                    No. Telp / Fax / Email
                </div>
                <div class="form-group">
                    <div class='row'>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='no_telp_kantor' class="form-control form-control-user" value="<?=$data["no_telp_kantor"];?>" placeholder="No. Telp Kantor" disabled>
                        </div>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='no_fax' class="form-control form-control-user" value="<?=$data["no_fax"];?>" placeholder="No. Telp Fax" disabled>
                        </div>
                        <div class='col-md-4 mb-3'>
                            <input type="text" name='email_kantor' class="form-control form-control-user" value="<?=$data["email_kantor"];?>" placeholder='Email Kantor' disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?
    }
    else
    {
?>
    <h3>Form Pendaftaran</h3>
    <spam>Selamat datang di aplikasi sertifikasi LSP IPI, silahkan isi nama anda dengan benar dan harap menggunakan alamat email yang aktif</spam>
    <hr>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=registrasi" target='inframe'>
            <div class="form-group">
                Nama
            </div>
            <div class="form-group">
                <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["username"];?>" disabled>
            </div>
            <div class="form-group">
                Email
            </div>
            <div class="form-group">
                <input type="email" name='email' class="form-control form-control-user" value="<?=$data["nama"];?>" disabled>
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
                            <input type="text" name="kode2" class="form-control form-control-user" disabled></td>
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
<?
    }
?>