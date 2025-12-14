<?
	if($sub=="skema")
	{
	   if($sha<>"")
        {
            $query = mysqli_query($conn,"SELECT * FROM sk_skema where sha='".$sha."'");
            $data = mysqli_fetch_assoc($query);
        }
?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>" target='inframe'>
        <div class="form-group">
            Skema
        </div>
        <div class="form-group">
            <input type="text" name='skema' class="form-control form-control-user" value="<?=$data["skema"];?>" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
	}
    else if($sub=="klaster")
    {
       if($sha<>"")
        {
            $query = mysqli_query($conn,"SELECT * FROM sk_skema_klaster where sha='".$sha."'");
            $data = mysqli_fetch_assoc($query);
        }
?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>" target='inframe' enctype='multipart/form-data'>
        <div class="form-group">
            Skema
        </div>
        <div class="form-group">
            <select class='form-control' name='id_skema_sertifikasi' required>
                <option value=''>PILIH</option>
                <?
                    $q_skema = mysqli_query($conn,"SELECT * FROM sk_skema where id_lsp='".$_SESSION["id_lsp"]."' order by skema");
                    while($skema = mysqli_fetch_assoc($q_skema))
                    {
                ?>
                <option value='<?=$skema["id"];?>' <?if($data["id_skema_sertifikasi"]==$skema["id"]){echo "selected";}?>><?=$skema["skema"];?></option>
                <?
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            Nomor
        </div>
        <div class="form-group">
            <input type="text" name='nomor' class="form-control form-control-user" value="<?=$data["nomor"];?>" required>
        </div>
        <div class="form-group">
            Klaster
        </div>
        <div class="form-group">
            <input type="text" name='klaster' class="form-control form-control-user" value="<?=$data["klaster"];?>" required>
        </div>
        <div class="form-group">
            File Skema ( pdf ) <?if($data["file_skema"]<>""){ echo "<a href='".$_SESSION['domain']."/data/".$data["file_skema"]."' target='_blank'>( Download )</a>";$required=""; }else{$required="required";}?>
        </div>
        <div class="form-group">
            <input type="file" name='file_skema' class="form-control form-control-user" value="" <?=$required;?>>
        </div>
        <div class="form-group">
            File Unit Kompetensi Skema ( pdf ) <?if($data["file_uk"]<>""){ echo "<a href='".$_SESSION['domain']."/data/".$data["file_uk"]."' target='_blank'>( Download )</a>";$required=""; }else{$required="required";}?>
        </div>
        <div class="form-group">
            <input type="file" name='file_uk' class="form-control form-control-user" value="">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
    }
    else if($sub=="unit-kompetensi")
    {
       if($sha<>"")
       {
        $query = mysqli_query($conn,"SELECT s.skema, k.* FROM sk_skema_klaster k, sk_skema s where s.id=k.id_skema_sertifikasi and k.sha='".$sha."'");
        $data = mysqli_fetch_assoc($query);
       }
?>
    <script>
        function edit_uk(sha)
        {
            $(document).ready(function(){
                $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha=<?=$data["sha"];?>&uk="+sha+"");
            });
        }
        
        function del_uk(sha)
        {
            return swal({ title: 'Hapus Data', text: 'Yakin akan menghapus data ?', type: 'info', showCancelButton: true, confirmButtonColor: 'red', confirmButtonText: 'Hapus',   closeOnConfirm: false }, function(){ inframe.location.href='<?=$_SESSION["domain"];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=delete&sha=<?=$data["sha"];?>&uk='+sha; });
        }
    </script>
    <h3><?=$data["skema"];?></h3>
    <spam><?=$data["nomor"];?> - <?=$data["klaster"];?></spam>
    <br><br>
    <div class="table-responsive">
        <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width='5%'>No.</th>
                    <th width='25%'>Kode Unit Kompetensi</th>
                    <th width='*'>Unit Kompetensi</th>
                    <th width='5%'><i class="fas fa-bars fa-sm text-gray-800-50"></i></th>
                </tr>
            </thead>
            <tbody>
                <?
                    $q_uk = mysqli_query($conn,"select * from sk_skema_uk where id_klaster='".$data["id"]."'");
                    $tuk = mysqli_num_rows($q_uk);
                    if($tuk>0)
                    {
                        while($uk = mysqli_fetch_assoc($q_uk))
                        {
                            $no++;
                ?>
                <tr>
                    <td align='center'><?=$no;?></td>
                    <td align='center'><?=$uk["kode"];?></td>
                    <td><?=$uk["unit_kompetensi"];?></td>
                    <td>
                        <a href="#" data-toggle="dropdown"><i class="fas fa-bars fa-sm text-gray-800-50"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick="edit_uk('<?=$uk["sha"];?>')">Edit</a></li>
                                <li role="seperator" class="dropdown-divider"></li>
                                <li><a href="#" onclick="del_uk('<?=$uk["sha"];?>')">Hapus</a></li>
                            </ul>
                    </td>
                </tr>
                <?
                        }
                    }
                    else
                    {
                ?>
                <tr>
                    <td colspan='4' align='center'><br>Data Tidak Ditemukan<br><br></td>
                </tr>
                <?
                    }
                ?>
            </tbody>
        </table>
    </div>
    <hr>
    <?
        if($_GET["uk"]<>"")
        {
            $q_duk = mysqli_query($conn,"select * from sk_skema_uk where sha='".$_GET["uk"]."'");
            $duk = mysqli_fetch_assoc($q_duk);
        }
    ?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>&uk=<?=$duk["sha"];?>" target='inframe'>
        <div class="form-group">
            Kode Unit Kompetensi
        </div>
        <div class="form-group">
            <input type="text" name='kode' class="form-control form-control-user" value="<?=$duk["kode"];?>" required>
        </div>
        <div class="form-group">
            Unit Kompetensi
        </div>
        <div class="form-group">
            <input type="text" name='unit_kompetensi' class="form-control form-control-user" value="<?=$duk["unit_kompetensi"];?>" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
    }
    else if($sub=="elemen-kuk")
    {
       if($sha<>"")
       {
        $query = mysqli_query($conn,"SELECT s.skema, k.* FROM sk_skema_klaster k, sk_skema s where s.id=k.id_skema_sertifikasi and k.sha='".$sha."'");
        $data = mysqli_fetch_assoc($query);
       }
?>
    <h3><?=$data["skema"];?></h3>
    <spam><?=$data["nomor"];?> - <?=$data["klaster"];?></spam>
    <hr>
    <?
        if($_GET["detail"]=="")
        {
    ?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>&uk=<?=$duk["sha"];?>" target='inframe'>
        <div class="form-group">
            Unit Kompetensi
        </div>
        <div class="form-group">
            <? $id_uk_selected = intval($_GET['id_uk'] ?? 0); ?>
            <select class='form-control' name='id_uk' id="select-uk" required>
                <option value=''>PILIH</option>
                <?
                    $q_uk = mysqli_query($conn,"select * from sk_skema_uk where id_klaster='".$data["id"]."'");
                    while($uk = mysqli_fetch_assoc($q_uk))
                    {
                ?>
                <option value='<?=$uk["id"];?>' <? if ($uk["id"] == $id_uk_selected) echo "selected"; ?>><?=$uk["kode"];?> - <?=$uk["unit_kompetensi"];?></option>
                <?
                    }
                ?>
            </select>
        </div>

        <div id="elemen-wrapper" class="opacity-50">
            <div id="elemen-container">

            </div>

            <button type="button" class="btn btn-secondary mt-2 mb-4" id="btn-add-elemen">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Elemen
            </button>
        </div>


        <script>
            $(document).ready(function () {
                
                let elemenIndex = 0; // to track elemen blocks
                let isDirty = false; // to track form changes
                let lastUk  = $("#select-uk").val() || ''; // to track last selected UK

                disableElemen(); // disable initially

                $('#elemen-wrapper').on('input', 'input', function () { // mark form as dirty on any input change
                    isDirty = true;
                });

                function disableElemen() { // disable elemen input fields and buttons
                    $('#elemen-wrapper')
                        .addClass('opacity-50')
                        .find('input, button')
                        .prop('disabled', true);

                    $('#btn-add-elemen').prop('disabled', true);
                }

                function enableElemen() { // enable elemen input fields and buttons
                    $('#elemen-wrapper')
                        .removeClass('opacity-50')
                        .find('input, button')
                        .prop('disabled', false);

                    $('#btn-add-elemen').prop('disabled', false);
                }

                function loadUk(idUk) {
                    if (idUk === '') {
                        disableElemen();
                        $('#elemen-container').html('');
                        return;
                    }

                    enableElemen();

                    const url = "<?= $_SESSION['domain']; ?>/proses"
                        + "?mod=<?= $mod; ?>"
                        + "&sub=<?= $sub; ?>"
                        + "&act=load&id_uk=" + idUk;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function (res) {
                            renderElemen(res);
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            swal("Error", "Gagal memuat data elemen", "error");
                        }
                    });
                }
                
                $("#select-uk").on('focus', function () {
                    lastUk = $(this).val();
                });

                $("#select-uk").on('change', function () {

                    const newUk = $(this).val();

                    // kalau belum ada perubahan → langsung pindah
                    if (!isDirty) {
                        lastUk = newUk;
                        loadUk(newUk);
                        return;
                    }

                    // rollback dulu supaya UI tidak langsung pindah
                    $(this).val(lastUk);

                    swal({
                        title: "Simpan Perubahan?",
                        text: "Perubahan pada Unit Kompetensi sebelumnya belum disimpan.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Simpan",
                        cancelButtonText: "Tidak"
                    }, function (isConfirm) {

                        if (isConfirm) {
                            autoSave(function () {
                                isDirty = false;
                                $("#select-uk").val(newUk);
                                lastUk = newUk;
                                loadUk(newUk);
                            });
                        } else {
                            isDirty = false;
                            $("#select-uk").val(newUk);
                            lastUk = newUk;
                            loadUk(newUk);
                        }
                    });

                });


                function autoSave(callback) {
                    const formData = $('form.user').serialize();

                    $.ajax({
                        url: "<?= $_SESSION['domain']; ?>/proses"
                            + "?mod=<?= $mod; ?>"
                            + "&sub=<?= $sub; ?>"
                            + "&act=add",
                        type: 'POST',
                        data: formData,
                        success: function () {
                            callback();
                        },
                        error: function () {
                            swal("Error", "Gagal menyimpan data", "error");
                        }
                    });
                }

                const selectedUk = $("#select-uk").val();
                if (selectedUk !== '') {
                    $("#select-uk").trigger('change');
                }

                function renderElemen(data) {
                    $('#elemen-container').html('');
                    elemenIndex = 0;

                    if (Object.keys(data).length === 0) {
                        addElemen();
                        return;
                    }

                    $.each(data, function (elemen, kuks) {
                        addElemen(elemen, kuks);
                    });
                }

                function addElemen(elemenVal = '', kukArr = ['']) {
                    elemenIndex++;

                    let elemenHtml = `
                    <div class="elemen-block mb-4"
                        data-elemen="${elemenIndex}"
                        style="border:1px solid #DEDCDC;padding:20px;border-radius:5px;">

                        <div class="form-group">
                            <label>Elemen</label>
                            <input type="text"
                                name="elemen[${elemenIndex}][nama]"
                                class="form-control form-control-user"
                                value="${elemenVal}"
                                required>
                        </div>

                        <div class="form-group">
                            Kriteria Unjuk Kerja
                            <hr>
                        </div>

                        <div class="kuk-wrapper">
                    `;

                    kukArr.forEach((kuk, i) => {
                        elemenHtml += kukRow(elemenIndex, kuk, i);
                    });

                    elemenHtml += `
                        </div>

                        <button type="button"
                                class="btn btn-secondary btn-add-kuk mt-2">
                            <i class="fa fa-plus-circle"></i>
                        </button>

                        <button type="button"
                                class="btn btn-outline-danger btn-remove-elemen mt-2 float-right">
                            <i class="fa fa-minus-circle"></i> Elemen
                        </button>

                        <div style="clear:both"></div>
                    </div>
                    `;

                    $('#elemen-container').append(elemenHtml);
                }

                function kukRow(elemenIdx, val = '', index = 0) {
                    return `
                    <div class="row kuk-item mb-2">
                        <div class="col-md-1 kuk-no">${index + 1}</div>
                        <div class="col-md-10">
                            <input type="text"
                                name="elemen[${elemenIdx}][kuk][]"
                                class="form-control form-control-user"
                                value="${val}"
                                required>
                        </div>
                        <div class="col-md-1">
                            <button type="button"
                                    class="btn btn-danger btn-remove-kuk">
                                <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                    </div>
                    `;
                }

                function updateKukNumber(elemenBlock) {
                    elemenBlock.find('.kuk-item').each(function (index) {
                        $(this).find('.kuk-no').text(index + 1);

                        // disable tombol hapus jika hanya 1
                        if (index === 0 && elemenBlock.find('.kuk-item').length === 1) {
                            $(this).find('.btn-remove-kuk').prop('disabled', true);
                        } else {
                            $(this).find('.btn-remove-kuk').prop('disabled', false);
                        }
                    });
                }

                // ========== TAMBAH ELEMEN ==========
                $('#btn-add-elemen').on('click', function () {
                    isDirty = true;
                    addElemen();
                });

                // ========== HAPUS ELEMEN ==========
                $('#elemen-container').on('click', '.btn-remove-elemen', function () {
                    if ($('.elemen-block').length > 1) {
                        isDirty = true;
                        $(this).closest('.elemen-block').remove();
                    } else {
                        swal("Informasi", "Minimal harus ada satu Elemen Kompetensi", "info");
                    }
                });


                // ========== TAMBAH KUK ==========
                $('#elemen-container').on('click', '.btn-add-kuk', function () {
                    isDirty = true;

                    const elemenBlock = $(this).closest('.elemen-block');
                    const elemenIdx   = elemenBlock.data('elemen');
                    const kukWrapper  = elemenBlock.find('.kuk-wrapper');

                    const index = kukWrapper.find('.kuk-item').length;
                    kukWrapper.append(kukRow(elemenIdx, '', index));

                    updateKukNumber(elemenBlock);
                });

                // ========== HAPUS KUK ==========
                $('#elemen-container').on('click', '.btn-remove-kuk', function () {
                    
                    const elemenBlock = $(this).closest('.elemen-block');
                    const kukWrapper  = elemenBlock.find('.kuk-wrapper');
                    
                    if (kukWrapper.find('.kuk-item').length > 1) {
                        isDirty = true;
                        $(this).closest('.kuk-item').remove();
                        updateKukNumber(elemenBlock);
                    } else {
                        swal(
                            "Informasi",
                            "Minimal harus ada satu Kriteria Unjuk Kerja (KUK)",
                            "info"
                        );
                    }
                });

                // // manipulasi elemen dan kuk -- END
            });
            </script>

        <div class="form-group">
            <input type="submit" class="btn btn-success" id='btn_simpan' value='Simpan'>
        </div>
    </form>
    <?
        }
        else
        {
    ?>
        detail
    <?
        }
    ?>
<?
    }
?>