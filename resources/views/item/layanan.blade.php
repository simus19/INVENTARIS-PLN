@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4"> Layanan</h1>

<div class="row">
  <div class="col-12">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <div class="row">
                  <div class="col-6">
                      <h6 class="mt-2 font-weight-bold text-primary">Data Layanan</h6>
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
              <table class="table table-bordered table-striped table-responsive" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr >
                          <th>Jenis Layanan</th>
                          <th>Unit Induk PLN</th>
                          <th>NO BA Aktivasi</th>
                          <th>Tanggal BA</th>
                          <th>Nama Layanan</th>
                          <th>Level Unit</th>
                          <th>Alamat Unit</th>
                          <th>Bandwidth</th>
                          <th>IP Gateway</th>
                          <th>Status</th>
                          <th>Harga Layanan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr >
                        <th>Jenis Layanan</th>
                        <th>Unit Induk PLN</th>
                        <th>NO BA Aktivasi</th>
                        <th>Tanggal BA</th>
                        <th>Nama Layanan</th>
                        <th>Level Unit</th>
                        <th>Alamat Unit</th>
                        <th>Bandwidth</th>
                        <th>IP Gateway</th>
                        <th>Status</th>
                        <th>Harga Layanan</th>
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
          url: "{{ url('items/layanan/datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'jenis_layanan',name:'jenis_layanan'},
          {data:'unit_induk_PLN',name:'unit_induk_PLN'},
          {data:'no_BA_aktivasi',name:'no_BA_aktivasi'},
          {data:'tanggal_BA',name:'tanggal_BA'},
          {data:'nama_layanan',name:'nama_layanan'},
          {data:'level_unit',name:'level_unit'},
          {data:'alamat_unit',name:'alamat_unit'},
          {data:'bandwidth',name:'bandwidth'},
          {data:'ip_gateway',name:'ip_gateway'},
          {data:'status',name:'status'},
          {data:'harga_layanan',name:'harga_layanan'},
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Jenis Layanan</label>
                            <input type="text" class="form-control" id="jenis_layanan" name="jenis_layanan" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Unit Induk PLN</label>
                            <input type="text" class="form-control" id="unit_induk_PLN" name="unit_induk_PLN" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">NO BA Aktivasi</label>
                            <input type="text" class="form-control" id="no_BA_aktivasi" name="no_BA_aktivasi" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Tanggal BA</label>
                            <input type="date" class="form-control" id="tanggal_BA" name="tanggal_BA" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Nama Layanan</label>
                            <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Level Unit</label>
                            <input type="text" class="form-control" id="level_unit" name="level_unit" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Alamat Unit</label>
                            <input type="text" class="form-control" id="alamat_unit" name="alamat_unit" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Bandwidth</label>
                            <input type="text" class="form-control" id="bandwidth" name="bandwidth" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">IP Gateway</label>
                            <input type="text" class="form-control" id="ip_gateway" name="ip_gateway" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Harga Layanan</label>
                            <input type="text" class="form-control" id="harga_layanan" name="harga_layanan" placeholder="">
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
        let jenis_layanan   = $('#jenis_layanan').val();
        let unit_induk_PLN   = $('#unit_induk_PLN').val();
        let no_BA_aktivasi   = $('#no_BA_aktivasi').val();
        let tanggal_BA   = $('#tanggal_BA').val();
        let nama_layanan   = $('#nama_layanan').val();
        let level_unit   = $('#level_unit').val();
        let alamat_unit   = $('#alamat_unit').val();
        let bandwidth   = $('#bandwidth').val();
        let ip_gateway   = $('#ip_gateway').val();
        let status   = $('#status').val();
        let harga_layanan   = $('#harga_layanan').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/layanan/store') }}`,
            type: "POST",
            cache: false,
            data: {
                'jenis_layanan': jenis_layanan,
                'unit_induk_PLN': unit_induk_PLN,
                'no_BA_aktivasi': no_BA_aktivasi,
                'tanggal_BA': tanggal_BA,
                'nama_layanan': nama_layanan,
                'level_unit': level_unit,
                'alamat_unit': alamat_unit,
                'bandwidth': bandwidth,
                'ip_gateway': ip_gateway,
                'status': status,
                'harga_layanan': harga_layanan,
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
                $('#jenis_layanan').val('');
                $('#unit_induk_PLN').val('');
                $('#no_BA_aktivasi').val('');
                $('#tanggal_BA').val('');
                $('#nama_layanan').val('');
                $('#level_unit').val('');
                $('#alamat_unit').val('');
                $('#bandwidth').val('');
                $('#ip_gateway').val('');
                $('#status').val('');
                $('#harga_layanan').val('');
  
                //close modal
                $('#modal-create').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.harga_layanan?.[0]) { 
                toastr.error(error.responseJSON.harga_layanan[0]);
              }
              if (error.responseJSON.status?.[0]) { 
                toastr.error(error.responseJSON.status[0]);
              }
              if (error.responseJSON.ip_gateway?.[0]) { 
                toastr.error(error.responseJSON.ip_gateway[0]);
              }
              if (error.responseJSON.bandwidth?.[0]) { 
                toastr.error(error.responseJSON.bandwidth[0]);
              }
              if (error.responseJSON.alamat_unit?.[0]) { 
                toastr.error(error.responseJSON.alamat_unit[0]);
              }
              if (error.responseJSON.level_unit?.[0]) { 
                toastr.error(error.responseJSON.level_unit[0]);
              }
              if (error.responseJSON.nama_layanan?.[0]) { 
                toastr.error(error.responseJSON.nama_layanan[0]);
              }
              if (error.responseJSON.tanggal_BA?.[0]) { 
                toastr.error(error.responseJSON.tanggal_BA[0]);
              }
              if (error.responseJSON.no_BA_aktivasi?.[0]) { 
                toastr.error(error.responseJSON.no_BA_aktivasi[0]);
              }
              if (error.responseJSON.unit_induk_PLN?.[0]) { 
                toastr.error(error.responseJSON.unit_induk_PLN[0]);
              }
              if (error.responseJSON.jenis_layanan?.[0]) { 
                toastr.error(error.responseJSON.jenis_layanan[0]);
              }
            }
        });
    });
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Layanan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" id="layanans_id">
                      <div class="form-group">
                          <label for="name" class="control-label">Jenis Layanan</label>
                          <input type="text" class="form-control" id="jenis_layanan_edit" name="jenis_layanan" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="email" class="control-label">Unit Induk PLN</label>
                          <input type="text" class="form-control" id="unit_induk_PLN_edit" name="unit_induk_PLN" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">NO BA Aktivasi</label>
                          <input type="text" class="form-control" id="no_BA_aktivasi_edit" name="no_BA_aktivasi" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Tanggal BA</label>
                          <input type="date" class="form-control" id="tanggal_BA_edit" name="tanggal_BA" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Nama Layanan</label>
                          <input type="text" class="form-control" id="nama_layanan_edit" name="nama_layanan" placeholder="">
                      </div>
                      
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="password" class="control-label">Level Unit</label>
                          <input type="text" class="form-control" id="level_unit_edit" name="level_unit" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Alamat Unit</label>
                          <input type="text" class="form-control" id="alamat_unit_edit" name="alamat_unit" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Bandwidth</label>
                          <input type="text" class="form-control" id="bandwidth_edit" name="bandwidth" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">IP Gateway</label>
                          <input type="text" class="form-control" id="ip_gateway_edit" name="ip_gateway" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Status</label>
                          <input type="text" class="form-control" id="status_edit" name="status" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="password" class="control-label">Harga Layanan</label>
                          <input type="text" class="form-control" id="harga_layanan_edit" name="harga_layanan" placeholder="">
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
          url: `{{ url('items/layanan/show/${data_id}') }}`,
          type: "GET",
          cache: false,
          success: function (response) {
            // console.log(response.data);
            $('#layanans_id').val(response.data.id);
            $('#jenis_layanan_edit').val(response.data.jenis_layanan);
            $('#unit_induk_PLN_edit').val(response.data.unit_induk_PLN);
            $('#no_BA_aktivasi_edit').val(response.data.no_BA_aktivasi);
            $('#tanggal_BA_edit').val(response.data.tanggal_BA);
            $('#nama_layanan_edit').val(response.data.nama_layanan);
            $('#level_unit_edit').val(response.data.level_unit);
            $('#alamat_unit_edit').val(response.data.alamat_unit);
            $('#bandwidth_edit').val(response.data.bandwidth);
            $('#ip_gateway_edit').val(response.data.ip_gateway);
            $('#status_edit').val(response.data.status);
            $('#harga_layanan_edit').val(response.data.harga_layanan);
          }
        });
        //open modal
        $('#modal-edit').modal('show');
    });

    $('#update').click(function (e) { 
        e.preventDefault();
        let layanans_id = $('#layanans_id').val();
        let jenis_layanan   = $('#jenis_layanan_edit').val();
        let unit_induk_PLN   = $('#unit_induk_PLN_edit').val();
        let no_BA_aktivasi   = $('#no_BA_aktivasi_edit').val();
        let tanggal_BA   = $('#tanggal_BA_edit').val();
        let nama_layanan   = $('#nama_layanan_edit').val();
        let level_unit   = $('#level_unit_edit').val();
        let alamat_unit   = $('#alamat_unit_edit').val();
        let bandwidth   = $('#bandwidth_edit').val();
        let ip_gateway   = $('#ip_gateway_edit').val();
        let status   = $('#status_edit').val();
        let harga_layanan   = $('#harga_layanan_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('items/layanan/update/${layanans_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'jenis_layanan': jenis_layanan,
                'unit_induk_PLN': unit_induk_PLN,
                'no_BA_aktivasi': no_BA_aktivasi,
                'tanggal_BA': tanggal_BA,
                'nama_layanan': nama_layanan,
                'level_unit': level_unit,
                'alamat_unit': alamat_unit,
                'bandwidth': bandwidth,
                'ip_gateway': ip_gateway,
                'status': status,
                'harga_layanan': harga_layanan,
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
                $('#jenis_layanan_edit').val('');
                $('#unit_induk_PLN_edit').val('');
                $('#no_BA_aktivasi_edit').val('');
                $('#tanggal_BA_edit').val('');
                $('#nama_layanan_edit').val('');
                $('#level_unit_edit').val('');
                $('#alamat_unit_edit').val('');
                $('#bandwidth_edit').val('');
                $('#ip_gateway_edit').val('');
                $('#status_edit').val('');
                $('#harga_layanan_edit').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.harga_layanan?.[0]) { 
                toastr.error(error.responseJSON.harga_layanan[0]);
              }
              if (error.responseJSON.status?.[0]) { 
                toastr.error(error.responseJSON.status[0]);
              }
              if (error.responseJSON.ip_gateway?.[0]) { 
                toastr.error(error.responseJSON.ip_gateway[0]);
              }
              if (error.responseJSON.bandwidth?.[0]) { 
                toastr.error(error.responseJSON.bandwidth[0]);
              }
              if (error.responseJSON.alamat_unit?.[0]) { 
                toastr.error(error.responseJSON.alamat_unit[0]);
              }
              if (error.responseJSON.level_unit?.[0]) { 
                toastr.error(error.responseJSON.level_unit[0]);
              }
              if (error.responseJSON.nama_layanan?.[0]) { 
                toastr.error(error.responseJSON.nama_layanan[0]);
              }
              if (error.responseJSON.tanggal_BA?.[0]) { 
                toastr.error(error.responseJSON.tanggal_BA[0]);
              }
              if (error.responseJSON.no_BA_aktivasi?.[0]) { 
                toastr.error(error.responseJSON.no_BA_aktivasi[0]);
              }
              if (error.responseJSON.unit_induk_PLN?.[0]) { 
                toastr.error(error.responseJSON.unit_induk_PLN[0]);
              }
              if (error.responseJSON.jenis_layanan?.[0]) { 
                toastr.error(error.responseJSON.jenis_layanan[0]);
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
        url: `{{ url('items/layanan/destroy/${data_id}') }}`,
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