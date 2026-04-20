import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
import invitesD766f2 from './invites'
/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
export const create = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/employees/register/{centralUserInvite}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
create.url = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { centralUserInvite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { centralUserInvite: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            centralUserInvite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        centralUserInvite: typeof args.centralUserInvite === 'object'
        ? args.centralUserInvite.id
        : args.centralUserInvite,
    }

    return create.definition.url
            .replace('{centralUserInvite}', parsedArgs.centralUserInvite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
create.get = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
create.head = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
const createForm = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
createForm.get = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::create
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:24
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
createForm.head = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::store
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:33
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
export const store = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/employees/register/{centralUserInvite}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::store
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:33
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
store.url = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { centralUserInvite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { centralUserInvite: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            centralUserInvite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        centralUserInvite: typeof args.centralUserInvite === 'object'
        ? args.centralUserInvite.id
        : args.centralUserInvite,
    }

    return store.definition.url
            .replace('{centralUserInvite}', parsedArgs.centralUserInvite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::store
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:33
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
store.post = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::store
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:33
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
const storeForm = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\UserInviteRegistrationController::store
* @see app/Http/Controllers/Central/UserInviteRegistrationController.php:33
* @route '//dashboard.test/employees/register/{centralUserInvite}'
*/
storeForm.post = (args: { centralUserInvite: number | { id: number } } | [centralUserInvite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/employees',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard.test/employees'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
export const invites = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: invites.url(options),
    method: 'get',
})

invites.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/employees/invites',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
invites.url = (options?: RouteQueryOptions) => {
    return invites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
invites.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: invites.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
invites.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: invites.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
const invitesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invites.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
invitesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invites.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::invites
* @see app/Http/Controllers/Central/InviteController.php:25
* @route '//dashboard.test/employees/invites'
*/
invitesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invites.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

invites.form = invitesForm

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
export const deleted = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

deleted.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/employees/deleted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
deleted.url = (options?: RouteQueryOptions) => {
    return deleted.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
deleted.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
deleted.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: deleted.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
const deletedForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
deletedForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard.test/employees/deleted'
*/
deletedForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

deleted.form = deletedForm

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
export const show = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/employees/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
show.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { user: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.slug
        : args.user,
    }

    return show.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
const showForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
showForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard.test/employees/{user}'
*/
showForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const employees = {
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    index: Object.assign(index, index),
    invites: Object.assign(invites, invitesD766f2),
    deleted: Object.assign(deleted, deleted),
    show: Object.assign(show, show),
}

export default employees