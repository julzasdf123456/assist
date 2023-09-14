@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <span style="font-size: 2em;">
                        <div style="margin-left: 5px; border-radius: 50%; height: 36px; width: 36px; display: inline-block; background-color: {{ $thirdPartyTokens->ColorHex }};"></div>
                        {{ $thirdPartyTokens->Company }}                        
                    </span>
                </div>
                <div class="col-sm-2">
                    <a class="btn btn-default float-right"
                       href="{{ route('thirdPartyTokens.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        {{-- COMPANY PROFILE --}}
        <div class="card shadow-none">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-info-circle ico-tab"></i>Company Profile</span>
                <div class="card-tools">
                    <a href="{{ route('thirdPartyTokens.edit', [$thirdPartyTokens->id]) }}" class="btn btn-tool"><i class="fas fa-pen"></i></a>
                </div>
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

        {{-- COLLECTION HISTORY --}}
        <div class="card shadow-none" style="height: 50vh;">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-history ico-tab"></i>{{ $thirdPartyTokens->Company }}  Collection History</span>
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
                        @php
                            $total = 0;
                            $average = 0;
                            $count = 0;
                        @endphp
                        @foreach ($thirdPartyTransactions as $item)
                            <tr>
                                <td>{{ date('F d, Y', strtotime($item->DateOfTransaction)) }}</td>
                                <td class="text-right">{{ number_format($item->NumberOfTransactions) }} payments</td>
                                <td class="text-right"><strong>₱ {{ number_format($item->Total, 2) }}</strong></td>
                                <td>
                                    <a href="{{ route('thirdPartyTransactions.view-posted-transactions', [$item->DateOfTransaction, $thirdPartyTokens->Company]) }}" class="btn btn-xs btn-primary float-right"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                            @php
                                $total += floatval($item->Total);
                                $count += floatval($item->NumberOfTransactions);
                                if ($total > 0) {
                                    $average = $total/count($thirdPartyTransactions);
                                } else {
                                    $average = 0;
                                }
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- STATS --}}
        <div class="card shadow-none">
            <div class="card-header border-0">
                <span class="card-title"><i class="fas fa-chart-line ico-tab"></i>{{ $thirdPartyTokens->Company }}  Collection Stats</span>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- STATS --}}
                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="text-muted text-center">Total Collection<br>Amount</p>
                                <h2 class="text-center text-success">₱ {{ number_format($total, 2) }}</h2>
                            </div>

                            <div class="col-lg-4">
                                <p class="text-muted text-center">No. of Bills<br>Collected</p>
                                <h2 class="text-center text-primary">{{ number_format($count) }}</h2>
                            </div>

                            <div class="col-lg-4">
                                <p class="text-muted text-center">Average Collection<br>Daily</p>
                                <h2 class="text-center text-danger">₱ {{ number_format($average, 2) }}</h2>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div style="margin-bottom: 20px;">
                            <span id="year-label" style="font-size: 1.4em; font-weight: bold;">Year {{ date('Y') }}</span>
                            <span style="color: #878787;">Monthly Trend</span>
                        </div>
                        <div id="graph-holder-year">
                            <canvas id="collection-summary-chart-yearly" style="height: 300px; padding-top: 10px;"></canvas>
                        </div>
                    </div>

                    {{-- ACTIVITY CALENDAR --}}
                    <div class="col-lg-4 col-md-12">
                        <div id="calendar" style="height: 150px"></div>
                    </div>

                    {{-- MONTHLY SUMMARY --}}
                    <div class="col-lg-12" style="margin-top: 20px;">
                        <table class="table table-sm table-bordered table-hover">
                            <tr>
                                <th></th>
                                <th>January</th>
                                <th>February</th>
                                <th>March</th>
                                <th>April</th>
                                <th>May</th>
                                <th>June</th>
                                <th>July</th>
                                <th>August</th>
                                <th>September</th>
                                <th>October</th>
                                <th>November</th>
                                <th>December</th>
                            </tr>
                            <tr>
                                <th>Collection Count</th>
                                <td class="text-right" id="JanuaryCount"></td>
                                <td class="text-right" id="FebruaryCount"></td>
                                <td class="text-right" id="MarchCount"></td>
                                <td class="text-right" id="AprilCount"></td>
                                <td class="text-right" id="MayCount"></td>
                                <td class="text-right" id="JuneCount"></td>
                                <td class="text-right" id="JulyCount"></td>
                                <td class="text-right" id="AugustCount"></td>
                                <td class="text-right" id="SeptemberCount"></td>
                                <td class="text-right" id="OctoberCount"></td>
                                <td class="text-right" id="NovemberCount"></td>
                                <td class="text-right" id="DecemberCount"></td>
                            </tr>
                            <tr>
                                <th>Collection Amount</th>
                                <td class="text-right" id="JanuaryAmount"></td>
                                <td class="text-right" id="FebruaryAmount"></td>
                                <td class="text-right" id="MarchAmount"></td>
                                <td class="text-right" id="AprilAmount"></td>
                                <td class="text-right" id="MayAmount"></td>
                                <td class="text-right" id="JuneAmount"></td>
                                <td class="text-right" id="JulyAmount"></td>
                                <td class="text-right" id="AugustAmount"></td>
                                <td class="text-right" id="SeptemberAmount"></td>
                                <td class="text-right" id="OctoberAmount"></td>
                                <td class="text-right" id="NovemberAmount"></td>
                                <td class="text-right" id="DecemberAmount"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>
    </div>
