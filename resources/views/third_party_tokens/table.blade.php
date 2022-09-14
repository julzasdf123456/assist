@php
    use App\Models\IDGenerator;
@endphp

<div class="table-responsive">
    <table class="table table-hover" id="thirdPartyTokens-table">
        <thead>
            <tr>
            <th>Company</th>
            <th>Access Key</th>
            <th>Token</th>
            <th>Expires In</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($thirdPartyTokens as $thirdPartyTokens)
            <tr>
                <td>{{ $thirdPartyTokens->Company }}</td>
            <td>{{ $thirdPartyTokens->AccessKey }}</td>
            <td>
                {{ $thirdPartyTokens->Token }}
                <a href="{{ route('thirdPartyTokens.regenerate-token', [$thirdPartyTokens->id]) }}" class="btn btn-xs btn-info float-right"><i class="fas fa-sync ico-tab-mini"></i>Re-generate</a>
            </td>
            <td>
                {{ date('F d, Y', strtotime($thirdPartyTokens->ExpiresIn)) }}
                <span class="badge bg-warning">{{ IDGenerator::getDaysDifference(date('Y-m-d'), $thirdPartyTokens->ExpiresIn) }} days left</span>
            </td>
            <td width="120">
                {!! Form::open(['route' => ['thirdPartyTokens.destroy', $thirdPartyTokens->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{{ route('thirdPartyTokens.show', [$thirdPartyTokens->id]) }}" class='btn btn-default btn-xs'>
                        <i class="far fa-eye"></i>
                    </a>
                    <a href="{{ route('thirdPartyTokens.edit', [$thirdPartyTokens->id]) }}" class='btn btn-default btn-xs'>
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
