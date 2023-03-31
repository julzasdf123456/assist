@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><strong class="text-primary">{{ $company }}</strong> Unposted Collection</h4>
                    <p style="margin: 0px !important; padding: 0px !important;">Collection Date: {{ date('F d, Y', strtotime($date)) }}</p>
                </div>
                {{-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('thirdPartyTransactions.create') }}">
                        Add New
                    </a>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-none" style="height: 75vh;">
                <div class="card-header">
                    <span class="card-title">Logged Collection</span>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <th>Account No</th>
                            <th>Ref. No</th>
                            <th>Consumer Name</th>
                            <th>Net Amount</th>
                            <th>Surcharge</th>
                            <th>Total Amount Paid</th>
                            <th>Excel Report<br>Data Comparison</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['AccountNumber'] }}</td>
                                    <td>{{ $item['ORNumber'] }}</td>
                                    <td>{{ $item['ConsumerName'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['Amount']) ? number_format($item['Amount'], 2) : $item['Amount'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['Surcharge']) ? number_format($item['Surcharge'], 2) : $item['Surcharge'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['TotalAmount']) ? number_format($item['TotalAmount'], 2) : $item['TotalAmount'] }}</td>
                                    <td class="text-right"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
                <div class="card-footer">
                    <button class="btn btn-success">Post</button>
                </div>
            </div>
        </div>
    </div>
@endsection