@endsection

@push('page_scripts')
    <script>
        /**
         * CALENDAR 
         */
        var scheds = [];
        
        var Calendar
        var calendarEl
        var calendar

        $(document).ready(function() {
            Calendar = FullCalendar.Calendar
            calendarEl = document.getElementById('calendar')

            fetchCalendarData(moment().format('MMMM YYYY'))
            graphCollectionYearly(`{{ date('Y') }}`)
        })

        function fetchCalendarData(month) {
            scheds = []
            // QUERY SCHEDS
            $.ajax({
                url : '{{ route("thirdPartyTransactions.get-company-calendar-activity") }}',
                type : 'GET',
                data : {
                    Company : "{{ $thirdPartyTokens->Company }}"
                },
                success : function(res) {
                    $.each(res, function(index, element) {
                        var obj = {}
                        var timestamp = moment(res[index]['DateCollected'], 'YYYY-MM-DD')

                        obj['title'] = res[index]['NoOfCollection']
                        obj['backgroundColor'] = "{{ $thirdPartyTokens->ColorHex }}";
                        obj['borderColor'] = "{{ $thirdPartyTokens->ColorHex }}";

                        obj['extendedProps'] = {
                           CollectionDate : res[index]['DateCollected'],
                        }
                        
                        obj['start'] = moment(timestamp).format('YYYY-MM-DD');
                        
                        obj['allDay'] = true;
                        scheds.push(obj)
                    })

                    if (calendar != null) {
                        calendar.removeAllEvents()
                    }
                
                    calendar = new Calendar(calendarEl, {
                        headerToolbar: {
                            left  : 'prev,next',
                            center: 'title',
                        },
                        themeSystem: 'bootstrap',
                        events : scheds,
                        eventOrderStrict : true,
                        editable  : true,
                        height : 500,
                        // initialDate : moment(month).format("YYYY-MM-DD")
                        eventClick : function(info) {
                            window.location.href = "{{ url('/third_party_transactions/view-posted-transactions/') }}/" + info.event.extendedProps['CollectionDate'] + "/{{ $thirdPartyTokens->Company }}"
                        }
                    });

                    calendar.render()
                },
                error : function(err) {
                    Toast.fire({
                        icon : 'error',
                        text : 'Error getting calendar data'
                    })
                }
            })
        }

        function graphCollectionYearly(year) {
            $('#collection-summary-chart-yearly').remove()
            $('#graph-holder-year').append('<canvas id="collection-summary-chart-yearly" style="height: 300px;"></canvas>')

            var collectionSummaryChartCanvas = $('#collection-summary-chart-yearly').get(0).getContext('2d')
            
            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

            $.ajax({
                url : "{{ route('thirdPartyTransactions.get-graph-data-yearly') }}",
                type : 'GET',
                data : {
                    Year : year,
                    Company : "{{ $thirdPartyTokens->Company }}"
                },
                success : function(res) {
                    if (!jQuery.isEmptyObject(res)) {
                        var ticksStyle = { fontColor:'#495057', fontStyle:'bold'}
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

                            // ADD COUNT
                            $('#JanuaryCount').text(jQuery.isEmptyObject(res[index]['JanuaryCount']) ? '' : Number(parseFloat(res[index]['JanuaryCount'])).toLocaleString())
                            $('#FebruaryCount').text(jQuery.isEmptyObject(res[index]['FebruaryCount']) ? '' : Number(parseFloat(res[index]['FebruaryCount'])).toLocaleString())
                            $('#MarchCount').text(jQuery.isEmptyObject(res[index]['MarchCount']) ? '' : Number(parseFloat(res[index]['MarchCount'])).toLocaleString())
                            $('#AprilCount').text(jQuery.isEmptyObject(res[index]['AprilCount']) ? '' : Number(parseFloat(res[index]['AprilCount'])).toLocaleString())
                            $('#MayCount').text(jQuery.isEmptyObject(res[index]['MayCount']) ? '' : Number(parseFloat(res[index]['MayCount'])).toLocaleString())
                            $('#JuneCount').text(jQuery.isEmptyObject(res[index]['JuneCount']) ? '' : Number(parseFloat(res[index]['JuneCount'])).toLocaleString())
                            $('#JulyCount').text(jQuery.isEmptyObject(res[index]['JulyCount']) ? '' : Number(parseFloat(res[index]['JulyCount'])).toLocaleString())
                            $('#AugustCount').text(jQuery.isEmptyObject(res[index]['AugustCount']) ? '' : Number(parseFloat(res[index]['AugustCount'])).toLocaleString())
                            $('#SeptemberCount').text(jQuery.isEmptyObject(res[index]['SeptemberCount']) ? '' : Number(parseFloat(res[index]['SeptemberCount'])).toLocaleString())
                            $('#OctoberCount').text(jQuery.isEmptyObject(res[index]['OctoberCount']) ? '' : Number(parseFloat(res[index]['OctoberCount'])).toLocaleString())
                            $('#NovemberCount').text(jQuery.isEmptyObject(res[index]['NovemberCount']) ? '' : Number(parseFloat(res[index]['NovemberCount'])).toLocaleString())
                            $('#DecemberCount').text(jQuery.isEmptyObject(res[index]['DecemberCount']) ? '' : Number(parseFloat(res[index]['DecemberCount'])).toLocaleString())

                            // ADD AMOUNT
                            $('#JanuaryAmount').text(jQuery.isEmptyObject(res[index]['January']) ? '' : Number(parseFloat(res[index]['January'])).toLocaleString())
                            $('#FebruaryAmount').text(jQuery.isEmptyObject(res[index]['February']) ? '' : Number(parseFloat(res[index]['February'])).toLocaleString())
                            $('#MarchAmount').text(jQuery.isEmptyObject(res[index]['March']) ? '' : Number(parseFloat(res[index]['March'])).toLocaleString())
                            $('#AprilAmount').text(jQuery.isEmptyObject(res[index]['April']) ? '' : Number(parseFloat(res[index]['April'])).toLocaleString())
                            $('#MayAmount').text(jQuery.isEmptyObject(res[index]['May']) ? '' : Number(parseFloat(res[index]['May'])).toLocaleString())
                            $('#JuneAmount').text(jQuery.isEmptyObject(res[index]['June']) ? '' : Number(parseFloat(res[index]['June'])).toLocaleString())
                            $('#JulyAmount').text(jQuery.isEmptyObject(res[index]['July']) ? '' : Number(parseFloat(res[index]['July'])).toLocaleString())
                            $('#AugustAmount').text(jQuery.isEmptyObject(res[index]['August']) ? '' : Number(parseFloat(res[index]['August'])).toLocaleString())
                            $('#SeptemberAmount').text(jQuery.isEmptyObject(res[index]['September']) ? '' : Number(parseFloat(res[index]['September'])).toLocaleString())
                            $('#OctoberAmount').text(jQuery.isEmptyObject(res[index]['October']) ? '' : Number(parseFloat(res[index]['October'])).toLocaleString())
                            $('#NovemberAmount').text(jQuery.isEmptyObject(res[index]['November']) ? '' : Number(parseFloat(res[index]['November'])).toLocaleString())
                            $('#DecemberAmount').text(jQuery.isEmptyObject(res[index]['December']) ? '' : Number(parseFloat(res[index]['December'])).toLocaleString())

                            var clump = {}
                            // clump['label'] = res[index]['Company'] + "(₱ " + Number(parseFloat(res[index]['TotalCollection'])).toLocaleString() + ")"
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
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    },
                                    ticks : ticksStyle,
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false
                                    },
                                    ticks : $.extend({
                                        beginAtZero:true,
                                        callback : function(value) { 
                                            if(value>=1000) { 
                                                value/=1000
                                                value+='k'
                                            }
                                            return '$'+value
                                        }}, ticksStyle
                                    )
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
