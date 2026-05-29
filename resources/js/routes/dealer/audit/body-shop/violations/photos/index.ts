import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:251
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
export const destroy = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:251
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
destroy.url = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            violation: args[1],
            photoId: args[2],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        violation: typeof args.violation === 'object'
        ? args.violation.id
        : args.violation,
        photoId: args.photoId,
    }

    return destroy.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace('{photoId}', parsedArgs.photoId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:251
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
destroy.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const photos = {
    destroy: Object.assign(destroy, destroy),
}

export default photos