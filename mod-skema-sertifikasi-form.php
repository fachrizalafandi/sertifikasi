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
            <select class='form-control' name='id_uk' required>
                <option value=''>PILIH</option>
                <?
                    $q_uk = mysqli_query($conn,"select * from sk_skema_uk where id_klaster='".$data["id"]."'");
                    while($uk = mysqli_fetch_assoc($q_uk))
                    {
                ?>
                <option value='<?=$uk["id"];?>'><?=$uk["kode"];?> - <?=$uk["unit_kompetensi"];?></option>
                <?
                    }
                ?>
            </select>
        </div>    
        <div style='border: 1px solid #DEDCDC;padding:20px;border-radius: 5px;'>
            <div class="form-group">
                Elemen 1
            </div>
            <div class="form-group">
                <input type="text" name='elemen[]' class="form-control form-control-user" value="" required>
            </div>
            <div class="form-group">
                Kriteria Unjuk Kerja
                <hr>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-1 mb-2">
                        1
                    </div>
                    <div class="col-md-10 mb-2">
                        <input type="text" name='kuk[]' class="form-control form-control-user" value="" required>
                    </div>
                    <div class="col-md-1 mb-2">
                        <button class='btn btn-danger'>-</button>
                    </div>
                    <div class="col-md-1 mb-2">
                        2
                    </div>
                    <div class="col-md-10 mb-2">
                        <input type="text" name='kuk[]' class="form-control form-control-user" value="" required>
                    </div>
                    <div class="col-md-1 mb-2">
                        <button class='btn btn-danger'>-</button>
                    </div>
                </div>
                <button class='btn btn-secondary'>+</button>  
            </div>
        </div>
        <br>
        <button class='btn btn-secondary'>+ Elemen</button> 
        <br><br>
        <hr>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
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