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
    it('renders the employee profile courses page for authorized users', function (): void {
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

    it('renders the manage courses page for users who can manage assignments', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update(['videos' => false]);
        app()->instance('currentStore', $store->id);

        $department = Department::query()->create([
            'name' => 'Finance '.uniqid(),
            'slug' => 'finance-'.uniqid(),
        ]);

        $user = User::query()->create([
            'name' => 'Morgan Employee',
            'email' => 'morgan.employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        Course::query()->create([
            'name' => 'Assigned Course',
            'slug' => 'assigned-course-show-page-test',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show.manage-courses', $user));

        $response->assertOk()
            ->assertSee('Manage Courses')
            ->assertSee('Manage course assignments')
            ->assertDontSee('Select the &quot;Manage Courses&quot; tab to load course assignments.', false);
    });

    it('renders the certificates page without waiting for a tab event', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update(['videos' => false]);
        app()->instance('currentStore', $store->id);

        $user = User::query()->create([
            'name' => 'Jordan Cert User',
            'email' => 'jordan.cert@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show.certificates', $user));

        $response->assertOk()
            ->assertSee('DOT Certificates')
            ->assertDontSee('Select the &quot;DOT Certificates&quot; tab to load certificates.', false);
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

    it('autoloads manage courses data when rendered on its own page', function (): void {
        $department = Department::query()->create([
            'name' => 'Detailing '.uniqid(),
            'slug' => 'detailing-'.uniqid(),
        ]);

        $user = User::query()->create([
            'name' => 'Autoload User',
            'email' => 'autoload.user@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        Course::query()->create([
            'name' => 'Autoload Course',
            'slug' => 'autoload-course-show-page-test',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        Livewire::test(AssignCustomCoursesForm::class, ['user' => $user, 'autoload' => true])
            ->assertSet('isLoaded', true);
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

    it('autoloads certificates when rendered on their own page', function (): void {
        $user = User::query()->create([
            'name' => 'Autoload Cert User',
            'email' => 'autoload.cert@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Livewire::test(CertIndex::class, ['user' => $user, 'autoload' => true])
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

    it('autoloads video progress when rendered on its own page', function (): void {
        $user = User::query()->create([
            'name' => 'Autoload Video User',
            'email' => 'autoload.video@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $user->videoProgress()->create([
            'video_id' => 202,
            'completed' => true,
        ]);

        $mock = $this->mock(VimeoService::class);
        $mock->shouldReceive('getVideos')->once()->andReturn([
            ['id' => 202, 'title' => 'Video B', 'category' => 'Compliance'],
        ]);

        Livewire::test(VideoProgress::class, ['user' => $user, 'autoload' => true])
            ->assertSet('isLoaded', true)
            ->assertViewHas('videos', function ($videos): bool {
                if (count($videos) !== 1) {
                    return false;
                }

                return $videos[0]['id'] === 202 && $videos[0]['completed'] === true;
            });
    });
});
