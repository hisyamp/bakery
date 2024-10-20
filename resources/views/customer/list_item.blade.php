@extends('template_backend_admin.app')
@section('subjudul','List Pengembalian')
@section('content')
<table id="table-user" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">NO.IO/SP2K/SO</th>
      <th class="text-center">Valuation Type</th>
      <th class="text-center">Customer</th>
      <th class="text-center">Status</th>
      <th class="text-center">Tanggal Pengembalian</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
</table>
@endsection
@section('script')
<div class="modal" id="modal-detail" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content rounded">
					<!--begin::Modal header-->
					<div class="modal-header pb-0 border-0 justify-content-end">
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Close-->
					</div>
					<!--begin::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">

						<!--begin:Form-->
						<form id="form-regist" class="form" action="{{ route('register') }}" method="POST">
						{{ csrf_field() }}

            <!--begin::Heading-->
            <div class="mb-13 text-center">
                <!--begin::Title-->
                <h1 class="mb-3">Form Pengembalian Item</h1>
                <!--end::Title-->
                <!--begin::Description-->
                <!-- <div class="text-muted fw-bold fs-5">If you need more info, please check -->
                <!-- <a href="#" class="fw-bolder link-primary">Project Guidelines</a>.</div> -->
                <!--end::Description-->
            </div>
            <!--end::Heading-->

            <div class="d-flex flex-column fv-row mb-2">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">NO. IO/SP2K/SO/PO/ANDOP</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="NO. IO/SP2K/SO/PO/ANDOP"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="NO. IO/SP2K/SO/PO/ANDOP" name="so" id="so" />
            </div>

        <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Tanggal</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tanggal"></i>
                </label>
                <!--end::Label-->
                <input type="date" class="form-control form-control-solid" placeholder="Tanggal" name="tanggal" id="tanggal"/>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Valuation Type</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valuation Type"></i>
                </label>
                <!--end::Label-->
                <select class="form-select form-select-solid drdn" id="valuation_type" name="valuation_type" data-control="select2" data-hide-search="true" data-placeholder="Valuation Type" name="valuation_type">
                    <option value="">Pilih Valuation Type...</option>
                    <option value="ex-Project">ex-Project</option>
                    <option value="Dismantle">Dismantle</option>
                    <option value="Rusak-L">Rusak-L</option>
                    <option value="Rusak-TL">Rusak-TL</option>
                </select>
                </div>
                <!--end::Col-->
            </div>
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Lokasi Asal</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Lokasi Asal"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Lokasi Asal" name="lokasi_asal" id="lokasi_asal"/>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Customer Name(CPE)</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Customer Name(CPE)"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Customer Name" name="customer_name" id="customer_name"/>
                </div>
                <!--end::Col-->
            </div>
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Type</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Type"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Type" name="type" id="type"/>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Merk</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Merk"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Merk" name="merk" id="merk"/>
                </div>
                <!--end::Col-->
                
            </div>
            <div class="d-flex flex-column fv-row mb-2">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Serial Number(SN) / Batch</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Serial Number(SN) / Batch"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Serial Number(SN) / Batch" name="sn" id="sn" />
            </div>
            <div class="alert alert-info alert-block mt-5">
                <div class="text-muted fw-bold fs-5 mb-7 mt-7">Beri tanda centang pada checkbox jika 
                    <strong class="link-primary fw-bolder">Material Rusak</strong></div>
            </div>

            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Continue</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Continue"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="is_continue" name="is_continue"/>
                    <label class="form-check-label" for="is_continue">
                        Indikasi error terjadi terus menerus
                    </label>
                </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Intermitent</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Intermitent"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="intermittent" name="intermittent"/>
                    <label class="form-check-label" for="intermitent">
                        Indikasi error terjadi kadang-kadang/random
                    </label>
                </div>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->
                        <!-- checbox -->
                        <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Dead On Arrival</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Dead On Arrival"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="dead_on_arrival" name="dead_on_arrival"/>
                    <label class="form-check-label" for="dead_on_arrival">
                        Perangkat mati total pada jangka waktu 24 jam setelah pemasangan
                    </label>
                </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Rectifier/inverter fault(Input/Output Voltage/Current Fault)</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Rectifier/inverter fault(Input/Output Voltage/Current Fault)"></i>
                </label>
                <!--end::Label-->
                <select class="form-select form-select-solid drdn" id="rectifier" name="rectifier" data-control="select2" data-hide-search="true" data-placeholder="Rectifier/Inverter Fault" name="valuation_type">
                    <option value="">Pilih Rectifier/inverter fault</option>
                    <option value="Input">Input</option>
                    <option value="Output Voltage">Output Voltage</option>
                    <option value="Current Fault">Current Fault</option>
                </select>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->
                        <!-- checbox -->
                        <div class="row g-9 mb-8">
                
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Dead On Operational</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Dead On Operational"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="dead_on_operational" name="dead_on_operational"/>
                    <label class="form-check-label" for="dead_on_operational">
                        Perangkat mati total saat beroperasi normal
                    </label>
                </div>
                </div>
                <!--end::Col-->                
                                
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Charging/Static Switch</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Charging/Static Switch"></i>
                </label>
                <!--end::Label-->
                <select class="form-select form-select-solid drdn" id="charging" name="charging" data-control="select2" data-hide-search="true" data-placeholder="Charging/Static Switch" name="valuation_type">
                    <option value="">Pilih Battery Faulty</option>
                    <option value="Pengisian Rusak">Pengisian Rusak</option>
                    <option value="Switch Rusak">Switch Rusak</option>
                </select>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->
            <!-- checbox -->
            <div class="row g-9 mb-8">

                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">BER Indicator</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="BER Indicator"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="ber" name="ber"/>
                    <label class="form-check-label" for="ber">
                        Indikasi error pada display modul/NMS/hasil bertest(disertakan no trip yang error)
                    </label>
                </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Battery Faulty</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Battery Faulty"></i>
                </label>
                <!--end::Label-->
                <select class="form-select form-select-solid drdn" id="battery_faulty" name="battery_faulty" data-control="select2" data-hide-search="true" data-placeholder="Battery Faulty" name="valuation_type">
                    <option value="">Pilih Battery Faulty</option>
                    <option value="Battery Rusak">Battery Rusak</option>
                    <option value="Battery Drop">Battery Drop</option>
                </select>
                </div>
                <!--end::Col-->
                
            </div>
            <!-- endchecbox -->
            
            <!-- checbox -->
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Software Error</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Software Error"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="software_error" name="software_error"/>
                    <label class="form-check-label" for="software_error">
                        Gangguan yang disebabkan firmware/IOS/internet EPROM
                    </label>
                </div>
                </div>
                <!--end::Col-->                
            </div>
            <!-- endchecbox -->
            <!-- checbox -->
            <div class="row g-9 mb-8">
                
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Tributary Error</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tributary Error"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="tributary_error" name="tributary_error"/>
                    <label class="form-check-label" for="tributary_error">
                        Low order modul error (PDH/SDH)
                    </label>
                </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Number of Tribu</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tributary Error"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Number of Tribu" name="number_of_tribu" id="number_of_tribu"/>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->

            <!-- checbox -->
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Channel Error</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Channel Error"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="channel_error" name="channel_error"/>
                    <label class="form-check-label" for="channel_error">
                        64K channelize "<"2Mb Fault (for VFEM,V.24, Voice Ch)
                    </label>
                </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Number of Char</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Tributary Error"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Number of Char" name="number_of_channel" id="number_of_channel"/>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->
            <!-- checbox -->
            <div class="row g-9 mb-8">
                
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Port Error</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Port Error"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="port_error" name="port_error"/>
                    <label class="form-check-label" for="port_error">
                        Port membangkitkan error/mati total(IP network family, converter)
                    </label>
                </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Number of Port</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Port Error"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Number of Port" name="number_of_port" id="number_of_port"/>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->

            <!-- checbox -->
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Laser Tx Faulty</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Laser Tx Faulty"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="tx_laser_faulty" name="tx_laser_faulty"/>
                    <label class="form-check-label" for="tx_laser_faulty">
                    Only Optical Modul Tx Loss, No Signal, High Temp, Laser Bias
                    </label>
                </div>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->

            <!-- checbox -->
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Laser Rx Faulty</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Laser Rx Faulty"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rx_laser_faulty" name="rx_laser_faulty"/>
                    <label class="form-check-label" for="rx_laser_faulty">
                        Only Optical Modul No.Rx. Frame error
                    </label>
                </div>
                </div>
                <!--end::Col-->
            </div>
            <!-- endchecbox -->

            <!-- checbox -->
            <div class="row g-9 mb-8">
                <!--begin::Col-->
                <div class="col-md-6 fv-row">
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Physical Damage</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Physical Damage"></i>
                </label>
                <!--end::Label-->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="physical_damage" name="physical_damage"/>
                    <label class="form-check-label" for="physical_damage">
                        Rusak physic perangkat, benturan, short circuit, liquid
                    </label>
                </div>
                </div>
                <!--end::Col-->

            </div>
            <!-- endchecbox -->


            <!--begin::Input group-->
            <div class="d-flex flex-column fv-row mb-2">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Misscellaneous</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Sebab lain yang tidak tertulis diatas, mohon indikasi dijelaskan"></i>
                </label>
                <!--end::Label-->
                <textarea class="form-control form-control-solid"  id="notes" cols="30" rows="3"></textarea>
            </div>
            <!-- checbox -->

        </form>
						<!--end:Form-->
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
    
