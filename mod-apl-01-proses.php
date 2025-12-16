<?php
if ($sub == "") {
    if ($act == "load-klaster") {
        header('Content-Type: application/json; charset=utf-8');
        ob_clean();

        $id_skema = intval($_GET['id_skema']);

        $data = [];

        $q = mysqli_query($conn,"
            SELECT id, nomor, klaster
            FROM sk_skema_klaster
            WHERE id_skema_sertifikasi = '$id_skema'
            ORDER BY nomor ASC
        ");

        while ($r = mysqli_fetch_assoc($q)) {
            $data[] = $r;
        }

        echo json_encode($data);
        exit;
    }
    elseif ($act == 'load-persyaratan') {

        header('Content-Type: application/json; charset=utf-8');
        ob_clean();

        $id_klaster = intval($_GET['id_klaster']);

        $q = mysqli_query($conn,"
            SELECT persyaratan1, persyaratan2, persyaratan3
            FROM sk_skema_klaster
            WHERE id = '$id_klaster'
            LIMIT 1
        ");

        $d = mysqli_fetch_assoc($q);

        $persyaratan = [];

        if (!empty($d['persyaratan1'])) {
            $persyaratan[] = $d['persyaratan1'];
        }
        if (!empty($d['persyaratan2'])) {
            $persyaratan[] = $d['persyaratan2'];
        }
        if (!empty($d['persyaratan3'])) {
            $persyaratan[] = $d['persyaratan3'];
        }

        echo json_encode($persyaratan);
        exit;
    }
    elseif ($act == "add") {
        $id_registrasi  = intval($_SESSION['id_user']);
        $id_klaster     = intval($_POST['id_klaster']);
        $tujuan         = input($_POST['tujuan_asesmen']);
        $tgl_pengajuan  = date('Y-m-d');
        $status         = 'submitted';
        $sha_apl01      = md5(uniqid(rand(), true));

        if ($id_klaster == 0 || $tujuan == "") {
            echo "<script>parent.swal('Error','Data belum lengkap','error');</script>";
            exit;
        }

        // cek duplikasi APL-01 dari klaster yang sama dan registrasi yang sama
        $cek = mysqli_query($conn, "
            SELECT id FROM sr_apl01
            WHERE id_registrasi = '$id_registrasi'
            AND id_klaster = '$id_klaster'
            AND status IN ('draft','submitted','verifikasi','asesmen')
        ");

        if (mysqli_num_rows($cek) > 0) {
            echo "<script>
                parent.swal(
                    'Informasi',
                    'Anda masih memiliki pengajuan APL-01 yang aktif untuk klaster ini',
                    'info'
                );
            </script>";
            exit;
        }

        // simpan data APL-01
        $q_apl01 = mysqli_query($conn, "
            INSERT INTO sr_apl01 
            (id_registrasi, id_klaster, tujuan_asesmen, tgl_pengajuan, status, sha)
            VALUES
            ('$id_registrasi','$id_klaster','$tujuan','$tgl_pengajuan','$status','$sha_apl01')
        ");

        if (!$q_apl01) {
            echo "<script>parent.swal('Error','Gagal menyimpan APL-01','error');</script>";
            exit;
        }

        $id_apl01 = mysqli_insert_id($conn);

        
        // simpan data bukti persyaratan
        if (!empty($_POST['bukti_persyaratan'])) {

            foreach ($_POST['bukti_persyaratan'] as $i => $bukti) {

                if (trim($bukti) == "") continue;

                $bukti_text = input($bukti);
                $file_name  = '';

                if (!empty($_FILES['file_bukti_persyaratan']['name'][$i])) {

                    $ext  = pathinfo($_FILES['file_bukti_persyaratan']['name'][$i], PATHINFO_EXTENSION);
                    $file_name = md5(uniqid()) . '.' . $ext;

                    move_uploaded_file(
                        $_FILES['file_bukti_persyaratan']['tmp_name'][$i],
                        "data/bukti-apl-01/" . $file_name
                    );
                }

                $sha_bukti = md5(uniqid(rand(), true));

                mysqli_query($conn, "
                    INSERT INTO sr_apl01_bukti
                    (id_apl01, bukti_persyaratan, file_bukti_persyaratan, sha)
                    VALUES
                    ('$id_apl01','$bukti_text','$file_name','$sha_bukti')
                ");
            }
        }

        // feedback sukses
        ?>
        <script>
            parent.swal({
                title: "Sukses",
                text: "Data berhasil disimpan",
                type: "success"
            }, function () {
                parent.location.href = "<?= $_SESSION['domain']; ?>/apl-01";
            });
        </script>
        <?
    }
}
?>
