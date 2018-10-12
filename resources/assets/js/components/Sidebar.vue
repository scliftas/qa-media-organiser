<template>
  <div class="wrapper">
    <div id="sidebar">
        <div class="sidebar-header p-4 text-info">
            <router-link :to="'/'" class="h4">
              {{ appName }}
            </router-link>
        </div>

        <ul class="list-unstyled components">
            <li  :class="'sidebar-nav-item p-4 d-flex hvr-grow'">
              <span class="my-auto ml-3">All</span>
            </li>
        </ul>

        <upload/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Upload from '~/components/upload'
import axios from 'axios'

export default {
  data: () => ({
    appName: window.config.appName,
    nav_items: []
  }),

  components: {
    Upload
  },

  computed: mapGetters({
    user: 'auth/user',
    typeId: 'files/typeId'
  }),

  mounted () {
  },

  methods: {
  }
}
</script>
