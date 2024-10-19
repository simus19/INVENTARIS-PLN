@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Prodi</h1>

<div class="row">

    <div class="col-md-7">
      <div class="mt-3 mb-3">
        <button class="btn btn-primary w-100" id="btn-create">
          <i class="icon fas fa-plus pr-1"></i> Tambah Data</button>
      </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="mt-2 font-weight-bold text-primary">Data</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Menu</th>
                </tr>
              </tfoot>
              <tbody></tbody>
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
          url: "{{ route('admin/prodi.get_datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'name',name:'name'},
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
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
        let name   = $('#name').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ route('admin/prodi.post_store') }}`,
            type: "POST",
            cache: false,
            data: {
                'name': name,
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
                $('#name').val('');
  
                //close modal
                $('#modal-create').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.name?.[0]) { 
                toastr.error(error.responseJSON.name[0]);
              }
            }
        });
    });
  </script>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="data_id">
          <div class="form-group">
              <label for="name_edit" class="control-label">Name</label>
              <input type="text" class="form-control" id="name_edit" name="name_edit" placeholder="">
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
          url: `{{ url('admin/prodi/show/${data_id}') }}`,
          type: "GET",
          cache: false,
          success: function (response) {
            // console.log(response.data);
            $('#data_id').val(response.data.id);
            $('#name_edit').val(response.data.name);
          }
        });
        //open modal
        $('#modal-edit').modal('show');
    });
  
    $('#update').click(function (e) { 
        e.preventDefault();
        let data_id = $('#data_id').val();
        let name   = $('#name_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('admin/prodi/update/${data_id}') }}`,
            type: "POST",
            cache: false,
            data: {

                'name': name,
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
                $('#name').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
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
          url: `{{ url('admin/prodi/destroy/${data_id}') }}`,
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