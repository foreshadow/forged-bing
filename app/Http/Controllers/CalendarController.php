<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index')->with('agendas', Agenda::recent());
    }

    public function store(Request $request)
    {
        $repeat = $request->get('repeat_time') or $repeat = 1;
        $begin_at = strtotime($request->get('begin_at'));
        $end_at = strtotime($request->get('end_at'));
        for ($i = 0; $i < $repeat; $i += 1) {
            $agenda = new Agenda();
            $agenda->title = $request->get('title');
            $agenda->description = $request->get('description');
            $agenda->begin_at = $begin_at;
            $agenda->end_at = $end_at or $agenda->end_at = $begin_at;
            $agenda->class = $request->get('class');
            $agenda->save();
            $begin_at += $request->get('repeat_interval') * 24 * 60 * 60;
            if ($end_at) {
                $end_at += $request->get('repeat_interval') * 24 * 60 * 60;
            }
        }

        return redirect()->back();
    }

    public function destroy($id, Request $request)
    {
        $agenda = Agenda::find($id);
        $agenda->delete();
        return redirect('/');
    }

    public function api(Request $request)
    {
        $agendas = Agenda::recent();
        foreach ($agendas as &$agenda) {
            $agenda->start = date('Y-m-d H:i:s', $agenda->begin_at);
            $agenda->end = date('Y-m-d H:i:s', $agenda->end_at);
        }

        return $agendas->toJson();
    }
}
