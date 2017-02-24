@extends('layouts.app')

@section('title', 'Hello Infinity!')

@section('navbar')
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-infinity">
    <div class="navbar-header">
      <!-- Collapsed Hamburger -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- Branding Image -->
      <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
    </div>
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <!-- Left Side Of Navbar -->
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="//cn.bing.com">Bing</a></li>
        <li><a href="//taobao.com">Taobao</a></li>
        <li><a href="//bilibili.com">Bilibili <span class="badge"></span></a></li>
        <li><a href="//github.com">Github <span class="badge"></span></a></li>
        <li><a href="//codeforces.com">CodeForces <span class="badge"></span></a></li>
      </ul>
      <!-- Right Side Of Navbar -->
      <ul class="nav navbar-nav navbar-right">
       {{-- <li><a href="#">Link</a></li> --}}
       <li class="dropdown">
         <a id="btn-agenda" href="#">Agenda <span class="caret"></span></a>
         <ul class="ul-fluid dropdown-menu" style="display: block;">
           <li>
             <div class="routine routine-index">
                @include('calendar.routine')
             </div>
           </li>
         </ul>
       </li>
     </ul>
    </div>
  </div>
</nav>
@endsection

@section('content')
@include('calendar.modal')
<div class="full-screen alternative">You are offline</div>
<div class="full-screen background"></div>
<div class="full-screen foreground"></div>
<div id="sbox" class="sw_sform" role="search">
  <div class="hp_sw_logo hpcLogoWhite">必应</div>
  <div class="search_controls">
    <form action="http://cn.bing.com/search" id="sb_form" class="sw_box">
      <div class="b_searchboxForm">
        <input class="b_searchbox" id="sb_form_q" name="q" title="输入搜索词" type="search" value="" maxlength="100" autocapitalize="off" autocorrect="off" autocomplete="off" spellcheck="false">
        <input type="submit" class="b_searchboxSubmit" id="sb_form_go" title="搜索" tabindex="0" name="go">
      </div>
    </form>
  </div>
</div>

<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
  <div class="container-infinity">
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a id="btn-calendar" href="#">Calendar</a>
          <ul class="dropdown-menu">
            <li>
              <div id="calendar" class="calendar"></div>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li><a href="http://fanyi.baidu.com">Translation</a></li>
        <li><a href="http://mail.bjtu.edu.cn">Bjtu Mail</a></li>
        <li><a href="http://pastebin.infinitys.site">Pastebin</a></li>
        <li><a href="http://cplusplus.com/reference">C++ Reference</a></li>
        {{-- <li><a href="http://www.w3school.com.cn/sql/">SQL Tutorial</a></li> --}}
        <li><a href="http://api.jquery.com/">jQuery API</a></li>
        <li><a href="http://v3.bootcss.com">Bootstrap</a></li>
        <li><a href="http://php.net/manual/zh/">PHP Manual</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>
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
    $('a[href^="http"]').each(function() {
        $(this).attr('target', '_blank');
    });
    $('#sb_form_q').focus(function() {
        $('.foreground').fadeIn('fast');
    });
    $('#sb_form_q').blur(function() {
        $('.foreground').fadeOut('fast');
    });
    $('#btn-agenda').click(function() {
        $(this).next().toggle('fast');
    });
    $('#btn-calendar').click(function() {
        $(this).next().toggle('fast');
        if ($(this).next().css('display') == 'block') {
            $('#calendar').fullCalendar('render');
        }
    });
    $('#calendar').fullCalendar({
        events: '/api/calendar',
        defaultView: 'basicWeek',
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
