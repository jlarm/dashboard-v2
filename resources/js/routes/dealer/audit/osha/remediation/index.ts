import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:322
* @route '/audits/osha/{audit}/remediation/generate'
*/
export const generate = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/remediation/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:322
* @route '/audits/osha/{audit}/remediation/generate'
*/
generate.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return generate.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:322
* @route '/audits/osha/{audit}/remediation/generate'
*/
generate.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:204
* @route '/audits/osha/{audit}/remediation'
*/
export const update = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/remediation',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:204
* @route '/audits/osha/{audit}/remediation'
*/
update.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return update.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:204
* @route '/audits/osha/{audit}/remediation'
*/
update.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:296
* @route '/audits/osha/{audit}/remediation/download'
*/
export const download = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/remediation/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:296
* @route '/audits/osha/{audit}/remediation/download'
*/
download.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return download.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:296
* @route '/audits/osha/{audit}/remediation/download'
*/
download.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:296
* @route '/audits/osha/{audit}/remediation/download'
*/
download.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

const remediation = {
    update: Object.assign(update, update),
    download: Object.assign(download, download),
}

export default remediation