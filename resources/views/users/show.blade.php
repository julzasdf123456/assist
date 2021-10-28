@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Users Stats</h4>
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
        <div class="row">
            <div class="col-lg-5 col-md-6">
                {{-- LINKED ACCOUNTS --}}
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span class="card-title">Linked Accounts</span>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th>Account Number</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($accountLinks as $accountLinks)
                                <tr>
                                    <td>{{ $accountLinks->AccountNumber }}</td>
                                    <td>{{ $accountLinks->ConsumerName }}</td>
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
                </div>

                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <span class="card-title">Pending Account Link Requests</span>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($accountLinksPending as $accountLinks)
                                <tr>
                                    <td>{{ $accountLinks->AccountNumber }}</td>
                                    <td>{{ $accountLinks->ConsumerName }}</td>
                                    <td width="120">                                        
                                        <a href="{{ route('accountLinks.approve-account-link', [$accountLinks->id]) }}" class="btn btn-xs btn-success" title="Approve"><i class="fas fa-check-circle"></i></a>
                                        <a href="{{ route('accountLinks.reject-account-link', [$accountLinks->id]) }}" class="btn btn-xs btn-danger" title="Reject"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="card border-0">
                    <div class="card-header">
                        <span class="card-title">Activity</span>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-sm table-hover">
                            <thead>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Timestamp</th>
                            </thead>
                            <tbody>
                                @foreach ($appLogs as $item)
                                    <tr>
                                        <td>{{ $item->Type }}</td>
                                        <td>{{ $item->Details }}</td>
                                        <td>{{ date('F d, Y h:i:s A', strtotime($item->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="row justify-content-md-center">
                            <div class="col-md-auto">
                                {{ $appLogs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
