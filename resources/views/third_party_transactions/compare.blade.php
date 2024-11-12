@php
    use App\Models\Users;
@endphp

@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4><strong class="text-primary">{{ $company }}</strong> <span class="text-success">Posted Transactions Comparison</span></h4>
                <p style="margin: 0px !important; padding: 0px !important;">Collection Date: {{ date('F d, Y', strtotime($date)) }}</p>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Comparison View</span>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center' colspan="4">From BOHECO I API</th>
                            <th class='text-center' colspan="4">From {{ $company }} Collection Report</th>
                        </tr>
                        <tr>
                            <th class='text-center'>Account Number</th>
                            <th class='text-center'>Account Name</th>
                            <th class='text-center'>Billing Month</th>
                            <th class='text-center'>Amount Paid</th>
                            <th class='text-center'>Account Number</th>
                            <th class='text-center'>Account Name</th>
                            <th class='text-center'>Billing Month</th>
                            <th class='text-center'>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection