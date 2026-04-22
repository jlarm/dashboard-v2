import SwitchStoreController from './SwitchStoreController'
import CreateStoreController from './CreateStoreController'

const Store = {
    SwitchStoreController: Object.assign(SwitchStoreController, SwitchStoreController),
    CreateStoreController: Object.assign(CreateStoreController, CreateStoreController),
}

export default Store