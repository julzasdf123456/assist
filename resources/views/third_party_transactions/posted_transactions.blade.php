@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Posted Third Party API Transaction History</h4>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <th>Collection Date</th>
                        <th>Company/Collector</th>
                        <th>No. of Collections</th>
                        <th style="width: 120px;"></th>
                    </thead>
                    <tbody>
                        @foreach ($thirdPartyTransactions as $item)
                            <tr>
                                <td>{{ date('F d, Y', strtotime($item->DateOfTransaction)) }}</td>
                                <td>{{ $item->Company }}</td>
                                <td>{{ number_format($item->NumberOfTransactions) }}</td>
                                <td>
                                    <a href="{{ route('thirdPartyTransactions.view-posted-transactions', [$item->DateOfTransaction, $item->Company]) }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

