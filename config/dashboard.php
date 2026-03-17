<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Excluded Users
    |--------------------------------------------------------------------------
    |
    | Users listed here will be excluded from department completion statistics.
    |
    */

    'excluded_users' => [
        'Joe Lohr',
        'Terry Dortch',
        'Mike Backer',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Dealership ID
    |--------------------------------------------------------------------------
    |
    | The ID of the dealership that is always visible to non-super-admin users,
    | regardless of their assigned dealerships.
    |
    */

    'default_dealership_id' => env('DEFAULT_DEALERSHIP_ID', 'e44653a5-c049-4be0-92e3-b8aacea4bf20'),

];
