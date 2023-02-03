<?php

namespace Database\Seeders;

use App\Models\Dealer\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $files = Storage::disk('courses')->allFiles();

        foreach ($files as $file) {
            $course = File::get(app_path("courses/{$file}"));
            $json = json_decode($course);

            foreach ($json as $key => $value) {
                $course = Course::create([
                    'department_id' => $value->department,
                    'slug' => $value->slug,
                    'name' => $value->name,
                    'slides' => $value->slides,
                    'questions' => $value->questions,
                ]);
            }
        }
    }
}
