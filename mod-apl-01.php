<?
    if($sub=="")
    {
?>                    
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width='5%'>No.</th>
                                <th width='10%'>Username</th>
                                <th width='10%'>Password</th>
                                <th width='*'>Nama</th>
                                <th width='15%'>Hak Akses</th>
                                <th width='5%'><i class="fas fa-bars fa-sm text-gray-800-50"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(function()
            {
                $('#datatable').DataTable({
                    pageLength : 20,
                    "processing": true,
                    "serverSide": true,
                    "lengthChange": true,
                    "ajax":{
                        "url": "<?=$_SESSION["domain"];?>/list?mod=<?=$mod;?>&sub=<?=$sub;?>",
                        "dataType": "json",
                        "type": "POST"
                    },
                    language : {
                        "processing": "Data Tidak Ditemukan ..."             
                    },
                    "columns": [
                        { "data": "no" },
                        { "data": "username" },
                        { "data": "password" },
                        { "data": "nama" },
                        { "data": "hak_akses" },
                        { "data": "action" },
                        ]  
                });
            });
        </script>
<?
    }
?>