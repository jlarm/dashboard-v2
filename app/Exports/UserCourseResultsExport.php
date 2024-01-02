<?php

namespace App\Exports;

use App\Models\Dealer\Course;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UserCourseResultsExport implements FromQuery
{
    use Exportable;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function query()
    {
        //        return User::all();
        return Course::query()
            ->where('department_id', $this->user->department_id)
            ->select('id', 'name')
            ->with('results', function ($query) {
                $query->where('user_id', $this->user->id)->select('id')->latest();
            });
    }
}
