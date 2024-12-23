@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4"> Hardware</h1>

<div class="row">
  <div class="col-12">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col-6">
                      <h6 class="mt-2 font-weight-bold text-primary">Data Hardware</h6>
                  </div>
                  <div class="col-6">
                      <div class="text-right">
                        <button class="btn btn-primary" id="btn-create">
                            <i class="icon fas fa-plus pr-1"></i>Tambah Data</button>
                      </div>
                  </div>
                </div>
          </div>
          <div class="card-body">
              <table class="table table-bordered table-striped table_responsive" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr >
                          <th>Jenis Hardware</th>
                          <th>Merk Hardware</th>
                          <th>Tipe Hardware</th>
                          <th>Serial Number</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>QR Code</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                          <th>Jenis Hardware</th>
                          <th>Merk Hardware</th>
                          <th>Tipe Hardware</th>
                          <th>Serial Number</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>QR Code</th>
                          <th>Aksi</th>
                      </tr>
                  </tfoot>
              </table>
          </div>
      </div>
  </div>
</div>
@endsection @push('scripts')
<!-- Page level plugins -->
  <script src="{{ url('') }}/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
    //Call the dataTables jQuery plugin
    $(document).ready(function() {
      $('#dataTable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ url('items/hardware/datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'jenis_hardware',name:'jenis_hardware'},
          {data:'merk_hardware',name:'merk_hardware'},
          {data:'tipe_hardware',name:'tipe_hardware'},
          {data:'serial_number',name:'serial_number'},
          {data:'lokasi',name:'lokasi'},
          {data:'status',name:'status'},
          {data:'qr_code',name:'qr_code'},
          {data:'action',name:'action', orderable: false, searchable: false},
        ],
        order: [[0, 'asc']]
      });
    });


    // Event listener untuk tombol cetak QR
$('body').on('click', '.btn-print-qr', function () {
    const qrData = $(this).data('qrcode'); // Ambil data QR dari atribut tombol
    let printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    @page {
                        margin: 0; /* Hilangkan margin default pada halaman cetak */
                    }
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh; /* Penuhi tinggi halaman */
                        margin: 0; /* Hilangkan margin pada body */
                        background-color: white; /* Latar belakang putih */
                    }
                    img {
                        max-width: 100%; /* Pastikan gambar tidak melampaui lebar halaman */
                        max-height: 100%; /* Pastikan gambar tidak melampaui tinggi halaman */
                    }
                    /* Sembunyikan header dan footer cetak */
                    @media print {
                        body::before, body::after {
                            content: none !important;
                        }
                    }
                </style>
            </head>
            <body>
                <img src="${qrData}" alt="QR Code" />
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
});

  </script>


  <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Hardware</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Jenis Hardware</label>
                    <input type="text" class="form-control" id="jenis_hardware" name="jenis_hardware" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Merk Hardware</label>
                    <input type="text" class="form-control" id="merk_hardware" name="merk_hardware" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Tipe Hardware</label>
                    <input type="text" class="form-control" id="tipe_hardware" name="tipe_hardware" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="">
                </div>
                <div class="form-group">
                    <label for="status" class="control-label">Status</label>
                    <select style="width: 100%" class="status form-control form-control-lg" id="status" name="status">
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Standby">Standby</option>
                        <option value="Terpinjam">Terpinjam</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="store"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
  </div>

