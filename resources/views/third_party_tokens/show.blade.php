@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $thirdPartyTokens->Company }}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('thirdPartyTokens.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card shadow-none">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-info-circle ico-tab"></i>Company Profile</span>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm table-borderless">
                    <tr>
                        <td>Access Key</td>
                        <td><strong>{{ $thirdPartyTokens->AccessKey }}</strong></td>
                    </tr>
                    <tr>
                        <td>Token</td>
                        <td><strong>{{ $thirdPartyTokens->Token }}</strong></td>
                    </tr>
                    <tr>
                        <td>Token Expiration</td>
                        <td><strong>{{ date('M d, Y', strtotime($thirdPartyTokens->ExpiresIn)) }}</strong></td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="card shadow-none" style="height: 70vh;">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-history ico-tab"></i>Collection History</span>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                    <thead>
                        <th>Collection Date</th>
                        <th class="text-right">Total No. of Collections</th>
                        <th class="text-right">Total Collection Amount</th>
                        <th style="width: 120px;"></th>
                    </thead>
                    <tbody>
                        @foreach ($thirdPartyTransactions as $item)
                            <tr>
                                <td>{{ date('F d, Y', strtotime($item->DateOfTransaction)) }}</td>
                                <td class="text-right">{{ number_format($item->NumberOfTransactions) }}</td>
                                <td class="text-right">{{ number_format($item->Total, 2) }}</td>
                                <td>
                                    <a href="{{ route('thirdPartyTransactions.view-posted-transactions', [$item->DateOfTransaction, $thirdPartyTokens->Company]) }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
