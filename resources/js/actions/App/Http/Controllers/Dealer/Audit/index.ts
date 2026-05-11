import IndividualCreateController from './IndividualCreateController'
import IndividualController from './IndividualController'
import SingleIndividualController from './SingleIndividualController'
import IndividualIndexController from './IndividualIndexController'

const Audit = {
    IndividualCreateController: Object.assign(IndividualCreateController, IndividualCreateController),
    IndividualController: Object.assign(IndividualController, IndividualController),
    SingleIndividualController: Object.assign(SingleIndividualController, SingleIndividualController),
    IndividualIndexController: Object.assign(IndividualIndexController, IndividualIndexController),
}

export default Audit