<?
if ($sub == "") {

    // data asesi
    $q_reg = mysqli_query($conn,"
        SELECT * FROM sr_registrasi 
        WHERE id = '".$_SESSION['id_user']."' LIMIT 1
    ");
    $data = mysqli_fetch_assoc($q_reg);
?>

<form class="user" method="post" enctype="multipart/form-data"
      action="<?=$_SESSION['domain'];?>/proses?mod=<?= $mod ?>&act=add"
      target="inframe">

    <!-- ================= INFORMASI PENGAJUAN ================= -->
    <h4>FR.APL.01 – Permohonan Sertifikasi Kompetensi</h4>
    <hr>

    <h5>Informasi Pengajuan</h5>
    <div class="row">

        <div class="col-md-6 mb-3">
            Skema Sertifikasi <span class="text-danger">*</span>
            <select id="select_skema" name="id_skema" class="form-control" required>
                <option value="">PILIH</option>
                <?
                    $q_skema = mysqli_query($conn,"SELECT * FROM sk_skema WHERE id_lsp='".$_SESSION['id_lsp']."' ORDER BY skema ASC");
                    while($s = mysqli_fetch_assoc($q_skema)){
                ?>
                    <option value="<?=$s['id'];?>"><?=$s['skema'];?></option>
                <? } ?>
            </select>
        </div>

		<div class="col-md-6 mb-3">
			Klaster <span class="text-danger">*</span>
			<select class="form-control" name="id_klaster" id="select_klaster" required disabled>
				<option value="">Silahkan Pilih Skema Terlebih Dahulu</option>
			</select>
		</div>


        <div class="col-md-6 mb-3">
            Tujuan Asesmen <span class="text-danger">*</span>
            <select name="tujuan_asesmen" class="form-control" required>
                <option value="">PILIH</option>
                <option value="Sertifikasi">Sertifikasi</option>
                <option value="Sertifikasi Ulang">Sertifikasi Ulang</option>
                <option value="Pengakuan Kompetensi Terkini (PKT)">Pengakuan Kompetensi Terkini (PKT)</option>
                <option value="Rekognisi Pembelajaran Lampau">Rekognisi Pembelajaran Lampau</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            Tanggal Pengajuan
            <input type="date" class="form-control"
                   value="<?=date('Y-m-d');?>"
                   readonly>
        </div>
    </div>

    <!-- ================= DATA ASESI ================= -->
    <hr>
    <h5>Data Pribadi Asesi</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            Nama
            <input type="text" class="form-control" value="<?=$data['nama'];?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
            NIK
            <input type="text" class="form-control" value="<?=$data['no_ktp'];?>" readonly>
        </div>

        <div class="col-md-4 mb-3">
            Tempat Lahir
            <input type="text" class="form-control" value="<?=$data['tempat_lahir'];?>" readonly>
        </div>
        <div class="col-md-4 mb-3">
            Tanggal Lahir
            <input type="date" class="form-control" value="<?=$data['tgl_lahir'];?>" readonly>
        </div>
        <div class="col-md-4 mb-3">
            Jenis Kelamin
            <input type="text" class="form-control" value="<?=$data['jenis_kelamin'];?>" readonly>
        </div>
    </div>

	<!-- ================= DATA PEKERJAAN ================= -->
	<hr>
	<h5>Data Pekerjaan</h5>

	<div class="row">
		<div class="col-md-6 mb-3">
			Nama Institusi / Perusahaan
			<input type="text" class="form-control"
				value="<?=$data['nama_institusi'];?>"
				readonly>
		</div>

		<div class="col-md-6 mb-3">
			Jabatan
			<input type="text" class="form-control"
				value="<?=$data['jabatan'];?>"
				readonly>
		</div>

		<div class="col-md-6 mb-3">
			Alamat Kantor
			<textarea class="form-control" rows="3" readonly><?=$data['alamat_kantor'];?></textarea>
		</div>

		<div class="col-md-3 mb-3">
			No. Telp Kantor
			<input type="text" class="form-control"
				value="<?=$data['no_telp_kantor'];?>"
				readonly>
		</div>

		<div class="col-md-3 mb-3">
			Email Kantor
			<input type="text" class="form-control"
				value="<?=$data['email_kantor'];?>"
				readonly>
		</div>
	</div>

    <!-- ================= PERSYARATAN ================= -->
    <hr>
    <h5>Persyaratan</h5>

    <div id="persyaratan-wrapper" class="mb-3 text-muted">
        <i class="text-muted">Silakan pilih klaster terlebih dahulu</i>
    </div>

    <!-- ================= BUKTI PENDUKUNG ================= -->
    <hr>
    <h5>Bukti Pendukung</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="35%">Keterangan Bukti</th>
                <th>File</th>
                <th width="5%"></th>
            </tr>
        </thead>
        <tbody id="bukti-wrapper">
            <tr>
                <td>
                    <input type="text" name="bukti_persyaratan[]" class="form-control" required>
                </td>
                <td>
                    <input type="file" name="file_bukti_persyaratan[]" class="form-control" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-remove-bukti">&times;</button>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary btn-sm mb-3" id="btn-add-bukti">
        <i class="fa fa-plus"></i> Tambah Bukti
    </button>

    <hr>
    <div class="text-left">
        <button type="submit" class="btn btn-success">
            Ajukan APL-01
        </button>
    </div>

</form>

<script>
$('#select_skema').on('change', function () {
	const idSkema = $(this).val();
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

$('#btn-add-bukti').on('click', function () {
    $('#bukti-wrapper').append(`
        <tr>
            <td><input type="text" name="bukti_persyaratan[]" class="form-control"></td>
            <td><input type="file" name="file_bukti_persyaratan[]" class="form-control" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-remove-bukti">&times;</button>
            </td>
        </tr>
    `);
});

$(document).on('click', '.btn-remove-bukti', function () {
    $(this).closest('tr').remove();
});
</script>

<?
}
?>
