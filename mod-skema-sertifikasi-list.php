<?
    if($sub=="skema")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'skema',
            5=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(id) as jumlah FROM sk_skema where id_lsp='".$_SESSION["id_lsp"]."'");
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
            $keyword="and (skema LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT * FROM sk_skema WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(id) as jumlah FROM sk_skema WHERE 1 and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

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
                $nestedData['skema'] = $r['skema'];
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
    else if($sub=="klaster")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'skema',
            2 =>'nomor',
            3 =>'klaster',
            4=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(k..id) as jumlah FROM sk_skema s, sk_skema_klaster k where s.id_lsp='".$_SESSION["id_lsp"]."' and s.id=k.id_skema_sertifikasi");
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
            $keyword="and (s.skema LIKE '%$search%' or k.nomor LIKE '%$search%' or k.klaster LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT s.skema,k.* FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and s.id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(k.id) as jumlah FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

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
                if($r["file_skema"]<>"")
                {
                    $file_skema="<a href='".$_SESSION['domain']."/data/".$r["file_skema"]."' target='_blank'><i class='fas fa-download fa-sm text-gray-800-50'></i></a>";
                }
                else
                {
                    $file_skema="";
                }

                if($r["file_uk"]<>"")
                {
                    $file_uk="<a href='".$_SESSION['domain']."/data/".$r["file_uk"]."' target='_blank'><i class='fas fa-download fa-sm text-gray-800-50'></i></a>";
                }
                else
                {
                    $file_uk="";
                }
                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['skema'] = $r['skema'];
                $nestedData['nomor'] = $r['nomor'];
                $nestedData['klaster'] = $r['klaster'];
                $nestedData['file_skema'] = "<center>".$file_skema."</center>";
                $nestedData['file_uk'] = "<center>".$file_uk."</center>";
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
    else if($sub=="unit-kompetensi")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'skema',
            2 =>'nomor',
            3 =>'klaster',
            4=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(k..id) as jumlah FROM sk_skema s, sk_skema_klaster k where s.id_lsp='".$_SESSION["id_lsp"]."' and s.id=k.id_skema_sertifikasi");
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
            $keyword="and (s.skema LIKE '%$search%' or k.nomor LIKE '%$search%' or k.klaster LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT s.skema,k.* FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and s.id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(k.id) as jumlah FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

        $datacount = mysqli_fetch_array($qcount);
        $totalFiltered = $datacount["jumlah"];

        $r = array();
        if($totalFiltered>0)
        {
            $no = $start + 1;
            while ($r = mysqli_fetch_array($query))
            {
                $action="<a href='#' onclick=uk('".$r["sha"]."')><i class='fas fa-edit fa-sm text-gray-800-50'></i></a>";

                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['skema'] = $r['skema'];
                $nestedData['nomor'] = $r['nomor'];
                $nestedData['klaster'] = $r['klaster'];
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
    else if($sub=="elemen-kuk")
    {
        $columns = array
        ( 
            0 =>'id', 
            1 =>'skema',
            2 =>'nomor',
            3 =>'klaster',
            4=> 'id',
        );

        $q_count = mysqli_query($conn,"SELECT count(k.id) as jumlah FROM sk_skema s, sk_skema_klaster k where s.id_lsp='".$_SESSION["id_lsp"]."' and s.id=k.id_skema_sertifikasi");
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
            $keyword="and (s.skema LIKE '%$search%' or k.nomor LIKE '%$search%' or k.klaster LIKE '%$search%')";
        }

        $query = mysqli_query($conn,"SELECT s.skema,k.* FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and s.id_lsp='".$_SESSION["id_lsp"]."' ".$keyword." order by $order $dir LIMIT $limit OFFSET $start");
        $qcount = mysqli_query($conn,"SELECT count(k.id) as jumlah FROM sk_skema s, sk_skema_klaster k WHERE s.id=k.id_skema_sertifikasi and id_lsp='".$_SESSION["id_lsp"]."' ".$keyword."");

        $datacount = mysqli_fetch_array($qcount);
        $totalFiltered = $datacount["jumlah"];

        $r = array();
        if($totalFiltered>0)
        {
            $no = $start + 1;
            while ($r = mysqli_fetch_array($query))
            {
                $detail="<a href='#' onclick=detail('".$r["sha"]."')><i class='far fa-clipboard text-gray-800-50'></i></a>";
                $action="<a href='#' onclick=uk('".$r["sha"]."')><i class='fas fa-edit fa-sm text-gray-800-50'></i></a>";

                $nestedData['no'] = "<center>".number_format($no)."</center>";
                $nestedData['skema'] = $r['skema'];
                $nestedData['nomor'] = "<center>".$r['nomor']."</center>";
                $nestedData['klaster'] = $r['klaster'];
                $nestedData['detail'] = "<center>".$detail."</center>";
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