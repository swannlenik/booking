<?php

namespace App\Services;

use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimetableService
{
    public function getTimetables(): Collection {
        return Timetable::all()->keyBy('id');
    }

    public function getByID(int $id): Timetable {
        return Timetable::find($id);
    }

    public function addTimetable(array $data): Timetable {
        $timetable = new Timetable();
        $timetable->day = $data['day'];
        $timetable->id_place = $data['id_place'];
        $timetable->slot_duration = $data['slot_duration'];
        $timetable->max_user = $data['max_user'];
        $timetable->start_time = $data['start_time'];
        $timetable->end_time = $data['end_time'];
        $timetable->save();

        return $timetable;
    }

    public function deleteTimetable(int $id): void {
        $timetable = Timetable::find($id);
        $timetable->delete();
    }
}
