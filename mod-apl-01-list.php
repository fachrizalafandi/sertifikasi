<?
if ($sub == "") {

    $columns = array(
        0 => 'id',
        1 => 'skema',
        2 => 'klaster',
        3 => 'tujuan_asesmen',
        4 => 'tgl_pengajuan',
        5 => 'id'
    );

    // total data tanpa filter
    $q_count = mysqli_query($conn, "
        SELECT COUNT(a.id) AS jumlah
        FROM sr_apl01 a
        JOIN sr_registrasi r ON a.id_registrasi = r.id
        WHERE r.id = '".$_SESSION['id_user']."'
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
                s.skema LIKE '%$search%' OR
                k.klaster LIKE '%$search%'
            )
        ";
    }

    // main query dengan filter dan paging
    $query = mysqli_query($conn, "
        SELECT 
            a.id,
            a.sha,
            a.tujuan_asesmen,
            a.tgl_pengajuan,
            a.status,
            s.skema,
            k.klaster
        FROM sr_apl01 a
        JOIN sr_registrasi r ON a.id_registrasi = r.id
        JOIN sk_skema_klaster k ON a.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
        WHERE r.id = '".$_SESSION['id_user']."'
        $keyword
        ORDER BY $order $dir
        LIMIT $limit OFFSET $start
    ");

    // hitung total data setelah difilter
    $qcount = mysqli_query($conn, "
        SELECT COUNT(a.id) AS jumlah
        FROM sr_apl01 a
        JOIN sr_registrasi r ON a.id_registrasi = r.id
        JOIN sk_skema_klaster k ON a.id_klaster = k.id
        JOIN sk_skema s ON k.id_skema_sertifikasi = s.id
        WHERE r.id = '".$_SESSION['id_user']."'
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
        $action = '
            <a href="javascript:void(0)"
            onclick="edit(\''.$row['sha'].'\')"
            class="btn btn-sm btn-primary">
                <i class="fa fa-edit"></i>
            </a>
        ';

        $nestedData = array();
        $nestedData['no']                = "<center>".$no."</center>";
        $nestedData['skema']             = $row['skema'];
        $nestedData['klaster']           = $row['klaster'];
        $nestedData['tujuan_asesmen']            = $row['tujuan_asesmen'];
        $nestedData['tanggal_pengajuan'] = tgl_indo($row['tgl_pengajuan']);
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
