<?php
if ($sub == "") {

    if ($act == "add") {

        $id_user   = intval($_SESSION['id_user']);
        $sha_apl02 = $_POST['sha_apl02'] ?? '';

        if ($sha_apl02 == '') {
            echo "<script>parent.swal('Error','Data APL-02 tidak valid','error');</script>";
            exit;
        }

        // ==========================
        // AMBIL DATA APL-02
        // ==========================
        $q_apl02 = mysqli_query($conn, "
            SELECT 
                a2.id,
                a2.status,
                a1.id_registrasi
            FROM sr_apl02 a2
            JOIN sr_apl01 a1 ON a1.id = a2.id_apl01
            WHERE a2.sha = '$sha_apl02'
            LIMIT 1
        ");

        if (mysqli_num_rows($q_apl02) == 0) {
            echo "<script>parent.swal('Error','Data APL-02 tidak ditemukan','error');</script>";
            exit;
        }

        $apl02 = mysqli_fetch_assoc($q_apl02);

        // ==========================
        // VALIDASI AKSES ASESSI
        // ==========================
        if ($apl02['id_registrasi'] != $id_user) {
            echo "<script>parent.swal('Error','Akses tidak diizinkan','error');</script>";
            exit;
        }

        // ==========================
        // VALIDASI STATUS
        // ==========================
        if ($apl02['status'] != 'draft') {
            echo "<script>
                parent.swal(
                    'Informasi',
                    'APL-02 sudah diproses dan tidak dapat diubah',
                    'info'
                );
            </script>";
            exit;
        }

        $id_apl02 = $apl02['id'];

        // ==========================
        // SIMPAN PENILAIAN & BUKTI
        // ==========================
        if (!empty($_POST['penilaian'])) {

            foreach ($_POST['penilaian'] as $id_uk => $elemenList) {

                foreach ($elemenList as $id_elemen => $nilai) {

                    $penilaian = ($nilai === 'K') ? 'K' : 'BK';

                    $id_bukti = $_POST['bukti'][$id_uk][$id_elemen] ?? null;

                    $id_uk     = intval($id_uk);
                    $id_elemen = intval($id_elemen);
                    $id_bukti  = ($id_bukti !== '' && $id_bukti !== null)
                                    ? intval($id_bukti)
                                    : null;

                    $txt_update = "
                        UPDATE sr_apl02_detail SET
                            penilaian = '$penilaian',
                            id_bukti_persyaratan = ".($id_bukti ? "'$id_bukti'" : "NULL")."
                        WHERE id_apl02 = '$id_apl02'
                        AND id_uk = '$id_uk'
                        AND id_elemen = '$id_elemen'
                    ";

                    mysqli_query($conn, $txt_update);
                }
            }

        }

        // ==========================
        // UPDATE STATUS APL-02
        // ==========================
        mysqli_query($conn, "
            UPDATE sr_apl02 SET
                status = 'submitted',
                tgl_submit = NOW()
            WHERE id = '$id_apl02'
        ");

        ?>
        <script>
            top.location.href="<?=$_SESSION["domain"];?>/<?=$mod;?>";
        </script>
        <?
        exit;
    }
}
?>