<?
if ($sub == "") {
    if ($_GET['act'] == '')
    {
        // Ambil data APL-02 berdasarkan SHA dari parameter GET
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

        $apl02 = mysqli_fetch_assoc($q_apl02);

        // Ambil detail APL-02 -> Mode Edit (jika isian sudah ada)
        $apl02_detail = [];
        $q_detail = mysqli_query($conn, "
            SELECT id_uk, id_elemen, penilaian, id_bukti_persyaratan
            FROM sr_apl02_detail
            WHERE id_apl02 = '".$apl02['id_apl02']."'
        ");

        while ($d = mysqli_fetch_assoc($q_detail)) {
            $apl02_detail[$d['id_uk']][$d['id_elemen']] = [
                'penilaian' => $d['penilaian'],
                'bukti'     => $d['id_bukti_persyaratan']
            ];
        }

        // Cek apakah boleh edit atau tidak
        // draft, submitted => boleh edit
        // processed, verified, passed, rejected => tidak boleh edit
        $canEdit = true;
        if (in_array($apl02['status_apl02'], ['draft', 'submitted'])) {
            if($_SESSION['hak_akses'] == 'asessi') {
                $canEdit = true;
            } else {
                $canEdit = false;
            }
        } else {
            $canEdit = false;
        }

        ?>
        <h3><?= $apl02["skema"] ?></h3>
        <spam><?= $apl02["nomor"] ?> - <?= $apl02["klaster"] ?></spam>

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
        // Ambil unit kompetensi berdasarkan klaster
        $q_uk = mysqli_query($conn, "
            SELECT id, kode, unit_kompetensi
            FROM sk_skema_uk
            WHERE id_klaster = '".$apl02['id_klaster']."'
            ORDER BY kode ASC
        ");
        ?>

        <form method="post" action="<?= $_SESSION[
            "domain"
        ] ?>/proses?mod=<?= $mod ?>&act=add" target="inframe">
        <input type="hidden" name="sha_apl02" value="<?= $apl02["sha_apl02"] ?>">

        <? while ($uk = mysqli_fetch_assoc($q_uk)) { ?>
        <div class="card mb-3">
            <div class="card-header" style="background-color: #faf7cf;">
                <strong><?= $uk["kode"] ?></strong> – <?= $uk["unit_kompetensi"] ?>
            </div>
            <div class="card-body">
            <?
            // Ambil elemen berdasarkan unit kompetensi
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
            <strong>Elemen <?= $no_elemen ?>:</strong>
            <div class="mb-2"><?= $el["elemen"] ?></div>

            <strong>Kriteria Unjuk Kerja:</strong>
            <ul>
                <?
                // Ambil KUK berdasarkan elemen dan unit kompetensi
                $q_kuk = mysqli_query($conn, "
                    SELECT kuk
                    FROM sk_skema_elemen
                    WHERE id_uk = '".$uk['id']."'
                    AND elemen = '".mysqli_real_escape_string($conn,$el['elemen'])."'
                ");

                // Tampilkan KUK
                $no_kuk = 1;
                while ($k = mysqli_fetch_assoc($q_kuk)) {
                ?>
                    <table width="100%" cellpadding="2" cellspacing="0" border="0">
                        <tr>
                            <td width="20px" valign="top"><?= $no_elemen .
                                "." .
                                $no_kuk ?></td>
                            <td valign="top"><?= $k["kuk"] ?></td>
                        </tr>
                    </table>
                <?
                    $no_kuk++;
                }
                ?>
            </ul>
            <div class="row mb-2">
                <div class="col-md-4">
                    <?
                    // Ambil nilai penilaian jika ada
                    $nilai = $apl02_detail[$uk['id']][$el['id_elemen']]['penilaian'] ?? '';
                    ?>
                    <label>
                        <input type="radio"
                            name="penilaian[<?= $uk["id"] ?>][<?= $el[
        "id_elemen"
    ] ?>]"
                            value="K" <?= $nilai == "K"
                                ? "checked"
                                : "" ?> required <?= $canEdit
        ? ""
        : "disabled" ?>> Kompeten
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="radio"
                            name="penilaian[<?= $uk["id"] ?>][<?= $el[
        "id_elemen"
    ] ?>]"
                            value="BK" <?= $nilai == "BK"
                                ? "checked"
                                : "" ?> <?= $canEdit
        ? ""
        : "disabled" ?>> Belum Kompeten
                    </label>
                </div>

                <div class="col-md-8">
                    <? 
                    // Ambil bukti pendukung jika ada
                    $id_bukti_pendukung = $apl02_detail[$uk['id']][$el['id_elemen']]['bukti'] ?? '';
                    ?>
                    <select name="bukti[<?= $uk["id"] ?>][<?= $el["id_elemen"] ?>]"
                            class="form-control" required <?= $canEdit
                                ? ""
                                : "disabled" ?>>
                        <option value="">-- Pilih Bukti Pendukung --</option>
                        <?
                        $q_bukti = mysqli_query($conn, "
                            SELECT id, bukti_persyaratan
                            FROM sr_apl01_bukti
                            WHERE id_apl01 = '".$apl02['id_apl01']."'
                        ");
                        while ($b = mysqli_fetch_assoc($q_bukti)) {
                            echo "<option value='{$b['id']}' ".($id_bukti_pendukung == $b['id'] ? 'selected' : '').">{$b['bukti_persyaratan']}</option>";
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

        <?
        // Tombol Simpan & Submit hanya muncul jika boleh edit
        if ($canEdit) { ?>
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
    elseif ($_GET['act'] == 'admin')
    {
        $sha = mysqli_real_escape_string($conn, $_GET['sha']);

        // ambil data apl02 + status
        $q = mysqli_query($conn,"
            SELECT 
                a2.id AS id_apl02,
                a2.status AS status_apl02,
                a2.sha AS sha_apl02,
                a1.id AS id_apl01,
                a1.sha AS sha_apl01
            FROM sr_apl02 a2
            JOIN sr_apl01 a1 ON a1.id = a2.id_apl01
            WHERE a2.sha = '$sha'
            LIMIT 1
        ");

        if (mysqli_num_rows($q) == 0) {
            echo "<script>parent.swal('Error','Data tidak ditemukan','error');</script>";
            exit;
        }

        $apl = mysqli_fetch_assoc($q);
        ?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="apl01-tab" data-toggle="tab" data-target="#apl01" type="button" role="tab" aria-controls="apl01" aria-selected="true">APL-01</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="apl02-tab" data-toggle="tab" data-target="#apl02" type="button" role="tab" aria-controls="apl02" aria-selected="false">APL-02</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approve-tab" data-toggle="tab" data-target="#approve" type="button" role="tab" aria-controls="approve" aria-selected="false">Approvement</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane p-4 active" id="apl01" role="tabpanel" aria-labelledby="apl01-tab">a</div>
            <div class="tab-pane p-4" id="apl02" role="tabpanel" aria-labelledby="apl02-tab">b</div>
            <div class="tab-pane p-4" id="approve" role="tabpanel" aria-labelledby="approve-tab">c</div>
        </div>

        <script>
        $(function () {
            $('#myTab li:first-child button').tab('show')
        })
        </script>

        <script>
            $(function () {

                // load tab pertama langsung
                $('#apl01')
                    .load("<?= $_SESSION['domain']; ?>/form?mod=apl-01&sha=<?= $apl['sha_apl01']; ?>")
                    .data('loaded', true);

                $('button[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                    const target = $(e.target).data('target');

                    if (target === '#apl02' && !$('#apl02').data('loaded')) {
                        $('#apl02')
                            .load("<?= $_SESSION['domain']; ?>/form?mod=apl-02&sha=<?= $apl['sha_apl02']; ?>")
                            .data('loaded', true);
                    }

                    if (target === '#approve' && !$('#approve').data('loaded')) {
                        $('#approve')
                            .load("<?= $_SESSION['domain']; ?>/form?mod=apl-02&sub=&act=admin_approve&sha=<?= $apl['sha_apl02']; ?>")
                            .data('loaded', true);
                    }

                });
            });
        </script>



    <?
    }
    elseif ($_GET['act'] == 'admin_approve')
    {
    ?>
        <form method="post" action="<?= $_SESSION['domain']; ?>/proses?mod=apl-02&act=approve" target="inframe">

            <input type="hidden" name="id_apl02" value="<?= $apl['id_apl02']; ?>">

            <div class="form-group">
                <label>Keputusan</label>
                <select name="keputusan" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="form-group">
                <label>Asesor</label>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Asesor</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="asesor-wrapper">
                        <tr>
                            <td>
                                <select name="asesor[]" class="form-control" required>
                                    <option value="">Pilih Asesor</option>
                                    <?php
                                    $q = mysqli_query($conn,"SELECT id, nama FROM m_asessor WHERE id_lsp = '".$_SESSION['id_lsp']."' ORDER BY nama ASC");
                                    while($a=mysqli_fetch_assoc($q)){
                                    ?>
                                        <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                    <?
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-remove-asesor" disabled>&times;</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-secondary btn-sm" id="btn-add-asesor">
                    + Tambah Asesor
                </button>
            </div>
            <script>
                $(function(){

                    $('#btn-add-asesor').on('click', function(){

                        let row = `
                        <tr>
                            <td>
                                <select name="asesor[]" class="form-control" required>
                                    <option value="">Pilih Asesor</option>
                                    <?php
                                    $q = mysqli_query($conn,"SELECT id, nama FROM m_asessor WHERE id_lsp = '".$_SESSION['id_lsp']."' ORDER BY nama ASC");
                                    while($a=mysqli_fetch_assoc($q)){
                                    ?>
                                        <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                                    <?
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-remove-asesor">&times;</button>
                            </td>
                        </tr>
                        `;

                        $('#asesor-wrapper').append(row);
                        updateRemoveButton();
                    });

                    $('#asesor-wrapper').on('click', '.btn-remove-asesor', function(){
                        $(this).closest('tr').remove();
                        updateRemoveButton();
                    });

                    function updateRemoveButton(){
                        let total = $('#asesor-wrapper tr').length;
                        $('.btn-remove-asesor').prop('disabled', total === 1);
                    }

                });
            </script>


            <div class="form-group">
                <label>TUK</label>
                <input type="text" name="tuk" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal Uji Sertifikasi</label>
                <input type="date" name="tgl_uji" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Catatan Admin</label>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">
                Simpan Keputusan
            </button>

        </form>

    <?
    }
}
?>
