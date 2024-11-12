<!-- Accountnumber Field -->
<div class="form-group col-sm-6">
    {!! Form::label('AccountNumber', 'Accountnumber:') !!}
    {!! Form::text('AccountNumber', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50]) !!}
</div>

<!-- Billingperiod Field -->
<div class="form-group col-sm-6">
    {!! Form::label('BillingPeriod', 'Billingperiod:') !!}
    {!! Form::text('BillingPeriod', null, ['class' => 'form-control','id'=>'BillingPeriod']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#BillingPeriod').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Amountdue Field -->
<div class="form-group col-sm-6">
    {!! Form::label('AmountDue', 'Amountdue:') !!}
    {!! Form::number('AmountDue', null, ['class' => 'form-control']) !!}
</div>

<!-- Surcharge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Surcharge', 'Surcharge:') !!}
    {!! Form::number('Surcharge', null, ['class' => 'form-control']) !!}
</div>