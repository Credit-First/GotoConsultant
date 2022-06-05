@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('styles')
    <link rel="stylesheet" href="https://fullcalendar.io/releases/fullcalendar/3.10.0/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{asset('css/fullcalendar.print.css')}}" media='print'>
@endsection
@section('content')
    <div class="member-wrapper">
        @include('elements.member_sidebar')
        <div class="content-wrapper">
            <div class="single-page qWidth">
                <div class="pages-heading">
                    <h2>@lang('member.calendar')</h2>
                </div>
                <div class="prepaid-card-full">
                    <div id="calendar"></div>
                </div>
                <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content calendar">
                            <div class="modal-header">
                                <div style="display:flex; flex-direction: column">
                                    <span class="calendar-modal-title">Plan Title</span>
                                    <span id="event-title"></span>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if ($role == 'consultant')
                                    <div class="modal-category-item">
                                        <div class="modal-category-title">@lang('member.customer'):</div>
                                        <div class="modal-category-content" style="display: flex;">
                                            <img class="event-modal-avatar" id="user-avatar" />
                                            <div id="user-info"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="modal-category-item">
                                        <div class="modal-category-title">@lang('member.consultant'):</div>
                                        <div class="modal-category-content" style="display: flex;">
                                            <img class="event-modal-avatar" id="consultant-avatar" />
                                            <div id="consultant-info"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="modal-category-item">
                                    <div class="modal-category-title">@lang('member.booked-date'):</div>
                                    <div class="modal-category-content" id="booked-date"></div>
                                </div>
                                <div class="modal-category-item">
                                    <div class="modal-category-title">@lang('member.start-time'):</div>
                                    <div class="modal-category-content" id="start-time"></div>
                                </div>
                                <div class="modal-category-item">
                                    <div class="modal-category-title">@lang('member.end-time'):</div>
                                    <div class="modal-category-content" id="end-time"></div>
                                </div>
                                <div class="modal-category-item">
                                    <div class="modal-category-title">@lang('member.paid'):</div>
                                    <div class="modal-category-content" id="paid"></div>
                                </div>
                            </div>
                            <div class="modal-footer calendar">
                                <a class="btn btn-modal-close" data-dismiss="modal" aria-label="Close">@lang('member.close')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://fullcalendar.io/releases/fullcalendar/3.10.0/lib/moment.min.js"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script src='https://fullcalendar.io/releases/fullcalendar/3.10.0/locale/es.js'></script>
    <script>
        /*
            date store today date.
            d store today date.
            m store current month.
            y store current year.
        */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        /*
         Initialize fullCalendar and store into variable.
         Why in variable?
         Because doing so we can use it inside other function.
         In order to modify its option later.
         */

        $(document).ready(function(){
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                selectable: true,
                selectHelper: true,
                allDaySlot: true,
                // allDayText: 'all-day',
                // firstHour: 6,
                // slotMinutes: 30,
                // defaultEventMinutes: 120,
                axisFormat: 'H', //,'h(:mm)tt',
                // timeFormat: {
                //     agenda: 'H' //h:mm{ - h:mm}'
                // },
                // dragOpacity: {
                //     agenda: .5
                // },
                // minTime: 0,
                // maxTime: 24,
                eventClick: function(event) {
                    var weeks = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    var datetime = new Date(event.start);
                    var date = `${weeks[datetime.getDay()]}, ${months[datetime.getMonth()]} ${datetime.getDate()}`;
                    var startTime = `${datetime.toString().substr(16, 5)}, ${datetime.toString().substr(25)}`;
                    var endTime = `${new Date(datetime.getTime() + 3600000).toString().substr(16, 5)}, ${datetime.toString().substr(25)}`;
                    
                    $('#event-title').html(event.title);
                    $('#user-info').html(event.data.user_name);
                    $('#consultant-info').html(event.data.consultant_name);
                    $('#booked-date').html(date);
                    $('#start-time').html(startTime);
                    $('#end-time').html(endTime);
                    $('#paid').html(`${event.data.currency_type} ${event.data.price}`);
                    $('#user-avatar').attr("src", event.data.user_avatar === '' ? "{{ asset('images/user.svg') }}" : event.data.user_avatar);
                    $('#consultant-avatar').attr("src", event.data.consultant_avatar === '' ? "{{ asset('images/user.svg') }}" : event.data.consultant_avatar);
                    $('#event-modal').modal("show");
                },
                allDayDefault: false,
                events: [
                    @foreach($data as $record)
                        {
                            title: "{{$record->title}}",
                            start: new Date("{{$record->booking_date}}"),
                            color: "{{$record->status === 'pending' ? '#f764a8' : '#54dab1'}}",
                            data: {
                                user_name: "{{$record->user_first_name}} {{$record->user_last_name}}",
                                consultant_name: "{{$record->consultant_first_name}} {{$record->consultant_last_name}}",
                                user_avatar: "{{$record->user_avatar}}",
                                consultant_avatar: "{{$record->consultant_avatar}}",
                                price: "{{$record->price}}",
                                currency_type: "{{$record->currency_type}}",
                            }
                        },
                    @endforeach
                ],
                locale: "{{$lang === 'en' ? 'en' : 'nb'}}",
                allDaySlot: false
            });
        });
    </script>
@endsection
