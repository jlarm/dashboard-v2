import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/scans',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:35
* @route '/scans'
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
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
export const externalFinding = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: externalFinding.url(options),
    method: 'get',
})

externalFinding.definition = {
    methods: ["get","head"],
    url: '/scans/external-finding',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
externalFinding.url = (options?: RouteQueryOptions) => {
    return externalFinding.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
externalFinding.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: externalFinding.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
externalFinding.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: externalFinding.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
const externalFindingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: externalFinding.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
externalFindingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: externalFinding.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:217
* @route '/scans/external-finding'
*/
externalFindingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: externalFinding.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

externalFinding.form = externalFindingForm

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:141
* @route '/scans/queue-report'
*/
export const queueReport = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: queueReport.url(options),
    method: 'post',
})

queueReport.definition = {
    methods: ["post"],
    url: '/scans/queue-report',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:141
* @route '/scans/queue-report'
*/
queueReport.url = (options?: RouteQueryOptions) => {
    return queueReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:141
* @route '/scans/queue-report'
*/
queueReport.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: queueReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:141
* @route '/scans/queue-report'
*/
const queueReportForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: queueReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:141
* @route '/scans/queue-report'
*/
queueReportForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: queueReport.url(options),
    method: 'post',
})

queueReport.form = queueReportForm

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
export const reportStatus = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reportStatus.url(args, options),
    method: 'get',
})

reportStatus.definition = {
    methods: ["get","head"],
    url: '/scans/report-status/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
reportStatus.url = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return reportStatus.definition.url
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
reportStatus.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reportStatus.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
reportStatus.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reportStatus.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
const reportStatusForm = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: reportStatus.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
reportStatusForm.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: reportStatus.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::reportStatus
* @see app/Http/Controllers/Tenant/ScansController.php:176
* @route '/scans/report-status/{type}'
*/
reportStatusForm.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: reportStatus.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

reportStatus.form = reportStatusForm

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:205
* @route '/scans/refresh-cache'
*/
export const refreshCache = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: refreshCache.url(options),
    method: 'post',
})

refreshCache.definition = {
    methods: ["post"],
    url: '/scans/refresh-cache',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:205
* @route '/scans/refresh-cache'
*/
refreshCache.url = (options?: RouteQueryOptions) => {
    return refreshCache.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:205
* @route '/scans/refresh-cache'
*/
refreshCache.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: refreshCache.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:205
* @route '/scans/refresh-cache'
*/
const refreshCacheForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: refreshCache.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:205
* @route '/scans/refresh-cache'
*/
refreshCacheForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: refreshCache.url(options),
    method: 'post',
})

refreshCache.form = refreshCacheForm

const ScansController = { index, externalFinding, queueReport, reportStatus, refreshCache }

export default ScansController