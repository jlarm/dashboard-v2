<?php

namespace Database\Seeders;

use App\Models\Dealer\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $path = app_path('courses');
        $files = File::allFiles($path);
        sort($files, SORT_NATURAL);

        foreach ($files as $file) {
            $course = File::get($file);
            $json = json_decode($course);
            foreach ($json as $key => $value) {
                $course = Course::create([
                    'slug' => $value->slug,
                    'name' => $value->name,
                    'slides' => $value->slides,
                    'questions' => $value->questions,
                    'optional' => $value->optional ?? false,
                ]);
                if ($value->department !== null) {
                    $course->departments()->attach($value->department);
                }
                if ($value->roles !== null) {
                    $course->roles()->attach($value->roles);
                }
            }
        }
    }
}
