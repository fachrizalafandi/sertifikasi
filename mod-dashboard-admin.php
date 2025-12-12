<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Asessor</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Asessi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">253</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Uji Sertifikasi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                Sertifikat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">40</div>
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
                        <div class="col-lg-6 mb-0">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Pelaksanaan Sertifikasi</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?
                                      for($a=1;$a<=12;$a++)
                                      {
                                        $query_chart = mysqli_query($conn,"select sum(i.total) as pembayaran from k_ibps i where year(tgl_bayar)='".date(Y)."' and MONTH(tgl_bayar)='".$a."'");
                                        $d_chart = mysqli_fetch_array($query_chart);
                                        $pembayaran[$a]=$d_chart["pembayaran"];   
                                      }
                                    ?>
                                   <canvas id="chart_ibps" height='300px' width="100%"  class="chart-canvas"></canvas>
                                    <script>
                                      var ctx = document.getElementById("chart_ibps");
                                      var myChart1 = new Chart(ctx, {
                                      type: 'bar',
                                      data: {
                                      labels: [<?
                                              for($a=1;$a<=12;$a++)
                                              {
                                                echo '"'.getBulan2($a).'",';
                                              }
                                            ?>],
                                      datasets: [{
                                        label: 'Upload Data',
                                        data: [<?
                                              for($a=1;$a<=12;$a++)
                                              {
                                                echo '"'.rand(10,100).'",';
                                              }
                                            ?>],
                                        backgroundColor: '#ef7f30',
                                          }]
                                        },
                                        options: { 
                                          scales: {
                                          xAxes: [{
                                          barThickness: 5,  // number (pixels) or 'flex'
                                          maxBarThickness: 5 // number (pixels)
                                            }]
                                          }, 
                                          responsive: true,
                                          maintainAspectRatio: false,
                                          legend: {
                                            display: false
                                          }
                                        }
                                      });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-0">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Terbit Sertifikat</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                   <canvas id="chart_iaps" height='300px' width="100%"  class="chart-canvas"></canvas>
                                    <script>
                                      var ctx = document.getElementById("chart_iaps");
                                      var myChart1 = new Chart(ctx, {
                                      type: 'bar',
                                      data: {
                                      labels: [<?
                                              for($a=1;$a<=12;$a++)
                                              {
                                                echo '"'.getBulan2($a).'",';
                                              }
                                            ?>],
                                      datasets: [{
                                        label: 'Kios < 2 Ton',
                                        data: [<?
                                              for($a=1;$a<=12;$a++)
                                              {
                                                echo '"'.rand(10,100).'",';
                                              }
                                            ?>],
                                        backgroundColor: '#ef7f30',
                                          }]
                                        },
                                        options: { 
                                          scales: {
                                          xAxes: [{
                                          barThickness: 5,  // number (pixels) or 'flex'
                                          maxBarThickness: 5 // number (pixels)
                                            }]
                                          }, 
                                          responsive: true,
                                          maintainAspectRatio: false,
                                          legend: {
                                            display: false
                                          }
                                        }
                                      });
                                    </script>
                                </div>
                            </div>
                        </div>

                    </div>