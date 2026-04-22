import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
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
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
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
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
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
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
const settingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
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
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
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
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
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
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
* @route '/scans/report/{type}'
*/
report.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
* @route '/scans/report/{type}'
*/
report.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: report.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
* @route '/scans/report/{type}'
*/
const reportForm = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
* @route '/scans/report/{type}'
*/
reportForm.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: report.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::report
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:17
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
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
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
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
archive.url = (options?: RouteQueryOptions) => {
    return archive.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
archive.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
archive.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archive.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
const archiveForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: archive.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
archiveForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: archive.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
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
    settings: Object.assign(settings, settings),
    report: Object.assign(report, report),
    archive: Object.assign(archive, archive),
}

export default scan