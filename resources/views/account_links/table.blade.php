<div class="table-responsive">
    <table class="table" id="accountLinks-table">
        <thead>
            <tr>
                <th>Userid</th>
        <th>Accountnumber</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accountLinks as $accountLinks)
            <tr>
                <td>{{ $accountLinks->UserId }}</td>
            <td>{{ $accountLinks->AccountNumber }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['accountLinks.destroy', $accountLinks->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accountLinks.show', [$accountLinks->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('accountLinks.edit', [$accountLinks->id]) }}" class='btn btn-default btn-xs'>
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