<script>
 $('body').on('click', '#btn-create', function () {
        //open modal
        $('#modal-create').modal('show');
    });

    $('#store').click(function (e) { 
        e.preventDefault();
        let jenis_hardware   = $('#jenis_hardware').val();
        let merk_hardware   = $('#merk_hardware').val();
        let tipe_hardware   = $('#tipe_hardware').val();
        let serial_number   = $('#serial_number').val();
        let lokasi   = $('#lokasi').val();
        let status   = $('#status').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/hardware/store') }}`,
            type: "POST",
            cache: false,
            data: {
                'jenis_hardware': jenis_hardware,
                'merk_hardware': merk_hardware,
                'tipe_hardware': tipe_hardware,
                'serial_number': serial_number,
                'lokasi': lokasi,
                'status': status,
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
                $('#jenis_hardware').val('');
                $('#merk_hardware').val('');
                $('#tipe_hardware').val('');
                $('#serial_number').val('');
                $('#lokasi').val('');
                $('#status').val('');
  
                //close modal
                $('#modal-create').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.status?.[0]) { 
                toastr.error(error.responseJSON.status[0]);
              }
              if (error.responseJSON.lokasi?.[0]) { 
                toastr.error(error.responseJSON.lokasi[0]);
              }
              if (error.responseJSON.serial_number?.[0]) { 
                toastr.error(error.responseJSON.serial_number[0]);
              }
              if (error.responseJSON.tipe_hardware?.[0]) { 
                toastr.error(error.responseJSON.tipe_hardware[0]);
              }
              if (error.responseJSON.merk_hardware?.[0]) { 
                toastr.error(error.responseJSON.merk_hardware[0]);
              }
              if (error.responseJSON.jenis_hardware?.[0]) { 
                toastr.error(error.responseJSON.jenis_hardware[0]);
              }
            }
        });
    });
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Hardware</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="hardwares_id">
              <div class="form-group">
                  <label for="name" class="control-label">Jenis Hardware</label>
                  <input type="text" class="form-control" id="jenis_hardware_edit" name="jenis_hardware" placeholder="">
              </div>
              <div class="form-group">
                  <label for="email" class="control-label">Merk Hardware</label>
                  <input type="text" class="form-control" id="merk_hardware_edit" name="merk_hardware" placeholder="">
              </div>
              <div class="form-group">
                  <label for="password" class="control-label">Tipe Hardware</label>
                  <input type="text" class="form-control" id="tipe_hardware_edit" name="tipe_hardware" placeholder="">
              </div>
              <div class="form-group">
                  <label for="password" class="control-label">Serial Number</label>
                  <input type="text" class="form-control" id="serial_number_edit" name="serial_number" placeholder="">
              </div>
              <div class="form-group">
                  <label for="password" class="control-label">Lokasi</label>
                  <input type="text" class="form-control" id="lokasi_edit" name="lokasi" placeholder="">
              </div>
              <div class="form-group">
                    <label for="status" class="control-label">Status</label>
                    <select style="width: 100%" class="status form-control form-control-lg" id="status_edit" name="status">
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Standby">Standby</option>
                        <option value="Terpinjam">Terpinjam</option>
                        <option value="Rusak">Rusak</option>
                    </select>
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
    let data_id = $(this).data('id'); // Ambil ID dari tombol yang diklik
    
    $.ajax({
        url: `{{ url('items/hardware/show/${data_id}') }}`, // Endpoint untuk menampilkan data detail
        type: "GET",
        cache: false,
        success: function (response) {
            if (response.data) {
                // Isi data ke dalam modal form edit
                $('#hardwares_id').val(response.data.id);
                $('#jenis_hardware_edit').val(response.data.jenis_hardware);
                $('#merk_hardware_edit').val(response.data.merk_hardware);
                $('#tipe_hardware_edit').val(response.data.tipe_hardware);
                $('#serial_number_edit').val(response.data.serial_number);
                $('#lokasi_edit').val(response.data.lokasi);

                // Pilih status sesuai data yang diterima
                $('#status_edit').val(response.data.status);

                // Tampilkan modal edit
                $('#modal-edit').modal('show');
            } else {
                // Jika data tidak ditemukan
                swal.fire({
                    icon: 'error',
                    title: 'Data tidak ditemukan',
                    text: 'Data hardware tidak tersedia.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        },
        error: function (error) {
            // Handle error jika gagal load data
            console.log(error);
            swal.fire({
                icon: 'error',
                title: 'Gagal memuat data',
                text: 'Terjadi kesalahan saat mengambil data hardware.',
                showConfirmButton: true
            });
        }
    });
});

// Event saat tombol update ditekan
$('#update').click(function (e) {
    e.preventDefault();
    let hardwares_id = $('#hardwares_id').val();
    let jenis_hardware = $('#jenis_hardware_edit').val();
    let merk_hardware = $('#merk_hardware_edit').val();
    let tipe_hardware = $('#tipe_hardware_edit').val();
    let serial_number = $('#serial_number_edit').val();
    let lokasi = $('#lokasi_edit').val();
    let status = $('#status_edit').val();
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: `{{ url('items/hardware/update/${hardwares_id}') }}`, // Endpoint untuk update data
        type: "PUT",
        cache: false,
        data: {
            'jenis_hardware': jenis_hardware,
            'merk_hardware': merk_hardware,
            'tipe_hardware': tipe_hardware,
            'serial_number': serial_number,
            'lokasi': lokasi,
            'status': status,
            '_token': token,
        },
        success: function (response) {
            if (response.success) {
                swal.fire({
                    icon: response.icon,
                    title: response.title,
                    text: response.text,
                    timer: 3000,
                    showConfirmButton: false
                });

                // Reset form modal edit
                $('#jenis_hardware_edit').val('');
                $('#merk_hardware_edit').val('');
                $('#tipe_hardware_edit').val('');
                $('#serial_number_edit').val('');
                $('#lokasi_edit').val('');
                $('#status_edit').val('');

                // Tutup modal edit
                $('#modal-edit').modal('hide');

                // Reload DataTable untuk merefresh data terbaru
                $('#dataTable').DataTable().ajax.reload();
            } else {
                // Jika gagal update
                swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal memperbarui data hardware.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        },
        error: function (error) {
            // Tampilkan validasi error
            console.log(error);

            if (error.responseJSON.errors) {
                let errors = error.responseJSON.errors;
                if (errors.jenis_hardware) toastr.error(errors.jenis_hardware[0]);
                if (errors.merk_hardware) toastr.error(errors.merk_hardware[0]);
                if (errors.tipe_hardware) toastr.error(errors.tipe_hardware[0]);
                if (errors.serial_number) toastr.error(errors.serial_number[0]);
                if (errors.lokasi) toastr.error(errors.lokasi[0]);
                if (errors.status) toastr.error(errors.status[0]);
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
        url: `{{ url('items/hardware/destroy/${data_id}') }}`,
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
            title: `Hardware`,
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