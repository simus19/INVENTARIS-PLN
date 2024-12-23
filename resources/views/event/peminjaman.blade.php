@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Peminjaman</h1>

<div class="row">
  <div class="col-12">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col-6">
                      <h6 class="mt-2 font-weight-bold text-primary">Data Peminjaman</h6>
                  </div>
                  <div class="col-6">
                      <div class="text-right">
                        <button class="btn btn-primary" id="btn-create">
                            <i class="icon fas fa-plus pr-1"></i>Pinjam Barang</button>
                      </div>
                  </div>
                </div>
          </div>
          <div class="card-body">
              <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr >
                          <th>Nama Kegiatan</th>
                          <th>Nama Peminjam</th>
                          <th>Tanggal Peminjaman</th>
                          <th>Tanggal Pengembalian</th>
                          <th>Lokasi Peminjam</th>
                          <th>Kebutuhan Hardware</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                        <th>Nama Kegiatan</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Lokasi Peminjam</th>
                        <th>Kebutuhan Hardware</th>
                        <th>Aksi</th>
                      </tr>
                  </tfoot>
              </table>
          </div>
      </div>
  </div>
</div>
@endsection 
@push('scripts')
<!-- Page level plugins -->
  <script src="{{ url('') }}/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/@zxing/library@latest"></script>
  <script>
    // Konfigurasi DataTable
    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('events/peminjaman/datatable') }}"
            },
            columns: [
                { data: 'nama_kegiatan', name: 'nama_kegiatan' },
                { data: 'nama_peminjam', name: 'nama_peminjam' },
                { data: 'tanggal_peminjaman', name: 'tanggal_peminjaman' },
                { data: 'tanggal_pengembalian', name: 'tanggal_pengembalian' },
                { data: 'lokasi_peminjam', name: 'lokasi_peminjam' },
                { data: 'kebutuhan_hardware', name: 'kebutuhan_hardware' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[0, 'asc']]
        });
    });
</script>


<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_kegiatan" class="control-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="">
                </div>
                <div class="form-group">
                    <label for="nama_peminjam" class="control-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" placeholder="">
                </div>
                <div class="form-group">
                    <label for="tanggal_peminjaman" class="control-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" placeholder="">
                </div>
                <div class="form-group">
                    <label for="tanggal_pengembalian" class="control-label">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" placeholder="">
                </div>
                <div class="form-group">
                    <label for="lokasi_peminjam" class="control-label">Lokasi Peminjam</label>
                    <input type="text" class="form-control" id="lokasi_peminjam" name="lokasi_peminjam" placeholder="">
                </div>
                <div class="form-group">
                    <label for="kebutuhan_hardware" class="control-label">Kebutuhan Hardware</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="kebutuhan_hardware" name="kebutuhan_hardware" placeholder="Hasil scan QR akan muncul di sini">
                        <button type="button" id="scan-qr" class="btn btn-info">Scan QR Code</button>
                    </div>
                    <div id="hardware-list" class="mt-2"></div>
                </div>
                
                <!-- Video untuk menampilkan kamera -->
                <video id="video" style="width: 100%" autoplay></video>

                <!-- Canvas untuk tangkapan layar (disembunyikan) -->
                <canvas id="capture-canvas" style="display: none;"></canvas>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="store"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
</div>
  
