@extends('layouts.admin') 

@section('main-content')
@php
    use App\Models\User_role_menu;
@endphp
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Role</h1>

<div class="row">

    <div class="col-md-7">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="mt-2 font-weight-bold text-primary">Data Role: {{ $role->name }}</h6>
      </div>
      <div class="card-body">
        @foreach ($admin_menu as $am)
            @php
                $user_role_menu = user_role_menu::where('roles_id', $roles_id)->where('menus_id', $am->id)->select('id', 'roles_id', 'menus_id')->get();
            @endphp
            <div class="row d-flex justify-content-beetwen mb-2">
              <div class="col" style="font-size: 16px">
                {{ $am->name }}
              </div>
              <div class="col text-right">
                <div class="form-check">
                  <input class="form-check-input position-static" style="transform: scale(2)" type="checkbox" data-role="{{ $roles_id }}" data-menu="{{ $am->id }}" {{ (count($user_role_menu) > 0 ? "checked" : "") }} >
                </div>
              </div>
            </div>
        @endforeach
      </div>
    </div>
    
    
    </div>
</div>
@endsection 

@push('scripts')
  <script>
     $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: `{{ url('admin/role/change-access/${menuId}/${roleId}') }}`,
            type: 'get',
            cache: false,
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
              location.reload();
            },
        });
    });
  </script>

@endpush