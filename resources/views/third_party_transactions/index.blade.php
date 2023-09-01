@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Unposted Third Party API Transactions</h4>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-success btn-sm float-right"
                       href="{{ route('thirdPartyTransactions.posted-transactions') }}">
                        View Posted Transactions
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        {{-- UNPOSTED TRANSACTIONS --}}
        <div class="card shadow-none">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-info-circle ico-tab"></i>Un-Posted Collections from Third-Party Collectors</span>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <th>Collection Date</th>
                        <th>Company/Collector</th>
                        <th class="text-right">No. of Collections</th>
                        <th class="text-right">Total Collection</th>
                        <th style="width: 120px;"></th>
                    </thead>
                    <tbody>
                        @foreach ($thirdPartyTransactions as $item)
                            <tr>
                                <td>{{ date('F d, Y', strtotime($item->DateOfTransaction)) }}</td>
                                <td>{{ $item->Company }}</td>
                                <td class="text-right">{{ number_format($item->NumberOfTransactions) }}</td>
                                <td class="text-right">{{ number_format($item->Total, 2) }}</td>
                                <td>
                                    <a href="{{ route('thirdPartyTransactions.view-transactions', [$item->DateOfTransaction, $item->Company]) }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DASHBOARD DAILY --}}
        <div class="card shadow-none">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-chart-line ico-tab"></i>Daily Collection Trend</span>

                <div>
                    <button id="filter-btn" class="btn btn-primary btn-sm float-right" title="Filter" style="margin-left: 5px;"><i class="fas fa-filter"></i></button>
                    {{-- YEAR --}}
                    <input id="year-select" type="number" class="form-control form-control-sm float-right" placeholder="Year" value="{{ date('Y') }}" style="width: 100px; margin-left: 5px;">

                    {{-- MONTHS --}}
                    <select id="month-select" style="width: 120px;" class="form-control form-control-sm float-right">
                        <option value="01" {{ date('m')=='01' ? 'selected' : '' }}>January</option>
                        <option value="02" {{ date('m')=='02' ? 'selected' : '' }}>February</option>
                        <option value="03" {{ date('m')=='03' ? 'selected' : '' }}>March</option>
                        <option value="04" {{ date('m')=='04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ date('m')=='05' ? 'selected' : '' }}>May</option>
                        <option value="06" {{ date('m')=='06' ? 'selected' : '' }}>June</option>
                        <option value="07" {{ date('m')=='07' ? 'selected' : '' }}>July</option>
                        <option value="08" {{ date('m')=='08' ? 'selected' : '' }}>August</option>
                        <option value="09" {{ date('m')=='09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ date('m')=='10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ date('m')=='11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ date('m')=='12' ? 'selected' : '' }}>December</option>
                    </select>

                    <label for="" class="text-muted float-right" style="margin-right: 8px;">Parameters</label>
                </div>
            </div>
            <div class="card-body">
                <span>
                    <span id="month-label" style="font-size: 1.4em; font-weight: bold;">{{ date('F Y') }}</span>
                    <span style="color: #878787;">Collection Trend</span>
                </span>
                <div id="graph-holder">
                    <canvas id="collection-summary-chart" style="height: 440px;"></canvas>
                </div>
            </div>
        </div>

        {{-- DASHBOARD MONTHLY --}}
        <div class="card shadow-none">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-calendar ico-tab"></i>Monthy Collection Trend</span>

                <div>
                    <button id="filter-btn-year" class="btn btn-primary btn-sm float-right" title="Filter" style="margin-left: 5px;"><i class="fas fa-filter"></i></button>
                    {{-- YEAR --}}
                    <input id="year-input" type="number" class="form-control form-control-sm float-right" placeholder="Year" value="{{ date('Y') }}" style="width: 100px; margin-left: 5px;">

                    <label for="" class="text-muted float-right" style="margin-right: 8px;">Year</label>
                </div>
            </div>
            <div class="card-body">
                <span>
                    <span id="year-label" style="font-size: 1.4em; font-weight: bold;">Year {{ date('Y') }}</span>
                    <span style="color: #878787;">Monthly Trend</span>
                </span>
                <div id="graph-holder-year">
                    <canvas id="collection-summary-chart-yearly" style="height: 440px;"></canvas>
                </div>
            </div>
        </div>

        <div style="height: 20px; width: 100%;">

        </div>
    </div>

@endsection

@push('page_scripts')
    <script>
        $(document).ready(function() {
            graphCollectionSummary($('#month-select').val(), $('#year-select').val())
            graphCollectionYearly($('#year-input').val())

            $('#filter-btn').on('click', function() {
                $('#month-label').text($("#month-select option:selected").text() + " " + $('#year-select').val())

                graphCollectionSummary($('#month-select').val(), $('#year-select').val())
            })

            $('#filter-btn-year').on('click', function() {
                $('#year-label').text("Year " + $('#year-input').val())

                graphCollectionYearly($('#year-input').val())
            })

        })

        function graphCollectionSummary(month, year) {
            $('#collection-summary-chart').remove()
            $('#graph-holder').append('<canvas id="collection-summary-chart" style="height: 440px;"></canvas>')

            var collectionSummaryChartCanvas = $('#collection-summary-chart').get(0).getContext('2d')
            
            var dates = []
            for (var i=0; i<31; i++) {
                dates.push(['Day ' + (i + 1)])
            }

            $.ajax({
                url : "{{ route('thirdPartyTransactions.get-graph-data') }}",
                type : 'GET',
                data : {
                    Month : month,
                    Year : year
                },
                success : function(res) {
                    if (!jQuery.isEmptyObject(res)) {
                        var datum = []

                        $.each(res, function(index, element) {
                            var plotPoints = [
                                jQuery.isEmptyObject(res[index]['Data01']) ? 0 : Math.round((parseFloat(res[index]['Data01']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data02']) ? 0 : Math.round((parseFloat(res[index]['Data02']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data03']) ? 0 : Math.round((parseFloat(res[index]['Data03']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data04']) ? 0 : Math.round((parseFloat(res[index]['Data04']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data05']) ? 0 : Math.round((parseFloat(res[index]['Data05']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data06']) ? 0 : Math.round((parseFloat(res[index]['Data06']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data07']) ? 0 : Math.round((parseFloat(res[index]['Data07']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data08']) ? 0 : Math.round((parseFloat(res[index]['Data08']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data09']) ? 0 : Math.round((parseFloat(res[index]['Data09']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data10']) ? 0 : Math.round((parseFloat(res[index]['Data10']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data11']) ? 0 : Math.round((parseFloat(res[index]['Data11']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data12']) ? 0 : Math.round((parseFloat(res[index]['Data12']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data13']) ? 0 : Math.round((parseFloat(res[index]['Data13']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data14']) ? 0 : Math.round((parseFloat(res[index]['Data14']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data15']) ? 0 : Math.round((parseFloat(res[index]['Data15']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data16']) ? 0 : Math.round((parseFloat(res[index]['Data16']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data17']) ? 0 : Math.round((parseFloat(res[index]['Data17']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data18']) ? 0 : Math.round((parseFloat(res[index]['Data18']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data19']) ? 0 : Math.round((parseFloat(res[index]['Data19']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data20']) ? 0 : Math.round((parseFloat(res[index]['Data20']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data21']) ? 0 : Math.round((parseFloat(res[index]['Data21']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data22']) ? 0 : Math.round((parseFloat(res[index]['Data22']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data23']) ? 0 : Math.round((parseFloat(res[index]['Data23']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data24']) ? 0 : Math.round((parseFloat(res[index]['Data24']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data25']) ? 0 : Math.round((parseFloat(res[index]['Data25']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data26']) ? 0 : Math.round((parseFloat(res[index]['Data26']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data27']) ? 0 : Math.round((parseFloat(res[index]['Data27']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data28']) ? 0 : Math.round((parseFloat(res[index]['Data28']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data29']) ? 0 : Math.round((parseFloat(res[index]['Data29']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data30']) ? 0 : Math.round((parseFloat(res[index]['Data30']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['Data31']) ? 0 : Math.round((parseFloat(res[index]['Data31']) + Number.EPSILON) * 100) / 100,
                            ]

                            var clump = {}
                            clump['label'] = res[index]['Company'] + "(₱ " + Number(parseFloat(res[index]['TotalCollection'])).toLocaleString() + ")"
                            clump['backgroundColor'] = res[index]['Color'] + "aa"
                            clump['borderColor'] = res[index]['Color']
                            clump['pointRadius'] = 3
                            clump['pointColor'] = res[index]['Color']
                            clump['pointStrokeColor'] = 'rgba(60,141,188,1)'
                            clump['pointHighlightFill'] = '#fff'
                            clump['pointHighlightStroke'] = 'rgba(60,141,188,1)'
                            clump['data'] = plotPoints

                            datum.push(clump)
                        })

                        // console.log(datum)

                        var collectionSummaryChartData = {
                            labels: dates,
                            datasets: datum
                        }

                        var collectionSummaryChartOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            }
                        }

                        var collectionSummaryChart = new Chart(collectionSummaryChartCanvas, { 
                            type: 'line',
                            data: collectionSummaryChartData,
                            options: collectionSummaryChartOptions
                        })
                    } else {
                        var datum = []

                        // console.log(datum)

                        var collectionSummaryChartData = {
                            labels: dates,
                            datasets: datum
                        }

                        var collectionSummaryChartOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            }
                        }

                        var collectionSummaryChart = new Chart(collectionSummaryChartCanvas, { 
                            type: 'line',
                            data: collectionSummaryChartData,
                            options: collectionSummaryChartOptions
                        })
                    }
                },
                error : function(err) {
                    console.log(err)
                } 
            })
        }

        function graphCollectionYearly(year) {
            $('#collection-summary-chart-yearly').remove()
            $('#graph-holder-year').append('<canvas id="collection-summary-chart-yearly" style="height: 440px;"></canvas>')

            var collectionSummaryChartCanvas = $('#collection-summary-chart-yearly').get(0).getContext('2d')
            
            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

            $.ajax({
                url : "{{ route('thirdPartyTransactions.get-graph-data-yearly') }}",
                type : 'GET',
                data : {
                    Year : year
                },
                success : function(res) {
                    if (!jQuery.isEmptyObject(res)) {
                        var datum = []

                        $.each(res, function(index, element) {
                            var plotPoints = [
                                jQuery.isEmptyObject(res[index]['January']) ? 0 : Math.round((parseFloat(res[index]['January']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['February']) ? 0 : Math.round((parseFloat(res[index]['February']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['March']) ? 0 : Math.round((parseFloat(res[index]['March']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['April']) ? 0 : Math.round((parseFloat(res[index]['April']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['May']) ? 0 : Math.round((parseFloat(res[index]['May']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['June']) ? 0 : Math.round((parseFloat(res[index]['June']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['July']) ? 0 : Math.round((parseFloat(res[index]['July']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['August']) ? 0 : Math.round((parseFloat(res[index]['August']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['September']) ? 0 : Math.round((parseFloat(res[index]['September']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['October']) ? 0 : Math.round((parseFloat(res[index]['October']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['November']) ? 0 : Math.round((parseFloat(res[index]['November']) + Number.EPSILON) * 100) / 100,
                                jQuery.isEmptyObject(res[index]['December']) ? 0 : Math.round((parseFloat(res[index]['December']) + Number.EPSILON) * 100) / 100,
                            ]

                            var clump = {}
                            clump['label'] = res[index]['Company'] + "(₱ " + Number(parseFloat(res[index]['TotalCollection'])).toLocaleString() + ")"
                            clump['backgroundColor'] = res[index]['Color'] + "aa"
                            clump['borderColor'] = res[index]['Color']
                            clump['pointRadius'] = 3
                            clump['pointColor'] = res[index]['Color']
                            clump['pointStrokeColor'] = 'rgba(60,141,188,1)'
                            clump['pointHighlightFill'] = '#fff'
                            clump['pointHighlightStroke'] = 'rgba(60,141,188,1)'
                            clump['data'] = plotPoints

                            datum.push(clump)
                        })

                        // console.log(datum)

                        var collectionSummaryChartData = {
                            labels: months,
                            datasets: datum
                        }

                        var collectionSummaryChartOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            }
                        }

                        var collectionSummaryChart = new Chart(collectionSummaryChartCanvas, { 
                            type: 'line',
                            data: collectionSummaryChartData,
                            options: collectionSummaryChartOptions
                        })
                    } else {
                        var datum = []

                        // console.log(datum)

                        var collectionSummaryChartData = {
                            labels: months,
                            datasets: datum
                        }

                        var collectionSummaryChartOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            }
                        }

                        var collectionSummaryChart = new Chart(collectionSummaryChartCanvas, { 
                            type: 'line',
                            data: collectionSummaryChartData,
                            options: collectionSummaryChartOptions
                        })
                    }
                },
                error : function(err) {
                    console.log(err)
                } 
            })
        }
    </script>
@endpush    