<script>
     // Handle Create Button
     $('body').on('click', '#btn-create', function () {
        $('#modal-create').modal('show');
    });

    // Inisialisasi daftar hardware
    let hardwareList = [];

    document.addEventListener('DOMContentLoaded', () => {
        const scanQrButton = document.getElementById('scan-qr');
        const hardwareListDiv = document.getElementById('hardware-list');
        const kebutuhanHardwareInput = document.getElementById('kebutuhan_hardware');
        const videoContainer = document.createElement('div'); // Container untuk elemen video
        const video = document.createElement('video'); // Elemen video untuk stream kamera
        const stopCameraButton = document.createElement('button'); // Tombol untuk menghentikan kamera
        let codeReader = new ZXing.BrowserQRCodeReader();
        let stream;

        // Atur video container dan tambahkan ke halaman
        videoContainer.style.position = 'relative';
        videoContainer.style.width = '100%';
        videoContainer.style.maxWidth = '500px';
        videoContainer.style.margin = '0 auto';
        videoContainer.style.textAlign = 'center';
        videoContainer.setAttribute('id', 'video-container');

        video.style.width = '100%';
        video.style.border = '1px solid #ccc';
        video.style.display = 'none';
        video.setAttribute('id', 'vidio');

        stopCameraButton.textContent = 'Hentikan Kamera';
        stopCameraButton.className = 'btn btn-danger mt-2';
        stopCameraButton.style.display = 'none';
        stopCameraButton.addEventListener('click', stopCamera);

        videoContainer.appendChild(video);
        videoContainer.appendChild(stopCameraButton);
        document.body.appendChild(videoContainer);

        // Fungsi untuk memulai kamera dan memindai QR
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                video.style.display = 'block';
                stopCameraButton.style.display = 'block';
                video.play();

                const codeReader = new ZXing.BrowserQRCodeReader();
                codeReader.decodeOnceFromVideoDevice(undefined, 'video')
                .then(result => {
                if (result && result.text) {
                    try {
                        // Parsing hasil QR Code sebagai JSON
                        const qrData = JSON.parse(result.text);

                        // Pastikan data memiliki ID dan jenis_hardware
                        if (qrData.id && qrData.jenis_hardware) {
                            console.log('Hasil QR Code:', qrData);
                            
                            // Tambahkan ke daftar hardware
                            const hardwareItem = `${qrData.jenis_hardware}, ${qrData.merk_hardware}, ${qrData.serial_number}`;
                            hardwareList.push(hardwareItem);

                            // Perbarui tampilan daftar hardware
                            updateHardwareList();
                        } else {
                            console.error('Data QR Code tidak valid:', qrData);
                            Swal.fire({
                                title: 'Error',
                                text: 'QR Code tidak berisi data ID atau jenis hardware yang valid.',
                                icon: 'error',
                            });
                        }
                    } catch (e) {
                        console.error('Gagal memproses QR Code:', e);
                        Swal.fire({
                            title: 'Error',
                            text: 'QR Code tidak berisi format JSON yang valid.',
                            icon: 'error',
                        });
                    }
                }
                stopCamera();
                codeReader.reset();
                $('#qr-modal').modal('hide');
            })
            .catch(err => {
                console.error('Error saat memindai QR Code:', err);
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal memindai QR Code. Silakan coba lagi.',
                    icon: 'error',
                });
            });

            } catch (error) {
                console.error('Tidak dapat mengakses kamera:', error);
                alert('Mohon izinkan akses kamera pada browser Anda.');
            }
        }

        // Fungsi untuk menghentikan kamera
        function stopCamera() {
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                video.style.display = 'none';
                stopCameraButton.style.display = 'none';
            }
        }

        // Fungsi untuk memperbarui daftar hardware
        function updateHardwareList() {
            hardwareListDiv.innerHTML = '';
            hardwareList.forEach((item, index) => {
                hardwareListDiv.innerHTML += `<p>${index + 1}. ${item}</p>`;
            });
            kebutuhanHardwareInput.value = JSON.stringify(hardwareList);
        }

        // Event Listener untuk tombol scan QR
        scanQrButton.addEventListener('click', () => {
            startCamera(); // Mulai kamera dan pindai QR
        });
    

    // Tombol Simpan Data
