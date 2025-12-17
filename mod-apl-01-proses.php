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

        $id_registrasi = intval($_SESSION['id_user']);
        $id_klaster    = intval($_POST['id_klaster']);
        $tujuan        = input($_POST['tujuan_asesmen']);
        $tgl_pengajuan = date('Y-m-d');
        $sha_apl01     = $_POST['sha_apl01'] ?? '';

        if ($id_klaster == 0 || $tujuan == "") {
            echo "<script>parent.swal('Error','Data belum lengkap','error');</script>";
            exit;
        }

        /* =========================
           MODE EDIT
        ========================= */
        if ($sha_apl01 != '') {

            $q = mysqli_query($conn,"
                SELECT id, status
                FROM sr_apl01
                WHERE sha = '$sha_apl01'
                AND id_registrasi = '$id_registrasi'
                LIMIT 1
            ");

            if (mysqli_num_rows($q) == 0) {
                echo "<script>parent.swal('Error','Data APL-01 tidak ditemukan','error');</script>";
                exit;
            }

            $d = mysqli_fetch_assoc($q);

            if (!in_array($d['status'], ['draft','submitted'])) {
                echo "<script>
                    parent.swal(
                        'Informasi',
                        'APL-01 sudah diproses Admin LSP dan tidak dapat diedit',
                        'info'
                    );
                </script>";
                exit;
            }

            $id_apl01 = $d['id'];

            mysqli_query($conn,"
                UPDATE sr_apl01 SET
                    id_klaster = '$id_klaster',
                    tujuan_asesmen = '$tujuan'
                WHERE id = '$id_apl01'
            ");

            // hapus bukti lama
           $existing = [];
            $q = mysqli_query($conn,"
                SELECT sha, file_bukti_persyaratan
                FROM sr_apl01_bukti
                WHERE id_apl01 = '$id_apl01'
            ");

            while ($r = mysqli_fetch_assoc($q)) {
                $existing[$r['sha']] = $r['file_bukti_persyaratan'];
            }

            $bukti_lama_sha = $_POST['bukti_lama_sha'] ?? [];
            $deleted = array_diff(array_keys($existing), $bukti_lama_sha);
            foreach ($deleted as $sha_bukti) {

            // hapus file fisik
            if (!empty($existing[$sha_bukti])) {
                @unlink("data/bukti-apl-01/" . $existing[$sha_bukti]);
            }

            // hapus record DB
            mysqli_query($conn,"DELETE FROM sr_apl01_bukti WHERE sha = '$sha_bukti'");
        }

        }

        /* =========================
           MODE ADD
        ========================= */
        else {

            $sha_apl01 = md5(uniqid(rand(), true));

            mysqli_query($conn,"
                INSERT INTO sr_apl01
                (id_registrasi, id_klaster, tujuan_asesmen, tgl_pengajuan, status, sha)
                VALUES
                ('$id_registrasi','$id_klaster','$tujuan','$tgl_pengajuan','submitted','$sha_apl01')
            ");

            $id_apl01 = mysqli_insert_id($conn);
        }

        /* =========================
           SIMPAN BUKTI
        ========================= */
        if (!empty($_POST['bukti_persyaratan'])) {
            
            foreach ($_POST['bukti_persyaratan'] as $i => $bukti) {

                if (trim($bukti) == "") continue;

                $bukti_text = input($bukti);
                $file_name  = '';

                if (!empty($_FILES['file_bukti_persyaratan']['name'][$i])) {

                    $ext = pathinfo(
                        $_FILES['file_bukti_persyaratan']['name'][$i],
                        PATHINFO_EXTENSION
                    );

                    $file_name = $id_registrasi . '_' . str_replace(' ', '_', strtolower($_SESSION["nama"])) . '_' . $id_klaster . '_' . md5(uniqid()) . '.' . $ext;

                    move_uploaded_file($_FILES['file_bukti_persyaratan']['tmp_name'][$i], "data/bukti-apl-01/" . $file_name);
                }

                $angka=substr(md5(microtime()),rand(0,26),5);
                $sha_bukti=md5(uniqid($angka, true));

                mysqli_query($conn,"
                    INSERT INTO sr_apl01_bukti
                    (id_apl01, bukti_persyaratan, file_bukti_persyaratan, sha)
                    VALUES
                    ('$id_apl01','$bukti_text','$file_name','$sha_bukti')
                ");
            }
        }


        ?>
        <script>
            top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>";
        </script>
        <?
        exit;
    }
}
?>
