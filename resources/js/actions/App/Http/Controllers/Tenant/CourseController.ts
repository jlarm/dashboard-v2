import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:28
* @route '/courses'
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
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
export const all = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: all.url(options),
    method: 'get',
})

all.definition = {
    methods: ["get","head"],
    url: '/courses/all',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
all.url = (options?: RouteQueryOptions) => {
    return all.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
all.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: all.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
all.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: all.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
const allForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: all.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
allForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: all.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:43
* @route '/courses/all'
*/
allForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: all.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

all.form = allForm

/**
* @see \App\Http\Controllers\Tenant\CourseController::issueDotCertificate
* @see app/Http/Controllers/Tenant/CourseController.php:123
* @route '/courses/dot-certificate'
*/
export const issueDotCertificate = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: issueDotCertificate.url(options),
    method: 'post',
})

issueDotCertificate.definition = {
    methods: ["post"],
    url: '/courses/dot-certificate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::issueDotCertificate
* @see app/Http/Controllers/Tenant/CourseController.php:123
* @route '/courses/dot-certificate'
*/
issueDotCertificate.url = (options?: RouteQueryOptions) => {
    return issueDotCertificate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::issueDotCertificate
* @see app/Http/Controllers/Tenant/CourseController.php:123
* @route '/courses/dot-certificate'
*/
issueDotCertificate.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: issueDotCertificate.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::issueDotCertificate
* @see app/Http/Controllers/Tenant/CourseController.php:123
* @route '/courses/dot-certificate'
*/
const issueDotCertificateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: issueDotCertificate.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::issueDotCertificate
* @see app/Http/Controllers/Tenant/CourseController.php:123
* @route '/courses/dot-certificate'
*/
issueDotCertificateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: issueDotCertificate.url(options),
    method: 'post',
})

issueDotCertificate.form = issueDotCertificateForm

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
export const show = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
show.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
show.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
show.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
const showForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
showForm.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:52
* @route '/courses/{course}'
*/
showForm.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
export const quiz = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

quiz.definition = {
    methods: ["get","head"],
    url: '/courses/{course}/quiz',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
quiz.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return quiz.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
quiz.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
quiz.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: quiz.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
const quizForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: quiz.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
quizForm.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: quiz.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:68
* @route '/courses/{course}/quiz'
*/
quizForm.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: quiz.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

quiz.form = quizForm

/**
* @see \App\Http\Controllers\Tenant\CourseController::submitQuiz
* @see app/Http/Controllers/Tenant/CourseController.php:90
* @route '/courses/{course}/quiz'
*/
export const submitQuiz = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitQuiz.url(args, options),
    method: 'post',
})

submitQuiz.definition = {
    methods: ["post"],
    url: '/courses/{course}/quiz',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::submitQuiz
* @see app/Http/Controllers/Tenant/CourseController.php:90
* @route '/courses/{course}/quiz'
*/
submitQuiz.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return submitQuiz.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::submitQuiz
* @see app/Http/Controllers/Tenant/CourseController.php:90
* @route '/courses/{course}/quiz'
*/
submitQuiz.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitQuiz.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::submitQuiz
* @see app/Http/Controllers/Tenant/CourseController.php:90
* @route '/courses/{course}/quiz'
*/
const submitQuizForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: submitQuiz.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::submitQuiz
* @see app/Http/Controllers/Tenant/CourseController.php:90
* @route '/courses/{course}/quiz'
*/
submitQuizForm.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: submitQuiz.url(args, options),
    method: 'post',
})

submitQuiz.form = submitQuizForm

/**
* @see \App\Http\Controllers\Tenant\CourseController::markVideoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:113
* @route '/courses/{course}/video-complete'
*/
export const markVideoComplete = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markVideoComplete.url(args, options),
    method: 'post',
})

markVideoComplete.definition = {
    methods: ["post"],
    url: '/courses/{course}/video-complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::markVideoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:113
* @route '/courses/{course}/video-complete'
*/
markVideoComplete.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return markVideoComplete.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::markVideoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:113
* @route '/courses/{course}/video-complete'
*/
markVideoComplete.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: markVideoComplete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::markVideoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:113
* @route '/courses/{course}/video-complete'
*/
const markVideoCompleteForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: markVideoComplete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::markVideoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:113
* @route '/courses/{course}/video-complete'
*/
markVideoCompleteForm.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: markVideoComplete.url(args, options),
    method: 'post',
})

markVideoComplete.form = markVideoCompleteForm

const CourseController = { index, all, issueDotCertificate, show, quiz, submitQuiz, markVideoComplete }

export default CourseController