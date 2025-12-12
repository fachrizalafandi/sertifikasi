<?
    if($sub=="skema")
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
                                <th width='*'>Skema</th>
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
                        { "data": "skema" },
                        { "data": "action" },
                        ]  
                });
            });
        </script>
<?
    }
    else if($sub=="klaster")
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
                                <th width='15%'>Skema</th>
                                <th width='25%'>Nomor</th>
                                <th width='*'>Klaster</th>
                                <th width='5%'>File Skema</th>
                                <th width='5%'>File UK</th>
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
                        { "data": "skema" },
                        { "data": "nomor" },
                        { "data": "klaster" },
                        { "data": "file_skema" },
                        { "data": "file_uk" },
                        { "data": "action" },
                        ]  
                });
            });
        </script>
<?
    }
    else if($sub=="unit-kompetensi")
    {
?>          
        <script>
            function uk(sha)
            {
                $(document).ready(function(){
                    $('#window-modal').modal('show');
                    $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha="+sha);
                });
            }
        </script>          
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
                                <th width='15%'>Skema</th>
                                <th width='25%'>Nomor</th>
                                <th width='*'>Klaster</th>
                                <th width='5%'><i class="fas fa-edit fa-sm text-gray-800-50"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("add_data").style.display="none";
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
                        { "data": "skema" },
                        { "data": "nomor" },
                        { "data": "klaster" },
                        { "data": "action" },
                        ]  
                });
            });
        </script>
<?
    }
    else if($sub=="elemen-kuk")
    {
?>          
        <script>
            function uk(sha)
            {
                $(document).ready(function(){
                    $('#window-modal').modal('show');
                    $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&sha="+sha);
                });
            }

            function detail(sha)
            {
                $(document).ready(function(){
                    $('#window-modal').modal('show');
                    $("#content-modal").load("<?=$_SESSION["domain"];?>/form?mod=<?=$mod;?>&sub=<?=$sub;?>&detail=yes&sha="+sha);
                });
            }
        </script>          
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
                                <th width='15%'>Skema</th>
                                <th width='25%'>Nomor</th>
                                <th width='*'>Klaster</th>
                                <th width='5%'><i class="far fa-clipboard text-gray-800-50"></i></th>
                                <th width='5%'><i class="fas fa-edit fa-sm text-gray-800-50"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("add_data").style.display="none";
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
                        { "data": "skema" },
                        { "data": "nomor" },
                        { "data": "klaster" },
                        { "data": "detail" },
                        { "data": "action" },
                        ]  
                });
            });
        </script>
<?
    }
?>