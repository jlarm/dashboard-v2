<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\AssignCustomCoursesForm;
use App\Http\Livewire\Dealer\Employee\CertIndex;
use App\Http\Livewire\Tenant\Employee\VideoProgress;
use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\VimeoService;
use Livewire\Livewire;

describe('employee show page', function (): void {
    it('renders the employee profile view for authorized users', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update(['videos' => false]);
        app()->instance('currentStore', $store->id);

        $department = Department::query()->create([
            'name' => 'Sales '.uniqid(),
            'slug' => 'sales-'.uniqid(),
        ]);

        $user = User::query()->create([
            'name' => 'Alex Employee',
            'email' => 'alex.employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        $response = $this->actingAs($this->consultant)->get(route('dealer.employees.show', $user));

        $response->assertOk()
            ->assertSee('Alex Employee')
            ->assertSee('Courses')
            ->assertSee('DOT Certificates');
    });
});

describe('employee show page deferred components', function (): void {
    it('loads manage courses data only when manage-courses tab is opened', function (): void {
        $department = Department::query()->create([
            'name' => 'Service '.uniqid(),
            'slug' => 'service-'.uniqid(),
        ]);

        $user = User::query()->create([
            'name' => 'Taylor User',
            'email' => 'taylor.user@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        Course::query()->create([
            'name' => 'General Safety',
            'slug' => 'general-safety-show-page-test',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $component = Livewire::test(AssignCustomCoursesForm::class, ['user' => $user])
            ->assertSet('isLoaded', false);

        expect($component->get('courses')->count())->toBe(0);

        $component->call('handleTabChanged', 'courses')
            ->assertSet('isLoaded', false);

        $component->call('handleTabChanged', 'manage-courses')
            ->assertSet('isLoaded', true);

        expect($component->get('courses')->count())->toBeGreaterThan(0);
    });

    it('loads certificates only when certificates tab is opened', function (): void {
        $user = User::query()->create([
            'name' => 'Jordan User',
            'email' => 'jordan.user@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Livewire::test(CertIndex::class, ['user' => $user])
            ->assertSet('isLoaded', false)
            ->assertViewHas('certs', fn ($certs) => $certs->isEmpty())
            ->call('handleTabChanged', 'courses')
            ->assertSet('isLoaded', false)
            ->call('handleTabChanged', 'certificates')
            ->assertSet('isLoaded', true);
    });

    it('loads video progress only when video-progress tab is opened', function (): void {
        $user = User::query()->create([
            'name' => 'Casey User',
            'email' => 'casey.user@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $user->videoProgress()->create([
            'video_id' => 101,
            'completed' => true,
        ]);

        $mock = $this->mock(VimeoService::class);
        $mock->shouldReceive('getVideos')->once()->andReturn([
            ['id' => 101, 'title' => 'Video A', 'category' => 'Security'],
        ]);

        Livewire::test(VideoProgress::class, ['user' => $user])
            ->assertSet('isLoaded', false)
            ->assertViewHas('videos', fn ($videos): bool => count($videos) === 0)
            ->call('handleTabChanged', 'courses')
            ->assertSet('isLoaded', false)
            ->call('handleTabChanged', 'video-progress')
            ->assertSet('isLoaded', true)
            ->assertViewHas('videos', function ($videos): bool {
                if (count($videos) !== 1) {
                    return false;
                }

                $video = $videos[0];

                return $video['id'] === 101 && $video['completed'] === true;
            });
    });
});
