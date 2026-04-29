import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import password from './password'
import store from './store'
import legacyStores from './legacy-stores'
import employees from './employees'
import sds from './sds'
import courses from './courses'
import vendor from './vendor'
import vendors from './vendors'
import dealer from './dealer'
import profile from './profile'
import userPassword from './user-password'
import appearance from './appearance'
import notifications from './notifications'
import settings from './settings'
import audit from './audit'
import phishing from './phishing'
import ridgeback from './ridgeback'
import locations from './locations'
import logs from './logs'
import manual from './manual'
import scan from './scan'
import doc from './doc'
import fitTests from './fit-tests'
import impersonate from './impersonate'
import employee from './employee'
import stop from './stop'
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
export const welcome = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

welcome.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
welcome.url = (options?: RouteQueryOptions) => {
    return welcome.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
welcome.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
welcome.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: welcome.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
const welcomeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: welcome.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
welcomeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: welcome.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
welcomeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: welcome.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

welcome.form = welcomeForm

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:21
* @route '/login'
*/
loginForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

login.form = loginForm

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dashboard.form = dashboardForm

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:50
* @route '/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:50
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:50
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:50
* @route '/logout'
*/
const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Tenant/Auth/AuthenticatedSessionController.php:50
* @route '/logout'
*/
logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

logout.form = logoutForm

const dealerNamespace = {
    welcome: Object.assign(welcome, welcome),
    login: Object.assign(login, login),
    password: Object.assign(password, password),
    dashboard: Object.assign(dashboard, dashboard),
    store: Object.assign(store, store),
    legacyStores: Object.assign(legacyStores, legacyStores),
    employees: Object.assign(employees, employees),
    sds: Object.assign(sds, sds),
    courses: Object.assign(courses, courses),
    vendor: Object.assign(vendor, vendor),
    vendors: Object.assign(vendors, vendors),
    dealer: Object.assign(dealer, dealer),
    profile: Object.assign(profile, profile),
    userPassword: Object.assign(userPassword, userPassword),
    appearance: Object.assign(appearance, appearance),
    notifications: Object.assign(notifications, notifications),
    logout: Object.assign(logout, logout),
    settings: Object.assign(settings, settings),
    audit: Object.assign(audit, audit),
    phishing: Object.assign(phishing, phishing),
    ridgeback: Object.assign(ridgeback, ridgeback),
    locations: Object.assign(locations, locations),
    logs: Object.assign(logs, logs),
    manual: Object.assign(manual, manual),
    scan: Object.assign(scan, scan),
    doc: Object.assign(doc, doc),
    fitTests: Object.assign(fitTests, fitTests),
    impersonate: Object.assign(impersonate, impersonate),
    employee: Object.assign(employee, employee),
    stop: Object.assign(stop, stop),
}

export default dealerNamespace