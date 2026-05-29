import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:234
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
* @see app/Http/Controllers/Tenant/UserController.php:234
* @route '/employees/deleted'
*/
deleted.url = (options?: RouteQueryOptions) => {
    return deleted.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:234
* @route '/employees/deleted'
*/
deleted.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::deleted
* @see app/Http/Controllers/Tenant/UserController.php:234
* @route '/employees/deleted'
*/
deleted.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: deleted.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::restoreEmployee
* @see app/Http/Controllers/Tenant/UserController.php:247
* @route '/employees/deleted/{user}/restore'
*/
export const restoreEmployee = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restoreEmployee.url(args, options),
    method: 'post',
})

restoreEmployee.definition = {
    methods: ["post"],
    url: '/employees/deleted/{user}/restore',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::restoreEmployee
* @see app/Http/Controllers/Tenant/UserController.php:247
* @route '/employees/deleted/{user}/restore'
*/
restoreEmployee.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { user: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.id
        : args.user,
    }

    return restoreEmployee.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::restoreEmployee
* @see app/Http/Controllers/Tenant/UserController.php:247
* @route '/employees/deleted/{user}/restore'
*/
restoreEmployee.post = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: restoreEmployee.url(args, options),
    method: 'post',
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
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:114
* @route '/employees/invite'
*/
export const storeInvite = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeInvite.url(options),
    method: 'post',
})

storeInvite.definition = {
    methods: ["post"],
    url: '/employees/invite',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:114
* @route '/employees/invite'
*/
storeInvite.url = (options?: RouteQueryOptions) => {
    return storeInvite.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:114
* @route '/employees/invite'
*/
storeInvite.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeInvite.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:141
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
* @see app/Http/Controllers/Tenant/UserController.php:141
* @route '/employees/open-invites'
*/
openInvites.url = (options?: RouteQueryOptions) => {
    return openInvites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:141
* @route '/employees/open-invites'
*/
openInvites.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: openInvites.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::openInvites
* @see app/Http/Controllers/Tenant/UserController.php:141
* @route '/employees/open-invites'
*/
openInvites.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: openInvites.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvites
* @see app/Http/Controllers/Tenant/UserController.php:174
* @route '/employees/open-invites/resend'
*/
export const resendInvites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendInvites.url(options),
    method: 'post',
})

resendInvites.definition = {
    methods: ["post"],
    url: '/employees/open-invites/resend',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvites
* @see app/Http/Controllers/Tenant/UserController.php:174
* @route '/employees/open-invites/resend'
*/
resendInvites.url = (options?: RouteQueryOptions) => {
    return resendInvites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvites
* @see app/Http/Controllers/Tenant/UserController.php:174
* @route '/employees/open-invites/resend'
*/
resendInvites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendInvites.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvite
* @see app/Http/Controllers/Tenant/UserController.php:156
* @route '/employees/open-invites/{invite}/resend'
*/
export const resendInvite = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendInvite.url(args, options),
    method: 'post',
})

resendInvite.definition = {
    methods: ["post"],
    url: '/employees/open-invites/{invite}/resend',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvite
* @see app/Http/Controllers/Tenant/UserController.php:156
* @route '/employees/open-invites/{invite}/resend'
*/
resendInvite.url = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { invite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { invite: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            invite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        invite: typeof args.invite === 'object'
        ? args.invite.id
        : args.invite,
    }

    return resendInvite.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::resendInvite
* @see app/Http/Controllers/Tenant/UserController.php:156
* @route '/employees/open-invites/{invite}/resend'
*/
resendInvite.post = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendInvite.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroyInvite
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/open-invites/{invite}'
*/
export const destroyInvite = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyInvite.url(args, options),
    method: 'delete',
})

destroyInvite.definition = {
    methods: ["delete"],
    url: '/employees/open-invites/{invite}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::destroyInvite
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/open-invites/{invite}'
*/
destroyInvite.url = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { invite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { invite: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            invite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        invite: typeof args.invite === 'object'
        ? args.invite.id
        : args.invite,
    }

    return destroyInvite.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::destroyInvite
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/open-invites/{invite}'
*/
destroyInvite.delete = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyInvite.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:267
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
* @see app/Http/Controllers/Tenant/UserController.php:267
* @route '/employees/import'
*/
importMethod.url = (options?: RouteQueryOptions) => {
    return importMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:267
* @route '/employees/import'
*/
importMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:292
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
* @see app/Http/Controllers/Tenant/UserController.php:292
* @route '/employees/export'
*/
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:292
* @route '/employees/export'
*/
exportMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:508
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
* @see app/Http/Controllers/Tenant/UserController.php:508
* @route '/employees/email-report'
*/
emailReport.url = (options?: RouteQueryOptions) => {
    return emailReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:508
* @route '/employees/email-report'
*/
emailReport.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: emailReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::sendMessage
* @see app/Http/Controllers/Tenant/UserController.php:534
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
* @see app/Http/Controllers/Tenant/UserController.php:534
* @route '/employees/send-message'
*/
sendMessage.url = (options?: RouteQueryOptions) => {
    return sendMessage.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::sendMessage
* @see app/Http/Controllers/Tenant/UserController.php:534
* @route '/employees/send-message'
*/
sendMessage.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendMessage.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:332
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
* @see app/Http/Controllers/Tenant/UserController.php:332
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
* @see app/Http/Controllers/Tenant/UserController.php:332
* @route '/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:332
* @route '/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:345
* @route '/employees/{user}/courses'
*/
export const courses = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(args, options),
    method: 'get',
})

courses.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:345
* @route '/employees/{user}/courses'
*/
courses.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return courses.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:345
* @route '/employees/{user}/courses'
*/
courses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:345
* @route '/employees/{user}/courses'
*/
courses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
export const recordCourseResult = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordCourseResult.url(args, options),
    method: 'post',
})

recordCourseResult.definition = {
    methods: ["post"],
    url: '/employees/{user}/courses/{course}/result',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
recordCourseResult.url = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            user: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.slug
        : args.user,
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return recordCourseResult.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
recordCourseResult.post = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordCourseResult.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:380
* @route '/employees/{user}/manage-courses'
*/
export const manageCourses = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

manageCourses.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/manage-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:380
* @route '/employees/{user}/manage-courses'
*/
manageCourses.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return manageCourses.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:380
* @route '/employees/{user}/manage-courses'
*/
manageCourses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:380
* @route '/employees/{user}/manage-courses'
*/
manageCourses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: manageCourses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:394
* @route '/employees/{user}/course-overrides/{course}'
*/
export const updateCourseOverride = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateCourseOverride.url(args, options),
    method: 'patch',
})

updateCourseOverride.definition = {
    methods: ["patch"],
    url: '/employees/{user}/course-overrides/{course}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:394
* @route '/employees/{user}/course-overrides/{course}'
*/
updateCourseOverride.url = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            user: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.slug
        : args.user,
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return updateCourseOverride.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:394
* @route '/employees/{user}/course-overrides/{course}'
*/
updateCourseOverride.patch = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateCourseOverride.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:414
* @route '/employees/{user}/dot-certificates'
*/
export const dotCertificates = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dotCertificates.url(args, options),
    method: 'get',
})

