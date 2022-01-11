@extends('adminlte::page')

@section('title', 'Akumulasi Poin')

@section('content_header')
    <h3>
        Akumulasi Poin
    </h3>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary btn-flat" id="filter-show"><i class="fas fa-search"></i> Filter</button>
                <button type="button" class="btn btn-secondary btn-reset btn-flat" id="reset" style="display:none"><i class="fas fa-sync"></i> Reset</button>
                <button type="button" id="download" class="btn btn-success btn-flat"><i class="fas fa-download"></i> Download Excel</button>
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
                                    <label for="msisdn">Nomer HP</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control mb-2" />

                                    <label for="desc_info">Batch</label>
                                    <select class="form-control" name="batch" id="batch">
                                        <option value="">-- Select Batch --</option>
                                    </select>
                                </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submit" class="btn btn-primary btn-flat">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('custom_js')
<script type="text/javascript" src="{{ asset('vendor/datatables/FixedHeader-3.1.7/js/dataTables.fixedHeader.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var tabel = $('#akumulasi_poin_table');
        tabel.DataTable({
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "searching": true,
            "ajax": {
                url: "{{ route('ajax-akumulasi-poin') }}",
                type: 'GET',
                data: function (d) {
                    d.id_member     = $('#id_member').val();
                    d.no_hp         = $('#no_hp').val();
                    d.batch         = $('#batch').val();
                    d.poin          = $('#poin').val();
                    d.created_at    = $('#created_at').val();
                }
            },
            "deferRender": true,
            "columns": [
                { "data": "id", "name": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { "data": "id_member", "name": "id_member" },
                { "data": "batch", "name" : "batch" },
                { "data": "no_hp", "name" : "no_hp" },
                { "data": "poin", "name" : "poin" },
                { "data": "created_at", "name" : "created_at" },
            ],
            "columnDefs": [

            ],
            "pageLength": 50,
            'lengthMenu': [
                [ 10, 50, 100, 300, 400 ],
                [ '10 rows', '50 rows', '100 rows', '300 rows', '400 rows']
            ],
            "dom": 'lBfrtip',
            "buttons": [

            ],
        });

    $("#filter-show").on('click',function (e) {
        $('#modal-filter').modal('show');
    });

    $('#reset').click(function(e) {
        $("#search-form").trigger("reset");
        table.draw();
        e.preventDefault();
        $('.btn-reset').delay(1000).hide(0);
    });

});
</script>
@stop
