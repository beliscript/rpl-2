<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12">
                  <h4>Transaksi</h4>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-4 mb-4">
                      <button
                        class="btn btn-primary w-100 btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#filterData"
                      >
                        FILTER DATA <i class="bx bx-filter-alt"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-6 mb-4">
                  <button
                    class="btn btn-success w-100 btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahPemasukan"
                  >
                    Tambah Pemasukan <i class="bx bx-money"></i>
                  </button>
                </div>
                <div class="col-6 mb-4">
                  <button
                    class="btn btn-danger w-100 btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahPengeluaran"
                  >
                    Tambah Pengeluaran <i class="bx bx-cart"></i>
                  </button>
                </div>
                <div class="col-12">
                  <div class="alert alert-success text-black ">
                      Informasi :
                      <br>
                      <ul>
                        <li>Untuk menambahkan transaksi pemasukan, silahkan klik tombol <b>Tambah Pemasukan</b></li>
                        <li>Untuk menambahkan transaksi pengeluaran, silahkan klik tombol <b>Tambah Pengeluaran</b></li>
                        <li>Untuk melihat transaksi berdasarkan kategori, silahkan klik tombol <b>Filter Data</b></li>
                        <li>Untuk melihat detail transaksi, silahkan klik <b>judul transaksi</b> atau tombol <b>Detail</b></li>
                      </ul>
                    </div>
                  <div class="card">
                    <h5 class="card-header">
                      Transaksi <i class="bx bx-money"></i>
                    </h5>
                    

                    <div
                      class="table-responsive text-nowrap"
                      style="min-height: 200px"
                    >
                    
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Waktu</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="tableTransaksi">
                          <tr>
                            <td colspan="4" class="text-center">
                              <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            </td>
                        </tbody>
                      </table>
                      <nav aria-label="Page navigation" style="margin: 10px">
                          <ul class="pagination" id="pagination">
                           
                          </ul>
                      </nav>
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>




