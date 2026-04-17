import Controllers from './Controllers'
import Livewire from './Livewire'

const Http = {
    Controllers: Object.assign(Controllers, Controllers),
    Livewire: Object.assign(Livewire, Livewire),
}

export default Http