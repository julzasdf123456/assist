<div class="table-responsive">
    <table class="table table-hover table-sm table-borderless" id="users-table">
        {{-- <thead>
            <tr>
                <th width="30px"></th>
                <th>Registered Name</th>
                <th>Username</th>
                <th colspan="3">Action</th>
            </tr>
        </thead> --}}
        <tbody>
        @foreach($users as $user)
            <tr>
                <td width="25px">
                    @if ($user->activity == 'active')
                        <i class="fas fa-circle" style="font-size: .8em; color: green;"></i>
                    @else 
                        <i class="far fa-circle" style="font-size: .8em; color: #bcbcbc;"></i>
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-default btn-xs'>
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

    {{ $users->links() }}
</div>
