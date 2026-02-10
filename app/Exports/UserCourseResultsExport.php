<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UserCourseResultsExport implements FromQuery
{
    use Exportable;

    public User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function query(): Builder
    {
        //        return User::all();
        return Course::query()
            ->where('department_id', $this->user->department_id)
            ->select('id', 'name')
            ->with('results', function ($query): void {
                $query->where('user_id', $this->user->id)->select('id')->latest();
            });
    }
}
