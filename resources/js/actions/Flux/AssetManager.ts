import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
export const fluxJs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: fluxJs.url(options),
    method: 'get',
})

fluxJs.definition = {
    methods: ["get","head"],
    url: '/flux/flux.js',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
fluxJs.url = (options?: RouteQueryOptions) => {
    return fluxJs.definition.url + queryParams(options)
}

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
fluxJs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: fluxJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
fluxJs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: fluxJs.url(options),
    method: 'head',
})

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
const fluxJsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
fluxJsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxJs
* @see vendor/livewire/flux/src/AssetManager.php:44
* @route '/flux/flux.js'
*/
fluxJsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxJs.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

fluxJs.form = fluxJsForm

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
export const fluxMinJs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: fluxMinJs.url(options),
    method: 'get',
})

fluxMinJs.definition = {
    methods: ["get","head"],
    url: '/flux/flux.min.js',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
fluxMinJs.url = (options?: RouteQueryOptions) => {
    return fluxMinJs.definition.url + queryParams(options)
}

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
fluxMinJs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: fluxMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
fluxMinJs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: fluxMinJs.url(options),
    method: 'head',
})

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
const fluxMinJsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
fluxMinJsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::fluxMinJs
* @see vendor/livewire/flux/src/AssetManager.php:50
* @route '/flux/flux.min.js'
*/
fluxMinJsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: fluxMinJs.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

fluxMinJs.form = fluxMinJsForm

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
export const editorCss = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorCss.url(options),
    method: 'get',
})

editorCss.definition = {
    methods: ["get","head"],
    url: '/flux/editor.css',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
editorCss.url = (options?: RouteQueryOptions) => {
    return editorCss.definition.url + queryParams(options)
}

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
editorCss.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorCss.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
editorCss.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editorCss.url(options),
    method: 'head',
})

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
const editorCssForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorCss.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
editorCssForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorCss.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorCss
* @see vendor/livewire/flux/src/AssetManager.php:56
* @route '/flux/editor.css'
*/
editorCssForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorCss.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

editorCss.form = editorCssForm

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
export const editorJs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorJs.url(options),
    method: 'get',
})

editorJs.definition = {
    methods: ["get","head"],
    url: '/flux/editor.js',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
editorJs.url = (options?: RouteQueryOptions) => {
    return editorJs.definition.url + queryParams(options)
}

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
editorJs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
editorJs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editorJs.url(options),
    method: 'head',
})

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
const editorJsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
editorJsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorJs
* @see vendor/livewire/flux/src/AssetManager.php:62
* @route '/flux/editor.js'
*/
editorJsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorJs.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

editorJs.form = editorJsForm

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
export const editorMinJs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorMinJs.url(options),
    method: 'get',
})

editorMinJs.definition = {
    methods: ["get","head"],
    url: '/flux/editor.min.js',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
editorMinJs.url = (options?: RouteQueryOptions) => {
    return editorMinJs.definition.url + queryParams(options)
}

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
editorMinJs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editorMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
editorMinJs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editorMinJs.url(options),
    method: 'head',
})

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
const editorMinJsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
editorMinJsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorMinJs.url(options),
    method: 'get',
})

/**
* @see \Flux\AssetManager::editorMinJs
* @see vendor/livewire/flux/src/AssetManager.php:68
* @route '/flux/editor.min.js'
*/
editorMinJsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: editorMinJs.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

editorMinJs.form = editorMinJsForm

const AssetManager = { fluxJs, fluxMinJs, editorCss, editorJs, editorMinJs }

export default AssetManager