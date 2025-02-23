@extends('template_backend_admin.app')
@section('subjudul','Report')
@section('script_atas')
<script type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
@section('content')
<div class="card bg-light shadow-sm m-5">
    <div class="card-header">
        <h3 class="card-title">Report</h3>
    </div>
    <div class="card-body card-scroll">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                <span>Tanggal</span>
                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tanggal"></i>
            </label>
            <!--end::Label-->
            <input type="text" class="form-control form-control-solid" placeholder="Select Date Range" name="dateRangePicker" id="dateRangePicker"/>
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
        flatpickr("#dateRangePicker", {
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                if (dateStr) {
                    const [startDate, endDate] = dateStr.split(" to ");
                    console.log("Start Date:", startDate); // Logs the start date
                    console.log("End Date:", endDate);     // Logs the end date
                }
            }
        });
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
@endsection