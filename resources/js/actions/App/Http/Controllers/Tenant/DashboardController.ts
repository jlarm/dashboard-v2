import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
const showForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
showForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::show
* @see app/Http/Controllers/Tenant/DashboardController.php:60
* @route '/dashboard'
*/
showForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
export const downloadAuditReport = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadAuditReport.url(options),
    method: 'get',
})

downloadAuditReport.definition = {
    methods: ["get","head"],
    url: '/dashboard/audit-report',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
downloadAuditReport.url = (options?: RouteQueryOptions) => {
    return downloadAuditReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
downloadAuditReport.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadAuditReport.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
downloadAuditReport.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadAuditReport.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
const downloadAuditReportForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditReport.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
downloadAuditReportForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditReport.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:192
* @route '/dashboard/audit-report'
*/
downloadAuditReportForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditReport.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadAuditReport.form = downloadAuditReportForm

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
export const downloadAuditTypeReport = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadAuditTypeReport.url(args, options),
    method: 'get',
})

downloadAuditTypeReport.definition = {
    methods: ["get","head"],
    url: '/dashboard/audit-report/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
downloadAuditTypeReport.url = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { type: args }
    }

    if (Array.isArray(args)) {
        args = {
            type: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        type: args.type,
    }

    return downloadAuditTypeReport.definition.url
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
downloadAuditTypeReport.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadAuditTypeReport.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
downloadAuditTypeReport.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadAuditTypeReport.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
const downloadAuditTypeReportForm = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditTypeReport.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
downloadAuditTypeReportForm.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditTypeReport.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::downloadAuditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:217
* @route '/dashboard/audit-report/{type}'
*/
downloadAuditTypeReportForm.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadAuditTypeReport.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadAuditTypeReport.form = downloadAuditTypeReportForm

/**
* @see \App\Http\Controllers\Tenant\DashboardController::updateConsultantNote
* @see app/Http/Controllers/Tenant/DashboardController.php:170
* @route '/dashboard/consultant-note'
*/
export const updateConsultantNote = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateConsultantNote.url(options),
    method: 'post',
})

updateConsultantNote.definition = {
    methods: ["post"],
    url: '/dashboard/consultant-note',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::updateConsultantNote
* @see app/Http/Controllers/Tenant/DashboardController.php:170
* @route '/dashboard/consultant-note'
*/
updateConsultantNote.url = (options?: RouteQueryOptions) => {
    return updateConsultantNote.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::updateConsultantNote
* @see app/Http/Controllers/Tenant/DashboardController.php:170
* @route '/dashboard/consultant-note'
*/
updateConsultantNote.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateConsultantNote.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::updateConsultantNote
* @see app/Http/Controllers/Tenant/DashboardController.php:170
* @route '/dashboard/consultant-note'
*/
const updateConsultantNoteForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateConsultantNote.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::updateConsultantNote
* @see app/Http/Controllers/Tenant/DashboardController.php:170
* @route '/dashboard/consultant-note'
*/
updateConsultantNoteForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateConsultantNote.url(options),
    method: 'post',
})

updateConsultantNote.form = updateConsultantNoteForm

const DashboardController = { show, downloadAuditReport, downloadAuditTypeReport, updateConsultantNote }

export default DashboardController