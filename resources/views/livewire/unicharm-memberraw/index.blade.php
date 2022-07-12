@extends('adminlte::page')

@section('title', 'Data Member Raw')

@section('content_header')
    <h3>
        Data Member Raw
    </h3>
@stop

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>

    body{
        background: #ccc;
    }

    form{
        background: #fff;
        padding: 20px;
    }

    .progress { 
        position:relative;
        width:100%;
    }
    .bar { 
        background-color: #00ff00;
        width:0%;
        height:20px;
    }
    .percent {
        position:absolute;
        display:inline-block; 
        left:50%;
        color: #040608;
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="row">
            {{-- <form action="/member-raw-import"  method="POST" enctype="multipart/form-data"> --}}
            <form action="{{ route('memberraw-import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- <input type="file" name="file" class="form-control"> --}}
                <input type="file" name="file" class="form-control">
                <br>
                <a type="text" class="btn btn-primary btn-flat" id="filter-show"><i class="fas fa-search"></i> Filter</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-download"></i>Import User Data</button>
                <a type="button" href="{{ route('memberraw-export') }}" class="btn btn-warning btn-flat"><i class="fas fa-download"></i> Export Excel</a>
                         
                <div class="progress" style="text-align: center;height:20px;">
                    <div class="bar" style="text-align: center;height:20px;"></div >
                    <div class="percent" style="text-align: center; height:20px; padding-top:10px;margin:none;">0%</div >
                </div>

            </form>
        </div>
        <div class="row">
            <div class="col-12">
                
                <button type="button" class="btn btn-secondary btn-reset btn-flat" id="reset" style="display:none"><i class="fas fa-sync"></i> Reset</button>
                
            </div>
        </div>
        <div class="mb-3"></div>

        <br />
        @if(count($errors) > 0)
         <div class="alert alert-danger">
          Upload Validation Error<br><br>
          <ul>
           @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
           @endforeach
          </ul>
         </div>
        @endif

        @if($message = Session::get('success'))
        <div class="alert alert-success alert-block">
         <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif

        <table class="table table-bordered" id="data_member_raw_table" style="width:100%;">
            
            <thead class="thead-light text-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Member</th>
                    <th class="text-center">No HP</th>
                    <th class="text-center">Status Cek</th>
                    <th class="text-center">Created At</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-filter">
    <div class="modal-dialog modal-lg">
        <form id="search-form" role="form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                                <div class="col-md-6">

                                    <label for="id_member">ID Member</label>
                                    <input type="tel" name="id_member" id="id_member" class="form-control mb-2" />

                                    <label for="no_hp">Nomer HP</label>
                                    <input type="tel" name="no_hp" id="no_hp" class="form-control mb-2" />

                                    <label for="poin">Status Cek Data</label>
                                    <input type="text" name="status_cek_data" id="status_cek_data" class="form-control mb-2" />

                                </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submit-filter" class="btn btn-primary btn-flat">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('custom_js')
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedHeader-3.2.1/js/dataTables.fixedHeader.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var tabel = $('#data_member_raw_table').DataTable({
        processing: true,
        ordering: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "{{ route('ajax-data-member-raw') }}",
            type: 'POST',
            data: function (d) {
                d.id_member           = $('#id_member').val();
                d.no_hp               = $('#no_hp').val();
                d.status_cek_data     = $('#status_cek_data').val();
            }
        },
        deferRender: true,
        columns: [
            { "data": "id", "name": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "id_member", "name": "id_member" },
            { "data": "no_hp", "name" : "no_hp" },
            { "data": "status_cek_data", "name": "status_cek_data" },
            { "data": "created_at", "name" : "created_at" },
        ],
        pageLength: 50,
        lengthMenu: [
            [ 10, 50, 100, 300, 400 ],
            [ '10 rows', '50 rows', '100 rows', '300 rows', '400 rows']
        ]
    });

    $('#submit-filter').on('click',function (e) {
        console.log($('#id_member').val());
        $('#modal-filter').modal('hide');
        tabel.draw();
        e.preventDefault();
        $('.btn-reset').show();
    });

    $("#filter-show").on('click',function (e) {
        $('#modal-filter').modal('show');
    });

    $('#reset').click(function(e) {
        $("#search-form").trigger("reset");
        tabel.draw();
        e.preventDefault();
        $('.btn-reset').hide();
    });

    // $('#export_excel').on('click',function () {
    //     var id_member           = $('#id_member').val();
    //     var no_hp               = $('#no_hp').val();
    //     var status_cek_data     = $('#status_cek_data').val();

    //     var download_url    = "{{ url('data-member-raw/action-excel') }}";

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     jQuery.ajax({
    //         url:"{{ url('data-member-raw/export-excel') }}",
    //         type:"POST",
    //         data:{
    //             id_member : id_member,
    //             no_hp : no_hp,
    //             status_cek_data: status_cek_data
    //         },
    //         success: function (result) {
    //             console.log(result);
    //             window.location.href = download_url + '/' +result;
    //         }
    //     });
    // });

});
</script>
<script type="text/javascript">
	var save_method; //for save method string
	$(document).ready(function() {
		//datatables
		var table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
                        "order": [], //Line ini sudah tidak diperlukan
			// Load data dari ajax
			"ajax": {
				"url": "ajax-data-member-raw",
				"type": "GET" //(untuk mendapatkan data)
			},
			// Tambahkan bagian ini:
			"columns": [
                                // Membuat nomor pada datatable (bukan ID user)
				// {data: 'DT_Row_Index', name:'DT_Row_Index' },
                                // ID user
				{data: 'id', name: 'id' },
				{data: 'id_member', name: 'id_member' },
                                // nama user
				{data: 'no_hp', name: 'no_hp' },
                                // posisi user
				{data: 'status_cek_data', name: 'status_cek_data'},
				{data: 'created_at', name: 'created_at'},
			],
			//Set column definition initialisation properties.
			"columnDefs":[
                    // membuat kolom 0 (No.) dan kolom 1 (ID) tidak dapat di search dan sorting
				{
                    "searchable": false, "orderable": false, "targets": [0,1],
                },

                
			],
		})
	});
</script>


 <script type="text/javascript">
     var SITEURL = "{{URL('/')}}";
     $(function () {
         $(document).ready(function () {
             var bar = $('.bar');
             var percent = $('.percent');
             $('form').ajaxForm({
                 beforeSend: function () {
                     var percentVal = '0%';
                     bar.width(percentVal)
                     percent.html(percentVal);
                 },
                 uploadProgress: function (event, position, total, percentComplete) {
                     var percentVal = percentComplete + '%';
                     bar.width(percentVal)
                     percent.html(percentVal);
                 },
                 complete: function (xhr) {
                     alert('File Has Been Uploaded Successfully');
                     window.location.href = SITEURL + "/" + "data-member-raw";
                 }
             });
         });
     });
 </script>
@stop
