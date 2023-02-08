<link
      rel="stylesheet"
      href="assets/vendor/libs/apex-charts/apex-charts.css"
    />

<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12">
                  <h4>Dashboard</h4>
                </div>
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="mb-3 row">
                        <label
                          for="html5-date-input"
                          class="col-md-2 col-form-label"
                          >Awal</label
                        >
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="date"
                            value="<?php echo date('Y-m-01'); ?>"
                            id="tanggalAwal"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="mb-3 row">
                        <label
                          for="html5-date-input"
                          class="col-md-2 col-form-label"
                          >Akhir</label
                        >
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="date"
                            value="<?php echo date('Y-m-t'); ?>"
                            id="tanggalAkhir"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-4">
                      <button class="btn btn-primary btn-sm w-100" onclick="getGrafik()">Tampilkan</button>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
             
                      <div class="row">
                        <div div id="chart" style="height: 350px;width: 100%"></div>
                      </div>
                      <div class="row">
                      <div class="col-lg-4 d-flex p-4 pt-3">
                          <div class="avatar flex-shrink-0 me-3 bg-success d-flex align-items-center justify-content-center text-white rounded-circle">
                              <i class="bx bx-wallet"></i>
                            </div>
                            <div>
                              <small class="text-muted d-block">Total Pemasukan </small>
                              <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1" id="totalPemasukan">0</h6>
                                <small class="text-success fw-semibold">
                                </small>
                              </div>
                            </div>
                        </div>
                      
                        <div class="col-lg-4 d-flex p-4 pt-3">
                            <div class="avatar flex-shrink-0 me-3 bg-danger d-flex align-items-center justify-content-center text-white rounded-circle">
                              <i class="bx bx-wallet"></i>
                            </div>
                            <div>
                              <small class="text-muted d-block">Total Pengeluaran </small>
                              <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1" id="totalPengeluaran"></h6>
                                <small class="text-success fw-semibold">
                                </small>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex p-4 pt-3">
                        <div class="avatar flex-shrink-0 me-3 bg-primary d-flex align-items-center justify-content-center text-white rounded-circle">
                              <i class="bx bx-wallet"></i>
                            </div>
                            <div>
                              <small class="text-muted d-block">Total Selisih</small>
                              <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1" id="selisih">0</h6>
                                <small class="text-success fw-semibold">
                            
                                
                                </small>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script>
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
        }).format(number);
      }

      function getGrafik() {
        var tanggalAwal = $("#tanggalAwal").val();
        var tanggalAkhir = $("#tanggalAkhir").val();
        $.ajax({
          url: "<?php echo BASEURL; ?>/dashboard/laporan",
          type: "POST",
          data: {
            tanggalAwal: tanggalAwal,
            tanggalAkhir: tanggalAkhir,
          },
          dataType: "JSON",
          beforeSend: function () {
            $("#chart").html(
              '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
          },
          success: function (data) {
            var labels = [];
            var pemasukan = [];
            var pengeluaran = [];
              $.each(data.grafik, function (key, value) {
                labels.push(value.tanggal);
                pemasukan.push(value.pemasukan);
                pengeluaran.push(value.pengeluaran);
              });
            createGrafik(labels, pemasukan, pengeluaran);
            $("#totalPengeluaran").html(rupiah(data.info.totalPengeluaran));
            $("#totalPemasukan").html(rupiah(data.info.totalPemasukan));
            $("#selisih").html(rupiah(data.info.selisih));
          },
          errors: function (data) {
            alert("error");
            
          },
        });
      }

      $(document).ready(function () {
        getGrafik();
      });
      function  createGrafik(labels, pemasukan, pengeluaran) {
        document.querySelector("#chart").innerHTML = "";
        var options = {
          series: [
            {
              name: "Pemasukan",
              data: pemasukan,
            },
            {
              name: "Pengeluaran",
              data: pengeluaran
            }
          ],
          colors:['#4CAF50','#F44336'],
          chart: {
          type: 'area',
          height: 350,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false,
          style : {
            fontSize: '12px',
            colors: ['#F44336', '#9C27B0']
          }
        },
        stroke: {
          curve: 'straight',
          width: 2
        },
        title: {
          text: 'Laporan Keuangan',
          align: 'left'
        },
        subtitle: {
          text: 'Pemasukan dan Pengeluaran',
          align: 'left'
        },
        labels: labels,
        xaxis: {
          type: 'datetime',
          
        },
        yaxis: {
          opposite: true,
          labels: {
            style: {
              color: '#F44336',
            },
            formatter: function (value) {
              // formatidr
              return rupiah(value);

            }
          },
        },
        legend: {
          horizontalAlign: 'left'
        }
        
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      }
    </script>
       