$('#store').on('click', function (e) {
    e.preventDefault();

    // Mengambil data dari form input
    let data = {
        nama_kegiatan: $('#nama_kegiatan').val(),
        nama_peminjam: $('#nama_peminjam').val(),
        tanggal_peminjaman: $('#tanggal_peminjaman').val(),
        tanggal_pengembalian: $('#tanggal_pengembalian').val(),
        lokasi_peminjam: $('#lokasi_peminjam').val(),
        kebutuhan_hardware: $('#kebutuhan_hardware').val(),
        _token: $("meta[name='csrf-token']").attr("content"),
    };

    // Validasi input sebelum mengirim data
    if (!data.nama_kegiatan || !data.nama_peminjam || !data.tanggal_peminjaman || 
        !data.tanggal_pengembalian || !data.lokasi_peminjam || !data.kebutuhan_hardware) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Semua kolom harus diisi!',
        });
        return;
    }

       // Mengirim data melalui AJAX
    $.ajax({
        url: '{{ url("events/peminjaman/store") }}',
        type: 'POST',
        data: data,
        success: function (response) {
            Swal.fire({
                icon: response.icon,
                title: response.title,
                text: response.text,
                timer: 3000,
                showConfirmButton: false,
            });

            // Reset form setelah berhasil disimpan
            $('#nama_kegiatan').val('');
            $('#nama_peminjam').val('');
            $('#tanggal_peminjaman').val('');
            $('#tanggal_pengembalian').val('');
            $('#lokasi_peminjam').val('');
            $('#kebutuhan_hardware').val('');

            // Tutup modal
            $('#modal-create').modal('hide');

            // Reload tabel data
            $('#dataTable').DataTable().ajax.reload();
        },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.kebutuhan_hardware?.[0]) { 
                toastr.error(error.responseJSON.kebutuhan_hardware[0]);
              }
              if (error.responseJSON.lokasi_peminjam?.[0]) { 
                toastr.error(error.responseJSON.lokasi_peminjam[0]);
              }
              if (error.responseJSON.tanggal_pengembalian?.[0]) { 
                toastr.error(error.responseJSON.tanggal_pengembalian[0]);
              }
              if (error.responseJSON.tanggal_peminjaman?.[0]) { 
                toastr.error(error.responseJSON.tanggal_peminjaman[0]);
              }
              if (error.responseJSON.nama_peminjam?.[0]) { 
                toastr.error(error.responseJSON.nama_peminjam[0]);
              }
              if (error.responseJSON.nama_kegiatan?.[0]) { 
                toastr.error(error.responseJSON.nama_kegiatan[0]);
              }
            }
        });
    });
    });
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan_edit" name="nama_kegiatan" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="nama_peminjam_edit" name="nama_peminjam" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_peminjaman_edit" name="tanggal_peminjaman" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian_edit" name="tanggal_pengembalian" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Lokasi Peminjam</label>
                    <input type="text" class="form-control" id="lokasi_peminjam_edit" name="lokasi_peminjam" placeholder="">
                </div>
                <div class="form-group">
                    <label for="kebutuhan_hardware_edit" class="control-label">Kebutuhan Hardware</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="kebutuhan_hardware_edit" name="kebutuhan_hardware" placeholder="Hasil scan QR akan muncul di sini">
                        <button type="button" id="scan-qr_edit" class="btn btn-info">Scan QR Code</button>
                    </div>
                    <div id="hardware-list" class="mt-2"></div>
                </div>

                <!-- Video untuk menampilkan kamera -->
                <video id="video-edit" style="width: 100%; display: none;" autoplay></video>
                <!-- Canvas untuk tangkapan layar (disembunyikan) -->
                <canvas id="capture-canvas" style="display: none;"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="update"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
  </div>


  <script>
    $(document).ready(function () {
    let hardwareList = [];

    // Event tombol edit
    $('body').on('click', '#btn-edit', function () {
        let data_id = $(this).data('id');
        $.ajax({
            url: `{{ url('events/peminjaman/show/${data_id}') }}`,
            type: "GET",
            cache: false,
            success: function (response) {
                $('#peminjamans_id').val(response.data.id);
                $('#nama_kegiatan_edit').val(response.data.nama_kegiatan);
                $('#nama_peminjam_edit').val(response.data.nama_peminjam);
                $('#tanggal_peminjaman_edit').val(response.data.tanggal_peminjaman);
                $('#tanggal_pengembalian_edit').val(response.data.tanggal_pengembalian);
                $('#lokasi_peminjam_edit').val(response.data.lokasi_peminjam);
                $('#kebutuhan_hardware_edit').val(response.data.kebutuhan_hardware);
                hardwareList = JSON.parse(response.data.kebutuhan_hardware || '[]');
                updateHardwareList();
            }
        });

        $('#modal-edit').modal('show');
    }); 

    // Tombol update
    $('#update').click(function (e) {
        e.preventDefault();
        let peminjamans_id = $('#peminjamans_id').val();
        let nama_kegiatan = $('#nama_kegiatan_edit').val();
        let nama_peminjam = $('#nama_peminjam_edit').val();
        let tanggal_peminjaman = $('#tanggal_peminjaman_edit').val();
        let tanggal_pengembalian = $('#tanggal_pengembalian_edit').val();
        let lokasi_peminjam = $('#lokasi_peminjam_edit').val();
        let kebutuhan_hardware = $('#kebutuhan_hardware_edit').val();
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: `{{ url('events/peminjaman/update/${peminjamans_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'nama_kegiatan': nama_kegiatan,
                'nama_peminjam': nama_peminjam,
                'tanggal_peminjaman': tanggal_peminjaman,
                'tanggal_pengembalian': tanggal_pengembalian,
                'lokasi_peminjam': lokasi_peminjam,
                'kebutuhan_hardware': kebutuhan_hardware,
                '_token': token,
            },
            success: function (response) {
                Swal.fire({
                    icon: `${response.icon}`,
                    title: `${response.title}`,
                    text: `${response.text}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
                console.error(error);
                for (let key in error.responseJSON) {
                    if (error.responseJSON[key]?.[0]) {
                        toastr.error(error.responseJSON[key][0]);
                    }
                }
            }
        });
    });

    // document.addEventListener('DOMContentLoaded', () => {
    //     const scanQrButton = document.getElementById('scan-qr');
    //     const hardwareListDiv = document.getElementById('hardware-list');
    //     const kebutuhanHardwareInput = document.getElementById('kebutuhan_hardware');
    //     const videoContainer = document.createElement('div'); // Container untuk elemen video
    //     const video = document.createElement('video'); // Elemen video untuk stream kamera
    //     const stopCameraButton = document.createElement('button'); // Tombol untuk menghentikan kamera
    //     let codeReader = new ZXing.BrowserQRCodeReader();
    //     let stream;

    // Fungsi untuk memulai kamera dan memindai QR
    async function startCamera() {
        const video = document.getElementById('video-edit');
        const stopCameraButton = document.getElementById('stop-camera');
        let stream;

        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = 'block';
            stopCameraButton.style.display = 'block';
            video.play();

            const codeReader = new ZXing.BrowserQRCodeReader();
            codeReader.decodeOnceFromVideoDevice(undefined, 'video-edit')
                .then(result => {
                    if (result && result.text) {
                                const qrData = JSON.parse(result.text);
                                if (qrData.jenis_hardware) {
                                    const hardwareItem = `${qrData.jenis_hardware}, ${qrData.merk_hardware}, ${qrData.serial_number}`;
                                    if (!hardwareList.includes(hardwareItem)) {
                                        hardwareList.push(hardwareItem);
                                        updateHardwareList();
                                    }
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'QR Code tidak valid.',
                                        icon: 'error'
                                    });
                                }
                            }
                    stopCamera();
                    codeReader.reset();
                    $('#qr-modal').modal('hide');
                })
                .catch(err => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal memindai QR Code. Silakan coba lagi.',
                        icon: 'error',
                    });
                });
        } catch (error) {
            alert('Mohon izinkan akses kamera pada browser Anda.');
        }

        // Fungsi untuk menghentikan kamera
        function stopCamera() {
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                video.style.display = 'none';
                stopCameraButton.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {

    // Fungsi untuk memperbarui daftar hardware
    function updateHardwareList() {
                const hardwareListDiv = document.getElementById('hardware-list').querySelector('div');
                const kebutuhanHardwareInput = document.getElementById('kebutuhan_hardware_edit');
                hardwareListDiv.innerHTML = '';
                hardwareList.forEach((item, index) => {
                    hardwareListDiv.innerHTML += `<p>${index + 1}. ${item}</p>`;
                });
                kebutuhanHardwareInput.value = JSON.stringify(hardwareList);
            }
        });

    // Event Listener untuk tombol scan QR
    $('#scan-qr_edit').click(() => {
                startCamera();
            });
        // });
});

