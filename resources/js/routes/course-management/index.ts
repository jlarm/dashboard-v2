import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/course-management',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::index
* @see app/Http/Controllers/Central/CourseManagementController.php:30
* @route '//dashboard.test/course-management'
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
* @see \App\Http\Controllers\Central\CourseManagementController::importMethod
* @see app/Http/Controllers/Central/CourseManagementController.php:91
* @route '//dashboard.test/course-management/import'
*/
export const importMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

importMethod.definition = {
    methods: ["post"],
    url: '//dashboard.test/course-management/import',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::importMethod
* @see app/Http/Controllers/Central/CourseManagementController.php:91
* @route '//dashboard.test/course-management/import'
*/
importMethod.url = (options?: RouteQueryOptions) => {
    return importMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::importMethod
* @see app/Http/Controllers/Central/CourseManagementController.php:91
* @route '//dashboard.test/course-management/import'
*/
importMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::importMethod
* @see app/Http/Controllers/Central/CourseManagementController.php:91
* @route '//dashboard.test/course-management/import'
*/
const importMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::importMethod
* @see app/Http/Controllers/Central/CourseManagementController.php:91
* @route '//dashboard.test/course-management/import'
*/
importMethodForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: importMethod.url(options),
    method: 'post',
})

importMethod.form = importMethodForm

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
export const edit = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/course-management/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
edit.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return edit.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
edit.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
edit.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
const editForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
editForm.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::edit
* @see app/Http/Controllers/Central/CourseManagementController.php:42
* @route '//dashboard.test/course-management/{course}'
*/
editForm.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\Central\CourseManagementController::update
* @see app/Http/Controllers/Central/CourseManagementController.php:49
* @route '//dashboard.test/course-management/{course}'
*/
export const update = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '//dashboard.test/course-management/{course}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::update
* @see app/Http/Controllers/Central/CourseManagementController.php:49
* @route '//dashboard.test/course-management/{course}'
*/
update.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return update.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::update
* @see app/Http/Controllers/Central/CourseManagementController.php:49
* @route '//dashboard.test/course-management/{course}'
*/
update.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::update
* @see app/Http/Controllers/Central/CourseManagementController.php:49
* @route '//dashboard.test/course-management/{course}'
*/
const updateForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::update
* @see app/Http/Controllers/Central/CourseManagementController.php:49
* @route '//dashboard.test/course-management/{course}'
*/
updateForm.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Central\CourseManagementController::updateQuiz
* @see app/Http/Controllers/Central/CourseManagementController.php:64
* @route '//dashboard.test/course-management/{course}/quiz'
*/
export const updateQuiz = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateQuiz.url(args, options),
    method: 'patch',
})

updateQuiz.definition = {
    methods: ["patch"],
    url: '//dashboard.test/course-management/{course}/quiz',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateQuiz
* @see app/Http/Controllers/Central/CourseManagementController.php:64
* @route '//dashboard.test/course-management/{course}/quiz'
*/
updateQuiz.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return updateQuiz.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateQuiz
* @see app/Http/Controllers/Central/CourseManagementController.php:64
* @route '//dashboard.test/course-management/{course}/quiz'
*/
updateQuiz.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateQuiz.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateQuiz
* @see app/Http/Controllers/Central/CourseManagementController.php:64
* @route '//dashboard.test/course-management/{course}/quiz'
*/
const updateQuizForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateQuiz.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateQuiz
* @see app/Http/Controllers/Central/CourseManagementController.php:64
* @route '//dashboard.test/course-management/{course}/quiz'
*/
updateQuizForm.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateQuiz.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateQuiz.form = updateQuizForm

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateSettings
* @see app/Http/Controllers/Central/CourseManagementController.php:75
* @route '//dashboard.test/course-management/{course}/settings'
*/
export const updateSettings = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateSettings.url(args, options),
    method: 'patch',
})

updateSettings.definition = {
    methods: ["patch"],
    url: '//dashboard.test/course-management/{course}/settings',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateSettings
* @see app/Http/Controllers/Central/CourseManagementController.php:75
* @route '//dashboard.test/course-management/{course}/settings'
*/
updateSettings.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return updateSettings.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateSettings
* @see app/Http/Controllers/Central/CourseManagementController.php:75
* @route '//dashboard.test/course-management/{course}/settings'
*/
updateSettings.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateSettings.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateSettings
* @see app/Http/Controllers/Central/CourseManagementController.php:75
* @route '//dashboard.test/course-management/{course}/settings'
*/
const updateSettingsForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSettings.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\CourseManagementController::updateSettings
* @see app/Http/Controllers/Central/CourseManagementController.php:75
* @route '//dashboard.test/course-management/{course}/settings'
*/
updateSettingsForm.patch = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateSettings.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateSettings.form = updateSettingsForm

const courseManagement = {
    index: Object.assign(index, index),
    import: Object.assign(importMethod, importMethod),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    updateQuiz: Object.assign(updateQuiz, updateQuiz),
    updateSettings: Object.assign(updateSettings, updateSettings),
}

export default courseManagement