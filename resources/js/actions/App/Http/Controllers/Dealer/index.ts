import Store from './Store'
import UserController from './UserController'
import VendorController from './VendorController'
import Auth from './Auth'
import StoreController from './StoreController'
import ImpersonationController from './ImpersonationController'

const Dealer = {
    Store: Object.assign(Store, Store),
    UserController: Object.assign(UserController, UserController),
    VendorController: Object.assign(VendorController, VendorController),
    Auth: Object.assign(Auth, Auth),
    StoreController: Object.assign(StoreController, StoreController),
    ImpersonationController: Object.assign(ImpersonationController, ImpersonationController),
}

export default Dealer