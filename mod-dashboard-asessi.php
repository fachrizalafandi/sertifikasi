<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Pengajuan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Sertifikat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">253</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-0">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Sertifikasi</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width='5%'>No.</th>
                                                    <th width='15%'>Tanggal</th>
                                                    <th width='25%'>Skema</th>
                                                    <th width='*'>Klaster</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                    $q_jadwal = mysqli_query($conn,"select * from sk_skema_uk where id_klaster='".$data["id"]."'");
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
                                                    <td><?=$uk["unit_kompetensi"];?></td>
                                                </tr>
                                                <?
                                                        }
                                                    }
                                                    else
                                                    {
                                                ?>
                                                <tr>
                                                    <td colspan='4' align='center'><br>Belum Ada Jadwal<br><br></td>
                                                </tr>
                                                <?
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>