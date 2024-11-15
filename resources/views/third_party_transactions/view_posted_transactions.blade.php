@php
    use App\Models\Users;
@endphp

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><strong class="text-primary">{{ $company }}</strong> <span class="text-success">Posted Transactions</span></h4>
                    <p style="margin: 0px !important; padding: 0px !important;">Collection Date: {{ date('F d, Y', strtotime($date)) }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-none" style="height: 65vh;">
                <div class="card-header">
                    <span class="card-title">Logged Collection <span class="text-success">({{ count($data) }} payments)</span></span>

                    <div class="card-tools">
                        <a href="{{ route('thirdPartyTransactions.print-double-payments', [$date, $company]) }}" class="btn btn-warning btn-tool">Print Double Payments</a>
                        <a href="{{ route('thirdPartyTransactions.print-posted-payments', [$date, $company]) }}" class="btn btn-success btn-tool">Print Posted Payments</a>
                        <a href="{{ route('thirdPartyTransactions.compare', [$date, $company]) }}" class="btn btn-primary btn-sm">Compare</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <th>#</th>
                            <th>Account No</th>
                            <th>Billing Mo.</th>
                            <th>Ref. No</th>
                            <th>Consumer Name</th>
                            <th>OR Number</th>
                            <th>OR Date</th>
                            <th>Net Amount</th>
                            <th>Surcharges</th>
                            <th>Total Amount Paid</th>
                            <th>Status</th>
                            <th>Payment Time</th>
                            {{-- <th>Excel Report<br>Data Comparison</th> --}}
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $i = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr class="{{ $item['Status']=='DOUBLE PAYMENTS' ? 'bg-danger' : '' }}">
                                    <td>{{ $i }}</td>
                                    <td>{{ $item['AccountNumber'] }}</td>
                                    <td>{{ date('M Y', strtotime($item['ServicePeriodEnd'])) }}</td>
                                    <td>{{ $item['RefNo'] }}</td>
                                    <td>{{ $item['ConsumerName'] }}</td>
                                    <td>{{ $item['ORNumber'] }}</td>
                                    <td>{{ $item['ORDate'] != null ? date('M d, Y', strtotime($item['ORDate'])) : '' }}</td>
                                    <td class="text-right">{{ is_numeric($item['Amount']) ? number_format($item['Amount'], 2) : $item['Amount'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['Surcharge']) ? number_format($item['Surcharge'], 2) : $item['Surcharge'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['TotalAmount']) ? number_format($item['TotalAmount'], 2) : $item['TotalAmount'] }}</td>
                                    <td>{{ $item['Status'] }}</td>
                                    <td>{{ date('M d, Y h:i A', strtotime($item['created_at'])) }}</td>
                                    {{-- <td class="text-right"></td> --}}
                                </tr>
                                @php
                                    $total += is_numeric($item['TotalAmount']) ? floatval($item['TotalAmount']) : 0;
                                    $i++;
                                @endphp
                            @endforeach
                            <tr>
                                <th colspan="8">Total Collection</th>
                                <th class="text-right text-success">{{ number_format($total, 2) }}</th>
                                <th></th>
                                <th></th>
                                {{-- <td class="text-right"></td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <div class="card-footer">
                    @if (Auth::user()->username == 'julz')
                        <button class="btn btn-default float-right" onclick="markAsPosted()">Mark as Posted</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-none">
                <div class="card-body">
                    @php
                        $totalDp = 0;
                        foreach ($dps as $item) {
                            $totalDp += $item->TotalAmount;
                        }
                    @endphp
                    
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center">TOTAL NO. OF PAYEES</th>
                            <th class="text-center">TOTAL DOUBLE<br>PAYMENT TRANSACTIONS</th>
                            <th class="text-center">TOTAL POSTED</th>
                            <th class="text-center">TOTAL DOUBLE<br>PAYMENT AMOUNT</th>
                            <th class="text-center">TOTAL AMOUNT<br>(EXC. DOUBLE PAYMENTS)</th>
                            <th class="text-center">TOTAL AMOUNT<br>(INC. DOUBLE PAYMENTS)</th>
                        </thead>
                        <tbody>
                            <th class="text-center">{{ count($data) }}</th>
                            <th class="text-center">{{ count($dps) }}</th>
                            <th class="text-center">{{ count($data) - count($dps) }}</th>
                            <th class="text-center">{{ number_format($totalDp, 2) }}</th>
                            <th class="text-center">{{ number_format($total - $totalDp, 2) }}</th>
                            <th class="text-center">{{ number_format($total, 2) }}</th>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        function markAsPosted() {
            Swal.fire({
                title: 'Do you want to mark these payments as posted?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url : "{{ route('thirdPartyTransactions.mark-as-posted') }}",
                        type : 'GET',
                        data : {
                            Date : "{{ $date }}",
                            Company : "{{ $company }}"
                        },
                        success : function(res) {
                            Toast.fire({
                                icon : 'success',
                                text : 'Payments marked as posted!'
                            })
                            window.location.href = "{{ route('thirdPartyTransactions.index') }}"
                        },
                        error : function(err) {
                            Toast.fire({
                                icon : 'error',
                                text : 'Error marking payments!'
                            })
                        }
                    })
                } 
            })            
        }
    </script>
@endpush