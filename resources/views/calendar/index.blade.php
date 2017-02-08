@extends('layouts.app')

@section('content')
<div id="calendar"></div>
{{-- <br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"></h3>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">New</button>
  </div>
  <div class="panel-body">
    @include('calendar.routine')
  </div>
</div> --}}
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Agenda</h4>
      </div>
      <form class="form" action="/calendar" method="post">
        <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" class="form-control">
          </div>
          <div class="form-group">
            <label>Begin at</label>
            <input type="datetime-local" name="begin_at" class="form-control" required>
          </div>
          <div class="form-group">
            <label>End at</label>
            <input type="datetime-local" name="end_at" class="form-control">
          </div>
          <div class="form-group">
            <label>Repeat</label>
            <div class="form-inline">
              Every
              <input type="text" name="repeat_interval" class="form-control" value="7">
              days for
              <input type="text" name="repeat_time" class="form-control" value="16">
              times
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
