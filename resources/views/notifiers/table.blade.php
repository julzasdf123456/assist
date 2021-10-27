<div class="table-responsive">
    <table class="table" id="notifiers-table">
        <thead>
            <tr>
                <th>Type</th>
        <th>Title</th>
        <th>Details</th>
        <th>Town</th>
        <th>Barangay</th>
        <th>Datetimefrom</th>
        <th>Datetimeto</th>
        <th>Commentsenabled</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notifiers as $notifiers)
            <tr>
                <td>{{ $notifiers->Type }}</td>
            <td>{{ $notifiers->Title }}</td>
            <td>{{ $notifiers->Details }}</td>
            <td>{{ $notifiers->Town }}</td>
            <td>{{ $notifiers->Barangay }}</td>
            <td>{{ $notifiers->DateTimeFrom }}</td>
            <td>{{ $notifiers->DateTimeTo }}</td>
            <td>{{ $notifiers->CommentsEnabled }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['notifiers.destroy', $notifiers->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('notifiers.show', [$notifiers->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('notifiers.edit', [$notifiers->id]) }}" class='btn btn-default btn-xs'>
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
