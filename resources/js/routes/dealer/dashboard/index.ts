import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
import consultantNote from './consultant-note'
/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:221
* @route '/dashboard/audit-report'
*/
export const auditReport = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditReport.url(options),
    method: 'get',
})

auditReport.definition = {
    methods: ["get","head"],
    url: '/dashboard/audit-report',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:221
* @route '/dashboard/audit-report'
*/
auditReport.url = (options?: RouteQueryOptions) => {
    return auditReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:221
* @route '/dashboard/audit-report'
*/
auditReport.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditReport.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditReport
* @see app/Http/Controllers/Tenant/DashboardController.php:221
* @route '/dashboard/audit-report'
*/
auditReport.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: auditReport.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:246
* @route '/dashboard/audit-report/{type}'
*/
export const auditTypeReport = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditTypeReport.url(args, options),
    method: 'get',
})

auditTypeReport.definition = {
    methods: ["get","head"],
    url: '/dashboard/audit-report/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:246
* @route '/dashboard/audit-report/{type}'
*/
auditTypeReport.url = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return auditTypeReport.definition.url
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:246
* @route '/dashboard/audit-report/{type}'
*/
auditTypeReport.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: auditTypeReport.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::auditTypeReport
* @see app/Http/Controllers/Tenant/DashboardController.php:246
* @route '/dashboard/audit-report/{type}'
*/
auditTypeReport.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: auditTypeReport.url(args, options),
    method: 'head',
})

const dashboard = {
    auditReport: Object.assign(auditReport, auditReport),
    auditTypeReport: Object.assign(auditTypeReport, auditTypeReport),
    consultantNote: Object.assign(consultantNote, consultantNote),
}

export default dashboard