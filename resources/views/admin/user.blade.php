@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4"> User</h1>

<div class="row">

    <div class="col-md-12">
      <div class="mt-3 mb-3">
        <button class="btn btn-primary w-100" id="btn-create">
          <i class="icon fas fa-plus pr-1"></i> User</button>
      </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="mt-2 font-weight-bold text-primary">Data User</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status Role</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status Role</th>
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
          url: "{{ route('admin/user.get_datatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'name',name:'name'},
          {data:'email',name:'email'},
          {data:'role',name:'role'},
          {data:'role_verified_is',name:'role_verified_is'},
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="">
                </div>
                <div class="form-group">
                    <label for="admin_roles_id" class="control-label">Role</label>
                    <select style="width: 100%" class="admin_roles_id form-control form-control-lg" id="admin_roles_id" name="admin_roles_id"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
                <button type="button" class="btn btn-primary" id="store"><i class="fa fa-send"></i></button>
            </div>
        </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function () {
        $('.admin_roles_id').select2({
            placeholder: 'Pilih Role',
            dropdownCssClass: "bigdrop",
            dropdownParent: $("#modal-create"),
            // theme: "classic",
            // minimumInputLength: 2,
            ajax : {
            url: `{{ url('/admin/role/role-ajax') }}`,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
            }
        });
    });
    $('body').on('click', '#btn-create', function () {
        //open modal
        $('#modal-create').modal('show');
    });
  
    $('#store').click(function (e) { 
        e.preventDefault();
        let name   = $('#name').val();
        let email   = $('#email').val();
        let password   = $('#password').val();
        let admin_roles_id   = $('#admin_roles_id').val() == null ? '' : $('#admin_roles_id').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ route('admin/user.post_store') }}`,
            type: "POST",
            cache: false,
            data: {
                'name': name,
                'email': email,
                'password': password,
                'admin_roles_id': admin_roles_id,
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
                $('#email').val('');
                $('#password').val('');
                $('#admin_roles_id').val('');
  
                //close modal
                $('#modal-create').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              
              if (error.responseJSON.admin_roles_id?.[0]) { 
                toastr.error(error.responseJSON.admin_roles_id[0]);
              }
              if (error.responseJSON.password?.[0]) { 
                toastr.error(error.responseJSON.password[0]);
              }
              if (error.responseJSON.email?.[0]) { 
                toastr.error(error.responseJSON.email[0]);
              }
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
          <h5 class="modal-title" id="exampleModalLabel">Form Edit Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="admins_id">
        <div class="form-group">
            <label for="name_edit" class="control-label">Nama</label>
            <input type="text" class="form-control" id="name_edit" name="name_edit" placeholder="">
        </div>
        <div class="form-group">
            <label for="email_edit" class="control-label">Email</label>
            <input type="text" class="form-control" id="email_edit" name="email_edit" readonly placeholder="">
        </div>
        <div class="form-group">
            <label for="password_edit" class="control-label">Password</label>
            <input type="text" class="form-control" id="password_edit" name="password_edit" placeholder="********">
        </div>
        <div class="form-group">
            <input type="hidden" id="admin_roles_id_old">
            <label for="admin_roles_id_edit" class="control-label">Role</label>
            <select style="width: 100%" class="admin_roles_id_edit form-control form-control-lg" id="admin_roles_id_edit" name="admin_roles_id_edit"></select>
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
      $('#admin_roles_id_edit').val('');
      $('#admin_prodis_id_edit').val('');
      let admins_id = $(this).data('id');
        $.ajax({
          url: `{{ url('admin/user/show/${admins_id}') }}`,
          type: "GET",
          cache: false,
          success: function (response) {
            // console.log(response.data);
            $('#admins_id').val(response.data.id);
            $('#name_edit').val(response.data.name);
            $('#email_edit').val(response.data.email);
            $('#admin_roles_id_old').val(response.data.roles_id);


            $('.admin_roles_id_edit').select2({
            placeholder: response.data.role.name,
            dropdownCssClass: "bigdrop",
            dropdownParent: $("#modal-edit"),
            // theme: "classic",
            // minimumInputLength: 2,
            ajax : {
            url: `{{ url('/admin/role/role-ajax') }}`,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
            }
            });
        
          }
        });

        //open modal
        $('#modal-edit').modal('show');
    });
  
    $('#update').click(function (e) { 
        e.preventDefault();
        let admins_id = $('#admins_id').val();
        let name   = $('#name_edit').val();
        let email   = $('#email_edit').val();
        let password   = $('#password_edit').val();
        let admin_roles_id   = $('#admin_roles_id_edit').val() == null ? $('#admin_roles_id_old').val() : $('#admin_roles_id_edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
  
        $.ajax({
            url: `{{ url('admin/user/update/${admins_id}') }}`,
            type: "PUT",
            cache: false,
            data: {
                'name': name,
                'password': password,
                'admin_roles_id': admin_roles_id,
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
                $('#name_edit').val('');
                $('#email_edit').val('');
                $('#password_edit').val('');
                $('#admin_roles_id_old').val('');
  
                //close modal
                $('#modal-edit').modal('hide');
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function (error) {
              console.log(error);
              if (error.responseJSON.password?.[0]) { 
                toastr.error(error.responseJSON.password[0]);
              }
              if (error.responseJSON.name?.[0]) { 
                toastr.error(error.responseJSON.name[0]);
              }
            }
        });
    });

    $('body').on('click', '#btn-delete', function () {
    let admin_prodis_id = $(this).data('id');
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
          url: `{{ url('/admin/user/destroy/${admin_prodis_id}') }}`,
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
    
    $('body').on('click', '#btn-verified', function () {
    let admin_prodis_id = $(this).data('id');
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
          url: `{{ url('/admin/user/verify/${admin_prodis_id}') }}`,
          type: "POST",
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
        });   

    });
    
    $('body').on('click', '#btn-unverified', function () {
    let admin_prodis_id = $(this).data('id');
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
          url: `{{ url('/admin/user/unverify/${admin_prodis_id}') }}`,
          type: "POST",
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
        });   

    });
  </script>



@endpush