<script type="text/javascript">
  $(document).ready(function () {
    $('#table-user').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{url('api_logpengajuan')}}',
      columns: [
        {
           render: function (data, type, row, meta) {
             return meta.row + meta.settings._iDisplayStart + 1;
           },
           className: 'dt-body-center',
        },
        {
           data: 'so',
           className: 'dt-body-center',
        },
        {
           data: 'valuation_type',
           className: 'dt-body-center'
        },
        {
           data: 'customer_name',
           className: 'dt-body-center'
        },
        {
          "render": function ( data, type, row ) {
             if(row.status=="A")return 'menunggu'
             else if(row.status=="B")return 'ditolak'
             else if(row.status=="C")return 'disetujui'
             else return '-'
           },
           className: 'dt-body-center',
        },
        {
           data: 'tanggal',
           className: 'dt-body-center'
        },
        {
           "render": function ( data, type, row ) {
             return `<button class="btn btn-primary btn-sm btn-detail" data-id="${row.id}">Detail</button>
             `
           },
           className: 'dt-body-center',
        }
      ],
    });
    var id_laporan
    $('body').on('click', '.btn-detail', function() {
        var dataid = $(this).data('id')
        id_laporan = dataid
        console.log("id_laporan change to", id_laporan)
        // console.log(`{{url('detailitem/${dataid}')}}`)
      $("#modal-detail").modal('show')
      $.ajax({
            url: `{{url('detailitem/${dataid}')}}`,
            type: "GET", 
            success: function(response) {
                console.log("data detail item",response)
                    // $('#modal-regis').modal('hide')
                    $('#so').val(response.data.so)
                    $('#valuation_type').val(response.data.valuation_type)
                    $('#tanggal').val(response.data.tanggal)
                    $('#lokasi_asal').val(response.data.lokasi_asal)
                    
                    $('#customer_name').val(response.data.customer_name)
                    $('#merk').val(response.data.merk)
                    $('#type').val(response.data.type)
                    $('#miscelaneous').val(response.data.miscelaneous)
                    if(response.data.status =="A") $('#status').val("Menunggu keputusan")
                    else if(response.data.status =="B") $('#status').val("Ditolak")
                    else if(response.data.status =="C") $('#status').val("Disetujui")
                    console.log(response.data)
                    var arr = response.data
                    // response.data.map((val)=>{console.log(val)})
                    for (const key in arr) {
                        if(arr[key] === "yes")
                        {
                            $(`#${key}`).prop('checked', true);
                        }
                        // console.log(`${key}: ${arr[key]}`);
                    }
                    
            },
            error: function(data) { 
                console.log('Error:', data);
            }
        });
    })
    $('body').on('click', '#btn-reject', function() {
        event.preventDefault();
        dataId = $(this).attr('data-id');
        // console.log(dataId)
        Swal.fire({ 
            title: "Konfirmasi",
            text: "Apakah yakin menolak pengembalian item ini ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Tolak`,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST", 
                    url: `{{ url('/actionitem/${id_laporan}/B') }}`,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Harap Tunggu',
                            text: "Data sedang diproses",
                            icon: 'info',
                            timer: 4000,
                            didOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal
                                        .getContent()
                                    if (content) {
                                        const b = content
                                            .querySelector(
                                                'b')
                                        if (b) {
                                            b.textContent =
                                                Swal
                                                .getTimerLeft()
                                        }
                                    }
                                }, 300)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            },
                        });
                    },
                    success: function(result) {
                        Swal.fire({
                            title: "Sukses!",
                            text: "Pengembalian berhasil ditolak !",
                            icon: "success",
                            confirmButtonText: `OK`,
                        }).then((ok) => {
                            if (ok.value) {
                                console.log("sukses")
                            }
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", xhr + " " + ajaxOptions + " " +
                            thrownError,
                            "error");
                    }
                });
            } else {
                return false;
            }
        });        
    });
    $('body').on('click', '#btn-approve', function() {
        event.preventDefault();
        dataId = $(this).attr('data-id');
        console.log(dataId)
        Swal.fire({ 
            title: "Konfirmasi",
            text: "Apakah yakin menyetujui pengembalian item ini ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Ubah`,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: `{{ url('/actionitem/${id_laporan}/C') }}`,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Harap Tunggu',
                            text: "Upload dokumen sedang diproses",
                            icon: 'info',
                            timer: 4000,
                            didOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal
                                        .getContent()
                                    if (content) {
                                        const b = content
                                            .querySelector(
                                                'b')
                                        if (b) {
                                            b.textContent =
                                                Swal
                                                .getTimerLeft()
                                        }
                                    }
                                }, 300)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            },
                        });
                    },
                    success: function(result) {
                        Swal.fire({
                            title: "Sukses!",
                            text: "Status aktivasi berhasil diubah !",
                            icon: "success",
                            confirmButtonText: `OK`,
                        }).then((ok) => {
                            if (ok.value) {
                                console.log("sukses")
                            }
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", xhr + " " + ajaxOptions + " " +
                            thrownError,
                            "error");
                    }
                });
            } else {
                return false;
            }
        });        
    });
  
  });
  
</script>
@endsection