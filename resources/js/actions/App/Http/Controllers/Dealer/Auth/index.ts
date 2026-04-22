import ConfirmablePasswordController from './ConfirmablePasswordController'
import PasswordController from './PasswordController'

const Auth = {
    ConfirmablePasswordController: Object.assign(ConfirmablePasswordController, ConfirmablePasswordController),
    PasswordController: Object.assign(PasswordController, PasswordController),
}

export default Auth