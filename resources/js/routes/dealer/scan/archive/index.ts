import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
export const upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

upload.definition = {
    methods: ["post"],
    url: '/scans-archive/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
upload.url = (options?: RouteQueryOptions) => {
    return upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

const archive = {
    upload: Object.assign(upload, upload),
}

export default archive