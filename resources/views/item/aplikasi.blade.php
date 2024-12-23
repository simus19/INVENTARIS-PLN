@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Aplikasi</h1>

<div class="row">
  <div class="col-12">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col-6">
                      <h6 class="mt-2 font-weight-bold text-primary">Data Aplikasi</h6>
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
                          <th>Nama Aplikasi</th>
                          <th>Versi Aplikasi</th>
                          <th>Tahun Produksi</th>
                          <th>Bahasa Pemrograman</th>
                          <th>Jenis Database</th>
                          <th>Server ID</th>
                          <th>Pengelola</th>
                          <th>Penanggung Jawab</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                          <th>Nama Aplikasi</th>
                          <th>Versi Aplikasi</th>
                          <th>Tahun Produksi</th>
                          <th>Bahasa Pemrograman</th>
                          <th>Jenis Database</th>
                          <th>Server ID</th>
                          <th>Pengelola</th>
                          <th>Penanggung Jawab</th>
                          <th>Status</th>
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
  <script>
    //Call the dataTables jQuery plugin
    $(document).ready(function() {
      $('#dataTable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ url('items/aplikasi/datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'nama_aplikasi',name:'nama_aplikasi'},
          {data:'versi_aplikasi',name:'versi_aplikasi'},
          {data:'tahun_produksi',name:'tahun_produksi'},
          {data:'bahasa_pemrograman',name:'bahasa_pemrograman'},
          {data:'jenis_database',name:'jenis_database'},
          {data:'server_id',name:'server_id'},
          {data:'pengelola',name:'pengelola'},
          {data:'penanggung_jawab',name:'penanggung_jawab'},
          {data:'status',name:'status'},
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Nama Aplikasi</label>
                            <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Versi Aplikasi</label>
                            <input type="text" class="form-control" id="versi_aplikasi" name="versi_aplikasi" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Tahun Produksi</label>
                            <input type="text" class="form-control" id="tahun_produksi" name="tahun_produksi" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Bahasa Pemrograman</label>
                            <input type="text" class="form-control" id="bahasa_pemrograman" name="bahasa_pemrograman" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Jenis Database</label>
                            <input type="text" class="form-control" id="jenis_database" name="jenis_database" placeholder="">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Server ID</label>
                            <select class="form-control" id="server_id" name="server_id">
                              <option value="">-- Pilih Server --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Pengelola</label>
                            <input type="text" class="form-control" id="pengelola" name="pengelola" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="">
                        </div>
                    </div>
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
    // Menampilkan modal
    $('#modal-create').modal('show');
    
    // Mengambil data server untuk dropdown
    $.ajax({
        url: "{{ route('servers.get') }}", // Route yang kita buat di ServerController
        type: "GET",
        success: function (data) {
            let serverSelect = $('#server_id');
            serverSelect.empty(); // Hapus opsi lama
            serverSelect.append('<option value="">-- Pilih Server --</option>'); // Opsi default
            
            // Looping melalui data server dan menambahkannya ke dropdown
            data.forEach(function (server) {
                serverSelect.append('<option value="' + server.id + '">' + server.merk_server + '</option>');
            });
        },
        error: function (error) {
            console.log(error);
            toastr.error('Gagal mengambil data server.');
        }
    });
});


    $('#store').click(function (e) { 
        e.preventDefault();
        let nama_aplikasi   = $('#nama_aplikasi').val();
        let versi_aplikasi   = $('#versi_aplikasi').val();
        let tahun_produksi   = $('#tahun_produksi').val();
        let bahasa_pemrograman   = $('#bahasa_pemrograman').val();
        let jenis_database   = $('#jenis_database').val();
        let server_id   = $('#server_id').val();
        let pengelola   = $('#pengelola').val();
        let penanggung_jawab   = $('#penanggung_jawab').val();
        let status   = $('#status').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/aplikasi/store') }}`,
            type: "POST",
            cache: false,
            data: {
                'nama_aplikasi': nama_aplikasi,
                'versi_aplikasi': versi_aplikasi,
                'tahun_produksi': tahun_produksi,
                'bahasa_pemrograman': bahasa_pemrograman,
                'jenis_database': jenis_database,
                'server_id': server_id,
                'pengelola': pengelola,
                'penanggung_jawab': penanggung_jawab,
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
                $('#nama_aplikasi').val('');
                $('#versi_aplikasi').val('');
                $('#tahun_produksi').val('');
                $('#bahasa_pemrograman').val('');
                $('#jenis_database').val('');
                $('#server_id').val('');
                $('#pengelola').val('');
                $('#penanggung_jawab').val('');
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
              if (error.responseJSON.penanggung_jawab?.[0]) { 
                toastr.error(error.responseJSON.penanggung_jawab[0]);
              }
              if (error.responseJSON.pengelola?.[0]) { 
                toastr.error(error.responseJSON.pengelola[0]);
              }
              if (error.responseJSON.server_id?.[0]) { 
                toastr.error(error.responseJSON.server_id[0]);
              }
              if (error.responseJSON.jenis_database?.[0]) { 
                toastr.error(error.responseJSON.jenis_database[0]);
              }
              if (error.responseJSON.bahasa_pemrograman?.[0]) { 
                toastr.error(error.responseJSON.bahasa_pemrograman[0]);
              }
              if (error.responseJSON.tahun_produksi?.[0]) { 
                toastr.error(error.responseJSON.tahun_produksi[0]);
              }
              if (error.responseJSON.versi_aplikasi?.[0]) { 
                toastr.error(error.responseJSON.versi_aplikasi[0]);
              }
              if (error.responseJSON.nama_aplikasi?.[0]) { 
                toastr.error(error.responseJSON.nama_aplikasi[0]);
              }
            }
        });
    });
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Edit Data aplikasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" id="aplikasis_id">
                      <div class="form-group">
                          <label for="name" class="control-label">Nama Aplikasi</label>
                          <input type="text" class="form-control" id="nama_aplikasi_edit" name="nama_aplikasi" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="email" class="control-label">Versi Aplikasi</label>
                          <input type="text" class="form-control" id="versi_aplikasi_edit" name="versi_aplikasi" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Tahun Produksi</label>
                          <input type="text" class="form-control" id="tahun_produksi_edit" name="tahun_produksi" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Bahasa Pemrograman</label>
                          <input type="text" class="form-control" id="bahasa_pemrograman_edit" name="bahasa_pemrograman" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Jenis Database</label>
                          <input type="text" class="form-control" id="jenis_database_edit" name="jenis_database" placeholder="">
                      </div>
                      
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="server_id_edit" class="control-label">Server ID</label>
                          <select class="form-control" id="server_id_edit" name="server_id">
                              <option value="">-- Pilih Server --</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Pengelola</label>
                          <input type="text" class="form-control" id="pengelola_edit" name="pengelola" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Penanggung Jawab</label>
                          <input type="text" class="form-control" id="penanggung_jawab_edit" name="penanggung_jawab" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Status</label>
                          <input type="text" class="form-control" id="status_edit" name="status" placeholder="">
                      </div>
                  </div>
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
        url: "{{ route('servers.get') }}", // Route yang kita buat di ServerController
        type: "GET",
        success: function (data) {
            let serverSelect = $('#server_id_edit');
            serverSelect.empty(); // Hapus opsi lama
            serverSelect.append('<option value="">-- Pilih Server --</option>'); // Opsi default
            
            // Looping melalui data server dan menambahkannya ke dropdown
            data.forEach(function (server) {
                serverSelect.append('<option value="' + server.id + '">' + server.merk_server + '</option>');
            });
        },
        error: function (error) {
            console.log(error);
            toastr.error('Gagal mengambil data server.');
        }
    });
    
    // Ambil data detail aplikasi
    $.ajax({
        url: `{{ url('items/aplikasi/show/${data_id}') }}`,
        type: "GET",
        cache: false,
        success: function (response) {
            // Populate form fields
            $('#aplikasis_id').val(response.data.id);
            $('#nama_aplikasi_edit').val(response.data.nama_aplikasi);
            $('#versi_aplikasi_edit').val(response.data.versi_aplikasi);
            $('#tahun_produksi_edit').val(response.data.tahun_produksi);
            $('#bahasa_pemrograman_edit').val(response.data.bahasa_pemrograman);
            $('#jenis_database_edit').val(response.data.jenis_database);
            $('#pengelola_edit').val(response.data.pengelola);
            $('#penanggung_jawab_edit').val(response.data.penanggung_jawab);
            $('#status_edit').val(response.data.status);

            // Isi dropdown server jika data server tersedia
            if (response.servers && Array.isArray(response.servers)) {
                      let serverSelect = $('#server_id_edit');
                      // serverSelect.empty(); // Hapus opsi lama
                      // serverSelect.append('<option value="">-- Pilih Server --</option>'); // Opsi default

                      response.servers.forEach(function (server) {
                          let selected = response.data.server_id === server.id ? 'selected' : '';
                          serverSelect.append(
                              `<option value="${server.id}" ${selected}>${server.merk_server}</option>`
                          );
                      });
        } else {
            console.warn('Data servers tidak ditemukan dalam respons.');
        }
    },
    error: function (error) {
        console.error('AJAX Error:', error);
        toastr.error('Gagal memuat data aplikasi.');
    }
    });

    // Buka modal
    $('#modal-edit').modal('show');
});

    $('#update').click(function (e) { 
        e.preventDefault();
        let aplikasis_id = $('#aplikasis_id').val();
        let nama_aplikasi   = $('#nama_aplikasi_edit').val();
        let versi_aplikasi   = $('#versi_aplikasi_edit').val();
        let tahun_produksi   = $('#tahun_produksi_edit').val();
        let bahasa_pemrograman   = $('#bahasa_pemrograman_edit').val();
        let jenis_database   = $('#jenis_database_edit').val();
        let server_id   = $('#server_id_edit').val();
        let pengelola   = $('#pengelola_edit').val();
        let penanggung_jawab   = $('#penanggung_jawab_edit').val();
        let status   = $('#status_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/aplikasi/update/${aplikasis_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'nama_aplikasi': nama_aplikasi,
                'versi_aplikasi': versi_aplikasi,
                'tahun_produksi': tahun_produksi,
                'bahasa_pemrograman': bahasa_pemrograman,
                'jenis_database': jenis_database,
                'server_id': server_id,
                'pengelola': pengelola,
                'penanggung_jawab': penanggung_jawab,
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
                $('#nama_aplikasi_edit').val('');
                $('#versi_aplikasi_edit').val('');
                $('#tahun_produksi_edit').val('');
                $('#bahasa_pemrograman_edit').val('');
                $('#jenis_database_edit').val('');
                $('#server_id_edit').val('');
                $('#pengelola_edit').val('');
                $('#penanggung_jawab_edit').val('');
                $('#status_edit').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);

              if (error.responseJSON.status?.[0]) { 
                toastr.error(error.responseJSON.status[0]);
              }
              if (error.responseJSON.penanggung_jawab?.[0]) { 
                toastr.error(error.responseJSON.penanggung_jawab[0]);
              }
              if (error.responseJSON.pengelola?.[0]) { 
                toastr.error(error.responseJSON.pengelola[0]);
              }
              if (error.responseJSON.server_id?.[0]) { 
                toastr.error(error.responseJSON.server_id[0]);
              }
              if (error.responseJSON.jenis_database?.[0]) { 
                toastr.error(error.responseJSON.jenis_database[0]);
              }
              if (error.responseJSON.bahasa_pemrograman?.[0]) { 
                toastr.error(error.responseJSON.bahasa_pemrograman[0]);
              }
              if (error.responseJSON.tahun_produksi?.[0]) { 
                toastr.error(error.responseJSON.tahun_produksi[0]);
              }
              if (error.responseJSON.versi_aplikasi?.[0]) { 
                toastr.error(error.responseJSON.versi_aplikasi[0]);
              }
              if (error.responseJSON.nama_aplikasi?.[0]) { 
                toastr.error(error.responseJSON.nama_aplikasi[0]);
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
        url: `{{ url('items/aplikasi/destroy/${data_id}') }}`,
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
            title: `Menu`,
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