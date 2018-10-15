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
            <dropdown title="Categories" :items="[{ name: 'Test Item 1' }]" @itemChosen="setCategory"/>
        </ul>

        <upload/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Dropdown from '~/components/dropdown'
import Upload from '~/components/upload'
import axios from 'axios'

export default {
  data: () => ({
    appName: window.config.appName,
    nav_items: [],
    categoriesToggled: false
  }),

  components: {
    Dropdown,
    Upload
  },

  computed: mapGetters({
    user: 'auth/user',
    typeId: 'files/typeId'
  }),

  methods: {
    toggleCategories () {
      this.categoriesToggled = !this.categoriesToggled
      console.log(this.categoriesToggled)
    },

    setCategory (category) {
      console.log(category)
    }
  }
}
</script>
