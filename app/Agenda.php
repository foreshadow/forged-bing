<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function recent()
    {
        return Agenda::orderBy('begin_at')->where('end_at', '>=', time())->get();
    }

    public static function codeforces()
    {
        $contests = CodeforcesContest::orderBy('startTimeSeconds')->where('startTimeSeconds', '>=', time() - 9000)->get();
        foreach ($contests as &$contest) {
            $contest->title = $contest->name;
            $contest->description = '<a href="//codeforces.com/contest/' . $contest->id . '">codeforces.com/contest/' . $contest->id . '</a>';
            $contest->begin_at = $contest->startTimeSeconds;
            $contest->end_at = $contest->startTimeSeconds + $contest->durationSeconds;
            $contest->class = 'bg-info';
        }
        return $contests;
    }

    public static function timeline()
    {
        return Agenda::recent()->merge(Agenda::codeforces())->sortBy('begin_at');
    }
}
