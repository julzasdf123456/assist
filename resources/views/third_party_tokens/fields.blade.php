<!-- Company Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Company', 'Company:') !!}
    {!! Form::text('Company', null, ['class' => 'form-control','maxlength' => 300,'maxlength' => 300]) !!}
</div>

<!-- Accesskey Field -->
<div class="form-group col-sm-6">
    {!! Form::label('AccessKey', 'Access Key:') !!}
    {!! Form::text('AccessKey', null, ['class' => 'form-control','maxlength' => 300,'maxlength' => 300, 'placeholder' => 'Company secret codes, could be a name, name of cat, etc.']) !!}
</div>

<!-- Expiresin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ExpiresIn', 'Expires In:') !!}
    {!! Form::text('ExpiresIn', null, ['class' => 'form-control','id'=>'ExpiresIn']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ExpiresIn').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Notes', 'Notes/Remarks:') !!}
    {!! Form::text('Notes', null, ['class' => 'form-control','maxlength' => 600,'maxlength' => 600]) !!}
</div>