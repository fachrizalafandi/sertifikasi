<?
if ($sub == "") {

    $columns = array(
        0 => 'id',
        1 => 'nama',
        2 => 'email',
        3 => 'nama_institusi',
        4 => 'jabatan',
        5 => 'id'
    );

    $where = " AND id_lsp = '".$_SESSION['id_lsp']."' ";

    // total data tanpa filter
    $q_count = mysqli_query($conn, "
        SELECT COUNT(r.id) AS jumlah
        FROM sr_registrasi r
        WHERE 1=1
        $where
    ");


    $datacount     = mysqli_fetch_assoc($q_count);
    $totalData     = $datacount['jumlah'];
    $totalFiltered = $totalData;

    // paging
    $limit  = $_POST['length'];
    $start  = $_POST['start'];
    $order  = $columns[$_POST['order'][0]['column']];
    $dir    = $_POST['order'][0]['dir'];

    $keyword = "";
    if (!empty($_POST['search']['value'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']['value']);
        $keyword = "
            AND (
                nama LIKE '%$search%' OR
                email LIKE '%$search%' OR
                nama_institusi LIKE '%$search%' OR
                jabatan LIKE '%$search%'
            )
        ";
    }

    // main query dengan filter dan paging
    $query = mysqli_query($conn, "
        SELECT 
            id,
            nama,
            email,
            nama_institusi,
            jabatan,
            sha
        FROM sr_registrasi
        WHERE 1=1
        $where
        $keyword
        ORDER BY $order $dir
        LIMIT $limit OFFSET $start
    ");


    // hitung total data setelah difilter
    $qcount = mysqli_query($conn, "
        SELECT COUNT(id) AS jumlah
        FROM sr_registrasi
        WHERE 1=1
        $where
        $keyword
    ");


    $datacount     = mysqli_fetch_assoc($qcount);
    $totalFiltered = $datacount['jumlah'];

    // prepare data
    $data = array();
    $no   = $start + 1;

    while ($row = mysqli_fetch_assoc($query)) {

        // menentukan action berdasarkan status
        $status = $row['status'];
        $textAction = 'View';
        $action="<a href='javascript:void(0)' data-toggle='dropdown'><i class='fas fa-bars fa-sm text-gray-800-50'></i></a>
            <ul class='dropdown-menu'>
                <li><a href='javascript:void(0)' onclick=edit('".$row["sha"]."','view')>$textAction</a></li>
            </ul>";

        $nestedData = array();
        $nestedData['no']                = "<center>".$no."</center>";
        $nestedData['nama']              = $row['nama'];
        $nestedData['email']             = $row['email'];
        $nestedData['nama_institusi']     = $row['nama_institusi'] ? $row['nama_institusi'] : '-';
        $nestedData['jabatan']           = $row['jabatan'] ? $row['jabatan'] : '-';
        $nestedData['action']            = "<center>$action</center>";

        $data[] = $nestedData;
        $no++;
    }

    // output to json format
    echo json_encode(array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    ));
}
?>
