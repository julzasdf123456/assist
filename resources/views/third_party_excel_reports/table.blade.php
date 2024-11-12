<div class="table-responsive">
    <table class="table" id="thirdPartyExcelReports-table">
        <thead>
            <tr>
                <th>Accountnumber</th>
        <th>Billingperiod</th>
        <th>Amountdue</th>
        <th>Surcharge</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($thirdPartyExcelReports as $thirdPartyExcelReport)
            <tr>
                <td>{{ $thirdPartyExcelReport->AccountNumber }}</td>
            <td>{{ $thirdPartyExcelReport->BillingPeriod }}</td>
            <td>{{ $thirdPartyExcelReport->AmountDue }}</td>
            <td>{{ $thirdPartyExcelReport->Surcharge }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['thirdPartyExcelReports.destroy', $thirdPartyExcelReport->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('thirdPartyExcelReports.show', [$thirdPartyExcelReport->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('thirdPartyExcelReports.edit', [$thirdPartyExcelReport->id]) }}" class='btn btn-default btn-xs'>
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
