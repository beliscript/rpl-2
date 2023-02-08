<div class="container-xxl flex-grow-1 container-p-y">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-lg-12">
               <h4>Edit Profile</h4>
            </div>
            <div class="col-12" id="alert">
                
            </div>
            <div class="col-12 mb-3">
               <div>
                  <label for="defaultFormControlInput" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" readonly value="<?php echo $data['user']['email'] ?>" />
               </div>
            </div>
            <div class="col-12 mb-3">
               <div>
                  <label for="defaultFormControlInput" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="nama" value="<?php echo $data['user']['nama'] ?>">
               </div>
            </div>
            <div class="col-12 mb-3">
               <div>
                  <label for="limitPengeluaran" class="form-label">Limit Pengeluaran</label> 
                  <input type="text" class="form-control" id="limitPengeluaran" value="<?php echo $data['user']['limitPengeluaran'] ?>">
                  <small class="form-text text-muted">Limit pengeluaran per hari (untuk mengirim notifikasi)</small>
               </div>
            </div>
            <div class="col-12 mb-3">
               <div>
                  <label for="defaultFormControlInput" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password"  placeholder="Password" aria-describedby="defaultFormControlHelp">
                  <div id="defaultFormControlHelp" class="form-text">
                     <i> Masukan password jika ingin mengubah password </i>
                  </div>
               </div>
            </div>
            <div class="col-12 mb-3">
               <div>
                  <label for="defaultFormControlInput" class="form-label">Password Konfirmasi</label>
                  <input type="password" class="form-control" id="password_confirmation" placeholder="Password Konfirmasi" aria-describedby="defaultFormControlHelp">
               </div>
            </div>
            <div class="col-12 mb-0 d-flex justify-content-end">
               <button type="button" onclick="ubahProfile()" class="btn btn-primary pull-right">
               Simpan
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
    function ubahProfile()
     {
        let nama = document.getElementById('nama').value;
        let password = document.getElementById('password').value;
        let password_confirmation = document.getElementById('password_confirmation').value;
        let limitPengeluaran = document.getElementById('limitPengeluaran').value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo BASEURL; ?>/profile/ubah", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("nama=" + nama + "&password=" + password + "&password_confirmation=" + password_confirmation + "&limitPengeluaran=" + limitPengeluaran);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                let alert = document.getElementById('alert');
                alert.innerHTML = '';
                if(data.status =="success") {
                    alert.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<strong>Berhasil!</strong> memperbaharui data<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                } else {
                    alert.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<strong>Peringatan!</strong> <ul>' + data.message +
                        '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';

                }
            }
        }
     }
</script>