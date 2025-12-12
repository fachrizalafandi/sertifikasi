<?
    if($sub=="user-akses")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'username',
            2=> 'password',
            3=> 'nama',
            4=> 'hak_akses',
            5=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_user_akses where id_lsp='".$_SESSION["id_lsp"]."'");
        $datacount = mysqli_fetch_array($q_count);
  
        $totalData = $datacount["jumlah"];
        $totalFiltered = $totalData; 

        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        if($order=="id")
        {
            $order=$columns[3];
        }
        $dir = $_POST['order']['0']['dir'];

        if($_POST['search']['value']<>"")
        { 
            $search = $_POST['search']['value'];
            $keyword="and (nama LIKE '%$search%' or username LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT * FROM m_user_akses WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_user_akses WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

        $datacount = mysqli_fetch_array($qcount);
        $totalFiltered = $datacount["jumlah"];

        $r = array();
        if($totalFiltered>0)
        {
            $no = $start + 1;
            while ($r = mysqli_fetch_array($query))
            {
                $action="<a href='#' data-toggle='dropdown'><i class='fas fa-bars fa-sm text-gray-800-50'></i></a>
                            <ul class='dropdown-menu'>
                                <li><a href='#' onclick=edit('".$r["sha"]."')>Edit</a></li>
                                <li role='seperator' class='dropdown-divider'></li>
                                <li><a href='#' onclick=del('".$r["sha"]."')>Hapus</a></li>
                            </ul>";

                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['username'] = "<center>".$r['username']."</center>";
                $nestedData['password'] = "<center>".$r['password']."</center>";
                $nestedData['nama'] = $r['nama'];
                $nestedData['hak_akses'] = "<center>".ucwords(str_replace("_"," ",$r['hak_akses']))."</center>";
                $nestedData['action'] = "<center>".$action."</center>";
                $data[] = $nestedData;
                $no++;
            }
        }

        $json_data = array
        (
            "draw"            => intval($_POST['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
                    
        echo json_encode($json_data); 
    }
    else if($sub=="tuk")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'nama_tuk',
            2=> 'alamat',
            3=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_tuk where id_lsp='".$_SESSION["id_lsp"]."'");
        $datacount = mysqli_fetch_array($q_count);
  
        $totalData = $datacount["jumlah"];
        $totalFiltered = $totalData; 

        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        if($order=="id")
        {
            $order=$columns[1];
        }
        $dir = $_POST['order']['0']['dir'];

        if($_POST['search']['value']<>"")
        { 
            $search = $_POST['search']['value'];
            $keyword="and (nama_tuk LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT * FROM m_tuk WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_tuk WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

        $datacount = mysqli_fetch_array($qcount);
        $totalFiltered = $datacount["jumlah"];

        $r = array();
        if($totalFiltered>0)
        {
            $no = $start + 1;
            while ($r = mysqli_fetch_array($query))
            {
                $action="<a href='#' data-toggle='dropdown'><i class='fas fa-bars fa-sm text-gray-800-50'></i></a>
                            <ul class='dropdown-menu'>
                                <li><a href='#' onclick=edit('".$r["sha"]."')>Edit</a></li>
                                <li role='seperator' class='dropdown-divider'></li>
                                <li><a href='#' onclick=del('".$r["sha"]."')>Hapus</a></li>
                            </ul>";

                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['nama_tuk'] = $r['nama_tuk'];
                $nestedData['alamat'] = $r['alamat'];
                $nestedData['action'] = "<center>".$action."</center>";
                $data[] = $nestedData;
                $no++;
            }
        }

        $json_data = array
        (
            "draw"            => intval($_POST['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
                    
        echo json_encode($json_data); 
    }
    else if($sub=="asessor")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'met',
            2 =>'password',
            3=> 'nama',
            4=> 'id'
        );

        $q_count = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_asessor where id_lsp='".$_SESSION["id_lsp"]."'");
        $datacount = mysqli_fetch_array($q_count);
  
        $totalData = $datacount["jumlah"];
        $totalFiltered = $totalData; 

        $limit = $_POST['length'];
        $start = $_POST['start'];
        $order = $columns[$_POST['order']['0']['column']];
        if($order=="id")
        {
            $order=$columns[3];
        }
        $dir = $_POST['order']['0']['dir'];

        if($_POST['search']['value']<>"")
        { 
            $search = $_POST['search']['value'];
            $keyword="and (nama LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT * FROM m_asessor WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(id) as jumlah FROM m_asessor WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

        $datacount = mysqli_fetch_array($qcount);
        $totalFiltered = $datacount["jumlah"];

        $r = array();
        if($totalFiltered>0)
        {
            $no = $start + 1;
            while ($r = mysqli_fetch_array($query))
            {
                $action="<a href='#' data-toggle='dropdown'><i class='fas fa-bars fa-sm text-gray-800-50'></i></a>
                            <ul class='dropdown-menu'>
                                <li><a href='#' onclick=edit('".$r["sha"]."')>Edit</a></li>
                                <li role='seperator' class='dropdown-divider'></li>
                                <li><a href='#' onclick=del('".$r["sha"]."')>Hapus</a></li>
                            </ul>";

                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['met'] = "<center>".$r['met']."</center>";
                $nestedData['password'] = "<center>".$r['password']."</center>";
                $nestedData['nama'] = $r['nama'];
                $nestedData['action'] = "<center>".$action."</center>";
                $data[] = $nestedData;
                $no++;
            }
        }

        $json_data = array
        (
            "draw"            => intval($_POST['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
                    
        echo json_encode($json_data); 
    }
?>