import Vue from 'vue'
import fontawesome from '@fortawesome/fontawesome'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

Vue.component('fa', FontAwesomeIcon)

// import { } from '@fortawesome/fontawesome-free-regular/shakable.es'

import {
  faUser, faLock, faSignOutAlt, faCog, faCloudUploadAlt, faDownload, faTrash, faPlay, faImage, faCaretDown, faCaretUp, faPlus, faArrowUp, faArrowDown, faEdit
} from '@fortawesome/fontawesome-free-solid/shakable.es'

fontawesome.library.add(
  faUser, faLock, faSignOutAlt, faCog, faCloudUploadAlt, faDownload, faTrash, faPlay, faImage, faCaretDown, faCaretUp, faPlus, faArrowUp, faArrowDown, faEdit
)
