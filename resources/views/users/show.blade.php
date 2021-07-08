@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('users.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('users.show_fields')
                </div>
            </div>

        </div>
    </div>

    <div class="content px-3">
        <h5>Linked Accounts</h5>
        <table class="table">
            <thead>
                <th>Account Number</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($accountLinks as $accountLinks)
                <tr>
                    <td>{{ $accountLinks->UserId }}</td>
                <td>{{ $accountLinks->AccountNumber }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['accountLinks.destroy', $accountLinks->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('accountLinks.show', [$accountLinks->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('accountLinks.edit', [$accountLinks->id]) }}" class='btn btn-default btn-xs'>
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
@endsection