<div class="col-lg-4 col-md-6">
      <!-- Modal -->
      <div
        class="modal fade"
        id="tambahPemasukan"
        tabindex="-1"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="tambahPemasukanTitle">
                Tambah Pemasukan
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
        
              <div class="row">
                <div class="col-12" id="tambahPemasukanAlert">
                    
              
                </div>
                <div class="col mb-3">
                  <label for="tambahPemasukanJudulTransaksi" class="form-label">Judul</label>
                  <input
                    type="text"
                    id="tambahPemasukanJudulTransaksi"
                    class="form-control"
                    placeholder="Masukan Judul"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPemasukanIdKategori" class="form-label">Kategori</label>
                  <select
                    class="form-select"
                    aria-label="Default select example"
                    id="tambahPemasukanIdKategori"
                  >
                    <option selected>Pilih Kategori</option>
                     <?php 
                         foreach ($data['categories_pemasukan']  as $catPem) {
                            echo "<option value='".$catPem['idKategori']."'>".$catPem['kategori']."</option>";
                         }
                      ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPemasukanJumlah" class="form-label">Jumlah</label>
                  <input
                    type="number"
                    id="tambahPemasukanJumlah"
                    class="form-control"
                    placeholder="Masukan Jumlah"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPemasukanTanggal" class="form-label">Waktu</label>
                  <input
                    type="datetime-local"
                    id="tambahPemasukanTanggal"
                    class="form-control"
                    placeholder="Masukan Waktu"
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
              >
                Batal
              </button>
              <button type="button" id="btntambahPemasukan" onclick="tambahPemasukan()"  class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <!-- Modal -->
      <div
        class="modal fade"
        id="tambahPengeluaran"
        tabindex="-1"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="tambahPengeluaranTitle">
                Tambah Pengeluaran
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
        
              <div class="row">
                <div class="col-12" id="tambahPengeluaranAlert">
                    
              
                </div>
                <div class="col mb-3">
                  <label for="tambahPengeluaranJudulTransaksi" class="form-label">Judul</label>
                  <input
                    type="text"
                    id="tambahPengeluaranJudulTransaksi"
                    class="form-control"
                    placeholder="Masukan Judul"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPengeluaranIdKategori" class="form-label">Kategori</label>
                  <select
                    class="form-select"
                    aria-label="Default select example"
                    id="tambahPengeluaranIdKategori"
                  >
                    <option selected>Pilih Kategori</option>
                     <?php 
                         foreach ($data['categories_pengeluaran']  as $catPeng) {
                            echo "<option value='".$catPeng['idKategori']."'>".$catPeng['kategori']."</option>";
                         }
                      ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPengeluaranJumlah" class="form-label">Jumlah</label>
                  <input
                    type="number"
                    id="tambahPengeluaranJumlah"
                    class="form-control"
                    placeholder="Masukan Jumlah"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="tambahPengeluaranTanggal" class="form-label">Waktu</label>
                  <input
                    type="datetime-local"
                    id="tambahPengeluaranTanggal"
                    class="form-control"
                    placeholder="Masukan Waktu"
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
              >
                Batal
              </button>
              <button type="button" id="btntambahPengeluaran" onclick="tambahPengeluaran()"  class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <!-- Modal -->
      <div class="modal fade" id="filterData" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="filterDataTitle">
                Filter
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="row g-2">
                <div class="col mb-3">
                  <label for="tanggalAwal" class="form-label"
                    >Tanggal Awal</label
                  >
                  <input
                    type="date"
                    id="tanggalAwal"
                    class="form-control"
                    placeholder="xxxx@xxx.xx"
                  />
                </div>
                <div class="col mb-3">
                  <label for="tanggalAkhir" class="form-label"
                    >Tanggal Akhir</label
                  >
                  <input
                    type="date"
                    id="tanggalAkhir"
                    class="form-control"
                    placeholder="DD / MM / YY"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="nameWithTitle" class="form-label">Tipe</label>
                  <select
                    class="form-select"
                    id="filterTipe"
                    aria-label="Default select example"
                  >
                    <option selected value="" >Pilih Tipe</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="filterKategori" class="form-label">Kategori</label>
                  <select
                    class="form-select"
                    aria-label="Default select example"
                    id="filterKategori"
                  >
                    <option value="" selected>Pilih Kategori</option>

                  </select>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
              >
                Batal
              </button>
              <button type="button" class="btn btn-primary" onclick="filterData()">Cari</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <!-- Modal -->
      <div
        class="modal fade"
        id="detailTransaksi"
        tabindex="-1"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="detailTransaksiTitle">
                Detail Transaksi <span id="detailTransaksiID"></span>
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col mb-3">
                  <label for="detailTransaksiJudulTransaksi" class="form-label">Judul</label>
                  <input
                    type="text"
                    id="detailTransaksiJudulTransaksi"
                    class="form-control"
                    placeholder="Masukan Judul"
                    readonly
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="detailTransaksiTipe" class="form-label">Tipe</label>
                  <input type="text" id="detailTransaksiTipe" class="form-control" placeholder="Masukan Tipe" readonly />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="detailTransaksiKategori" class="form-label">Kategori</label>
                  <input type="text" id="detailTransaksiKategori" class="form-control" placeholder="Masukan Kategori" readonly />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="detailTransaksiJumlah" class="form-label">Jumlah</label>
                  <input
                    type="text"
                    id="detailTransaksiJumlah"
                    class="form-control"
                    placeholder="Masukan Jumlah"
                    readonly
                  />
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="detailTransaksiTanggal" class="form-label">Waktu</label>
                  <input
                  
                    id="detailTransaksiTanggal"
                    class="form-control"
                    placeholder="Masukan Waktu"
                    readonly
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
              >
                Tutup
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-lg-4 col-md-6">
<!-- Modal -->
<div
  class="modal fade"
  id="editTransaksi"
  tabindex="-1"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="editTransaksiTitle">
          Perbaharui Transaksi <span id="editTransaksiID"></span>
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-12" id="editAlert">
                    
              
                    </div>
          <div class="col mb-3">
            <label for="editTransaksiJudulTransaksi" class="form-label">Judul</label>
            <input
              type="hidden"
              id="IDTransaksi"
              class="form-control"
              placeholder="Masukan Judul"
            />
            <input
              type="text"
              id="editTransaksiJudulTransaksi"
              class="form-control"
              placeholder="Masukan Judul"
            />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="editTransaksiTipe" class="form-label">Tipe</label>
            <input type="text" id="editTransaksiTipe" class="form-control" placeholder="Masukan Tipe" readonly />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="editTransaksiKategori" class="form-label">Kategori</label>
            <input type="text" id="editTransaksiKategori" class="form-control" placeholder="Masukan Kategori" readonly />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="editTransaksiJumlah" class="form-label">Jumlah</label>
            <input
              type="number"
              id="editTransaksiJumlah"
              class="form-control"
              placeholder="Masukan Jumlah"
            />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="editTransaksiTanggal" class="form-label">Waktu</label>
            <input
              type="datetime-local"
              id="editTransaksiTanggal"
              class="form-control"
              placeholder="Masukan Waktu"
            />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal"
        >
          Tutup
        </button>
        <button
          type="button"
          class="btn btn-warning"
          id="btnEditTransaksi"
          onclick="perbaharuiTransaksi()"
        >
          Perbaharui
       
        </button>
      </div>
    </div>
  </div>
