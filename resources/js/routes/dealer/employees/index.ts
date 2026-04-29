import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
import deleted3ae2e7 from './deleted'
import invite9ae5a1 from './invite'
import openInvitesA232b1 from './open-invites'
import showBac614 from './show'
import courses from './courses'
import courseOverrides from './course-overrides'
import dotCertificates from './dot-certificates'
/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
export const create = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/invite_registration/{invite}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.url = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { invite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'invitation_token' in args) {
        args = { invite: args.invitation_token }
    }

    if (Array.isArray(args)) {
        args = {
            invite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        invite: typeof args.invite === 'object'
        ? args.invite.invitation_token
        : args.invite,
    }

    return create.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.get = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.head = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/employees/dealer/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:199
* @route '/employees/deleted'
*/
export const deleted = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

deleted.definition = {
    methods: ["get","head"],
    url: '/employees/deleted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:199
* @route '/employees/deleted'
*/
deleted.url = (options?: RouteQueryOptions) => {
    return deleted.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:199
* @route '/employees/deleted'
*/
deleted.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:199
* @route '/employees/deleted'
*/
deleted.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: deleted.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:62
* @route '/employees'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/employees',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:62
* @route '/employees'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:62
* @route '/employees'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:62
* @route '/employees'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:90
* @route '/employees/invite'
*/
export const invite = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: invite.url(options),
    method: 'get',
})

invite.definition = {
    methods: ["get","head"],
    url: '/employees/invite',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:90
* @route '/employees/invite'
*/
invite.url = (options?: RouteQueryOptions) => {
    return invite.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:90
* @route '/employees/invite'
*/
invite.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: invite.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:90
* @route '/employees/invite'
*/
invite.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: invite.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:135
* @route '/employees/open-invites'
*/
export const openInvites = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: openInvites.url(options),
    method: 'get',
})

openInvites.definition = {
    methods: ["get","head"],
    url: '/employees/open-invites',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:135
* @route '/employees/open-invites'
*/
openInvites.url = (options?: RouteQueryOptions) => {
    return openInvites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:135
* @route '/employees/open-invites'
*/
openInvites.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: openInvites.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:135
* @route '/employees/open-invites'
*/
openInvites.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: openInvites.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:226
* @route '/employees/import'
*/
export const importMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

importMethod.definition = {
    methods: ["post"],
    url: '/employees/import',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:226
* @route '/employees/import'
*/
importMethod.url = (options?: RouteQueryOptions) => {
    return importMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:226
* @route '/employees/import'
*/
importMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/export'
*/
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

exportMethod.definition = {
    methods: ["post"],
    url: '/employees/export',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/export'
*/
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/export'
*/
exportMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:426
* @route '/employees/email-report'
*/
export const emailReport = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: emailReport.url(options),
    method: 'post',
})

emailReport.definition = {
    methods: ["post"],
    url: '/employees/email-report',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:426
* @route '/employees/email-report'
*/
emailReport.url = (options?: RouteQueryOptions) => {
    return emailReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:426
* @route '/employees/email-report'
*/
emailReport.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: emailReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::sendMessage
* @see app/Http/Controllers/Tenant/UserController.php:451
* @route '/employees/send-message'
*/
export const sendMessage = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendMessage.url(options),
    method: 'post',
})

sendMessage.definition = {
    methods: ["post"],
    url: '/employees/send-message',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::sendMessage
* @see app/Http/Controllers/Tenant/UserController.php:451
* @route '/employees/send-message'
*/
sendMessage.url = (options?: RouteQueryOptions) => {
    return sendMessage.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::sendMessage
* @see app/Http/Controllers/Tenant/UserController.php:451
* @route '/employees/send-message'
*/
sendMessage.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendMessage.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:282
* @route '/employees/{user}'
*/
export const show = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/employees/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:282
* @route '/employees/{user}'
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
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:282
* @route '/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:282
* @route '/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:387
* @route '/employees/{user}'
*/
export const update = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/employees/{user}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:387
* @route '/employees/{user}'
*/
update.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:387
* @route '/employees/{user}'
*/
update.patch = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:401
* @route '/employees/{user}'
*/
export const destroy = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/employees/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:401
* @route '/employees/{user}'
*/
destroy.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:401
* @route '/employees/{user}'
*/
destroy.delete = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:411
* @route '/employees/{user}/impersonate'
*/
export const impersonate = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: impersonate.url(args, options),
    method: 'post',
})

impersonate.definition = {
    methods: ["post"],
    url: '/employees/{user}/impersonate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:411
* @route '/employees/{user}/impersonate'
*/
impersonate.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return impersonate.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:411
* @route '/employees/{user}/impersonate'
*/
impersonate.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: impersonate.url(args, options),
    method: 'post',
})

const employees = {
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    deleted: Object.assign(deleted, deleted3ae2e7),
    index: Object.assign(index, index),
    invite: Object.assign(invite, invite9ae5a1),
    openInvites: Object.assign(openInvites, openInvitesA232b1),
    import: Object.assign(importMethod, importMethod),
    export: Object.assign(exportMethod, exportMethod),
    emailReport: Object.assign(emailReport, emailReport),
    sendMessage: Object.assign(sendMessage, sendMessage),
    show: Object.assign(show, showBac614),
    courses: Object.assign(courses, courses),
    courseOverrides: Object.assign(courseOverrides, courseOverrides),
    dotCertificates: Object.assign(dotCertificates, dotCertificates),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    impersonate: Object.assign(impersonate, impersonate),
}

export default employees