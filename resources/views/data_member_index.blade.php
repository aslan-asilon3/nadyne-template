@extends('adminlte::page')

@section('title', 'Data Member')

@section('content_header')
    <h3>
        Data Member
    </h3>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="data_member_table" style="width:100%;">
            <thead class="thead-light text-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Member</th>
                    <th class="text-center">No HP </th>
                    <th class="text-center">Created At</th>
                </tr>
            </thead>
        </table>
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

            var tabel = $('#data_sales_table');
            tabel.DataTable({
                "responsive":true,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": true,
                "ajax": {
                    url: "{{ route('ajax-data-sales') }}",
                    type: 'GET',
                    data: function (d) {
                        d.batch         = $('#batch').val();
                        d.poin          = $('#poin').val();
                        d.no_hp         = $('#no_hp').val();
                        d.tanggal       = $('#tanggal').val();
                        d.source        = $('#source').val();
                        d.recipient     = $('#recipient').val();
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
                    { "data": "batch", "name": "batch" },
                    { "data": "poin", "name" : "poin" },
                    { "data": "no_hp", "name" : "no_hp" },
                    { "data": "tanggal", "name" : "tanggal" },
                    { "data": "source", "name" : "source" },
                    { "data": "recipient", "name": "recipient" },
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
                    {
                        extend: 'excel',
                        title : '',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'print',
                        title : '',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        }
                    },
                ],
            });

    });
</script>
@stop
