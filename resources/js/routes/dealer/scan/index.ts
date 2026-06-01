import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import settings69f00b from './settings'
import archiveBc62fe from './archive'
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

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
export const settings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

settings.definition = {
    methods: ["get","head"],
    url: '/scans/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
const settingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settingsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

settings.form = settingsForm

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
export const report = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: report.url(args, options),
    method: 'get',
})

report.definition = {
    methods: ["get","head"],
    url: '/scans/report/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
report.url = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return report.definition.url
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
report.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
report.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: report.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
const reportForm = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
reportForm.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
reportForm.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: report.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

report.form = reportForm

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
export const archive = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})

archive.definition = {
    methods: ["get","head"],
    url: '/scans-archive',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
archive.url = (options?: RouteQueryOptions) => {
    return archive.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
archive.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
archive.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archive.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
const archiveForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: archive.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
archiveForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: archive.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::archive
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
archiveForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: archive.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

archive.form = archiveForm

const scan = {
    index: Object.assign(index, index),
    externalFinding: Object.assign(externalFinding, externalFinding),
    queueReport: Object.assign(queueReport, queueReport),
    reportStatus: Object.assign(reportStatus, reportStatus),
    refreshCache: Object.assign(refreshCache, refreshCache),
    settings: Object.assign(settings, settings69f00b),
    report: Object.assign(report, report),
    archive: Object.assign(archive, archiveBc62fe),
}

export default scan