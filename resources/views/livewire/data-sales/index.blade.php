@extends('adminlte::page')

@section('title', 'Data Sales')

@section('content_header')
    <h3>
        Data Sales
    </h3>
@stop

@push('css')
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
@endpush
@section('content')




<div class="card">
    <div class="card-body">
        <div class="row">
            <form action="{{ route('data-sales-import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <a type="text" class="btn btn-primary btn-flat" id="filter-show"><i class="fas fa-search"></i> Filter</a>
                
                <button class="btn btn-success" type="submit"><i class="fas fa-download"></i>Import User Data</button>

                <a class="btn btn-warning" href="{{ route('data-sales-export') }}" > Export User Data</a>

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

{{-- 
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-block">
         <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif --}}

       {{-- <div class="table-responsive" id="myTable"> --}}
        <table class="table table-bordered" id="data_sales_table" style="width:100%;">
            <thead class="thead-light text-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Member</th>
                    <th class="text-center">Batch</th>
                    <th class="text-center">Order ID</th>
                    <th class="text-center">Poin</th>
                    <th class="text-center">No HP</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Source</th>
                    <th class="text-center">Recipient</th>
                    <th class="text-center">Status Member</th>
                    <th class="text-center">Status Cek is Member</th>
                    <th class="text-center">Status Cek Poin</th>
                    <th class="text-center">Created At</th>
                </tr>
            </thead>
        </table>
       {{-- </div> --}}
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

                                    <label for="desc_info">Membership Status</label>
                                    <select class="form-control mb-2" name="is_member" id="is_member">
                                        <option value="">-- Select Membership --</option>
                                        <option value="1">Member</option>
                                        <option value="0">Non Member</option>
                                    </select>

                                    <label for="id_member">ID Member</label>
                                    <input type="tel" name="id_member" id="id_member" class="form-control mb-2" />

                                    <label for="no_hp">Order ID</label>
                                    <input type="tel" name="order_id" id="order_id" class="form-control mb-2" />

                                    <label for="no_hp">Nomer HP</label>
                                    <input type="tel" name="no_hp" id="no_hp" class="form-control mb-2" />

                                    <label for="poin">Poin</label>
                                    <input type="number" name="poin" id="poin" class="form-control mb-2" />

                                    <label for="recipient">Recipient</label>
                                    <input type="text" name="recipient" id="recipient" class="form-control mb-2" />

                                    <label for="source">Source</label>
                                    <input type="text" name="source" id="source" class="form-control mb-2" />

                                    <label for="desc_info">Batch</label>
                                    <select class="form-control" name="batch" id="batch">
                                        <option value="">-- Select Batch --</option>
                                         {{-- @foreach ($list_batch as $b)
                                            <option value="{{ $b->batch }}">{{ $b->batch }}</option>
                                        @endforeach  --}}
                                    </select>
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
    
        var tabel = $('#data_sales_table').DataTable({
            processing: true,
            ordering: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('ajax-data-sales') }}",
                type: 'POST',
                data: function (d) {
                    d.id_member     = $('#id_member').val();
                    d.batch         = $('#batch').val();
                    d.order_id         = $('#order_id').val();
                    d.poin         = $('#poin').val();
                    d.no_hp         = $('#no_hp').val();
                    d.tanggal         = $('#tanggal').val();
                    d.source         = $('#source').val();
                    d.recipient         = $('#recipient').val();
                    d.status_member         = $('#status_member').val();
                    d.status_cek_is_memebr         = $('#status_cek_is_member').val();
                    d.status_cek_poin         = $('#status_cek_poin').val();
                    // d.created_at    = $('#created_at').val();
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
                { "data": "batch", "name" : "batch" },
                { "data": "order_id", "name" : "order_id" },
                { "data": "poin", "name" : "poin" },
                { "data": "no_hp", "name" : "no_hp" },
                { "data": "tanggal", "name" : "tanggal" },
                { "data": "source", "name" : "source" },
                { "data": "recipient", "name" : "recipient" },
                { "data": "status_member", "name" : "status_member" },
                { "data": "status_cek_is_member", "name" : "status_cek_is_member" },
                { "data": "status_cek_poin", "name" : "status_cek_poin" },
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
            $('.btn-reset').delay(1000).hide(0);
        });
    
        // $('#export_excel').on('click',function () {
        //     var id_member       = $('#id_member').val();
        //     var no_hp           = $('#no_hp').val();
        //     var download_url    = "{{ url('data-member/action-excel') }}";
    
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
    
        //     jQuery.ajax({
        //         url:"{{ url('data-member/export-excel') }}",
        //         type:"POST",
        //         data:{
        //             id_member : id_member,
        //             no_hp : no_hp,
        //         },
        //         success: function (result) {
        //             console.log(result);
        //             window.location.href = download_url + '/' +result;
        //         }
        //     });
        // });
    
    });
    </script>

@stop


