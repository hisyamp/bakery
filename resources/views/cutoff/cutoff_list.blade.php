@extends('template_backend_admin.app')
@section('subjudul','Closing')
@section('content')


<div class="card p-5 mt-2">
    
    <div class="d-flex flex-column fv-row mb-2 my-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Nama Closing</span>
        </label>
        <input type="text" class="form-control form-control-solid my-2" id="cutoff_name" name="cutoff_name">
    </div>

    <div class="d-flex flex-column fv-row mb-2 my-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Tanggal</span>
        </label>
        <input type="date" class="form-control form-control-solid my-2" id="transaction_date" name="transaction_date">
    </div>


    <div class="d-flex flex-column fv-row mb-2 my-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Status</span>
        </label>
        <select class="form-select form-select-solid drdn" id="status" name="status" data-control="select2" data-hide-search="true" data-placeholder="Item">
            <!-- Populate log types from log_types table -->
            <option value="open">Open</option>
            <option value="process">Process</option>
            <option value="close">Closed</option>
        </select>
    </div>
    

    <div class="d-flex flex-column fv-row mb-2">
        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
            <span>Notes</span>
        </label>
        <textarea class="form-control form-control-solid my-2" id="notes" name="notes"></textarea>
    </div>
    <div>
        <button class="btn btn-info mb-3" id="btn-create">Closing</button>
    </div>
</div>

<div class="card p-5 mt-2">
    <!-- Logs Table -->
    <table id="table-log" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Id</th>
                <th>Nama</th>
                <th>Stok Awal</th>
                <th>Finishgood</th>
                <th>Waste</th>
                <th>Sell</th>
                <th>Total</th>
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

        $('#date-log').val(date)

        var table = $('#table-log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ url('/api_cutoff_list') }}`,
                type: 'GET', // Set the request method to POST
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
                { data: 'item_id', className: 'dt-body-center' },
                { data: 'item_name', className: 'dt-body-center' },
                { data: 'stok_akhir', className: 'dt-body-center' },
                { data: 'finishgood', className: 'dt-body-center' },
                { data: 'waste', className: 'dt-body-center' },
                { data: 'sell', className: 'dt-body-center' },
                { data: 'net_stock', className: 'dt-body-center' },
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
                cutoff_name: $('#cutoff_name').val(),
                start_date: $('#transaction_date').val(),
                end_date: $('#transaction_date').val(),
                notes: $('#notes').val(),
                _token : '{{ csrf_token() }}'
            };

            // You can now use `data` in your AJAX request
            console.log(data);  // Debugging: Check the data object
            // return
            $.ajax({
                    url: '{{ url("cutoff") }}',
                    type: "POST",
                    data: data,
                    success: function(response) {
                        Swal.fire('Success', 'Cutoff created successfully!', 'success');
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
