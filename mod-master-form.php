<?
	if($sub=="user-akses")
	{
	   if($sha<>"")
        {
            $query = mysqli_query($conn,"SELECT * FROM m_user_akses where sha='".$sha."'");
            $data = mysqli_fetch_assoc($query);
        }
?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>" target='inframe'>
        <div class="form-group">
            Username
        </div>
        <div class="form-group">
            <input type="text" name='username' class="form-control form-control-user" value="<?=$data["username"];?>" required>
        </div>
        <div class="form-group">
            Nama
        </div>
        <div class="form-group">
            <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["nama"];?>" required>
        </div>
        <div class="form-group">
            Hak Akses
        </div>
        <div class="form-group">
            <select class='form-control' name='hak_akses'>
                <option value=''>PILIH</option>
                <option value='administrator' <?if($data["hak_akses"]=="administrator"){echo "selected";}?>>Administrator</option>
                <option value='admin_lsp' <?if($data["hak_akses"]=="admin_lsp"){echo "selected";}?>>Admin LSP</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
	}
    else if($sub=="tuk")
    {
       if($sha<>"")
        {
            $query = mysqli_query($conn,"SELECT * FROM m_tuk where sha='".$sha."'");
            $data = mysqli_fetch_assoc($query);
        }
?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>" target='inframe'>
        <div class="form-group">
            Nama TUK
        </div>
        <div class="form-group">
            <input type="text" name='nama_tuk' class="form-control form-control-user" value="<?=$data["nama_tuk"];?>" required>
        </div>
        <div class="form-group">
            Alamat
        </div>
        <div class="form-group">
            <textarea name='alamat' class='form-control' rows="5" required><?=$data["alamat"];?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
    }
    else if($sub=="asessor")
    {
       if($sha<>"")
        {
            $query = mysqli_query($conn,"SELECT * FROM m_asessor where sha='".$sha."'");
            $data = mysqli_fetch_assoc($query);
        }
?>
    <form class="user" method="post" action="<?=$_SESSION['domain'];?>/proses?mod=<?=$mod;?>&sub=<?=$sub;?>&act=add&sha=<?=$data["sha"];?>" target='inframe'>
        <div class="form-group">
            MET
        </div>
        <div class="form-group">
            <input type="text" name='met' class="form-control form-control-user" value="<?=$data["met"];?>" required>
        </div>
        <div class="form-group">
            Nama
        </div>
        <div class="form-group">
            <input type="text" name='nama' class="form-control form-control-user" value="<?=$data["nama"];?>" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value='Simpan'>
        </div>
    </form>
<?
    }
?>