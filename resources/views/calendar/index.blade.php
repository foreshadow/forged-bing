@extends('layouts.app')

@section('content')
<div id="calendar"></div>
{{-- <br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"></h3> --}}
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">New</button>
  {{-- </div>
  <div class="panel-body">
    @include('calendar.routine')
  </div>
</div> --}}
@include ('calendar.modal')
@endsection

@push('stylesheets')
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" rel="stylesheet">
<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.print.css" rel="stylesheet"> -->
@endpush

@push('scripts')
<script src="//cdn.bootcss.com/moment.js/2.17.1/moment.min.js"></script>
<script src="//cdn.bootcss.com/moment.js/2.17.1/locale/zh-cn.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>
<script>
    $(document).ready(function() {
        $('[name=end_at]').focus(function () {
            if (!$('[name=end_at]').val()) {
                $('[name=end_at]').val($('[name=begin_at]').val());
            }
        });
        $('#calendar').fullCalendar({
            events: '/api/calendar',
            header: { left: 'title', center: 'prev,today,next', right: 'toMonth,toWeek,toWeekAgenda' },
            height: 'auto',
            fixedWeekCount : false,
            weekNumbers: true,
            timeFormat: 'HH:mm',
            minTime: '8:00',
            maxTime: '21:00',
            viewRender: function(view, element) {
                $.each($('.fc-week-number'), function() {
                    const ch = '零一二三四五六七八九十';
                    const offset = 8;
                    const limit = 18;
                    var weekno = $(this).text();
                    if (weekno && weekno[0] != 'W') {
                        weekno -= offset;
                        if (weekno <= 0 || weekno > limit) {
                            weekno = '(' + $(this).text() + ')';
                        } else if (weekno <= 10) {
                            weekno = ch[weekno];
                        } else {
                            weekno = ch[10] + ch[weekno - 10];
                        }
                        $(this).html(weekno);
                    }
                    $(this).css('width', '32px');
                });
            },
            customButtons: {
                toMonth: {
                    text: 'month',
                    click: function() {
                        $('#calendar').fullCalendar('changeView', 'month');
                    }
                },
                toWeek: {
                    text: 'week',
                    click: function() {
                        $('#calendar').fullCalendar('changeView', 'basicWeek');
                    }
                },
                toWeekAgenda: {
                    text: 'week agenda',
                    click: function() {
                        $('#calendar').fullCalendar('changeView', 'agendaWeek');
                    }
                }
            }
        });
    });
</script>
@endpush
