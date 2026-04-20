<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\User\Queries\GetDeletedUsers;
use App\Domain\Central\User\Queries\GetUsers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Central\UserDeletedResource;
use App\Http\Resources\Central\UserResource;
use App\Models\Course;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(GetUsers $getUsers): Response
    {
        return Inertia::render('central/user/Index', [
            'users' => UserResource::collection($getUsers->handle()),
            'totalCoursesCount' => Inertia::defer(fn () => Course::query()->count()),
        ]);
    }

    public function show(User $user): Response
    {
        $user->load('roles:id,name');

        return Inertia::render('central/user/Show', [
            'user' => new UserResource($user)->resolve(),
        ]);
    }

    public function deleted(GetDeletedUsers $getDeletedUsers): Response
    {
        $this->authorize('viewDeleted', User::class);

        return Inertia::render('central/user/Deleted', [
            'users' => UserDeletedResource::collection($getDeletedUsers->handle()),
        ]);
    }
}
