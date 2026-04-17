import isp from './isp'
import osha from './osha'
import redFlag from './red-flag'
import cms from './cms'

const manual = {
    isp: Object.assign(isp, isp),
    osha: Object.assign(osha, osha),
    redFlag: Object.assign(redFlag, redFlag),
    cms: Object.assign(cms, cms),
}

export default manual