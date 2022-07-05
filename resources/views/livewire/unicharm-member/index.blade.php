<div>


<table class="table">
    <div class="card">
    <div class="card-body">
        <div class="row mt-3">
            <thead>
                <tr>
                    <th>ID Member</th>
                    <th>No HP</th>
                </tr>
            </thead>
            <tbody>
                @if (count($datamembers) > 0)
                    @foreach ($datamembers as $datamember)
                        <tr>
                            <td>
                                {{$datamember->id_member}}
                            </td>
                            <td>
                                {{$datamember->no_hp}}
                            </td>
                        </tr>
                    @endforeach
                @else 
                    <tr>
                        <td colspan="3" align="center">
                            No datamember Found.
                        </td>
                    </tr>
                @endif
            </tbody>
</table>

</div>
