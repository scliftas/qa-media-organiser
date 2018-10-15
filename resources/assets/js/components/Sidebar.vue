<template>
  <div class="wrapper">
    <div id="sidebar">
        <div class="sidebar-header p-4 text-info">
            <router-link :to="'/'" class="h4">
              {{ appName }}
            </router-link>
        </div>

        <ul class="list-unstyled components">
            <li @click="resetFilters" :class="'sidebar-nav-item p-4 d-flex hvr-grow'">
              <span class="my-auto ml-3">All</span>
            </li>
            <dropdown title="Categories" :items="this.categories" @itemChosen="setCategory" @createNewItem="createNewCategory"/>
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
    resetFilters () {
      this.$store.dispatch('categories/clearCurrentCategory')
    },

    setCategory (category) {
      this.$store.dispatch('categories/setCurrentCategory', category)
    },

    setPlaylist (playlist) {
      console.log(playlist)
    },

    createNewCategory () {
      this.$root.$emit('bv::show::modal', 'category-modal')
    }
  }
}
</script>
