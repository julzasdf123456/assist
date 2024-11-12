<!-- Accountnumber Field -->
<div class="col-sm-12">
    {!! Form::label('AccountNumber', 'Accountnumber:') !!}
    <p>{{ $thirdPartyExcelReport->AccountNumber }}</p>
</div>

<!-- Billingperiod Field -->
<div class="col-sm-12">
    {!! Form::label('BillingPeriod', 'Billingperiod:') !!}
    <p>{{ $thirdPartyExcelReport->BillingPeriod }}</p>
</div>

<!-- Amountdue Field -->
<div class="col-sm-12">
    {!! Form::label('AmountDue', 'Amountdue:') !!}
    <p>{{ $thirdPartyExcelReport->AmountDue }}</p>
</div>

<!-- Surcharge Field -->
<div class="col-sm-12">
    {!! Form::label('Surcharge', 'Surcharge:') !!}
    <p>{{ $thirdPartyExcelReport->Surcharge }}</p>
</div>