</script>

<script>
  $('body').on('click', '#btn-delete', function () {
  let data_id = $(this).data('id');
  let token   = $("meta[name='csrf-token']").attr("content");
  Swal.fire({
    icon: 'warning',
    title: 'Apakah Kamu Yakin?',
    text: "ingin menghapus data ini!",
    showCancelButton: true,
    cancelButtonText: 'TIDAK',
    confirmButtonText: 'YA, HAPUS!'
  }).then((result) => {
    if (result.isConfirmed) {
      console.log('test');
      //fetch to delete data
      $.ajax({
        url: `{{ url('events/peminjaman/destroy/${data_id}') }}`,
        type: "DELETE",
        cache: false,
        data: {
          "_token": token
        },
        success:function(response){ 
          //show success message
          swal.fire({
            icon: `${response.icon}`,
            title: `${response.title}`,
            text: `${response.text}`,
            showConfirmButton: false,
            timer: 3000
          });
          //remove post on table
          $('#dataTable').DataTable().ajax.reload();
        },
        error: function (error) { 
          console.log(error);
          swal.fire({
            icon: `error`,
            title: `Peminjaman`,
            text: `Data Belum Bisa Dihapus!`,
            showConfirmButton: false,
            timer: 3000
          });
        }
      });          
    }
  })

  });
</script>


@endpush