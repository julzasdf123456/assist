<div class="table-responsive">
    <table class="table" id="thirdPartyTransactions-table">
        <thead>
            <tr>
                <th>Accountnumber</th>
        <th>Serviceperiodend</th>
        <th>Billnumber</th>
        <th>Kwhused</th>
        <th>Amount</th>
        <th>Surcharge</th>
        <th>Totalamount</th>
        <th>Company</th>
        <th>Teller</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($thirdPartyTransactions as $thirdPartyTransactions)
            <tr>
                <td>{{ $thirdPartyTransactions->AccountNumber }}</td>
            <td>{{ $thirdPartyTransactions->ServicePeriodEnd }}</td>
            <td>{{ $thirdPartyTransactions->BillNumber }}</td>
            <td>{{ $thirdPartyTransactions->KwhUsed }}</td>
            <td>{{ $thirdPartyTransactions->Amount }}</td>
            <td>{{ $thirdPartyTransactions->Surcharge }}</td>
            <td>{{ $thirdPartyTransactions->TotalAmount }}</td>
            <td>{{ $thirdPartyTransactions->Company }}</td>
            <td>{{ $thirdPartyTransactions->Teller }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['thirdPartyTransactions.destroy', $thirdPartyTransactions->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('thirdPartyTransactions.show', [$thirdPartyTransactions->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('thirdPartyTransactions.edit', [$thirdPartyTransactions->id]) }}" class='btn btn-default btn-xs'>
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
