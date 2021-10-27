<!-- Type Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('Type', 'Type:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                </div>
                {!! Form::select('Type', ['Information' => 'Information', 'Power Interruption' => 'Power Interruption', 'Advisory' => 'Advisory', 'Event' => 'Event'], null, ['class' => 'form-control',]) !!}
            </div>
        </div>
    </div>    
</div>

<!-- Title Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('Title', 'Title:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-word"></i></span>
                </div>
                {!! Form::text('Title', null, ['class' => 'form-control','maxlength' => 1000,'maxlength' => 1000, 'placeholder' => 'Title']) !!}
            </div>
        </div>
    </div> 
</div>

<!-- Details Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('Details', 'Details:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-word"></i></span>
                </div>
                {!! Form::textarea('Details', null, ['class' => 'form-control','maxlength' => 2000,'maxlength' => 2000, 'placeholder' => 'Details', 'rows' => 2]) !!}
            </div>
        </div>
    </div> 
</div>

{{-- <!-- Town Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Town', 'Town:') !!}
    {!! Form::text('Town', null, ['class' => 'form-control','maxlength' => 10,'maxlength' => 10]) !!}
</div>

<!-- Barangay Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Barangay', 'Barangay:') !!}
    {!! Form::text('Barangay', null, ['class' => 'form-control','maxlength' => 10,'maxlength' => 10]) !!}
</div> --}}

<!-- Datetimefrom Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('DateTimeFrom', 'Timestamp Event Start:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                </div>
                {!! Form::text('DateTimeFrom', null, ['class' => 'form-control','maxlength' => 1000,'maxlength' => 1000, 'placeholder' => 'Event Start']) !!}
            </div>
        </div>
    </div> 
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#DateTimeFrom').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Datetimeto Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('DateTimeTo', 'Timestamp Event End:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                </div>
                {!! Form::text('DateTimeTo', null, ['class' => 'form-control','maxlength' => 1000,'maxlength' => 1000, 'placeholder' => 'Event End']) !!}
            </div>
        </div>
    </div> 
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#DateTimeTo').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Commentsenabled Field -->
<div class="form-group col-sm-12">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            {!! Form::label('CommentsEnabled', 'Enable Comments:') !!}
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                </div>
                {!! Form::select('CommentsEnabled', ['True' => 'True', 'False' => 'False'], null, ['class' => 'form-control',]) !!}
            </div>
        </div>
    </div>    
</div>