dotCertificates.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/dot-certificates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:414
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return dotCertificates.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:414
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:414
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dotCertificates.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:433
* @route '/employees/{user}/dot-certificates'
*/
export const generateDotCertificate = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateDotCertificate.url(args, options),
    method: 'post',
})

generateDotCertificate.definition = {
    methods: ["post"],
    url: '/employees/{user}/dot-certificates',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:433
* @route '/employees/{user}/dot-certificates'
*/
generateDotCertificate.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return generateDotCertificate.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:433
* @route '/employees/{user}/dot-certificates'
*/
generateDotCertificate.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateDotCertificate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:451
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
* @see app/Http/Controllers/Tenant/UserController.php:451
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
* @see app/Http/Controllers/Tenant/UserController.php:451
* @route '/employees/{user}'
*/
update.patch = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:471
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
* @see app/Http/Controllers/Tenant/UserController.php:471
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
* @see app/Http/Controllers/Tenant/UserController.php:471
* @route '/employees/{user}'
*/
destroy.delete = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:487
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
* @see app/Http/Controllers/Tenant/UserController.php:487
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
* @see app/Http/Controllers/Tenant/UserController.php:487
* @route '/employees/{user}/impersonate'
*/
impersonate.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: impersonate.url(args, options),
    method: 'post',
})

const UserController = { deleted, restoreEmployee, index, invite, storeInvite, openInvites, resendInvites, resendInvite, destroyInvite, importMethod, exportMethod, emailReport, sendMessage, show, courses, recordCourseResult, manageCourses, updateCourseOverride, dotCertificates, generateDotCertificate, update, destroy, impersonate, import: importMethod, export: exportMethod }

export default UserController