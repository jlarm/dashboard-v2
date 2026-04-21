import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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

const UserInviteRegistrationController = { create, store }

export default UserInviteRegistrationController