@extends('template_backend_admin.app')
@section('subjudul','Dashboard')
@section('script_atas')
<script type="text/javascript"></script>
@endsection
@section('content')
<div class="card bg-light shadow-sm m-5">
    <div class="card-header">
        <h3 class="card-title">Dashboard Laporan</h3>
    </div>
    <div class="card card-bordered">
        <div class="card-body">
            <div id="chart" style="height: 350px;"></div>
        </div>
    </div>
    <div class="p-4">
        <table id="table-log" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Finishgood</th>
                    <th>Waste</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-body card-scroll h-500px">
    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <span class="svg-icon fs-3 text-success me-2">
                    >>>
                </span>
                <div class="fs-2 fw-bold" data-kt-countup="false" data-kt-countup-prefix="@" id="box-user">0</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 ">Jumlah User</div>
            <!--end::Label-->
        </div>
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <span class="svg-icon fs-3 text-success me-2">
                    >>>
                </span>
                <div class="fs-2 fw-bold" data-kt-countup="false" data-kt-countup-prefix="@" id="box-A">0</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 ">Menunggu Persetujuan</div>
            <!--end::Label-->
        </div>
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <span class="svg-icon fs-3 text-success me-2">
                    >>>
                </span>
                <div class="fs-2 fw-bold" data-kt-countup="false" data-kt-countup-prefix="@" id="box-B">0</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 ">Pengajuan Ditolak</div>
            <!--end::Label-->
        </div>
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <span class="svg-icon fs-3 text-success me-2">
                    >>>
                </span>
                <div class="fs-2 fw-bold" data-kt-countup="false" data-kt-countup-prefix="@" id="box-C">0</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 ">Pengajuan Disetujui</div>
            <!--end::Label-->
        </div>
    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

<script>
    function payNow(){
        // console.log("tes asajaaa")
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: `{{url('api_dashboard')}}`,
            type: "GET", 
            success: function(response) {
                    // console.log("data api dashboard",response)
                    $('#box-user').html(response.data.dataUser)
                    $('#box-A').html(response.data.dataA)
                    $('#box-B').html(response.data.dataB)
                    $('#box-C').html(response.data.dataC)
                    
                    var options = {
                        series: [{
                        name: 'chart',
                        type: 'column',
                        data: [response.data.dataUser,response.data.dataA,response.data.dataB,response.data.dataC]
                        }, {
                        name: 'jumlah',
                        type: 'line',
                        data: [response.data.dataUser,response.data.dataA,response.data.dataB,response.data.dataC]
                        }],
                        chart: {
                        height: 350,
                        type: 'line',
                        },
                        stroke: {
                        width: [0, 4]
                        },
                        title: {
                        text: 'Grafik Laporan'
                        },
                        dataLabels: {
                        enabled: true,
                        enabledOnSeries: [1]
                        },
                        labels: ['Jumlah user','Menunggu Persetujuan', 'Ditolak', 'Disetujui',],
                        xaxis: {
                        type: ''
                        },
                        yaxis: [{
                        title: {
                            text: 'total pengajuan',
                        },
                        
                        }, {
                        opposite: true,
                        title: {
                            text: '-'
                        }
                        }]
                        };

                        var chart = new ApexCharts(document.querySelector("#chart"), options);
                        chart.render();
                    
            },
            error: function(data) { 
                console.log('Error:', data);
            }
        });
        var table = $('#table-log').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `{{ url('api_report/2025-02-01/2025-02-28') }}`,
            type: 'GET',
        },
        columns: [
            { render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }, className: 'dt-body-center' },
            { data: 'item_name', className: 'dt-body-center' },
            { data: 'qty_finish_good', className: 'dt-body-center' },
            { data: 'qty_waste', className: 'dt-body-center' },
            { data: 'total_percentage', className: 'dt-body-center' }
        ],
    });
    })
</script>
<script>
    var countfetch = 0
    setInterval(() => {
        countfetch+=1
        // console.log("countfetch",countfetch)
        if(true)
        {
            $.ajax({
                url: `{{url('ceklaporan')}}`,
                type: "GET", 
                success: function(response) {
                    // console.log("data detail item",response.data)
                    if(response.data > 0)
                    {
                        Swal.fire({
                            title: "Alert!",
                            text: "Ada laporan yang harus ditinjau !",
                            icon: "warning",
                            confirmButtonText: `Lihat`,
                        }).then((ok) => {
                            if (ok.value) {
                                window.location.href = "{{ route('list_logitem')}}";
                            }
                        });
                    }
                    // $('#modal-regis').modal('hide')
                },
                error: function(data) { 
                    console.log('Error:', data);
                }
            });
        }
    }, 60*1000);
</script>

<script>
    
</script>
@endsection