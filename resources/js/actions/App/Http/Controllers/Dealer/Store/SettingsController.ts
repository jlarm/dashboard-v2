import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::__invoke
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:24
* @route '/settings'
*/
const SettingsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SettingsController.url(options),
    method: 'get',
})

SettingsController.definition = {
    methods: ["get","head"],
    url: '/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::__invoke
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:24
* @route '/settings'
*/
SettingsController.url = (options?: RouteQueryOptions) => {
    return SettingsController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::__invoke
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:24
* @route '/settings'
*/
SettingsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SettingsController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::__invoke
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:24
* @route '/settings'
*/
SettingsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SettingsController.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/managers'
*/
const show54d96389de2c26c8aa47568d826bdc1a = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

show54d96389de2c26c8aa47568d826bdc1a.definition = {
    methods: ["get","head"],
    url: '/settings/managers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/managers'
*/
show54d96389de2c26c8aa47568d826bdc1a.url = (options?: RouteQueryOptions) => {
    return show54d96389de2c26c8aa47568d826bdc1a.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/managers'
*/
show54d96389de2c26c8aa47568d826bdc1a.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/managers'
*/
show54d96389de2c26c8aa47568d826bdc1a.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/compliance'
*/
const show07e4b1e71f7ca89ae125207430bfcbc5 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

show07e4b1e71f7ca89ae125207430bfcbc5.definition = {
    methods: ["get","head"],
    url: '/settings/compliance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/compliance'
*/
show07e4b1e71f7ca89ae125207430bfcbc5.url = (options?: RouteQueryOptions) => {
    return show07e4b1e71f7ca89ae125207430bfcbc5.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/compliance'
*/
show07e4b1e71f7ca89ae125207430bfcbc5.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/compliance'
*/
show07e4b1e71f7ca89ae125207430bfcbc5.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/reset-courses'
*/
const show9b68a843959ff354cb034cafed1e1a3b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

show9b68a843959ff354cb034cafed1e1a3b.definition = {
    methods: ["get","head"],
    url: '/settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/reset-courses'
*/
show9b68a843959ff354cb034cafed1e1a3b.url = (options?: RouteQueryOptions) => {
    return show9b68a843959ff354cb034cafed1e1a3b.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/reset-courses'
*/
show9b68a843959ff354cb034cafed1e1a3b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/reset-courses'
*/
show9b68a843959ff354cb034cafed1e1a3b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/ridgeback'
*/
const show3780fa24ae844edb658a5dff4f3fa048 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show3780fa24ae844edb658a5dff4f3fa048.url(options),
    method: 'get',
})

show3780fa24ae844edb658a5dff4f3fa048.definition = {
    methods: ["get","head"],
    url: '/settings/ridgeback',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/ridgeback'
*/
show3780fa24ae844edb658a5dff4f3fa048.url = (options?: RouteQueryOptions) => {
    return show3780fa24ae844edb658a5dff4f3fa048.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/ridgeback'
*/
show3780fa24ae844edb658a5dff4f3fa048.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show3780fa24ae844edb658a5dff4f3fa048.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Store\SettingsController::show
* @see app/Http/Controllers/Dealer/Store/SettingsController.php:29
* @route '/settings/ridgeback'
*/
show3780fa24ae844edb658a5dff4f3fa048.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show3780fa24ae844edb658a5dff4f3fa048.url(options),
    method: 'head',
})

export const show = {
    '/settings/managers': show54d96389de2c26c8aa47568d826bdc1a,
    '/settings/compliance': show07e4b1e71f7ca89ae125207430bfcbc5,
    '/settings/reset-courses': show9b68a843959ff354cb034cafed1e1a3b,
    '/settings/ridgeback': show3780fa24ae844edb658a5dff4f3fa048,
}

SettingsController.show = show

export default SettingsController