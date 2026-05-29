import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:122
* @route '/courses/dot-certificate'
*/
export const issue = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: issue.url(options),
    method: 'post',
})

issue.definition = {
    methods: ["post"],
    url: '/courses/dot-certificate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:122
* @route '/courses/dot-certificate'
*/
issue.url = (options?: RouteQueryOptions) => {
    return issue.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:122
* @route '/courses/dot-certificate'
*/
issue.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: issue.url(options),
    method: 'post',
})

const dotCertificate = {
    issue: Object.assign(issue, issue),
}

export default dotCertificate