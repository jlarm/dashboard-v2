<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserCourseResultsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
//        return \App\Models\Dealer\Course::query()
//            ->where('department_id', $this->user->department_id)
//            ->select('id', 'name')
//            ->with('results', function ($query) {
//                $query->where('user_id', $this->user->id)->latest();
//            })
//            ->get();
    }
}
