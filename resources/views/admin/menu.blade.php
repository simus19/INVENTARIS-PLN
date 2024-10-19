@extends('layouts.admin') 
@push('css')
<!-- Custom styles for this page -->
<link href="{{ url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Menu & Sub Menu</h1>

<div class="row">

    <div class="col-md-6">
      <div class="mt-3 mb-3">
        <button class="btn btn-primary w-100" id="btn-create-menu">
          <i class="icon fas fa-plus pr-1"></i>Menu</button>
      </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="mt-2 font-weight-bold text-primary">Data Menu</h6>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTableMenu" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Menu</th>
                  <th>Icon</th>
                  <th>Menu</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nama Menu</th>
                  <th>Icon</th>
                  <th>Menu</th>
                </tr>
              </tfoot>
              <tbody></tbody>
        </table>
      </div>
    </div>
    </div>
    
    <div class="col-md-6">
      <div class="mt-3 mb-3">
        <button class="btn btn-primary w-100" id="btn-create-submenu">
            <i class="icon fas fa-plus pr-1"></i>Sub Menu</button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="mt-2 font-weight-bold text-primary">Data Sub Menu</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTableSubMenu" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Nama Menu</th>
                      <th>Nama Sub Menu</th>
                      <th>URL</th>
                      <th>Menu</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Nama Menu</th>
                      <th>Nama Sub Menu</th>
                      <th>URL</th>
                      <th>Menu</th>
                    </tr>
                </tfoot>
                <tbody></tbody>
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
      $('#dataTableMenu').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ route('admin/menu.get_menudatatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'name',name:'name'},
          {data:'icon',name:'icon'},
          {data:'action',name:'action', orderable: false, searchable: false},
        ],
        order: [[0, 'asc']]
      });
      
      $('#dataTableSubMenu').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url: "{{ route('admin/menu.get_submenudatatable') }}",
        //   type: 'GET'
        },
        columns: [
          {data:'menus_id',name:'menus_id'},
          {data:'name',name:'name'},
          {data:'url',name:'url'},
          {data:'action',name:'action', orderable: false, searchable: false},
        ],
        order: [[0, 'asc']]
      });
    });
  </script>


<div class="modal fade" id="modal-create-menu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Tambah Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <label for="name" class="control-label">Nama Menu</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="">
              </div>
              <div class="form-group">
                <label for="icon" class="control-label">Icon</label>
                <input type="text" class="form-control" id="icon" name="icon" placeholder="">
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
  $('body').on('click', '#btn-create-menu', function () {
      //open modal
      $('#modal-create-menu').modal('show');
  });

  $('#store').click(function (e) { 
      e.preventDefault();
      let name   = $('#name').val();
      let icon   = $('#icon').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
          url: `{{ route('admin/menu.post_storemenu') }}`,
          type: "POST",
          cache: false,
          data: {
              'name': name,
              'icon': icon,
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
              $('#icon').val('');

              //close modal
              $('#modal-create-menu').modal('hide');
              $('#dataTableMenu').DataTable().ajax.reload();
          },
          error: function (error) {
            if (error.responseJSON.icon?.[0]) { 
              toastr.error(error.responseJSON.icon[0]);
            }
            if (error.responseJSON.name?.[0]) { 
              toastr.error(error.responseJSON.name[0]);
            }
          }
      });
  });
</script>

