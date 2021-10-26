<div class="table-responsive">
    <table class="table" id="userAppLogs-table">
        <thead>
            <tr>
                <th>Type</th>
        <th>Details</th>
        <th>Latlong</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userAppLogs as $userAppLogs)
            <tr>
                <td>{{ $userAppLogs->Type }}</td>
            <td>{{ $userAppLogs->Details }}</td>
            <td>{{ $userAppLogs->LatLong }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['userAppLogs.destroy', $userAppLogs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('userAppLogs.show', [$userAppLogs->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('userAppLogs.edit', [$userAppLogs->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
