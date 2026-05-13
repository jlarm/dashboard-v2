import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:121
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
* @see app/Http/Controllers/Tenant/CourseController.php:121
* @route '/courses/dot-certificate'
*/
issue.url = (options?: RouteQueryOptions) => {
    return issue.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:121
* @route '/courses/dot-certificate'
*/
issue.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: issue.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:121
* @route '/courses/dot-certificate'
*/
const issueForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: issue.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::issue
* @see app/Http/Controllers/Tenant/CourseController.php:121
* @route '/courses/dot-certificate'
*/
issueForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: issue.url(options),
    method: 'post',
})

issue.form = issueForm

const dotCertificate = {
    issue: Object.assign(issue, issue),
}

export default dotCertificate