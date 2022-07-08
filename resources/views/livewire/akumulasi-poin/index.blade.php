@extends('adminlte::page')

@section('title', 'Akumulasi Poin')

@section('content_header')
    <h3>
        Akumulasi Poin
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
        <div class="row mt-3">
            <div class="form">
                <a type="button" class="btn btn-primary btn-flat" id="filter-show"><i class="fas fa-search"></i> Filter</a>
                <a type="button" class="btn btn-secondary btn-reset btn-flat" id="reset" style="display:none"><i class="fas fa-sync"></i> Reset</a>    
                <a href="{{ route('data-akumulasi-poin-export') }}"  href="margin-left:4px;" type="button"  class="btn btn-warning btn-flat"><i class="fas fa-download"></i> Export Excel</a>
                <div class="progress" style="text-align: center;height:20px;">
                    <div class="bar" style="text-align: center;height:20px;"></div >
                    <div class="percent" style="text-align: center; height:20px; padding-top:10px;margin:none;">0%</div >
                </div>
            </div>

        </div>
        <div class="mb-3"></div>
        <table class="table table-bordered" id="akumulasi_poin_table" style="width:100%;">
            <thead class="thead-light text-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Member</th>
                    <th class="text-center">No HP</th>
                    <th class="text-center">Batch</th>
                    <th class="text-center">Poin</th>
                    <th class="text-center">Cek Status Membership</th>
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

    var tabel = $('#akumulasi_poin_table').DataTable({
        processing: true,
        ordering: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "{{ route('ajax-akumulasi-poin') }}",
            type: 'POST',
            data: function (d) {
                d.id_member     = $('#id_member').val();
                d.no_hp         = $('#no_hp').val();
                d.batch         = $('#batch').val();
                d.poin         = $('#poin').val();
                d.status_cek_membership         = $('#status_cek_membership').val();
                d.created_at         = $('#created_at').val();
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
            { "data": "no_hp", "name" : "no_hp" },
            { "data": "batch", "name" : "batch" },
            { "data": "poin", "name" : "poin" },
            { "data": "status_cek_membership", "name" : "status_cek_membership" },
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
    //             //console.log(result);
    //             window.location.href = download_url + '/' +result;
    //         }
    //     });
    // });

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
                    window.location.href = SITEURL + "/" + "akumulasi-poin";
                }
            });
        });
    });
</script>
@stop
