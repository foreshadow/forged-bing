<div class="date">
  <a class="btn btn-link btn-sm pull-right" data-toggle="modal" data-target="#myModal">New</a>
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
    <form action="/calendar/{{ $agenda->id }}" method="POST">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="close" data-confirm="你确定吗？"
                      {{-- <span class='glyphicon glyphicon-trash'></span>  --}}
              data-toggle="tooltip" data-placement="left" title="删除">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
    </form>
    <div class="time">
      <div class="time-begin">
        {{ date('G:i', $agenda->begin_at) }}
      </div>
      @if ($agenda->end_at != $agenda->begin_at)
          <div class="time-end">
            {{ date('G:i', $agenda->end_at) }}
            @if ($agenda->end_at - $agenda->begin_at >= 24 * 60 * 60 || date('Hi', $agenda->end_at) < date('Hi', $agenda->begin_at))
              <small>+{{ floor(($agenda->end_at - $agenda->begin_at) / (24 * 60 * 60)) + (date('Hi', $agenda->end_at) < date('Hi', $agenda->begin_at) ? 1 : 0) }}</small>
            @endif
          </div>
      @endif
    </div>
    <div class="content">
      <div class="title">{{ $agenda->title }}</div>
      <div class="description inline">{!! $agenda->description !!}</div>
    </div>
  </div>
@endforeach
