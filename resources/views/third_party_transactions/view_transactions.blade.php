@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4><strong class="text-primary">{{ $company }}</strong> <span class="text-danger">Unposted Collection</span></h4>
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
                    <span class="card-title">Logged Collection <span class="text-primary">({{ count($data) }} payments)</span></span>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <th>Account No</th>
                            <th>Billing Mo.</th>
                            <th>Ref. No</th>
                            <th>Consumer Name</th>
                            <th>Net Amount</th>
                            <th>Surcharges</th>
                            <th>Surcharges VAT</th>
                            <th>Total Surcharges</th>
                            <th>Total Amount Paid</th>
                            <th>Payment Time</th>
                            {{-- <th>Excel Report<br>Data Comparison</th> --}}
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td title="{{ $item['ORNumber'] }}">
                                        @if ($item['Posted'] == 'Yes')
                                            <i class="fas fa-exclamation-circle text-danger ico-tab"></i>
                                        @else
                                            <i class="fas fa-check-circle text-success ico-tab"></i>
                                        @endif
                                        {{ $item['AccountNumber'] }}
                                    </td>
                                    <td>{{ date('M Y', strtotime($item['ServicePeriodEnd'])) }}</td>
                                    <td>{{ $item['RefNo'] }}</td>
                                    <td>{{ $item['ConsumerName'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['Amount']) ? number_format($item['Amount'], 2) : $item['Amount'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['Surcharge']) ? number_format(floatval($item['Surcharge']) / 1.12, 2) : '-' }}</td>
                                    <td class="text-right">{{ is_numeric($item['Surcharge']) ? number_format(floatval($item['Surcharge']) - (floatval($item['Surcharge']) / 1.12), 2) : '-' }}</td>
                                    <td class="text-right">{{ is_numeric($item['Surcharge']) ? number_format($item['Surcharge'], 2) : $item['Surcharge'] }}</td>
                                    <td class="text-right">{{ is_numeric($item['TotalAmount']) ? number_format($item['TotalAmount'], 2) : $item['TotalAmount'] }}</td>
                                    <td>{{ date('M d, Y h:i A', strtotime($item['created_at'])) }}</td>
                                    {{-- <td class="text-right"></td> --}}
                                </tr>
                                @php
                                    $total += is_numeric($item['TotalAmount']) ? floatval($item['TotalAmount']) : 0;
                                @endphp
                            @endforeach
                            <tr>
                                <th colspan="8">Total Collection</th>
                                <th class="text-right text-success">{{ number_format($total, 2) }}</th>
                                <th></th>
                                {{-- <td class="text-right"></td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <div class="card-footer">
                    <button class="btn btn-success" onclick="post()">Post</button>

                    <button class="btn btn-default float-right" onclick="markAsPosted()">Mark as Posted</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        function post() {
            Swal.fire({
                title: 'Posting Confirmation',
                text : 'Do you want to post these payments?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url : "{{ route('thirdPartyTransactions.post-transactions') }}",
                        type : 'GET',
                        data : {
                            Date : "{{ $date }}",
                            Company : "{{ $company }}"
                        },
                        success : function(res) {
                            Toast.fire({
                                icon : 'success',
                                text : 'Payments posted!'
                            })
                            window.location.href = "{{ url('/third_party_transactions/view-posted-transactions') }}" + "/{{ $date }}/{{ $company }}"
                        },
                        error : function(err) {
                            Toast.fire({
                                icon : 'error',
                                text : 'Error posting payments!'
                            })
                        }
                    })
                } 
            }) 
        }

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