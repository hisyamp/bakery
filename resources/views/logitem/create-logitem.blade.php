@extends('template_backend_admin.app')
@section('subjudul','Create Log Data')
@section('content')


<div class="card p-5 mt-2">
        <div class="d-flex flex-column fv-row mb-2 my-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Tanggal</span>
        </label>
        <input type="date" class="form-control form-control-solid my-2" id="date-log" name="notesdate-log">
    </div>

    <div class="d-flex flex-column fv-row mb-2 my-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Log Type</span>
        </label>
        <select class="form-select form-select-solid drdn" id="log_type_id" name="log_type_id" data-control="select2" data-hide-search="true" data-placeholder="Item">
            <!-- Populate log types from log_types table -->
            @foreach ($log_types as $log_type)
                <option value="{{ $log_type->id }}">{{ $log_type->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="row g-9 mb-2">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">Item</span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Item"></i>
            </label>
            <!--end::Label-->
            <select class="form-select form-select-solid drdn" id="item" name="item" data-control="select2" data-hide-search="true" data-placeholder="Item">
                <option value="">Pilih Item...</option>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span class="required">Jumlah</span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Jumlah"></i>
            </label>
            <!--end::Label-->
            <input type="number" class="form-control form-control-solid" placeholder="Jumlah" name="jumlah" id="jumlah"/>
        </div>
        <!--end::Col-->
    </div>
    <div class="d-flex flex-column fv-row mb-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Notes</span>
        </label>
        <textarea class="form-control form-control-solid my-2" id="notes" name="notes"></textarea>
    </div>
    <div>
        <button class="btn btn-info mb-3" id="btn-create">Add</button>
    </div>
</div>

<div class="card p-5 mt-2">
    <!-- Logs Table -->
    <table id="table-log" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Log Type</th>
                <th>Qty</th>
                <th>Notes</th>
                <th>Date</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

</div>

@endsection

@section('script')
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date().toISOString().split('T')[0]
        var id_filter = $('#filter_log').val()
        // const minDate = new Date({{$latestLogItemDate}}); 
        
        let latestLogItemDate = '{{$latestLogItemDate}}';

        // Check if latestLogItemDate is valid
        if (latestLogItemDate) {
            let minDate = new Date(latestLogItemDate);
            minDate.setDate(minDate.getDate() + 1); // Add 1 day

            flatpickr("#date-log", {
                minDate: minDate.toISOString().split('T')[0], // Format as YYYY-MM-DD
                dateFormat: "Y-m-d",
            });
        } else {
            flatpickr("#date-log", {
                minDate: "{{ now()->format('Y-m-d') }}",
                dateFormat: "Y-m-d",
            });
        }
            
        $('#date-log').val(date)

        var table = $('#table-log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ url('/api_log') }}`,
                type: 'POST', // Set the request method to POST
                data: function (d) {
                    // Always fetch the latest values
                    d.type_log_id = $('#log_type_id').val(); // Get the value from the input field
                    d.date = $('#date-log').val(); // Get the updated date value
                    d._token = '{{ csrf_token() }}'; // Add CSRF token
                }
            },            
            dom: 'lBfrtip',
            buttons: ['csv', 'pdf'],
            columns: [
                { render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, className: 'dt-body-center' },
                { data: 'name', className: 'dt-body-center' },
                { data: 'log_type_name', className: 'dt-body-center' },
                { data: 'qty', className: 'dt-body-center' },
                { data: 'notes', className: 'dt-body-center' },
                { data: 'transaction_date', className: 'dt-body-center',
                        render: function(data, type, row) {
                        // Format the transaction_date as 'YYYY-MM-DD'
                        var date = new Date(data); // Convert the data to a Date object
                        var formattedDate = date.toISOString().split('T')[0]; // Get the date part
                        return formattedDate; // Return the formatted date
                    }
                },
                { render: function (data, type, row) {
                        return `<button class="btn btn-primary btn-sm btn-detail m-2" data-id="${row.id}">Detail</button>
                                <button class="btn btn-danger btn-sm btn-delete m-2" data-id="${row.id}">Delete</button>`;
                    }, className: 'dt-body-center' }
            ],
        });

        $('#log_type_id').on('change', function () {
            // Update filter values dynamically
            id_filter = $('#log_type_id').val(); // Get new filter ID
            date = $('#date-log').val(); // Get new date filter
            console.log(`id_filter ${id_filter} --- date ${date}`);
            // Reload the DataTable with updated parameters
            table.ajax.reload(null, false); // Pass `false` to keep the current pagination
        });

        $('#date-log').on('change', function () {
            // Update filter values dynamically
            id_filter = $('#log_type_id').val(); // Get new filter ID
            date = $('#date-log').val(); // Get new date filter
            console.log(`id_filter ${id_filter} --- date ${date}`);
            // Reload the DataTable with updated parameters
            table.ajax.reload(null, false); // Pass `false` to keep the current pagination
        });


        // Handle Create button click
        $('#btn-create').click(function() {
            // $('#modal-title').text('Create Log');
            // $('#form-log')[0].reset();
            // $('#modal-detail').modal('show');
            var data = {
                item_id: $('#item').val(),
                branch_id: "{{ auth()->user()->branch_id }}",  // Use Blade syntax to get the authenticated user's branch_id
                type_log_id: $('#log_type_id').val(),
                transaction_date: $('#date-log').val(),
                uom: 'pcs',
                qty: parseInt($('#jumlah').val())??0,
                notes: $('#notes').val(),
                _token : '{{ csrf_token() }}'
            };

            // You can now use `data` in your AJAX request
            console.log(data);  // Debugging: Check the data object
            // return
            $.ajax({
                    url: '{{ url("logitem") }}',
                    type: "POST",
                    data: data,
                    success: function(response) {
                        Swal.fire('Success', 'Log created successfully!', 'success');
                        table.ajax.reload(null, false); // Pass `false` to keep the current pagination
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Error creating log!', 'error');
                    }
                });
        });

        // Handle detail button click
        $('body').on('click', '.btn-detail', function() {
            var dataid = $(this).data('id');
            $('#modal-title').text('Detail Log');
            $.ajax({
                url: `{{ url('log/${dataid}') }}`,
                type: "GET",
                success: function(response) {
                    $('#item_id').val(response.item_id);
                    $('#log_type_id').val(response.log_type_id);
                    $('#notes').val(response.notes);
                    $('#modal-detail').modal('show');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Error fetching log details!', 'error');
                }
            });
        });

        // Handle delete button click with SweetAlert confirmation
        $('body').on('click', '.btn-delete', function() {
            var dataid = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete the log permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('logitem/${dataid}') }}`,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'Log has been deleted.', 'success');
                            table.ajax.reload(null, false); // Pass `false` to keep the current pagination
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Error deleting log!', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
