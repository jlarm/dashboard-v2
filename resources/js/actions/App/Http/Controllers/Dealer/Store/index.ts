import CreateFirstStoreController from './CreateFirstStoreController'
import SettingsController from './SettingsController'

const Store = {
    CreateFirstStoreController: Object.assign(CreateFirstStoreController, CreateFirstStoreController),
    SettingsController: Object.assign(SettingsController, SettingsController),
}

export default Store