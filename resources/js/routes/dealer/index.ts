import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
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
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:20
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
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:20
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:20
* @route '/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::login
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:20
* @route '/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
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
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:46
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
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:46
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Auth\AuthenticatedSessionController::logout
* @see app/Http/Controllers/Dealer/Auth/AuthenticatedSessionController.php:46
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

const dealerNamespace = {
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