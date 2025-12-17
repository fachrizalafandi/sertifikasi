<?
if ($sub == "") {

    // data asesi
    $q_reg = mysqli_query($conn,"
        SELECT * FROM sr_registrasi 
        WHERE id = '".$_SESSION['id_user']."' LIMIT 1
    ");
    $data = mysqli_fetch_assoc($q_reg);

    // cek apakah edit atau tambah baru
    $id_apl01 = 0;
    $data_apl01 = [];
    $bukti_lama = [];

    if (!empty($_GET['sha'])) {
        // MODE EDIT
        if($_SESSION['hak_akses'] == 'asessi'){
            $t = "SELECT * FROM sr_apl01 WHERE sha = '".input($_GET['sha'])."' AND id_registrasi = '".$_SESSION['id_user']."' LIMIT 1";
        } else {
            $t = "SELECT * FROM sr_apl01 WHERE sha = '".input($_GET['sha'])."' LIMIT 1";
        }
        $q = mysqli_query($conn, $t);

        $data_apl01 = mysqli_fetch_assoc($q);

        if (!$data_apl01) {
            echo "<script>parent.swal('Error','Data APL-01 tidak ditemukan','error');</script>";
            exit;
        }

        $id_apl01 = $data_apl01['id'];

        $qb = mysqli_query($conn,"
            SELECT *
            FROM sr_apl01_bukti
            WHERE id_apl01 = '$id_apl01'
            ORDER BY id ASC
        ");

        while ($r = mysqli_fetch_assoc($qb)) {
            $bukti_lama[] = $r;
        }
    }

    $isAsessi = $_SESSION['hak_akses'] == 'asessi' ? true : false;

?>

<form class="user" method="post" enctype="multipart/form-data" action="<?=$_SESSION['domain'];?>/proses?mod=<?= $mod ?>&act=add" target="inframe">

    <input type="hidden" name="sha_apl01" value="<?=$data_apl01['sha'];?>">

    <!-- ================= INFORMASI PENGAJUAN ================= -->
    <h4>FR.APL.01 – Permohonan Sertifikasi Kompetensi</h4>
    <hr>

    <h5>Informasi Pengajuan</h5>
    <div class="row">

        <?
            $q_klaster = mysqli_query($conn,"
                SELECT *
                FROM sk_skema_klaster
                WHERE id = '".$data_apl01['id_klaster']."'
                LIMIT 1");
            $d_klaster = mysqli_fetch_assoc($q_klaster);
        ?>
        <div class="col-md-6 mb-3">
            Skema Sertifikasi <span class="text-danger">*</span>
            <select id="select_skema" name="id_skema" class="form-control" required <?= $isAsessi ? '' : 'disabled' ?>>
                <option value="">PILIH</option>
                <?
                    $q_skema = mysqli_query($conn,"SELECT * FROM sk_skema WHERE id_lsp='".$_SESSION['id_lsp']."' ORDER BY skema ASC");
                    while($s = mysqli_fetch_assoc($q_skema)){
                ?>
                    <option value="<?=$s['id'];?>" <?= $d_klaster['id_skema_sertifikasi'] == $s['id'] ? 'selected' : '' ?>><?=$s['skema'];?></option>
                <? } ?>
            </select>
        </div>

		<div class="col-md-6 mb-3">
			Klaster <span class="text-danger">*</span>
			<select class="form-control" name="id_klaster" id="select_klaster" required <?= $isAsessi ? '' : 'disabled' ?>>
                <option value="">Silahkan Pilih Skema Terlebih Dahulu</option>
                <?
                    $q_klaster_all = mysqli_query($conn,"SELECT * FROM sk_skema_klaster WHERE id_skema_sertifikasi = '".$d_klaster['id_skema_sertifikasi']."'");
                    while($d_klaster_all = mysqli_fetch_assoc($q_klaster_all)){
                ?>
                    <option value="<?=$d_klaster_all['id'];?>" <?= $d_klaster['id'] == $d_klaster_all['id'] ? 'selected' : '' ?>><?=$d_klaster_all['klaster'];?></option>
                <? } ?>
            </select>
		</div>


        <div class="col-md-6 mb-3">
            Tujuan Asesmen <span class="text-danger">*</span>
            <select name="tujuan_asesmen" id="tujuan_asesmen" class="form-control" required <?= $isAsessi ? '' : 'disabled' ?>>
                <option value="">PILIH</option>
                <option value="Sertifikasi" <?= $data_apl01['tujuan_asesmen'] == 'Sertifikasi' ? 'selected' : '' ?>>Sertifikasi</option>
                <option value="Sertifikasi Ulang" <?= $data_apl01['tujuan_asesmen'] == 'Sertifikasi Ulang' ? 'selected' : '' ?>>Sertifikasi Ulang</option>
                <option value="Pengakuan Kompetensi Terkini (PKT)" <?= $data_apl01['tujuan_asesmen'] == 'Pengakuan Kompetensi Terkini (PKT)' ? 'selected' : '' ?>>Pengakuan Kompetensi Terkini (PKT)</option>
                <option value="Rekognisi Pembelajaran Lampau" <?= $data_apl01['tujuan_asesmen'] == 'Rekognisi Pembelajaran Lampau' ? 'selected' : '' ?>>Rekognisi Pembelajaran Lampau</option>
                <option value="Lainnya" <?= $data_apl01['tujuan_asesmen'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            Tanggal Pengajuan
            <input type="date" class="form-control"
                   value="<?= $data_apl01 ? $data_apl01['tgl_pengajuan'] : date('Y-m-d');?>"
                   readonly <?= $isAsessi ? '' : 'disabled' ?>>
        </div>
    </div>

    <!-- ================= DATA ASESI ================= -->
    <hr>
    <h5>Data Pribadi Asesi</h5>

    <?
    if($data_apl01) {
        $q_dprib = mysqli_query($conn,"
            SELECT * FROM sr_registrasi
            WHERE id = '".$data_apl01['id_registrasi']."'
            LIMIT 1");
        $d_prib = mysqli_fetch_assoc($q_dprib);
    }
    ?>

    <div class="row">
        <div class="col-md-6 mb-3">
            Nama
            <input type="text" class="form-control" value="<?= $d_prib['nama'] ? $d_prib['nama'] : $data['nama'] ?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
            NIK
            <input type="text" class="form-control" value="<?= $d_prib['no_ktp'] ? $d_prib['no_ktp'] : $data['no_ktp'] ?>" readonly>
        </div>

        <div class="col-md-4 mb-3">
            Tempat Lahir
            <input type="text" class="form-control" value="<?= $d_prib['tempat_lahir'] ? $d_prib['tempat_lahir'] : $data['tempat_lahir']; ?>" readonly>
        </div>
        <div class="col-md-4 mb-3">
            Tanggal Lahir
            <input type="date" class="form-control" value="<?= $d_prib['tgl_lahir'] ? $d_prib['tgl_lahir'] : $data['tgl_lahir']; ?>" readonly>
        </div>
        <div class="col-md-4 mb-3">
            Jenis Kelamin
            <input type="text" class="form-control" value="<?= $d_prib['jenis_kelamin'] ? $d_prib['jenis_kelamin'] : $data['jenis_kelamin'];?>" readonly>
        </div>
    </div>

	<!-- ================= DATA PEKERJAAN ================= -->
	<hr>
	<h5>Data Pekerjaan</h5>

	<div class="row">
		<div class="col-md-6 mb-3">
			Nama Institusi / Perusahaan
			<input type="text" class="form-control"
				value="<?= $d_prib['nama_institusi'] ? $d_prib['nama_institusi'] : $data['nama_institusi'] ?>"
				readonly>
		</div>

		<div class="col-md-6 mb-3">
			Jabatan
			<input type="text" class="form-control"
				value="<?= $d_prib['jabatan'] ? $d_prib['jabatan'] : $data['jabatan']; ?>"
				readonly>
		</div>

		<div class="col-md-6 mb-3">
			Alamat Kantor
			<textarea class="form-control" rows="3" readonly><?= $d_prib['alamat_kantor'] ? $d_prib['alamat_kantor'] : $data['alamat_kantor']; ?></textarea>
		</div>

		<div class="col-md-3 mb-3">
			No. Telp Kantor
			<input type="text" class="form-control"
				value="<?= $d_prib['no_telp_kantor'] ? $d_prib['no_telp_kantor'] : $data['no_telp_kantor'];?>"
				readonly>
		</div>

		<div class="col-md-3 mb-3">
			Email Kantor
			<input type="text" class="form-control"
				value="<?= $d_prib['email_kantor'] ? $d_prib['email_kantor'] : $data['email_kantor'];?>"
				readonly>
		</div>
	</div>

    <!-- ================= PERSYARATAN ================= -->
    <hr>
    <h5>Persyaratan</h5>

    <div id="persyaratan-wrapper" class="mb-3 text-muted">
        <?
        if($d_klaster['id']) {
        ?>
        <ol>
            <li><?= $d_klaster['persyaratan1'] ?></li>
            <li><?= $d_klaster['persyaratan2'] ?></li>
            <li><?= $d_klaster['persyaratan3'] ?></li>
        </ol>
        <?
        } else {
        ?>
            <i class="text-muted">Silakan pilih klaster terlebih dahulu</i>
        <?
        }
        ?>
    </div>

    <!-- ================= BUKTI PENDUKUNG ================= -->
    <hr>
    <h5>Bukti Pendukung</h5>

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th width="50%">Keterangan Bukti</th>
                <th>File</th>
                <th width="5%"></th>
            </tr>
        </thead>
        <tbody id="bukti-wrapper">
            <? if (!empty($bukti_lama)) { ?>
                <? foreach ($bukti_lama as $b) { ?>
                    <tr class="bukti-item">

                        <!-- SHA bukti lama (PENTING) -->
                        <input type="hidden" name="bukti_lama_sha[]" value="<?=$b['sha'];?>">

                        <td>
                            <input type="text"
                                class="form-control"
                                value="<?=$b['bukti_persyaratan'];?>"
                                readonly>
                        </td>

                        <td class="text-center">
                            <? if ($b['file_bukti_persyaratan']) { ?>
                                <a href="<?= $_SESSION['domain'];?>/data/bukti-apl-01/<?=$b['file_bukti_persyaratan'];?>"
                                target="_blank"
                                class="btn btn-sm btn-outline-info">
                                    Lihat File
                                </a>
                            <? } ?>
                        </td>

                        <td class="text-center">
                            <button type="button"
                                    class="btn btn-danger btn-remove-bukti" <?= $isAsessi ? '' : 'disabled' ?>>
                                &times;
                            </button>
                        </td>
                    </tr>
                <? } ?>
            <? } ?>
            <tr class="bukti-item">
                <td>
                    <input type="text"
                        name="bukti_persyaratan[]"
                        class="form-control"
                        placeholder="Keterangan bukti" required <?= $isAsessi ? '' : 'disabled' ?>>
                </td>
                <td>
                    <input type="file"
                        name="file_bukti_persyaratan[]"
                        class="form-control" required <?= $isAsessi ? '' : 'disabled' ?>>
                </td>
                <td class="text-center">
                    <button type="button"
                            class="btn btn-danger btn-remove-bukti" <?= $isAsessi ? '' : 'disabled' ?>>
                        &times;
                    </button>
                </td>
            </tr>
        </tbody>
    </table>


    <button type="button" class="btn btn-secondary btn-sm mb-3" id="btn-add-bukti" <?= $isAsessi ? '' : 'disabled' ?>>
        <i class="fa fa-plus"></i> Tambah Bukti
    </button>

    <!-- ================= SUBMIT ================= -->
     <?
     if($_SESSION['hak_akses'] == 'asessi'){
     ?>
    <hr>
    <div class="text-left">
        <button type="submit" class="btn btn-success">
            <?
            if($data_apl01){
                echo "Simpan Perubahan APL-01";
            } else {
                echo "Ajukan APL-01";
            }
            ?>
        </button>
    </div>
    <?
    }
    ?>

</form>

<script>

function loadKlaster(id) {
    const idSkema = id;
	const $klaster = $('#select_klaster');

	// reset klaster
	$klaster.prop('disabled', true).html('<option value="">Memuat klaster...</option>');

	if (idSkema === '') {
		$klaster.html('<option value="">Silahkan Pilih Skema Terlebih Dahulu</option>');
		return;
	}


	$.ajax({
		url: "<?= $_SESSION['domain']; ?>/proses",
		type: "GET",
		dataType: "json",
		data: {
			mod: "apl-01",
			act: "load-klaster",
			id_skema: idSkema
		},
		success: function (res) {

			let html = '<option value="">PILIH</option>';

			if (res.length === 0) {
				html = '<option value="">Tidak ada klaster</option>';
			} else {
				$.each(res, function (i, k) {
					html += `<option value="${k.id}">${k.nomor} - ${k.klaster}</option>`;
				});
			}

			$klaster.html(html).prop('disabled', false);
		},
		error: function () {
			swal("Error", "Gagal memuat klaster", "error");
			$klaster.html('<option value="">Error</option>');
		}
	});
}

$('#select_skema').on('change', function () {
	loadKlaster($(this).val());
});

 $('#select_klaster').on('change', function () {
	const idKlaster = $(this).val();

	if (idKlaster === '') {
		$('#persyaratan-wrapper').html(
			'<i class="text-muted">Pilih klaster terlebih dahulu</i>'
		);
		return;
	}
	
	$('#persyaratan-wrapper').html('<i>Memuat persyaratan...</i>');

	$.ajax({
		url: "<?= $_SESSION['domain']; ?>/proses",
		type: "GET",
		dataType: "json",
		data: {
			mod: "apl-01",
			act: "load-persyaratan",
			id_klaster: idKlaster
		},
		success: function (res) {
			if (!res || res.length === 0) {
				$('#persyaratan-wrapper').html(
					'<i class="text-muted">Tidak ada persyaratan</i>'
				);
				return;
			}

			let html = '<ol>';

			res.forEach(function (item) {
				html += `<li>${item}</li>`;
			});

			html += '</ol>';

			$('#persyaratan-wrapper').html(html);
		},
		error: function () {
			$('#persyaratan-wrapper').html(
				'<span class="text-danger">Gagal memuat persyaratan</span>'
			);
		}
	});

});

$('#btn-add-bukti').on('click', function(){
    $('#bukti-wrapper').append(`
        <tr class="bukti-item">
            <td>
                <input type="text"
                        name="bukti_persyaratan[]"
                        class="form-control"
                        placeholder="Keterangan bukti" required>
            </td>
            <td>
                <input type="file"
                        name="file_bukti_persyaratan[]"
                        class="form-control" required>
            </td>
            <td class="text-center">
                <button type="button"
                        class="btn btn-danger btn-remove-bukti">
                    &times;
                </button>
            </td>
        </tr>
    `);
});

$('#bukti-wrapper').on('click','.btn-remove-bukti',function(){
    $(this).closest('tr').remove();
});

$(document).on('click', '.btn-remove-bukti', function () {
    $(this).closest('tr').remove();
});
</script>

<?
}
?>
