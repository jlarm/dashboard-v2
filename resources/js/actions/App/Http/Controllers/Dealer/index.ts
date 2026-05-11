import Store from './Store'
import UserController from './UserController'
import CourseController from './CourseController'
import CourseResultsController from './CourseResultsController'
import VendorController from './VendorController'
import Auth from './Auth'
import StoreController from './StoreController'
import ImpersonationController from './ImpersonationController'

const Dealer = {
    Store: Object.assign(Store, Store),
    UserController: Object.assign(UserController, UserController),
    CourseController: Object.assign(CourseController, CourseController),
    CourseResultsController: Object.assign(CourseResultsController, CourseResultsController),
    VendorController: Object.assign(VendorController, VendorController),
    Auth: Object.assign(Auth, Auth),
    StoreController: Object.assign(StoreController, StoreController),
    ImpersonationController: Object.assign(ImpersonationController, ImpersonationController),
}

export default Dealer