<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Type', 'Type:') !!}
    {!! Form::text('Type', null, ['class' => 'form-control','maxlength' => 500,'maxlength' => 500]) !!}
</div>

<!-- Details Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Details', 'Details:') !!}
    {!! Form::text('Details', null, ['class' => 'form-control','maxlength' => 2000,'maxlength' => 2000]) !!}
</div>

<!-- Latlong Field -->
<div class="form-group col-sm-6">
    {!! Form::label('LatLong', 'Latlong:') !!}
    {!! Form::text('LatLong', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>