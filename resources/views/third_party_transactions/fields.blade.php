<!-- Accountnumber Field -->
<div class="form-group col-sm-6">
    {!! Form::label('AccountNumber', 'Accountnumber:') !!}
    {!! Form::text('AccountNumber', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Serviceperiodend Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ServicePeriodEnd', 'Serviceperiodend:') !!}
    {!! Form::text('ServicePeriodEnd', null, ['class' => 'form-control','id'=>'ServicePeriodEnd']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ServicePeriodEnd').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Billnumber Field -->
<div class="form-group col-sm-6">
    {!! Form::label('BillNumber', 'Billnumber:') !!}
    {!! Form::text('BillNumber', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Kwhused Field -->
<div class="form-group col-sm-6">
    {!! Form::label('KwhUsed', 'Kwhused:') !!}
    {!! Form::number('KwhUsed', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Amount', 'Amount:') !!}
    {!! Form::number('Amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Surcharge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Surcharge', 'Surcharge:') !!}
    {!! Form::number('Surcharge', null, ['class' => 'form-control']) !!}
</div>

<!-- Totalamount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('TotalAmount', 'Totalamount:') !!}
    {!! Form::number('TotalAmount', null, ['class' => 'form-control']) !!}
</div>

<!-- Company Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Company', 'Company:') !!}
    {!! Form::text('Company', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Teller Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Teller', 'Teller:') !!}
    {!! Form::text('Teller', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>