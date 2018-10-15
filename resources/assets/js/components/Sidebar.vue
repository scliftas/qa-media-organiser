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
            <dropdown title="Playlists" :items="this.playlists" @itemChosen="setPlaylist" @createNewItem="createNewPlaylist"/>
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
    categories: 'categories/categories',
    playlists: 'playlists/playlists'
  }),

  mounted () {
    this.$store.dispatch('categories/getCategories')
    this.$store.dispatch('playlists/getPlaylists')
  },

  methods: {
    resetFilters () {
      this.$store.dispatch('categories/clearCurrentCategory')
      this.$store.dispatch('playlists/clearCurrentPlaylist')
    },

    setCategory (category) {
      this.$store.dispatch('categories/setCurrentCategory', category)
    },

    setPlaylist (playlist) {
      this.$store.dispatch('playlists/setCurrentPlaylist', playlist)
    },

    createNewCategory () {
      this.$root.$emit('bv::show::modal', 'category-modal')
    },

    createNewPlaylist () {
      this.$root.$emit('bv::show::modal', 'playlist-modal')
    }
  }
}
</script>
