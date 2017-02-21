<div class="date">
  <div class="date">{{ date('j', time()) }}</div>
  <div class="weekno">{{ date('l', time()) }}</div>
  @if (8 < date('W', time()) && date('W', time()) <= 24)
    <div class="weekno">, week {{ date('W', time()) - 8 }}</div>
  @endif
</div>
@php
$last = date('Ymd', time());
$last2 = date('Ym', time());
@endphp
@foreach ($agendas as $agenda)
@if ($loop->index)
<hr>
@endif
@if (date('Ym', $agenda->begin_at) != $last2)
<div class="date">
  <div class="date">{{ date('F', $agenda->begin_at) }}</div>
</div>
<hr>
@endif
@if (date('Ymd', $agenda->begin_at) != $last)
<div class="date">
  <div class="date">{{ date('j', $agenda->begin_at) }}</div>
  <div class="weekno">{{ date('l', $agenda->begin_at) }}</div>
  @if (8 < date('W', $agenda->begin_at) && date('W', $agenda->begin_at) <= 24)
    <div class="weekno">, week {{ date('W', $agenda->begin_at) - 8 }}</div>
  @endif
</div>
<hr>
@endif
@php
$last = date('Ymd', $agenda->begin_at);
$last2 = date('Ym', $agenda->begin_at);
@endphp
<div class="event @if ($agenda->class) {{ $agenda->class }} @endif">
  <div class="time">
    <div class="time-begin">
      {{ date('G:i', $agenda->begin_at) }}
    </div>
    @if ($agenda->end_at)
    <div class="time-end">
      {{ date('G:i', $agenda->end_at) }}
    </div>
    @endif
  </div>
  <div class="content">
    <div class="title">{{ $agenda->title }}</div>
    <div class="description">{{ $agenda->description }}</div>
  </div>
</div>
@endforeach
