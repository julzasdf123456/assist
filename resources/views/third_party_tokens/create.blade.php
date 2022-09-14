@php
    use App\Models\IDGenerator;
@endphp
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Third Party Tokens</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'thirdPartyTokens.store']) !!}

            <div class="card-body">

                <div class="row">
                    <input type="hidden" id="id" name="id" value="{{ IDGenerator::generateID() }}">

                    <input type="hidden" id="Token" name="Token" value="{{ IDGenerator::generateRandString(IDGenerator::tokenDefaultLength()) }}">
                    @include('third_party_tokens.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('thirdPartyTokens.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
