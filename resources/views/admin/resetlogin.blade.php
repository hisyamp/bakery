@extends('template_backend_admin.app')
@section('subjudul','Reset Login')
@section('content')
<table id="table-user" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">Nama</th>
      <th class="text-center">Email</th>
      <th class="text-center">No HP</th>
      <th class="text-center">Provinsi</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
</table>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function () {
    $('#table-user').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{url('apilistuser')}}',
      columns: [
        {
           render: function (data, type, row, meta) {
             return meta.row + meta.settings._iDisplayStart + 1;
           },
           className: 'dt-body-center',
        },
        {
           data: 'nama',
           className: 'dt-body-center',
        },
        {
           data: 'email',
           className: 'dt-body-center'
        },
        {
           data: 'nohp',
           className: 'dt-body-center'
        },
        {
           data: 'provinsi',
           className: 'dt-body-center'
        },
        {
           "render": function ( data, type, row ) {
             return '<button class="btn btn-primary btn-sm btnreset" data-id="'+ row.id_user +'">Reset Password</button>'
           },
           className: 'dt-body-center',
        }
      ],
    });

    $('body').on('click', '.btnreset', function() {
        dataId = $(this).attr('data-id');
        // console.log(dataId)
        Swal.fire({ 
            title: "Konfirmasi",
            text: "Apakah yakin mereset password akun ini ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Reset Password`,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST", 
                    dataType: 'json',
                    url: "{{ url('/reset_password') }}",
                    data : {
                        "id" : dataId,
                        "_token": "{{ csrf_token() }}"
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
                            text: "Data berhasil diubah !",
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