import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap-vue/dist/bootstrap-vue.css'

import '~/plugins'
import '~/components'

Vue.use(BootstrapVue)

Vue.config.productionTip = false

new Vue({
  i18n,
  store,
  router,
  ...App
})
