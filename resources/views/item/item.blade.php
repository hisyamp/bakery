@extends('template_backend_admin.app')
@section('subjudul','Data Item')
@section('content')

<!-- Add "Create" Button -->
<button class="btn btn-success mb-3" id="btn-create">Create Item</button>

<table id="table-item" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Aksi</th>
    </tr>
  </thead>
</table>

@endsection

@section('script')
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="modal" id="modal-detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form id="form-item" class="form" method="POST">
                    {{ csrf_field() }}

                    <div class="mb-13 text-center">
                        <h1 class="mb-3" id="modal-title">Detail Item</h1>
                    </div>

                    <div class="d-flex flex-column fv-row mb-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Nama Produk</span>
                        </label>
                        <input type="text" class="form-control form-control-solid" id="name" name="name" />
                    </div>

                    <div class="d-flex flex-column fv-row mb-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Kategori</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Cabang"></i>
                        </label>
                        <!--end::Label-->
                        <select class="form-select form-select-solid drdn" id="category" name="category" data-control="select2" data-hide-search="true" data-placeholder="Kategori">
                            <option value="">Pilih </option>
                            @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column fv-row mb-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Cabang</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Cabang"></i>
                        </label>
                        <!--end::Label-->
                        <select class="form-select form-select-solid drdn" id="branch_id" name="branch_id" data-control="select2" data-hide-search="true" data-placeholder="Cabang">
                            <option value="">Pilih </option>
                            @foreach($branch as $c)
                                <option value="{{$c->id}}">{{$c->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex flex-column fv-row mb-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Harga</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Harga"></i>
                        </label>
                        <!--end::Label-->
                        <input type="number" class="form-control form-control-solid" id="price" name="price" />
                    </div>


                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    var table = $('#table-item').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('api_item') }}',
        dom: 'lBfrtip',
        buttons: ['csv', 'pdf'],
        columns: [
            { 
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                className: 'dt-body-center',
            },
            { data: 'name', className: 'dt-body-center' },
            { data: 'category', className: 'dt-body-center' },
            {
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm btn-detail" data-id="${row.id}">
                            Detail
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">
                            Delete
                        </button>
                    `;
                },
                className: 'dt-body-center',
            }
        ],
    });

    // Handle Create button click
    $('#btn-create').click(function() {
        $('#modal-title').text('Create Item');
        $('#form-item')[0].reset();
        $('#modal-detail').modal('show');
        $('.drdn').trigger('change')
        
    });

    $('#save-btn').off('click').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ url("item") }}',
                type: "POST",
                data: $('#form-item').serialize(),
                success: function(response) {
                    Swal.fire('Success', 'Item created successfully!', 'success');
                    $('#modal-detail').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Error creating item!', 'error');
                }
            });
        });

    // Handle detail button click
    $('body').on('click', '.btn-detail', function() {
        var dataid = $(this).data('id');
        $('#modal-title').text('Detail Item');
        $.ajax({
            url: `{{ url('item/${dataid}') }}`,
            type: "GET",
            success: function(response) {
                console.log(response)
                $('#name').val(response.name);
                $('#category').val(response.category).trigger('change');;
                $('#branch_id').val(response.branch_id).trigger('change');;
                $('#price').val(response.price);

                $("#modal-detail").modal('show');
            },
            error: function(xhr) {
                Swal.fire('Error', 'Error fetching item details!', 'error');
            }
        });
    });

    // Handle delete button click with SweetAlert confirmation
    $('body').on('click', '.btn-delete', function() {
        var dataid = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action will delete the item permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('item/${dataid}') }}`,
                    type: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', 'Item has been deleted.', 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Error deleting item!', 'error');
                    }
                });
            }
        });
    });
});
</script>

@endsection
