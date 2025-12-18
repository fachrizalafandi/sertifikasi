<?
if ($sub == "") {

    $sha = mysqli_real_escape_string($conn, $_GET['sha']);

    $q_apl02 = mysqli_query($conn, "
        SELECT 
            a2.id        AS id_apl02,
            a2.sha       AS sha_apl02,
            a2.status    AS status_apl02,
            a1.id        AS id_apl01,
            s.skema,
            k.id         AS id_klaster,
            k.klaster,
            k.nomor
        FROM sr_apl02 a2
        JOIN sr_apl01 a1 ON a1.id = a2.id_apl01
        JOIN sk_skema_klaster k ON a1.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
        WHERE a2.sha = '$sha'
        LIMIT 1
    ");

    if (mysqli_num_rows($q_apl02) == 0) {
        echo "<script>parent.swal('Error','Data APL-02 tidak ditemukan','error');</script>";
        exit;
    }

    $apl = mysqli_fetch_assoc($q_apl02);
?>
<h3><?=$apl["skema"];?></h3>
<spam><?=$apl["nomor"];?> - <?=$apl["klaster"];?></spam>

<hr>

<div class="alert alert-info">
    <strong>PANDUAN ASESMEN MANDIRI</strong>
    <hr class="my-2">
    <strong>Instruksi:</strong>
    <ul class="mb-0">
        <li>Bacalah setiap Elemen Kompetensi dan Kriteria Unjuk Kerja yang ditampilkan dengan saksama.</li>
        <li>Tentukan penilaian Anda dengan memilih:
            <strong>Kompeten (K)</strong> atau <strong>Belum Kompeten (BK)</strong> pada setiap Elemen Kompetensi.</li>
        <li>Pilih bukti pendukung yang relevan untuk menunjukkan bahwa Anda telah melaksanakan tugas atau aktivitas tersebut.</li>
        <li>Pastikan seluruh Elemen Kompetensi telah diisi sebelum mengirimkan Asesmen Mandiri.</li>
    </ul>
</div>

<?
$q_uk = mysqli_query($conn, "
    SELECT id, kode, unit_kompetensi
    FROM sk_skema_uk
    WHERE id_klaster = '".$apl['id_klaster']."'
    ORDER BY kode ASC
");
?>

<form method="post" action="<?= $_SESSION['domain']; ?>/proses?mod=<?= $mod ?>&act=add" target="inframe">
<input type="hidden" name="sha_apl02" value="<?= $apl['sha_apl02']; ?>">

<? while ($uk = mysqli_fetch_assoc($q_uk)) { ?>
<div class="card mb-3">
    <div class="card-header" style="background-color: #faf7cf;">
        <strong><?= $uk['kode']; ?></strong> – <?= $uk['unit_kompetensi']; ?>
    </div>
    <div class="card-body">
    <?
    $q_elemen = mysqli_query($conn, "
        SELECT 
            MIN(id) AS id_elemen, 
            elemen
        FROM sk_skema_elemen
        WHERE id_uk = '".$uk['id']."'
        GROUP BY elemen
        ORDER BY id_elemen ASC
    "); // pakai min karena elemen bisa muncul lebih dari sekali, sehingga diambil yang pertama saja

    $no_elemen = 1;
    while ($el = mysqli_fetch_assoc($q_elemen)) {
    ?>
    <div class="mb-3">
    <strong>Elemen <?= $no_elemen; ?>:</strong>
    <div class="mb-2"><?= $el['elemen']; ?></div>

    <strong>Kriteria Unjuk Kerja:</strong>
    <ul>
        <?
        $q_kuk = mysqli_query($conn, "
            SELECT kuk
            FROM sk_skema_elemen
            WHERE id_uk = '".$uk['id']."'
            AND elemen = '".mysqli_real_escape_string($conn,$el['elemen'])."'
        ");
        $no_kuk = 1;
        while ($k = mysqli_fetch_assoc($q_kuk)) {
        ?>
            <table width="100%" cellpadding="2" cellspacing="0" border="0">
                <tr>
                    <td width="20px" valign="top"><?=$no_elemen.".".$no_kuk;?></td>
                    <td valign="top"><?=$k['kuk'];?></td>
                </tr>
            </table>
        <?
            $no_kuk++;
        }
        ?>
    </ul>
    <div class="row mb-2">
        <div class="col-md-4">
            <label>
                <input type="radio"
                      name="penilaian[<?= $uk['id']; ?>][<?= $el['id_elemen']; ?>]"
                       value="K" required> Kompeten
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="radio"
                       name="penilaian[<?= $uk['id']; ?>][<?= $el['id_elemen']; ?>]"
                       value="BK"> Belum Kompeten
            </label>
        </div>

        <div class="col-md-8">
            <select name="bukti[<?= $uk['id']; ?>][<?= $el['id_elemen']; ?>]"
                    class="form-control" required>
                <option value="">-- Pilih Bukti Pendukung --</option>
                <?
                $q_bukti = mysqli_query($conn, "
                    SELECT id, bukti_persyaratan
                    FROM sr_apl01_bukti
                    WHERE id_apl01 = '".$apl['id_apl01']."'
                ");
                while ($b = mysqli_fetch_assoc($q_bukti)) {
                    echo "<option value='{$b['id']}'>{$b['bukti_persyaratan']}</option>";
                }
                ?>
            </select>
        </div>
    </div>
</div>
<hr>
<? $no_elemen++; } ?>
    </div>
</div>
<? } ?>

<? if ($apl['status_apl02'] == 'draft') { ?>
<button type="submit" class="btn btn-primary">
    Simpan & Submit APL-02
</button>
<? } else { ?>
<div class="alert alert-warning">
    APL-02 sudah diproses dan tidak dapat diubah.
</div>
<? } ?>

</form>

<?
}
?>