</div>
</div>


<div
  class="modal fade"
  id="hapusTransaksi"
  tabindex="-1"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="hapusTransaksiTitle">
          Hapus Transaksi <span id="hapusTransaksiID"></span>
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-12" id="hapusAlert">
                    
              
                    </div>
          <div class="col mb-3">
            <label for="hapusTransaksiJudulTransaksi" class="form-label">Judul</label>
            <input
              type="hidden"
              id="hapusIdTransaksi"
              class="form-control"
              placeholder="Masukan Judul"
            />
            <input
              type="text"
              readonly
              id="hapusTransaksiJudulTransaksi"
              class="form-control"
              placeholder="Masukan Judul"
            />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="hapusTransaksiTipe" class="form-label">Tipe</label>
            <input type="text" readonly id="hapusTransaksiTipe" class="form-control" placeholder="Masukan Tipe" readonly />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="hapusTransaksiKategori" class="form-label">Kategori</label>
            <input type="text" id="hapusTransaksiKategori" class="form-control" placeholder="Masukan Kategori" readonly />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="hapusTransaksiJumlah" class="form-label">Jumlah</label>
            <input
              type="text"
              id="hapusTransaksiJumlah"
              class="form-control"
              placeholder="Masukan Jumlah"
              readonly
            />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="hapusTransaksiTanggal" class="form-label">Waktu</label>
            <input
            readonly
              type="datetime-local"
              id="hapusTransaksiTanggal"
              class="form-control"
              placeholder="Masukan Waktu"
            />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal"
        >
          Tutup
        </button>
        <button
          type="button"
          class="btn btn-danger"
          onclick="destroyTransaksi()"
        >
          Hapus
       
        </button>
      </div>
    </div>
  </div>
