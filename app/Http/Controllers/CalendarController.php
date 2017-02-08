<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index')->with('agendas', Agenda::orderBy('begin_at')->where('end_at', '>=', time())->get());
    }

    public function store(Request $request)
    {
        $repeat = $request->get('repeat_time') or 1;
        $begin_at = strtotime($request->get('begin_at'));
        $end_at = strtotime($request->get('end_at'));
        for ($i = 0; $i < $repeat; $i += 1) {
            $agenda = new Agenda();
            $agenda->title = $request->get('title');
            $agenda->description = $request->get('description');
            $agenda->begin_at = $begin_at;
            $agenda->end_at = $end_at;
            $agenda->save();
            $begin_at += $request->get('repeat_interval') * 24 * 60 * 60;
            if ($end_at) {
                $end_at += $request->get('repeat_interval') * 24 * 60 * 60;
            }
        }
        return redirect('/calendar');
    }

    function api(Request $request)
    {
        $agendas = Agenda::all();
        foreach ($agendas as &$agenda) {
            $agenda->start = date('Y-m-d H:i:s', $agenda->begin_at);
            $agenda->end = date('Y-m-d H:i:s', $agenda->end_at);
        }
        return $agendas->toJson();
    }
}
