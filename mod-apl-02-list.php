<?
if ($sub == "") {

    $columns = array(
        0 => 'id',
        1 => 'nama',
        2 => 'skema',
        3 => 'klaster',
        // 4 => 'tujuan_asesmen',
        4 => 'tgl_pengajuan',
        5 => 'status',
        6 => 'id'
    );

    $where = "";
    if ($_SESSION['hak_akses'] == 'asessi') {
        $where = " AND a1.id_registrasi = '".$_SESSION['id_user']."' ";
    }
    elseif ($_SESSION['hak_akses'] == 'admin_lsp') {
        $where = " AND s.id_lsp = '".$_SESSION['id_lsp']."' ";
    }


    // total data tanpa filter
    $txt_q_count = "SELECT COUNT(a2.id) AS jumlah
        FROM sr_apl02 a2
        JOIN sr_apl01 a1 ON a1.id=a2.id_apl01
        JOIN sk_skema_klaster k ON a1.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
        JOIN sr_registrasi r ON r.id = a1.id_registrasi
        WHERE 1=1 $where";
    $q_count = mysqli_query($conn, $txt_q_count);

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
                s.skema LIKE '%$search%' OR
                k.klaster LIKE '%$search%' OR
                r.nama LIKE '%$search%'
            )
        ";
    }

    // main query dengan filter dan paging
    $txt_query = "";
    $query = mysqli_query($conn, "
        SELECT 
            a2.id,
            a2.sha,
            a1.tujuan_asesmen,
            a1.tgl_pengajuan,
            a2.status,
            s.skema,
            k.klaster,
            r.nama
        FROM sr_apl02 a2
        JOIN sr_apl01 a1 ON a1.id=a2.id_apl01
        JOIN sk_skema_klaster k ON a1.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
        JOIN sr_registrasi r ON r.id = a1.id_registrasi
        WHERE 1=1
        $where
        $keyword
        ORDER BY $order $dir
        LIMIT $limit OFFSET $start
    ");


    // hitung total data setelah difilter
    $qcount = mysqli_query($conn, "
        SELECT COUNT(a.id) AS jumlah
        FROM sr_apl02 a
        JOIN sk_skema_klaster k ON a.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
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
        $textAction = $_SESSION['hak_akses'] == 'asessi' ? 'Edit' : 'View';
        $action="<a href='javascript:void(0)' data-toggle='dropdown'><i class='fas fa-bars fa-sm text-gray-800-50'></i></a>
            <ul class='dropdown-menu'>
                <li><a href='javascript:void(0)' onclick=edit('".$row["sha"]."')>$textAction</a></li>
            </ul>";

        if($row['status']=="draft"){
            $badge_class="secondary";
        } elseif($row['status']=="submitted"){
            $badge_class="info";
        } elseif($row['status']=="verified"){
            $badge_class="primary";
        } elseif($row['status']=="approved"){
            $badge_class="success";
        } elseif($row['status']=="rejected"){
            $badge_class="danger";
        } else {
            $badge_class="dark";
        }

        $nestedData = array();
        $nestedData['no']                = "<center>".$no."</center>";
        $nestedData['nama']              = $row['nama'];
        $nestedData['skema']             = $row['skema'];
        $nestedData['klaster']           = $row['klaster'];
        // $nestedData['tujuan_asesmen']    = $row['tujuan_asesmen'];
        $nestedData['tanggal_pengajuan'] = tgl_indo($row['tgl_pengajuan']);
        $nestedData['status']            = "<span class='badge badge-". $badge_class ."'>".ucfirst($row['status'])."</span>";
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
