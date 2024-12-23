@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4"> Server</h1>

<div class="row">
  <div class="col-12">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col-6">
                      <h6 class="mt-2 font-weight-bold text-primary">Data Server</h6>
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
                          <th>Merk Server</th>
                          <th>Server Serial Number</th>
                          <th>Operating System</th>
                          <th>Lisensi OS</th>
                          <th>IP Address</th>
                          <th>Processor</th>
                          <th>Memory</th>
                          <th>Jumlah Core</th>
                          <th>Storage</th>
                          <th>Status Hardisk</th>
                          <th>Fungsi Server</th>
                          <th>Server Type</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                          <th>Merk Server</th>
                          <th>Server Serial Number</th>
                          <th>Operating System</th>
                          <th>Lisensi OS</th>
                          <th>IP Address</th>
                          <th>Processor</th>
                          <th>Memory</th>
                          <th>Jumlah Core</th>
                          <th>Storage</th>
                          <th>Status Hardisk</th>
                          <th>Fungsi Server</th>
                          <th>Server Type</th>
                          <th>Keterangan</th>
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
          url: "{{ url('items/server/datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'merk_server',name:'merk_server'},
          {data:'server_serial_number',name:'server_serial_number'},
          {data:'operating_system',name:'operating_system'},
          {data:'lisensi_os',name:'lisensi_os'},
          {data:'ip_address',name:'ip_address'},
          {data:'processor',name:'processor'},
          {data:'memory',name:'memory'},
          {data:'jumlah_core',name:'jumlah_core'},
          {data:'storage',name:'storage'},
          {data:'status_hardisk',name:'status_hardisk'},
          {data:'fungsi_server',name:'fungsi_server'},
          {data:'server_type',name:'server_type'},
          {data:'keterangan',name:'keterangan'},
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Server</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Merk Server</label>
                            <input type="text" class="form-control" id="merk_server" name="merk_server" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Server Serial Number</label>
                            <input type="text" class="form-control" id="server_serial_number" name="server_serial_number" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Operating System</label>
                            <input type="text" class="form-control" id="operating_system" name="operating_system" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Lisensi OS</label>
                            <input type="text" class="form-control" id="lisensi_os" name="lisensi_os" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">IP Address</label>
                            <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Processor</label>
                            <input type="text" class="form-control" id="processor" name="processor" placeholder="">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Memory</label>
                            <input type="text" class="form-control" id="memory" name="memory" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Jumlah Core</label>
                            <input type="text" class="form-control" id="jumlah_core" name="jumlah_core" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Storage</label>
                            <input type="text" class="form-control" id="storage" name="storage" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Status Hardisk</label>
                            <input type="text" class="form-control" id="status_hardisk" name="status_hardisk" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Fungsi Server</label>
                            <input type="text" class="form-control" id="fungsi_server" name="fungsi_server" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Server Type</label>
                            <input type="text" class="form-control" id="server_type" name="server_type" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="">
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
        //open modal
        $('#modal-create').modal('show');
    });

    $('#store').click(function (e) { 
        e.preventDefault();
        let merk_server   = $('#merk_server').val();
        let server_serial_number   = $('#server_serial_number').val();
        let operating_system   = $('#operating_system').val();
        let lisensi_os   = $('#lisensi_os').val();
        let ip_address   = $('#ip_address').val();
        let processor   = $('#processor').val();
        let memory   = $('#memory').val();
        let jumlah_core   = $('#jumlah_core').val();
        let storage   = $('#storage').val();
        let status_hardisk   = $('#status_hardisk').val();
        let fungsi_server   = $('#fungsi_server').val();
        let server_type   = $('#server_type').val();
        let keterangan   = $('#keterangan').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/server/store') }}`,
            type: "POST",
            cache: false,
            data: {
                'merk_server': merk_server,
                'server_serial_number': server_serial_number,
                'operating_system': operating_system,
                'lisensi_os': lisensi_os,
                'ip_address': ip_address,
                'processor': processor,
                'memory': memory,
                'jumlah_core': jumlah_core,
                'storage': storage,
                'status_hardisk': status_hardisk,
                'fungsi_server': fungsi_server,
                'server_type': server_type,
                'keterangan': keterangan,
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
                $('#merk_server').val('');
                $('#server_serial_number').val('');
                $('#operating_system').val('');
                $('#lisensi_os').val('');
                $('#ip_address').val('');
                $('#processor').val('');
                $('#memory').val('');
                $('#jumlah_core').val('');
                $('#storage').val('');
                $('#status_hardisk').val('');
                $('#fungsi_server').val('');
                $('#server_type').val('');
                $('#keterangan').val('');
  
                //close modal
                $('#modal-create').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.keterangan?.[0]) { 
                toastr.error(error.responseJSON.keterangan[0]);
              }
              if (error.responseJSON.server_type?.[0]) { 
                toastr.error(error.responseJSON.server_type[0]);
              }
              if (error.responseJSON.fungsi_server?.[0]) { 
                toastr.error(error.responseJSON.fungsi_server[0]);
              }
              if (error.responseJSON.status_hardisk?.[0]) { 
                toastr.error(error.responseJSON.status_hardisk[0]);
              }
              if (error.responseJSON.storage?.[0]) { 
                toastr.error(error.responseJSON.storage[0]);
              }
              if (error.responseJSON.jumlah_core?.[0]) { 
                toastr.error(error.responseJSON.jumlah_core[0]);
              }
              if (error.responseJSON.memory?.[0]) { 
                toastr.error(error.responseJSON.memory[0]);
              }
              if (error.responseJSON.processor?.[0]) { 
                toastr.error(error.responseJSON.processor[0]);
              }
              if (error.responseJSON.ip_address?.[0]) { 
                toastr.error(error.responseJSON.ip_address[0]);
              }
              if (error.responseJSON.lisensi_os?.[0]) { 
                toastr.error(error.responseJSON.lisensi_os[0]);
              }
              if (error.responseJSON.operating_system?.[0]) { 
                toastr.error(error.responseJSON.operating_system[0]);
              }
              if (error.responseJSON.server_serial_number?.[0]) { 
                toastr.error(error.responseJSON.server_serial_number[0]);
              }
              if (error.responseJSON.merk_server?.[0]) { 
                toastr.error(error.responseJSON.merk_server[0]);
              }
            }
        });
    });
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Server</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" id="servers_id">
                      <div class="form-group">
                          <label for="name" class="control-label">Merk Server</label>
                          <input type="text" class="form-control" id="merk_server_edit" name="merk_server" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="email" class="control-label">Server Serial Number</label>
                          <input type="text" class="form-control" id="server_serial_number_edit" name="server_serial_number" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Operating System</label>
                          <input type="text" class="form-control" id="operating_system_edit" name="operating_system" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Lisensi OS</label>
                          <input type="text" class="form-control" id="lisensi_os_edit" name="lisensi_os" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">IP Address</label>
                          <input type="text" class="form-control" id="ip_address_edit" name="ip_address" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Processor</label>
                          <input type="text" class="form-control" id="processor_edit" name="processor" placeholder="">
                      </div>
                      
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="password" class="control-label">Memory</label>
                          <input type="text" class="form-control" id="memory_edit" name="memory" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Jumlah Core</label>
                          <input type="text" class="form-control" id="jumlah_core_edit" name="jumlah_core" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Storage</label>
                          <input type="text" class="form-control" id="storage_edit" name="storage" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Status Hardisk</label>
                          <input type="text" class="form-control" id="status_hardisk_edit" name="status_hardisk" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Fungsi Server</label>
                          <input type="text" class="form-control" id="fungsi_server_edit" name="fungsi_server" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Server Type</label>
                          <input type="text" class="form-control" id="server_type_edit" name="server_type" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Keterangan</label>
                          <input type="text" class="form-control" id="keterangan_edit" name="keterangan" placeholder="">
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
          url: `{{ url('items/server/show/${data_id}') }}`,
          type: "GET",
          cache: false,
          success: function (response) {
            // console.log(response.data);
            $('#servers_id').val(response.data.id);
            $('#merk_server_edit').val(response.data.merk_server);
            $('#server_serial_number_edit').val(response.data.server_serial_number);
            $('#operating_system_edit').val(response.data.operating_system);
            $('#lisensi_os_edit').val(response.data.lisensi_os);
            $('#ip_address_edit').val(response.data.ip_address);
            $('#processor_edit').val(response.data.processor);
            $('#memory_edit').val(response.data.memory);
            $('#jumlah_core_edit').val(response.data.jumlah_core);
            $('#storage_edit').val(response.data.storage);
            $('#status_hardisk_edit').val(response.data.status_hardisk);
            $('#fungsi_server_edit').val(response.data.fungsi_server);
            $('#server_type_edit').val(response.data.server_type);
            $('#keterangan_edit').val(response.data.keterangan);
          }
        });
        //open modal
        $('#modal-edit').modal('show');
    });

    $('#update').click(function (e) { 
        e.preventDefault();
        let servers_id = $('#servers_id').val();
        let merk_server   = $('#merk_server_edit').val();
        let server_serial_number   = $('#server_serial_number_edit').val();
        let operating_system   = $('#operating_system_edit').val();
        let lisensi_os   = $('#lisensi_os_edit').val();
        let ip_address   = $('#ip_address_edit').val();
        let processor   = $('#processor_edit').val();
        let memory   = $('#memory_edit').val();
        let jumlah_core   = $('#jumlah_core_edit').val();
        let storage   = $('#storage_edit').val();
        let status_hardisk   = $('#status_hardisk_edit').val();
        let fungsi_server   = $('#fungsi_server_edit').val();
        let server_type   = $('#server_type_edit').val();
        let keterangan   = $('#keterangan_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
  
        $.ajax({
            url: `{{ url('items/server/update/${servers_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'merk_server': merk_server,
                'server_serial_number': server_serial_number,
                'operating_system': operating_system,
                'lisensi_os': lisensi_os,
                'ip_address': ip_address,
                'processor': processor,
                'memory': memory,
                'jumlah_core': jumlah_core,
                'storage': storage,
                'status_hardisk': status_hardisk,
                'fungsi_server': fungsi_server,
                'server_type': server_type,
                'keterangan': keterangan,
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
                $('#merk_server_edit').val('');
                $('#server_serial_number_edit').val('');
                $('#operating_system_edit').val('');
                $('#lisensi_os_edit').val('');
                $('#ip_address_edit').val('');
                $('#processor_edit').val('');
                $('#memory_edit').val('');
                $('#jumlah_core_edit').val('');
                $('#storage_edit').val('');
                $('#status_hardisk_edit').val('');
                $('#fungsi_server_edit').val('');
                $('#server_type_edit').val('');
                $('#keterangan_edit').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.keterangan?.[0]) { 
                toastr.error(error.responseJSON.keterangan[0]);
              }
              if (error.responseJSON.server_type?.[0]) { 
                toastr.error(error.responseJSON.server_type[0]);
              }
              if (error.responseJSON.fungsi_server?.[0]) { 
                toastr.error(error.responseJSON.fungsi_server[0]);
              }
              if (error.responseJSON.status_hardisk?.[0]) { 
                toastr.error(error.responseJSON.status_hardisk[0]);
              }
              if (error.responseJSON.storage?.[0]) { 
                toastr.error(error.responseJSON.storage[0]);
              }
              if (error.responseJSON.jumlah_core?.[0]) { 
                toastr.error(error.responseJSON.jumlah_core[0]);
              }
              if (error.responseJSON.memory?.[0]) { 
                toastr.error(error.responseJSON.memory[0]);
              }
              if (error.responseJSON.processor?.[0]) { 
                toastr.error(error.responseJSON.processor[0]);
              }
              if (error.responseJSON.ip_address?.[0]) { 
                toastr.error(error.responseJSON.ip_address[0]);
              }
              if (error.responseJSON.lisensi_os?.[0]) { 
                toastr.error(error.responseJSON.lisensi_os[0]);
              }
              if (error.responseJSON.operating_system?.[0]) { 
                toastr.error(error.responseJSON.operating_system[0]);
              }
              if (error.responseJSON.server_serial_number?.[0]) { 
                toastr.error(error.responseJSON.server_serial_number[0]);
              }
              if (error.responseJSON.merk_server?.[0]) { 
                toastr.error(error.responseJSON.merk_server[0]);
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
        url: `{{ url('items/server/destroy/${data_id}') }}`,
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