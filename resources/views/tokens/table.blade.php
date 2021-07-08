<div class="table-responsive">
    <table class="table" id="tokens-table">
        <thead>
            <tr>
                <th>Userid</th>
        <th>Token</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tokens as $tokens)
            <tr>
                <td>{{ $tokens->userid }}</td>
            <td>{{ $tokens->token }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['tokens.destroy', $tokens->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tokens.show', [$tokens->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('tokens.edit', [$tokens->id]) }}" class='btn btn-default btn-xs'>
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
