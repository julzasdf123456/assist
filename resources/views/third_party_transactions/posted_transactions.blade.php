@extends('layouts.app')

<style>
    .fc-event-title {
        font-size: 1.2em;
        padding-bottom: 5px;
    }

    .fc-event {
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 3px;
        padding-bottom: 3px;
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Posted Third Party API Transaction History</h4>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-default float-right" id="view-option" title="Switch to list view"><i id="view-option-icon" class="fas fa-list"></i></button>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        {{-- LIST VIEW --}}
        <div id="list-view" class="card shadow-none gone" style="height: 90vh;">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-list ico-tab"></i>List View</span>
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
                                    <a href="{{ route('thirdPartyTransactions.view-posted-transactions', [$item->DateOfTransaction, $item->Company]) }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CALENDAR VIEW --}}
        <div id="calendar-view" class="card shadow-none" style="height: 90vh;">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-calendar ico-tab"></i>Calendar View</span>
            </div>
            <div class="card-body">
                <div id="calendar" style="height: 90vh;"></div>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    <script>
        var viewOption = 'calendar'

        $('#view-option').on('click', function() {
            if (viewOption == 'calendar') {
                viewOption = 'list'
                $('#view-option').prop('title', 'Switch to calendar view')
                $('#view-option-icon').removeClass('fa-list').addClass('fa-calendar')

                $('#list-view').removeClass('gone')
                $('#calendar-view').addClass('gone')
            } else {
                viewOption = 'calendar'
                $('#view-option').prop('title', 'Switch to list view')
                $('#view-option-icon').removeClass('fa-calendar').addClass('fa-list')

                $('#list-view').addClass('gone')
                $('#calendar-view').removeClass('gone')
            }
        })

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
        })

        function companyAlias(company) {
            if (company == 'Cooperative Bank of Bohol') {
                return 'CBB'
            } else {
                return company
            }
        }

        function fetchCalendarData(month) {
            scheds = []
            // QUERY SCHEDS
            $.ajax({
                url : '{{ route("thirdPartyTransactions.get-posted-calendar-data") }}',
                type : 'GET',
                data : {
                    // Month : month
                },
                success : function(res) {
                    console.log(res)
                    $.each(res, function(index, element) {
                        var obj = {}
                        var timestamp = moment(res[index]['DateCollected'], 'YYYY-MM-DD')

                        obj['title'] = companyAlias(res[index]['Company']) + ' (₱ ' + Number(parseFloat(res[index]['TotalCollection'])).toLocaleString() + ' - ' + res[index]['NoOfCollection'] + ')'
                        obj['backgroundColor'] = res[index]['Color'];
                        obj['borderColor'] = res[index]['Color'];

                        obj['extendedProps'] = {
                           CollectionDate : res[index]['DateCollected'],
                           Company : res[index]['Company'],
                        }
                        
                        obj['start'] = moment(timestamp).format('YYYY-MM-DD');
                        
                        // urlShow = urlShow.replace("rsId", res[index]['id'])
                        // obj['url'] = urlShow

                        obj['allDay'] = true;
                        scheds.push(obj)
                    })

                    if (calendar != null) {
                        calendar.removeAllEvents()
                    }
                
                    calendar = new Calendar(calendarEl, {
                        headerToolbar: {
                            left  : 'prev,next today',
                            center: 'title',
                            right : 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        themeSystem: 'bootstrap',
                        events : scheds,
                        eventOrderStrict : true,
                        editable  : true,
                        height : 780,
                        // initialDate : moment(month).format("YYYY-MM-DD")
                        eventClick : function(info) {
                            window.location.href = "{{ url('/third_party_transactions/view-posted-transactions/') }}/" + info.event.extendedProps['CollectionDate'] + "/" + info.event.extendedProps['Company']
                        }
                    });

                    calendar.render()

                    // $('.fc-prev-button').on('click', function() {
                    //     fetchCalendarData($('#fc-dom-1').text())
                    // })

                    // $('.fc-next-button').on('click', function() {
                    //     fetchCalendarData($('#fc-dom-1').text())
                    // })
                },
                error : function(err) {
                    Toast.fire({
                        icon : 'error',
                        text : 'Error getting schedules'
                    })
                }
            })
        }
    </script>
@endpush

