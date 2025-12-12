<?
    if($sub=="")
    {
        $query = mysqli_query($conn,"SELECT * FROM sr_registrasi where sha='".$_SESSION['sha']."'");
        $data = mysqli_fetch_assoc($query);
?>                    
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=registrasi" target='inframe'>
                    <div class="form-group">
                        <h4>Data Pribadi</h4>
                        <hr>
                    </div>
                    <div class="form-group">
                        Nama
                    </div>
                    <div class="form-group">
                        <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["nama"];?>" required>
                    </div>
                    <div class="form-group">
                        No. KTP / NIK / Paspor
                    </div>
                    <div class="form-group">
                        <input type="text" name='no_ktp' class="form-control form-control-user" value="<?=$data["no_ktp"];?>" required>
                    </div>
                    <div class="form-group">
                        Tempat Lahir & Tanggal Lahir
                    </div>
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='tempat_lahir' class="form-control form-control-user" value="<?=$data["tempat_lahir"];?>" required>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <input type="date" name='tgl_lahir' class="form-control form-control-user" value="<?=$data["tgl_lahir"];?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        Jenis Kelamin
                    </div>
                    <div class="form-group">
                        <select class='form-control' name='jenis_kelamin'>
                            <option value=''>PILIH</option>
                            <option value='laki-laki' <?if($data["jenis_kelamin"]=="laki-laki"){echo "selected";}?>>Laki-Laki</option>
                            <option value='perempuan' <?if($data["jenis_kelamin"]=="perempuan"){echo "selected";}?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        Kebangsaan
                    </div>
                    <div class="form-group">
                        <input type="text" name='kebangsaan' class="form-control form-control-user" value="<?=$data["kebangsaan"];?>" required>
                    </div>
                    <div class="form-group">
                        Alamat Rumah
                    </div>
                    <div class="form-group">
                        <textarea name='alamat' class='form-control' rows="5" required><?=$data["alamat"];?></textarea>
                    </div>
                    <div class="form-group">
                        Kode Pos
                    </div>
                    <div class="form-group">
                        <input type="text" name='kode_pos' class="form-control form-control-user" value="<?=$data["kode_pos"];?>" required>
                    </div>
                    <div class="form-group">
                        No. Telp / Email
                    </div>
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='no_telp_rumah' class="form-control form-control-user" value="<?=$data["no_telp_rumah"];?>" placeholder="No. Telp Rumah" required>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='no_hp' class="form-control form-control-user" value="<?=$data["no_hp"];?>" placeholder="No. Handphone" required>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='email' class="form-control form-control-user" value="<?=$data["email"];?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        Kualifikasi Pendidikan
                    </div>
                    <div class="form-group">
                        <input type="text" name='kualifikasi_pendidikan' class="form-control form-control-user" value="<?=$data["kualifikasi_pendidikan"];?>" required>
                    </div>
                    <div class="form-group">
                        <br>
                        <h4>Data Pekerjaan</h4>
                        <hr>
                    </div>
                    <div class="form-group">
                        Nama Institusi / Perusahaan
                    </div>
                    <div class="form-group">
                        <input type="text" name='nama_institusi' class="form-control form-control-user" value="<?=$data["nama_institusi"];?>" required>
                    </div>
                    <div class="form-group">
                        Jabatan
                    </div>
                    <div class="form-group">
                        <input type="text" name='jabatan' class="form-control form-control-user" value="<?=$data["jabatan"];?>" required>
                    </div>
                    <div class="form-group">
                        Alamat Kantor
                    </div>
                    <div class="form-group">
                        <textarea name='alamat_kantor' class='form-control' rows="5" required><?=$data["alamat_kantor"];?></textarea>
                    </div>
                    <div class="form-group">
                        Kode Pos
                    </div>
                    <div class="form-group">
                        <input type="text" name='kode_pos_kantor' class="form-control form-control-user" value="<?=$data["kode_pos_kantor"];?>" required>
                    </div>
                    <div class="form-group">
                        No. Telp / Fax / Email
                    </div>
                    <div class="form-group">
                        <div class='row'>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='no_telp_kantor' class="form-control form-control-user" value="<?=$data["no_telp_kantor"];?>" placeholder="No. Telp Kantor" required>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='no_fax' class="form-control form-control-user" value="<?=$data["no_fax"];?>" placeholder="No. Telp Fax" required>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <input type="text" name='email_kantor' class="form-control form-control-user" value="<?=$data["email_kantor"];?>" placeholder='Email Kantor'>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value='Simpan'>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById("add_data").style.display="none";
        </script>
<?
    }
?>