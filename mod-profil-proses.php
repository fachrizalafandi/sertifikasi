<?php
if ($sub == "") {
    // ambil identitas asesi
    $sha = $_SESSION['sha'];

    // ===== VALIDASI SESSION =====
    if ($sha == "") {
        ?>
        <script>
            parent.swal("Error", "Session tidak valid. Silakan login ulang.", "error");
        </script>
        <?php
        exit;
    }

    // ===== AMBIL & SANITASI INPUT =====
    $nama                   = input($_POST['nama']);
    $no_ktp                 = input($_POST['no_ktp']);
    $tempat_lahir           = input($_POST['tempat_lahir']);
    $tgl_lahir              = input($_POST['tgl_lahir']);
    $jenis_kelamin          = input($_POST['jenis_kelamin']);
    $kebangsaan             = input($_POST['kebangsaan']);
    $alamat                 = input($_POST['alamat']);
    $kode_pos               = input($_POST['kode_pos']);
    $no_hp                  = input($_POST['no_hp']);
    $no_telp_rumah          = input($_POST['no_telp_rumah']);
    $kualifikasi_pendidikan = input($_POST['kualifikasi_pendidikan']);

    $nama_institusi         = input($_POST['nama_institusi']);
    $jabatan                = input($_POST['jabatan']);
    $alamat_kantor          = input($_POST['alamat_kantor']);
    $kode_pos_kantor        = input($_POST['kode_pos_kantor']);
    $no_telp_kantor         = input($_POST['no_telp_kantor']);
    $no_fax                 = input($_POST['no_fax']);
    $email_kantor           = input($_POST['email_kantor']);

    // ===== VALIDASI FIELD WAJIB =====
    if (
        $nama == "" ||
        $no_ktp == "" ||
        $tempat_lahir == "" ||
        $tgl_lahir == "" ||
        $jenis_kelamin == "" ||
        $kebangsaan == "" ||
        $alamat == "" ||
        $kode_pos == "" ||
        $no_hp == "" ||
        $kualifikasi_pendidikan == "" ||
        $nama_institusi == "" ||
        $jabatan == "" ||
        $alamat_kantor == "" ||
        $kode_pos_kantor == ""
    ) {
        ?>
        <script>
            parent.swal("Error", "Data wajib belum lengkap", "error");
        </script>
        <?php
        exit;
    }

    // ===== UPDATE DATA =====
    $update = mysqli_query($conn, "
        UPDATE sr_registrasi SET
            nama = '$nama',
            no_ktp = '$no_ktp',
            tempat_lahir = '$tempat_lahir',
            tgl_lahir = '$tgl_lahir',
            jenis_kelamin = '$jenis_kelamin',
            kebangsaan = '$kebangsaan',
            alamat = '$alamat',
            kode_pos = '$kode_pos',
            no_hp = '$no_hp',
            no_telp_rumah = '$no_telp_rumah',
            kualifikasi_pendidikan = '$kualifikasi_pendidikan',
            nama_institusi = '$nama_institusi',
            jabatan = '$jabatan',
            alamat_kantor = '$alamat_kantor',
            kode_pos_kantor = '$kode_pos_kantor',
            no_telp_kantor = '$no_telp_kantor',
            no_fax = '$no_fax',
            email_kantor = '$email_kantor'
        WHERE sha = '$sha'
    ");

    // ===== RESPONSE =====
    if ($update) {
        ?>
        <script>
            parent.swal("Sukses", "Data berhasil disimpan", "success");
        </script>
        <?php
    } else {
        ?>
        <script>
            parent.swal("Error", "Gagal menyimpan data", "error");
        </script>
        <?php
    }
}
?>
