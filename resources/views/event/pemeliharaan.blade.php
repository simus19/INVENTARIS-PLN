@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Pemeliharaan</h1>

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
              <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr >
                          <th>Nama Kegiatan</th>
                          <th>Tanggal Mulai Kegiatan</th>
                          <th>Tanggal Selesai Kegiatan</th>
                          <th>Lokasi</th>
                          <th>Pelaksana</th>
                          <th>Evidence</th>
                          <th>Kebutuhan Hardware</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                          <th>Nama Kegiatan</th>
                          <th>Tanggal Mulai Kegiatan</th>
                          <th>Tanggal Selesai Kegiatan</th>
                          <th>Lokasi</th>
                          <th>Pelaksana</th>
                          <th>Evidence</th>
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

                        codeReader.decodeOnceFromVideoDevice(undefined, video)
            .then(result => {
                if (result && result.text) {
                    try {
                        // Parsing hasil QR Code sebagai JSON
                        const qrData = JSON.parse(result.text);

                        // Pastikan data memiliki ID dan jenis_hardware
                        if (qrData.id && qrData.jenis_hardware) {
                            console.log('Hasil QR Code:', qrData);

                            // Tambahkan ke daftar hardware
                            const hardwareItem = `${qrData.jenis_hardware}`;
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
    });

    // Konfigurasi DataTable
    $(document).ready(function() {
      $('#dataTable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ url('events/pemeliharaan/datatable') }}",
        },
        columns: [
          {data:'nama_kegiatan',name:'nama_kegiatan'},
          {data:'tanggal_mulai_kegiatan',name:'tanggal_mulai_kegiatan'},
          {data:'tanggal_selesai_kegiatan',name:'tanggal_selesai_kegiatan'},
          {data:'lokasi',name:'lokasi'},
          {data:'pelaksana',name:'pelaksana'},
          {data:'evidence',name:'evidence'},
          {data:'kebutuhan_hardware',name:'kebutuhan_hardware'},
          {data:'action',name:'action', orderable: false, searchable: false},
        ],
        order: [[0, 'asc']]
      });
    });
</script>

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Pemeliharaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/upload') }}" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                    <label for="name" class="control-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Tanggal Mulai Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_mulai_kegiatan" name="tanggal_mulai_kegiatan" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Tanggal Selesai Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_selesai_kegiatan" name="tanggal_selesai_kegiatan" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Pelaksana</label>
                    <input type="text" class="form-control" id="pelaksana" name="pelaksana" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Evidence</label>
                    <input type="file" class="form-control" id="evidence" name="evidence" accept=".jpg,.jpeg,.png,.pdf" required placeholder="">
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

    // Fungsi untuk memindai QR Code dan menambahkannya ke kolom Kebutuhan Hardware
    $('#scan-qr').click(function() {
    const codeReader = new ZXing.BrowserQRCodeReader();
    codeReader.decodeOnceFromVideoDevice(undefined, 'video')
        .then(result => {
            try {
                // Parsing hasil QR Code sebagai JSON
                const qrData = JSON.parse(result.text);

                // Validasi apakah data memiliki ID
                if (qrData.id) {
                    let existingValue = $('#kebutuhan_hardware').val();

                    // Tambahkan hanya ID ke kolom kebutuhan hardware
                    $('#kebutuhan_hardware').val(existingValue ? existingValue + ', ' + qrData.id : qrData.id);
                } else {
                    console.error('Data QR tidak valid:', qrData);
                    Swal.fire({
                        title: 'Error',
                        text: 'QR Code tidak berisi ID yang valid.',
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
});


    // Tombol Simpan Data
$('#store').on('click', function (e) {
    e.preventDefault();

    // Mengambil data dari form input
    let data = {
        nama_kegiatan: $('#nama_kegiatan').val(),
        tanggal_mulai_kegiatan: $('#tanggal_mulai_kegiatan').val(),
        tanggal_selesai_kegiatan: $('#tanggal_selesai_kegiatan').val(),
        lokasi: $('#lokasi').val(),
        pelaksana: $('#pelaksana').val(),
        evidence: $('#evidence').val(),
        kebutuhan_hardware: $('#kebutuhan_hardware').val(),
        _token: $("meta[name='csrf-token']").attr("content"),
    };

    // Validasi input sebelum mengirim data
    if (!data.nama_kegiatan || !data.tanggal_mulai_kegiatan || !data.tanggal_selesai_kegiatan || 
        !data.lokasi || !data.pelaksana || !data.evidence || !data.kebutuhan_hardware) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Semua kolom harus diisi!',
        });
        return;
    }

       // Mengirim data melalui AJAX
    $.ajax({
        url: '{{ url("events/pemeliharaan/store") }}',
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
            $('#tanggal_mulai_kegiatan').val('');
            $('#tanggal_selesai_kegiatan').val('');
            $('#lokasi').val('');
            $('#pelaksana').val('');
            $('#evidence').val('');
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
              if (error.responseJSON.evidence?.[0]) { 
                toastr.error(error.responseJSON.evidence[0]);
              }
              if (error.responseJSON.pelaksana?.[0]) { 
                toastr.error(error.responseJSON.pelaksana[0]);
              }
              if (error.responseJSON.lokasi?.[0]) { 
                toastr.error(error.responseJSON.lokasi[0]);
              }
              if (error.responseJSON.tanggal_selesai_kegiatan?.[0]) { 
                toastr.error(error.responseJSON.tanggal_selesai_kegiatan[0]);
              }
              if (error.responseJSON.tanggal_mulai_kegiatan?.[0]) { 
                toastr.error(error.responseJSON.tanggal_mulai_kegiatan[0]);
              }
              if (error.responseJSON.nama_kegiatan?.[0]) { 
                toastr.error(error.responseJSON.nama_kegiatan[0]);
              }
            }
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
                    <input type="date" class="form-control" id="tanggal_selesai_kegiatan_edit" name="tanggal_peminjaman" placeholder="">
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
                    <label for="password" class="control-label">Kebutuhan Hardware</label>
                    <input type="text" class="form-control" id="kebutuhan_hardware_edit" name="kebutuhan_hardware" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="update"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
  </div>


<script>
  $('body').on('click', '#btn-edit', function () {
      let data_id = $(this).data('id');
        $.ajax({
          url: `{{ url('events/peminjaman/show/${data_id}') }}`,
          type: "GET",
          cache: false,
          success: function (response) {
            // console.log(response.data);
            $('#peminjamans_id').val(response.data.id);
            $('#nama_kegiatan_edit').val(response.data.nama_kegiatan);
            $('#nama_peminjam_edit').val(response.data.nama_peminjam);
            $('#tanggal_peminjaman_edit').val(response.data.tanggal_peminajaman);
            $('#tanggal_pengembalian_edit').val(response.data.tanggal_pengembalian);
            $('#lokasi_peminjam_edit').val(response.data.lokasi_peminjam);
            $('#kebutuhan_hardware_edit').val(response.data.processor);
          }
        });
        //open modal
        $('#modal-edit').modal('show');
    });

    $('#update').click(function (e) { 
        e.preventDefault();
        let peminjamans_id = $('#peminjamans_id').val();
        let nama_kegiatan   = $('#nama_kegiatan_edit').val();
        let nama_peminjam   = $('#nama_peminjam_edit').val();
        let tanggal_peminajaman   = $('#tanggal_peminjaman_edit').val();
        let tanggal_pengembalian   = $('#tanggal_pengembalian_edit').val();
        let lokasi_peminjam   = $('#lokasi_peminjam_edit').val();
        let kebutuhan_hardware   = $('#kebutuhan_hardware_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
  
        $.ajax({
            url: `{{ url('events/peminjaman/update/${peminjamans_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'nama_kegiatan': nama_kegiatan,
                'nama_peminjam': nama_peminjam,
                'tanggal_peminajaman': tanggal_peminajaman,
                'tanggal_pengembalian': tanggal_pengembalian,
                'lokasi_peminjam': lokasi_peminjam,
                'kebutuhan_hardware': kebutuhan_hardware,
                '_token': token,
            },
            success: function (response) {
                swal.fire({
                    icon: `${response.icon}`,
                    title: `${response.title}`,
                    text: `${response.text}`,
                    showConfirmButton: false,
                    timer: 3000
                });
  
                //clear form
                $('#nama_kegiatan_edit').val('');
                $('#nama_peminjam_edit').val('');
                $('#tanggal_peminjaman_edit').val('');
                $('#tanggal_pengembalian_edit').val('');
                $('#lokasi_peminjam_edit').val('');
                $('#kebutuhan_hardware_edit').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
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
              if (error.responseJSON.tanggal_peminajaman?.[0]) { 
                toastr.error(error.responseJSON.tanggal_peminajaman[0]);
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



  @endpush