<div class="modal fade" id="modal-edit-menu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Edit Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="admin_menus_id">
              <div class="form-group">
                  <label for="name_edit" class="control-label">Nama Menu</label>
                  <input type="text" class="form-control" id="name_edit" name="name_edit" placeholder="">
              </div>
              <div class="form-group">
                <label for="icon_edit" class="control-label">Icon</label>
                <input type="text" class="form-control" id="icon_edit" name="icon_edit" placeholder="">
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
  $('body').on('click', '#btn-edit-menu', function () {
      //open modal
      let admin_menus_id = $(this).data('id');
      // console.log(admin_menus_id);
      $.ajax({
        url: `{{ url('admin/menu/showmenu/${admin_menus_id}') }}`,
        type: "GET",
        cache: false,
        success: function (response) {
          // console.log(response.data);
          $('#admin_menus_id').val(response.data.id);
          $('#name_edit').val(response.data.name);
          $('#icon_edit').val(response.data.icon);
        }
      });
      //open modal
      $('#modal-edit-menu').modal('show');
  });

  $('#update').click(function (e) { 
      e.preventDefault();
      let admin_menus_id   = $('#admin_menus_id').val();
      let name   = $('#name_edit').val();
      let icon   = $('#icon_edit').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
          url: `{{ url('admin/menu/updatemenu/${admin_menus_id}') }}`,
          type: "PUT",
          cache: false,
          data: {
              'admin_menus_id': admin_menus_id,
              'name': name,
              'icon': icon,
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
              $('#icon').val('');

              //close modal
              $('#modal-edit-menu').modal('hide');
              $('#dataTableMenu').DataTable().ajax.reload();
          },
          error: function (error) {
            if (error.responseJSON.icon?.[0]) { 
              toastr.error(error.responseJSON.icon[0]);
            }
            if (error.responseJSON.name?.[0]) { 
              toastr.error(error.responseJSON.name[0]);
            }
          }
      });
  });

  $('body').on('click', '#btn-delete-menu', function () {
    let admin_menus_id = $(this).data('id');
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
          url: `{{ url('/admin/menu/destroymenu/${admin_menus_id}') }}`,
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
            $('#dataTableMenu').DataTable().ajax.reload();
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














<div class="modal fade" id="modal-create-submenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Tambah Sub Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <label for="name_submenu" class="control-label">Nama Sub Menu</label>
                  <input type="text" class="form-control" id="name_submenu" name="name_submenu" placeholder="">
              </div>
              <div class="form-group">
                <label for="admin_menu_list" class="control-label">Menu Utama</label>
                <select style="width: 100%" class="admin_menu_list form-control form-control-lg" id="admin_menu_list" name="admin_menu_list"></select>
              </div>
              <div class="form-group">
                  <label for="url_submenu" class="control-label">URL</label>
                  <input type="text" class="form-control" id="url_submenu" name="url_submenu" placeholder="">
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
              <button type="button" class="btn btn-primary" id="store_submenu"><i class="fa fa-send"></i></button>
          </div>
      </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function () {
    $('.admin_menu_list').select2({
        placeholder: 'Pilih Menu',
        dropdownCssClass: "bigdrop",
        dropdownParent: $("#modal-create-submenu"),
        // theme: "classic",
        // minimumInputLength: 2,
        ajax : {
          url: `{{ url('/admin/menu/menu-ajax') }}`,
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

  $('body').on('click', '#btn-create-submenu', function () {
      //open modal
      $('#modal-create-submenu').modal('show');
  });

  
  $('#store_submenu').click(function (e) { 
      e.preventDefault();
      let name   = $('#name_submenu').val();
      let url   = $('#url_submenu').val();
      let menus_id   = $('#admin_menu_list').val() == null ? '' : $('#admin_menu_list').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
          url: `{{ route('admin/menu.post_storesubmenu') }}`,
          type: "POST",
          cache: false,
          data: {
              'name': name,
              'url': url,
              'menus_id': menus_id,
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
              $('#name_submenu').val('');
              $('#url_submenu').val('');
              $('#admin_menu_list').val('');

              //close modal
              $('#modal-create-submenu').modal('hide');
              $('#dataTableSubMenu').DataTable().ajax.reload();
          },
          error: function (error) {
            console.error(error.responseJSON);
            if (error.responseJSON.url?.[0]) { 
              toastr.error(error.responseJSON.url[0]);
            }
            if (error.responseJSON.admin_menus_id?.[0]) { 
              toastr.error(error.responseJSON.admin_menus_id[0]);
            }
            if (error.responseJSON.name?.[0]) { 
              toastr.error(error.responseJSON.name[0]);
            }
          }
      });
  });
  </script>

<div class="modal fade" id="modal-edit-submenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Form Tambah Sub Menu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="admin_sub_menus_id">
              <div class="form-group">
                  <label for="name_submenu_edit" class="control-label">Nama Sub Menu</label>
                  <input type="text" class="form-control" id="name_submenu_edit" name="name_submenu_edit" placeholder="">
              </div>
              <div class="form-group">
                <label for="admin_menu_list_edit" class="control-label">Menu Utama</label>
                <input type="hidden" id="admin_menu_list_old">
                <select style="width: 100%" class="admin_menu_list_edit form-control form-control-lg" id="admin_menu_list_edit" name="admin_menu_list_edit"></select>
            </div>
              <div class="form-group">
                  <label for="url_submenu_edit" class="control-label">URL</label>
                  <input type="text" class="form-control" id="url_submenu_edit" name="url_submenu_edit" placeholder="">
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-x"></i></button>
              <button type="button" class="btn btn-primary" id="update_submenu"><i class="fa fa-send"></i></button>
          </div>
      </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

  $('body').on('click', '#btn-edit-submenu', function () {
      //open modal
      //open modal
      let admin_sub_menus_id = $(this).data('id');
      // console.log(admin_menus_id);
      $.ajax({
        url: `{{ url('admin/menu/showsubmenu/${admin_sub_menus_id}') }}`,
        type: "GET",
        cache: false,
        success: function (response) {
          // console.log(response.data);
          $('#admin_sub_menus_id').val(response.data.id);
          $('#name_submenu_edit').val(response.data.name);
          $('#url_submenu_edit').val(response.data.url);
          $('#admin_menu_list_old').val(response.data.menus_id);
          
          $('.admin_menu_list_edit').select2({
            placeholder: `${response.data.menu.name}`,
            dropdownCssClass: "bigdrop",
            dropdownParent: $("#modal-edit-submenu"),
            // theme: "classic",
            // minimumInputLength: 2,
            ajax : {
              url: `{{ url('/admin/menu/menu-ajax') }}`,
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
      $('#modal-edit-submenu').modal('show');
  });

  
  $('#update_submenu').click(function (e) { 
      e.preventDefault();
      let admin_sub_menus_id = $('#admin_sub_menus_id').val();
      let name   = $('#name_submenu_edit').val();
      let url   = $('#url_submenu_edit').val();
      let menus_id   = $('#admin_menu_list_edit').val() == null ? $('#admin_menu_list_old').val() : $('#admin_menu_list_edit').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      console.log(menus_id, name, icon, url, menus_id);
      

      $.ajax({
          url: `{{ url('admin/menu/updatesubmenu/${admin_sub_menus_id}') }}`,
          type: "PUT",
          cache: false,
          data: {
              'name': name,
              'url': url,
              'menus_id': menus_id,
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
              $('#name_submenu').val('');
              $('#url_submenu').val('');
              $('#admin_menu_list').val('');

              //close modal
              $('#modal-edit-submenu').modal('hide');
              $('#dataTableSubMenu').DataTable().ajax.reload();
          },
          error: function (error) {
            console.error(error.responseJSON);
            if (error.responseJSON.url?.[0]) { 
              toastr.error(error.responseJSON.url[0]);
            }
            if (error.responseJSON.name?.[0]) { 
              toastr.error(error.responseJSON.name[0]);
            }
          }
      });
  });

  $('body').on('click', '#btn-delete-submenu', function () {
    let admin_menus_id = $(this).data('id');
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
          url: `{{ url('/admin/menu/destroysubmenu/${admin_menus_id}') }}`,
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
            $('#dataTableSubMenu').DataTable().ajax.reload();
          },
          error: function (error) { 
            console.log(error);
            swal.fire({
              icon: `error`,
              title: `Sub Menu`,
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