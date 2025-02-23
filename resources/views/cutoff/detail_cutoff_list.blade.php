@extends('template_backend_admin.app')
@section('subjudul','Pencatatan Data')
@section('content')
<div class="card p-5">

    <div class="row">

    <!--begin::Col-->
    <div class="col-md-3 fv-row">
        
        <!--end::Label-->
        <select class="form-select form-select-solid drdn" id="filter_log" name="filter_log" data-control="select2" data-hide-search="true" data-placeholder="Tipe Pencatatan" name="filter_log">
            <option value="">Pilih Tipe Pencatatan...</option>
            @foreach ($log_types as $log_type)
                <option value="{{ $log_type->id }}">{{ $log_type->name }}</option>
            @endforeach
        </select>
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-md-3 fv-row">
        <!--end::Label-->
        <input type="date" class="form-control form-control-solid" placeholder="Tanggal" name="tanggal_filter" id="tanggal_filter"/>
    </div>
    <div class="card-body card-scroll">
    <!--begin::Col-->
        <!-- <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span>Tanggal</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tanggal"></i>
                </label>
                <input type="text" class="form-control form-control-solid" placeholder="Select Date Range" name="dateRangePicker" id="dateRangePicker"/>
            </div>
        </div> -->
    <!--end::Col-->
    <!-- Add "Create Log" Button -->
    <div class="col-md-3">
        <button class="btn btn-success mb-3" id="btn-filter">Filter</button>
    </div>

    </div>
<!-- Logs Table -->
<table id="table-log" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Item</th>
            <th>Log Type</th>
            <th>Qty</th>
            <th>Notes</th>
            <!-- <th>Aksi</th> -->
        </tr>
    </thead>
</table>

<!-- Modal for Log Details -->
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
                <form id="form-log" class="form" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-13 text-center">
                        <h1 class="mb-3" id="modal-title">Detail Log</h1>
                    </div>
                    <div class="d-flex flex-column fv-row mb-2 my-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Tanggal</span>
                        </label>
                        <input type="date" class="form-control form-control-solid my-2" id="date-log" name="notesdate-log">
                    </div>
                    
                    <div class="d-flex flex-column fv-row mb-2 my-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Item</span>
                        </label>
                        <select class="form-control form-control-solid my-2" id="item_id" name="item_id">
                            <!-- Populate items from items table -->
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-column fv-row mb-2 my-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Log Type</span>
                        </label>
                        <select class="form-control form-control-solid my-2" id="log_type_id" name="log_type_id">
                            <!-- Populate log types from log_types table -->
                            @foreach ($log_types as $log_type)
                                <option value="{{ $log_type->id }}">{{ $log_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-column fv-row mb-2 my-2">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span>Notes</span>
                        </label>
                        <textarea class="form-control form-control-solid my-2" id="notes" name="notes"></textarea>
                    </div>
                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
        flatpickr("#dateRangePicker", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: [new Date(),new Date()],
            onClose: function(selectedDates, dateStr, instance) {
                if (dateStr) {
                    const [startDate, endDate] = dateStr.split(" to ");
                    console.log("Start Date:", startDate); // Logs the start date
                    console.log("End Date:", endDate);     // Logs the end date
                }
            }
        });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date().toISOString().split('T')[0]
        var id_filter = $('#filter_log').val()

        // $('#tanggal_filter').val(date)
        var table = $('#table-log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ url('/api_log') }}`,
                type: 'POST', // Set the request method to POST
                data: function (d) {
                    // Always fetch the latest values
                    var typeLogId = $('#filter_log').val();
                    var date = $('#tanggal_filter').val();
                    var id = '{{$id}}'; // Assuming this is a PHP variable in Blade
                    
                    // Add parameters only if they are not empty
                    if (typeLogId) d.type_log_id = typeLogId;
                    if (date) d.date = date;
                    if (id) d.id = id;

                    // CSRF token (optional if using Laravel's built-in CSRF protection)
                    d._token = '{{ csrf_token() }}';
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
                // { render: function (data, type, row) {
                //         return `<button class="btn btn-primary btn-sm btn-detail" data-id="${row.id}">Detail</button>`;
                //     }, className: 'dt-body-center' }
            ],
        });

        $('#btn-filter').on('click', function () {
            // Update filter values dynamically
            id_filter = $('#filter_log').val(); // Get new filter ID
            date = $('#tanggal_filter').val(); // Get new date filter
            console.log(`id_filter ${id_filter} --- date ${date}`);
            // Reload the DataTable with updated parameters
            table.ajax.reload(null, false); // Pass `false` to keep the current pagination
        });

        // Handle Create button click
        // $('#btn-create').click(function() {
        //     $('#modal-title').text('Create Log');
        //     $('#form-log')[0].reset();
        //     $('#modal-detail').modal('show');
        //     $('#save-btn').off('click').on('click', function(e) {
        //         e.preventDefault();
        //         $.ajax({
        //             url: '{{ url("log") }}',
        //             type: "POST",
        //             data: $('#form-log').serialize(),
        //             success: function(response) {
        //                 Swal.fire('Success', 'Log created successfully!', 'success');
        //                 $('#modal-detail').modal('hide');
        //                 table.ajax.reload();
        //             },
        //             error: function(xhr) {
        //                 Swal.fire('Error', 'Error creating log!', 'error');
        //             }
        //         });
        //     });
        // });

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
                        url: `{{ url('log/${dataid}') }}`,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'Log has been deleted.', 'success');
                            table.ajax.reload();
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
