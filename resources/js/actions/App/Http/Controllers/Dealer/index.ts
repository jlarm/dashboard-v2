import Auth from './Auth'
import Store from './Store'
import UserController from './UserController'
import CourseController from './CourseController'
import CourseResultsController from './CourseResultsController'
import VendorController from './VendorController'
import ProfileController from './ProfileController'
import Audit from './Audit'
import StoreController from './StoreController'
import EmployeeIndexController from './EmployeeIndexController'
import ImpersonationController from './ImpersonationController'

const Dealer = {
    Auth: Object.assign(Auth, Auth),
    Store: Object.assign(Store, Store),
    UserController: Object.assign(UserController, UserController),
    CourseController: Object.assign(CourseController, CourseController),
    CourseResultsController: Object.assign(CourseResultsController, CourseResultsController),
    VendorController: Object.assign(VendorController, VendorController),
    ProfileController: Object.assign(ProfileController, ProfileController),
    Audit: Object.assign(Audit, Audit),
    StoreController: Object.assign(StoreController, StoreController),
    EmployeeIndexController: Object.assign(EmployeeIndexController, EmployeeIndexController),
    ImpersonationController: Object.assign(ImpersonationController, ImpersonationController),
}

export default Dealer