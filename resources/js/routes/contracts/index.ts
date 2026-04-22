import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
import review from './review'
import pdf from './pdf'
/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
export const show = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contract/view/{contract}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return show.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
const showForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
showForm.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
showForm.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
export const thankYou = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankYou.url(options),
    method: 'get',
})

thankYou.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/thank-you',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
thankYou.url = (options?: RouteQueryOptions) => {
    return thankYou.definition.url + queryParams(options)
}

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
thankYou.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankYou.url(options),
    method: 'get',
})

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
thankYou.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: thankYou.url(options),
    method: 'head',
})

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
const thankYouForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankYou.url(options),
    method: 'get',
})

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
thankYouForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankYou.url(options),
    method: 'get',
})

/**
* @see routes/web.php:38
* @route '//dashboard.test/thank-you'
*/
thankYouForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankYou.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

thankYou.form = thankYouForm

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
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
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/contracts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
export const edit = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return edit.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
const editForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
editForm.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
editForm.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
export const update = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
update.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return update.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
update.patch = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
const updateForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
updateForm.patch = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
export const destroy = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
destroy.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return destroy.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
destroy.delete = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
const destroyForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
destroyForm.delete = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard.test/contracts/{contract}/send'
*/
export const send = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '//dashboard.test/contracts/{contract}/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard.test/contracts/{contract}/send'
*/
send.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return send.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard.test/contracts/{contract}/send'
*/
send.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard.test/contracts/{contract}/send'
*/
const sendForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard.test/contracts/{contract}/send'
*/
sendForm.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(args, options),
    method: 'post',
})

send.form = sendForm

const contracts = {
    show: Object.assign(show, show),
    review: Object.assign(review, review),
    thankYou: Object.assign(thankYou, thankYou),
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    send: Object.assign(send, send),
    pdf: Object.assign(pdf, pdf),
}

export default contracts