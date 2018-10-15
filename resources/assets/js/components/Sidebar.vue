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
            <dropdown title="Categories" :items="this.categories" @itemChosen="setCategory"/>
            <dropdown title="Playlists" :items="[{ name: 'Test Playlist 1' }]" @itemChosen="setPlaylist"/>
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
    nav_items: []
  }),

  components: {
    Dropdown,
    Upload
  },

  computed: mapGetters({
    user: 'auth/user',
    categories: 'categories/categories'
  }),

  mounted () {
    this.$store.dispatch('categories/getCategories')
  },

  methods: {
    setCategory (category) {
      console.log(category)
    },

    setPlaylist (playlist) {
      console.log(playlist)
    }
  }
}
</script>
