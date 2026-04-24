import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
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
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::index
* @see app/Http/Controllers/Tenant/UserController.php:52
* @route '/employees'
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
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
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
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
invite.url = (options?: RouteQueryOptions) => {
    return invite.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
invite.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: invite.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
invite.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: invite.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
const inviteForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invite.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
inviteForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invite.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::invite
* @see app/Http/Controllers/Tenant/UserController.php:87
* @route '/employees/invite'
*/
inviteForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: invite.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

invite.form = inviteForm

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:115
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
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
storeInvite.url = (options?: RouteQueryOptions) => {
    return storeInvite.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
storeInvite.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeInvite.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
const storeInviteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeInvite.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::storeInvite
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
storeInviteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeInvite.url(options),
    method: 'post',
})

storeInvite.form = storeInviteForm

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:137
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
* @see app/Http/Controllers/Tenant/UserController.php:137
* @route '/employees/import'
*/
importMethod.url = (options?: RouteQueryOptions) => {
    return importMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:137
* @route '/employees/import'
*/
importMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:137
* @route '/employees/import'
*/
const importMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::importMethod
* @see app/Http/Controllers/Tenant/UserController.php:137
* @route '/employees/import'
*/
importMethodForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importMethod.url(options),
    method: 'post',
})

importMethod.form = importMethodForm

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:162
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
* @see app/Http/Controllers/Tenant/UserController.php:162
* @route '/employees/export'
*/
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:162
* @route '/employees/export'
*/
exportMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:162
* @route '/employees/export'
*/
const exportMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: exportMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::exportMethod
* @see app/Http/Controllers/Tenant/UserController.php:162
* @route '/employees/export'
*/
exportMethodForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: exportMethod.url(options),
    method: 'post',
})

exportMethod.form = exportMethodForm

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:343
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
* @see app/Http/Controllers/Tenant/UserController.php:343
* @route '/employees/email-report'
*/
emailReport.url = (options?: RouteQueryOptions) => {
    return emailReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:343
* @route '/employees/email-report'
*/
emailReport.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: emailReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:343
* @route '/employees/email-report'
*/
const emailReportForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: emailReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::emailReport
* @see app/Http/Controllers/Tenant/UserController.php:343
* @route '/employees/email-report'
*/
emailReportForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: emailReport.url(options),
    method: 'post',
})

emailReport.form = emailReportForm

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:202
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
* @see app/Http/Controllers/Tenant/UserController.php:202
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
* @see app/Http/Controllers/Tenant/UserController.php:202
* @route '/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:202
* @route '/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:202
* @route '/employees/{user}'
*/
const showForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:202
* @route '/employees/{user}'
*/
showForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::show
* @see app/Http/Controllers/Tenant/UserController.php:202
* @route '/employees/{user}'
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

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:214
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
* @see app/Http/Controllers/Tenant/UserController.php:214
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
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/{user}/courses'
*/
courses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/{user}/courses'
*/
courses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/{user}/courses'
*/
const coursesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/{user}/courses'
*/
coursesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:214
* @route '/employees/{user}/courses'
*/
coursesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

courses.form = coursesForm

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:231
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
* @see app/Http/Controllers/Tenant/UserController.php:231
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
* @see app/Http/Controllers/Tenant/UserController.php:231
* @route '/employees/{user}/courses/{course}/result'
*/
recordCourseResult.post = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordCourseResult.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:231
* @route '/employees/{user}/courses/{course}/result'
*/
const recordCourseResultForm = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: recordCourseResult.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::recordCourseResult
* @see app/Http/Controllers/Tenant/UserController.php:231
* @route '/employees/{user}/courses/{course}/result'
*/
recordCourseResultForm.post = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: recordCourseResult.url(args, options),
    method: 'post',
})

recordCourseResult.form = recordCourseResultForm

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:242
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
* @see app/Http/Controllers/Tenant/UserController.php:242
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
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/{user}/manage-courses'
*/
manageCourses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/{user}/manage-courses'
*/
manageCourses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: manageCourses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/{user}/manage-courses'
*/
const manageCoursesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/{user}/manage-courses'
*/
manageCoursesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:242
* @route '/employees/{user}/manage-courses'
*/
manageCoursesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

manageCourses.form = manageCoursesForm

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:255
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
* @see app/Http/Controllers/Tenant/UserController.php:255
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
* @see app/Http/Controllers/Tenant/UserController.php:255
* @route '/employees/{user}/course-overrides/{course}'
*/
updateCourseOverride.patch = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateCourseOverride.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:255
* @route '/employees/{user}/course-overrides/{course}'
*/
const updateCourseOverrideForm = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateCourseOverride.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::updateCourseOverride
* @see app/Http/Controllers/Tenant/UserController.php:255
* @route '/employees/{user}/course-overrides/{course}'
*/
updateCourseOverrideForm.patch = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateCourseOverride.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateCourseOverride.form = updateCourseOverrideForm

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:269
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
* @see app/Http/Controllers/Tenant/UserController.php:269
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
* @see app/Http/Controllers/Tenant/UserController.php:269
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:269
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dotCertificates.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:269
* @route '/employees/{user}/dot-certificates'
*/
const dotCertificatesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:269
* @route '/employees/{user}/dot-certificates'
*/
dotCertificatesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:269
* @route '/employees/{user}/dot-certificates'
*/
dotCertificatesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dotCertificates.form = dotCertificatesForm

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:287
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
* @see app/Http/Controllers/Tenant/UserController.php:287
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
* @see app/Http/Controllers/Tenant/UserController.php:287
* @route '/employees/{user}/dot-certificates'
*/
generateDotCertificate.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateDotCertificate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:287
* @route '/employees/{user}/dot-certificates'
*/
const generateDotCertificateForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateDotCertificate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::generateDotCertificate
* @see app/Http/Controllers/Tenant/UserController.php:287
* @route '/employees/{user}/dot-certificates'
*/
generateDotCertificateForm.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateDotCertificate.url(args, options),
    method: 'post',
})

generateDotCertificate.form = generateDotCertificateForm

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:303
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
* @see app/Http/Controllers/Tenant/UserController.php:303
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
* @see app/Http/Controllers/Tenant/UserController.php:303
* @route '/employees/{user}'
*/
update.patch = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:303
* @route '/employees/{user}'
*/
const updateForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::update
* @see app/Http/Controllers/Tenant/UserController.php:303
* @route '/employees/{user}'
*/
updateForm.patch = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:317
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
* @see app/Http/Controllers/Tenant/UserController.php:317
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
* @see app/Http/Controllers/Tenant/UserController.php:317
* @route '/employees/{user}'
*/
destroy.delete = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:317
* @route '/employees/{user}'
*/
const destroyForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:317
* @route '/employees/{user}'
*/
destroyForm.delete = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:328
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
* @see app/Http/Controllers/Tenant/UserController.php:328
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
* @see app/Http/Controllers/Tenant/UserController.php:328
* @route '/employees/{user}/impersonate'
*/
impersonate.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: impersonate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:328
* @route '/employees/{user}/impersonate'
*/
const impersonateForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: impersonate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::impersonate
* @see app/Http/Controllers/Tenant/UserController.php:328
* @route '/employees/{user}/impersonate'
*/
impersonateForm.post = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: impersonate.url(args, options),
    method: 'post',
})

impersonate.form = impersonateForm

const UserController = { index, invite, storeInvite, importMethod, exportMethod, emailReport, show, courses, recordCourseResult, manageCourses, updateCourseOverride, dotCertificates, generateDotCertificate, update, destroy, impersonate, import: importMethod, export: exportMethod }

export default UserController