</div>
</div>

      
    <script>
        function deleteData(id) {
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                window.location.href = "<?= BASEURL; ?>/pengeluaran/delete/" + id;
            }
        }

        function createPagination(totalPage, currentPage) {
            var pagination = document.getElementById("pagination");
            pagination.innerHTML = "";
      
         
            if (currentPage == 1) {
                var prev = document.createElement("li");
                prev.setAttribute("class", "page-item prev disabled");
                var prevLink = document.createElement("a");
                prevLink.setAttribute("class", "page-link");
                prevLink.setAttribute("href", "javascript:void(0);");
                var prevIcon = document.createElement("i");
                prevIcon.setAttribute("class", "tf-icon bx bx-chevron-left");
                prevLink.appendChild(prevIcon);
                prev.appendChild(prevLink);
                pagination.appendChild(prev);
            } else {
                var prev = document.createElement("li");
                prev.setAttribute("class", "page-item prev");
                var prevLink = document.createElement("a");
                prevLink.setAttribute("class", "page-link");
                prevLink.setAttribute("href", "javascript:void(0);");
                prevLink.setAttribute("onclick", "tampilData(" + (currentPage - 1) + ")");
                var prevIcon = document.createElement("i");
                prevIcon.setAttribute("class", "tf-icon bx bx-chevron-left");
                prevLink.appendChild(prevIcon);
                prev.appendChild(prevLink);
                pagination.appendChild(prev);
            }

            

            for (let i = 1; i <= totalPage; i++) {
                var page = document.createElement("li");
         
                if (i == currentPage) {
                    page.setAttribute("class", "page-item active");
                } else {
                    page.setAttribute("class", "page-item");
                }
                var pageLink = document.createElement("a");
                pageLink.setAttribute("class", "page-link");
                pageLink.setAttribute("href", "javascript:void(0);");
                pageLink.setAttribute("onclick", "tampilData(" + i + ")");
                pageLink.innerHTML = i;
                page.appendChild(pageLink);
                pagination.appendChild(page);
            }
            if(currentPage == totalPage){
                var next = document.createElement("li");
                next.setAttribute("class", "page-item next disabled");
                var nextLink = document.createElement("a");
                nextLink.setAttribute("class", "page-link");
                nextLink.setAttribute("href", "javascript:void(0);");
                var nextIcon = document.createElement("i");
                nextIcon.setAttribute("class", "tf-icon bx bx-chevron-right");
                nextLink.appendChild(nextIcon);
                next.appendChild(nextLink);
                pagination.appendChild(next);
                return;
            }
            var next = document.createElement("li");
            next.setAttribute("class", "page-item next");
            var nextLink = document.createElement("a");
            nextLink.setAttribute("class", "page-link");
            nextLink.setAttribute("href", "javascript:void(0);");
            nextLink.setAttribute("onclick", "tampilData(" + (currentPage + 1) + ")");
            var nextIcon = document.createElement("i");
            nextIcon.setAttribute("class", "tf-icon bx bx-chevron-right");
            nextLink.appendChild(nextIcon);
            next.appendChild(nextLink);
            pagination.appendChild(next);

        }

        function filterData() {
          tampilData(1);
          $('#filterData').modal('hide');
        }

        const rupiah = (number)=>{
          return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
          }).format(number);
        }

        function detailTransaksi(idTransaksi) {
          $.ajax({
            url: "<?= BASEURL; ?>/transaksi/detail",
            type: "POST",
            dataType: "json",
            data: {
              idTransaksi: idTransaksi,
            },
            dataType: "json",
            success: function (data) {
              data = data.data;
              $('#detailTransaksiJudulTransaksi').val(data.judulTransaksi.charAt(0).toUpperCase() + data.judulTransaksi.slice(1));
              $('#detailTransaksiJumlah').val(rupiah(data.jumlah));
              $('#detailTransaksiTanggal').val(data.tanggal);
              $('#detailTransaksiTipe').val(data.tipe.charAt(0).toUpperCase() + data.tipe.slice(1));
              $('#detailTransaksiKategori').val(data.kategori);
              $('#detailTransaksi').modal('show');
            },
          });
        }

        function editTransaksi(idTransaksi) {
         $.ajax({
            url: "<?= BASEURL; ?>/transaksi/detail",
            type: "POST",
            dataType: "json",
            data: {
              idTransaksi: idTransaksi,
            },
            dataType: "json",
            success: function (data) {
              data = data.data; 
              $('#editTransaksiJudulTransaksi').val(data.judulTransaksi.charAt(0).toUpperCase() + data.judulTransaksi.slice(1));
              $('#editTransaksiJumlah').val(data.jumlah);
              $('#editTransaksiTanggal').val(data.tanggal);
              $('#editTransaksiTipe').val(data.tipe.charAt(0).toUpperCase() + data.tipe.slice(1));
              $('#editTransaksiKategori').val(data.kategori);
              $('#IDTransaksi').val(data.idTransaksi);
              $('#editTransaksi').modal('show');
            },
          });
        }

        function hapusTransaksi(idTransaksi) {

          $.ajax({
            url: "<?= BASEURL; ?>/transaksi/detail",
            type: "POST",
            dataType: "json",
            data: {
              idTransaksi: idTransaksi,
            },
            dataType: "json",
            success: function (data) {
              data = data.data;
              $('#hapusTransaksiJudulTransaksi').val(data.judulTransaksi.charAt(0).toUpperCase() + data.judulTransaksi.slice(1));
              $('#hapusTransaksiJumlah').val(rupiah(data.jumlah));
              $('#hapusTransaksiTanggal').val(data.tanggal);
              $('#hapusTransaksiTipe').val(data.tipe.charAt(0).toUpperCase() + data.tipe.slice(1));
              $('#hapusTransaksiKategori').val(data.kategori);
              $('#hapusIdTransaksi').val(data.idTransaksi);
              $('#IDTransaksi').val(data.idTransaksi);
              $('#hapusTransaksi').modal('show');
            },
            error: function (data) {
              alert(data);
            }
          });
        }

        function destroyTransaksi() {
          let idTransaksi = document.getElementById("hapusIdTransaksi").value;
          $.ajax({
            url: "<?= BASEURL; ?>/transaksi/hapus",
            type: "POST",
            dataType: "json",
            data: {
              idTransaksi: idTransaksi,
            },
            dataType: "json",
            success: function (data) {
              if (data.status == "success") {
                tampilData(1);
                $('#hapusTransaksi').modal('hide');
                alert("Data berhasil dihapus");
              }
            },
            error: function (data) {
              alert(data);
            }
          });
        }

        function perbaharuiTransaksi() {
          let idTransaksi = $('#IDTransaksi').val();
          let judulTransaksi = $('#editTransaksiJudulTransaksi').val();
          let jumlah = $('#editTransaksiJumlah').val();
          let tanggal = $('#editTransaksiTanggal').val();
          tanggal = tanggal.replace("T", " ");
          tanggal = tanggal + ":00";

          $.ajax({
            url: "<?= BASEURL; ?>/transaksi/ubah",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
              document.getElementById("editAlert").innerHTML = "";
              $('#editAlert').append('<div class="alert alert-info text-black"><b>Memproses</b> : <br>Memproses perubahan data transaksi</div>');
              $('#btnEditTransaksi').attr('disabled', 'disabled');
              $('#btnEditTransaksi').html('<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i> Memproses');
            },
            data: {
              idTransaksi: idTransaksi,
              judulTransaksi: judulTransaksi,
              jumlah: jumlah,
              tanggal: tanggal,
            },
            dataType: "json",
            success: function (data) {
              if (data.status == "success") {
                tampilData(1);
                    var alert = document.createElement("div");
                    alert.setAttribute("class", "alert alert-success text-black");
                    alert.innerHTML = "<b>Berhasil</b> : <br>";
                    alert.innerHTML += data.message;
                    $('#editAlert').html("");
                      $('#editAlert').append(alert);
              } else {
                      var alert = document.createElement("div");
                      alert.setAttribute("class", "alert alert-danger text-black");
                      console.log(data.errors);
                      alert.innerHTML = "<b>Gagal! </b><br><ul>";
                      alert.innerHTML += data.message;
          
                      alert.innerHTML += "</ul>";
                      $('#editAlert').html("");
                      $('#editAlert').append(alert);
              }
            },
            error: function (data) {
              alert(data);
            },
            complete: function () {
              $('#btnEditTransaksi').removeAttr('disabled');
              $('#btnEditTransaksi').html('Perbaharui');
            }
          });



        }

        function tambahPemasukan() {
          let judulTransaksi = $('#tambahPemasukanJudulTransaksi').val();
          let jumlah = $('#tambahPemasukanJumlah').val();
          let tanggal = $('#tambahPemasukanTanggal').val();
          tanggal = tanggal.replace("T", " ");
          tanggal = tanggal + ":00";

          let idKategori = $('#tambahPemasukanIdKategori').val();

          $.ajax({
             url : "<?= BASEURL; ?>/transaksi/simpan",
              type : "POST",
              dataType : "JSON",
              data : {
                judulTransaksi : judulTransaksi,
                jumlah : jumlah,
                tanggal : tanggal,
                idKategori : idKategori,
                tipe : "pemasukan"
              },
              beforeSend : function() {
                $('#btntambahPemasukan').attr('disabled', true);
                $('#btntambahPemasukan').html('Loading...');
              },
              success : function(data) {
                if (data.status == "success") {
                  tampilData(1);
                  var alert = document.createElement("div");
                  alert.setAttribute("class", "alert alert-success text-black");
                  alert.innerHTML = "<b>Berhasil!</b> <br>";
                  alert.innerHTML += data.message;
                  
                  document.getElementById("tambahPemasukanAlert").innerHTML = "";
                  document.getElementById("tambahPemasukanAlert").appendChild(alert);
                  // kosongkan form
                  $('#tambahPemasukanJudulTransaksi').val("");
                  $('#tambahPemasukanJumlah').val("");
                  $('#tambahPemasukanTanggal').val("");
                  $('#tambahPemasukanIdKategori').selectedIndex = 0;
                  

                } else {
                  var alert = document.createElement("div");
                  alert.setAttribute("class", "alert alert-danger text-black");
                  alert.innerHTML = "<b>Gagal!</b> <br><ul>";
                  alert.innerHTML += data.message;
      
                  alert.innerHTML += "</ul>";
                  document.getElementById("tambahPemasukanAlert").innerHTML = "";
                  document.getElementById("tambahPemasukanAlert").appendChild(alert);
                }
              },
              error : function() {
                alert("Gagal menambahkan data");
              },
              complete : function() {
                $('#btntambahPemasukan').attr('disabled', false);
                $('#btntambahPemasukan').html('Simpan');
              }

          })
        }

        function tambahPengeluaran() {
          let judulTransaksi = $('#tambahPengeluaranJudulTransaksi').val();
          let jumlah = $('#tambahPengeluaranJumlah').val();
          let tanggal = $('#tambahPengeluaranTanggal').val();
          tanggal = tanggal.replace("T", " ");
          tanggal = tanggal + ":00";

          let idKategori = $('#tambahPengeluaranIdKategori').val();


          $.ajax({
             url : "<?= BASEURL; ?>/transaksi/simpan",
              type : "POST",
              dataType : "JSON",
              data : {
                judulTransaksi : judulTransaksi,
                jumlah : jumlah,
                tanggal : tanggal,
                idKategori : idKategori,
                tipe : "pengeluaran"
              },
              beforeSend : function() {
                $('#btntambahPengeluaran').attr('disabled', true);
                $('#btntambahPengeluaran').html('Loading...');
              },
              success : function(data) {
                if (data.status == "success") {
                  tampilData(1);
                  var alert = document.createElement("div");
                  alert.setAttribute("class", "alert alert-success text-black");
                  alert.innerHTML = "<b>Berhasil!</b> <br>";
                  alert.innerHTML += data.message;
                  
                  document.getElementById("tambahPengeluaranAlert").innerHTML = "";
                  document.getElementById("tambahPengeluaranAlert").appendChild(alert);
                  // kosongkan form
                  $('#tambahPengeluaranJudulTransaksi').val("");
                  $('#tambahPengeluaranJumlah').val("");
                  $('#tambahPengeluaranTanggal').val("");
                  $('#tambahPengeluaranIdKategori').selectedIndex = 0;
                  

                } else {
                  var alert = document.createElement("div");
                  alert.setAttribute("class", "alert alert-danger text-black");
                  alert.innerHTML = "<b>Gagal!</b> <br><ul>";
                  alert.innerHTML += data.message;
      
                  alert.innerHTML += "</ul>";
                  document.getElementById("tambahPengeluaranAlert").innerHTML = "";
                  document.getElementById("tambahPengeluaranAlert").appendChild(alert);
                }
              },
              error : function() {
                alert("Gagal menambahkan data");
              },
              complete : function() {
                $('#btntambahPengeluaran').attr('disabled', false);
                $('#btntambahPengeluaran').html('Simpan');
              }

          })
  }

        function tampilData(page){
            var tanggalAwal = $('#tanggalAwal').val();
            var tanggalAkhir = $('#tanggalAkhir').val();
          
            var tipe = $('#filterTipe').val();
            var kategori = $('#filterKategori').val();


            // ajax http request
            var xhr = new XMLHttpRequest();
          
            xhr.open('POST', '<?= BASEURL; ?>/transaksi/tampil', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("tanggalAwal=" + tanggalAwal + "&tanggalAkhir=" + tanggalAkhir + "&tipe=" + tipe+"&page=" + page + "&idKategori=" + kategori);

            // console log result
            xhr.onload = function() {
            //  tableTransaksi
              const tableTransaksi = document.querySelector('#tableTransaksi');
              // kosongkan tabel
              tableTransaksi.innerHTML = '';
              // ambil data dari xhr
              const data = JSON.parse(xhr.responseText);
              // looping data
              let i = data.start+1;
              data.data.forEach(item => {
                // buat element tr
                const tr = document.createElement('tr');
                // buat element td
                const tdId = document.createElement('td');
                const tdJudul = document.createElement('td');
                const tdWaktu = document.createElement('td');
                const tdAksi = document.createElement('td');
                // masukkan td ke tr
                tr.appendChild(tdId);
                tr.appendChild(tdJudul);
                tr.appendChild(tdWaktu);
                tr.appendChild(tdAksi);
                // isi element td
                tdId.innerHTML = i;
                let classBadge = "";
                if(item.tipe == "pemasukan"){
                   classBadge = "badge bg-success";
                } else {
                   classBadge = "badge bg-danger";

                }
                tdJudul.innerHTML = `
                  <span class="${classBadge}"
                    style="cursor: pointer;"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    onclick="detailTransaksi(${item.idTransaksi})"
                  
                  >${item.judulTransaksi}</span>
                `;
                tdWaktu.innerHTML = item.tanggal;
                tdAksi.innerHTML = `<a href="#"
                 onclick="editTransaksi(${item.idTransaksi})"
                class="btn btn-sm btn-warning">
                  <i class="bx bx-edit"></i> Edit
                </a> <a href="javascript:void(0)" onclick="hapusTransaksi(${item.idTransaksi})" class="btn btn-sm btn-danger">
                  <i class="bx bx-trash"></i> Hapus
                </a> <a href="javascript:void(0)" class="btn btn-sm btn-info"
                  onclick="detailTransaksi(${item.idTransaksi})">
                  <i class="bx bx-zoom-in"></i> Detail
                </a>`;
                tableTransaksi.appendChild(tr);
                i++;
              });

              // pagination
              if(data.data.length > 0) {
                createPagination(data.total_pages, data.current_page);
              } else {
                document.getElementById("pagination").innerHTML = "";
                tableTransaksi.innerHTML = "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
              }
            };
        }

        // 
        // tunggu sampai halaman selesai di load
        window.onload = function() {
          tampilData(1);
        }

        // filterTipe
        document.getElementById("filterTipe").addEventListener("change", function(){
            var tipe = document.getElementById("filterTipe").value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= BASEURL; ?>/kategori/cari', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("tipe=" + tipe);

            xhr.onload = function() {
              const data = JSON.parse(xhr.responseText);
              const filterKategori = document.querySelector('#filterKategori');
              filterKategori.innerHTML = '';
              const option = document.createElement('option');
              option.setAttribute("value", "");
              option.innerHTML = "Semua Kategori";
              filterKategori.appendChild(option);
              data.forEach(item => {
                const option = document.createElement('option');
                option.setAttribute("value", item.idKategori);
                option.innerHTML = item.kategori;
                filterKategori.appendChild(option);
              });
              
            };
        });

    </script>
