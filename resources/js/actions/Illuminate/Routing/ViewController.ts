import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
const ViewControllerf00abb0097e42b00e09cbcd59b20e7f6 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url(options),
    method: 'get',
})

ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.definition = {
    methods: ["get","head"],
    url: '/sds-sheets',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url = (options?: RouteQueryOptions) => {
    return ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
const ViewControllerf00abb0097e42b00e09cbcd59b20e7f6Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
ViewControllerf00abb0097e42b00e09cbcd59b20e7f6Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/sds-sheets'
*/
ViewControllerf00abb0097e42b00e09cbcd59b20e7f6Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewControllerf00abb0097e42b00e09cbcd59b20e7f6.form = ViewControllerf00abb0097e42b00e09cbcd59b20e7f6Form
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
const ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.definition = {
    methods: ["get","head"],
    url: '/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url = (options?: RouteQueryOptions) => {
    return ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
const ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.form = ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
const ViewController39cf50c98836c20d29fa0dfb7a7064d0 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

ViewController39cf50c98836c20d29fa0dfb7a7064d0.definition = {
    methods: ["get","head"],
    url: '/courses/all',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.url = (options?: RouteQueryOptions) => {
    return ViewController39cf50c98836c20d29fa0dfb7a7064d0.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
const ViewController39cf50c98836c20d29fa0dfb7a7064d0Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController39cf50c98836c20d29fa0dfb7a7064d0.form = ViewController39cf50c98836c20d29fa0dfb7a7064d0Form
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
const ViewController63db0bdc59264ba3ad0fbd8a32b71620 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url(options),
    method: 'get',
})

ViewController63db0bdc59264ba3ad0fbd8a32b71620.definition = {
    methods: ["get","head"],
    url: '/vendors/thankyou',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
ViewController63db0bdc59264ba3ad0fbd8a32b71620.url = (options?: RouteQueryOptions) => {
    return ViewController63db0bdc59264ba3ad0fbd8a32b71620.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
ViewController63db0bdc59264ba3ad0fbd8a32b71620.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
ViewController63db0bdc59264ba3ad0fbd8a32b71620.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
const ViewController63db0bdc59264ba3ad0fbd8a32b71620Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
ViewController63db0bdc59264ba3ad0fbd8a32b71620Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
ViewController63db0bdc59264ba3ad0fbd8a32b71620Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController63db0bdc59264ba3ad0fbd8a32b71620.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController63db0bdc59264ba3ad0fbd8a32b71620.form = ViewController63db0bdc59264ba3ad0fbd8a32b71620Form
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
const ViewController25849e51446dd6841a9e89ac6c28cbec = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController25849e51446dd6841a9e89ac6c28cbec.url(options),
    method: 'get',
})

ViewController25849e51446dd6841a9e89ac6c28cbec.definition = {
    methods: ["get","head"],
    url: '/employees/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
ViewController25849e51446dd6841a9e89ac6c28cbec.url = (options?: RouteQueryOptions) => {
    return ViewController25849e51446dd6841a9e89ac6c28cbec.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
ViewController25849e51446dd6841a9e89ac6c28cbec.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController25849e51446dd6841a9e89ac6c28cbec.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
ViewController25849e51446dd6841a9e89ac6c28cbec.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController25849e51446dd6841a9e89ac6c28cbec.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
const ViewController25849e51446dd6841a9e89ac6c28cbecForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController25849e51446dd6841a9e89ac6c28cbec.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
ViewController25849e51446dd6841a9e89ac6c28cbecForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController25849e51446dd6841a9e89ac6c28cbec.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/employees/create'
*/
ViewController25849e51446dd6841a9e89ac6c28cbecForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController25849e51446dd6841a9e89ac6c28cbec.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController25849e51446dd6841a9e89ac6c28cbec.form = ViewController25849e51446dd6841a9e89ac6c28cbecForm
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
const ViewController4420dcf8aa0401dd2e787b7842100090 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController4420dcf8aa0401dd2e787b7842100090.url(options),
    method: 'get',
})

ViewController4420dcf8aa0401dd2e787b7842100090.definition = {
    methods: ["get","head"],
    url: '/locations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
ViewController4420dcf8aa0401dd2e787b7842100090.url = (options?: RouteQueryOptions) => {
    return ViewController4420dcf8aa0401dd2e787b7842100090.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
ViewController4420dcf8aa0401dd2e787b7842100090.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController4420dcf8aa0401dd2e787b7842100090.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
ViewController4420dcf8aa0401dd2e787b7842100090.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController4420dcf8aa0401dd2e787b7842100090.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
const ViewController4420dcf8aa0401dd2e787b7842100090Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController4420dcf8aa0401dd2e787b7842100090.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
ViewController4420dcf8aa0401dd2e787b7842100090Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController4420dcf8aa0401dd2e787b7842100090.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/locations'
*/
ViewController4420dcf8aa0401dd2e787b7842100090Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController4420dcf8aa0401dd2e787b7842100090.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController4420dcf8aa0401dd2e787b7842100090.form = ViewController4420dcf8aa0401dd2e787b7842100090Form
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
const ViewController00b8255e77f8b9a60ccb93668a7a17ae = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url(options),
    method: 'get',
})

ViewController00b8255e77f8b9a60ccb93668a7a17ae.definition = {
    methods: ["get","head"],
    url: '/scans-archive',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
ViewController00b8255e77f8b9a60ccb93668a7a17ae.url = (options?: RouteQueryOptions) => {
    return ViewController00b8255e77f8b9a60ccb93668a7a17ae.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
ViewController00b8255e77f8b9a60ccb93668a7a17ae.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
ViewController00b8255e77f8b9a60ccb93668a7a17ae.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
const ViewController00b8255e77f8b9a60ccb93668a7a17aeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
ViewController00b8255e77f8b9a60ccb93668a7a17aeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/scans-archive'
*/
ViewController00b8255e77f8b9a60ccb93668a7a17aeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController00b8255e77f8b9a60ccb93668a7a17ae.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController00b8255e77f8b9a60ccb93668a7a17ae.form = ViewController00b8255e77f8b9a60ccb93668a7a17aeForm
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
const ViewController86a0d0e665572eead9d650bb21337c56 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController86a0d0e665572eead9d650bb21337c56.url(options),
    method: 'get',
})

ViewController86a0d0e665572eead9d650bb21337c56.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
ViewController86a0d0e665572eead9d650bb21337c56.url = (options?: RouteQueryOptions) => {
    return ViewController86a0d0e665572eead9d650bb21337c56.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
ViewController86a0d0e665572eead9d650bb21337c56.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController86a0d0e665572eead9d650bb21337c56.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
ViewController86a0d0e665572eead9d650bb21337c56.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController86a0d0e665572eead9d650bb21337c56.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
const ViewController86a0d0e665572eead9d650bb21337c56Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController86a0d0e665572eead9d650bb21337c56.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
ViewController86a0d0e665572eead9d650bb21337c56Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController86a0d0e665572eead9d650bb21337c56.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/audits/deal-jackets'
*/
ViewController86a0d0e665572eead9d650bb21337c56Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController86a0d0e665572eead9d650bb21337c56.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController86a0d0e665572eead9d650bb21337c56.form = ViewController86a0d0e665572eead9d650bb21337c56Form

const ViewController = {
    '/sds-sheets': ViewControllerf00abb0097e42b00e09cbcd59b20e7f6,
    '/courses': ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b,
    '/courses/all': ViewController39cf50c98836c20d29fa0dfb7a7064d0,
    '/vendors/thankyou': ViewController63db0bdc59264ba3ad0fbd8a32b71620,
    '/employees/create': ViewController25849e51446dd6841a9e89ac6c28cbec,
    '/locations': ViewController4420dcf8aa0401dd2e787b7842100090,
    '/scans-archive': ViewController00b8255e77f8b9a60ccb93668a7a17ae,
    '/audits/deal-jackets': ViewController86a0d0e665572eead9d650bb21337c56,
}

export default ViewController