<template>
  <div>
    <h3 v-if="hasCurrentCategory() || hasCurrentPlaylist()">{{ getCurrentTitle() }}</h3>
    <div class="row pl-3">
      <file v-for="file in this.files" :key="file.id" v-if="showFile(file)" :file="file"/>
      <FileModal/>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import File from '~/components/File'
import FileModal from '~/components/FileModal'
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',

  components: {
    File,
    FileModal
  },

  computed: mapGetters({
    files: 'files/files',
    currentCategory: 'categories/currentCategory',
    currentPlaylist: 'playlists/currentPlaylist'
  }),

  mounted: async function () {
    await this.$store.dispatch('files/getFiles', this.$router.currentRoute.params.type_id || false)
  },

  methods: {
    hasCurrentCategory () {
      return this.currentCategory !== null
    },

    hasCurrentPlaylist () {
      return this.currentPlaylist !== null
    },

    showFile (file) {
      let hasNeither = !this.hasCurrentCategory() && !this.hasCurrentPlaylist()
      let categoryMatches = this.hasCurrentCategory() && file.categories.includes(this.currentCategory.id)
      let playlistMatches = this.hasCurrentPlaylist() && file.playlists.includes(this.currentPlaylist.id)

      return (hasNeither) || (categoryMatches || playlistMatches)
    },

    getCurrentTitle () {
      return (this.hasCurrentCategory() ? this.currentCategory.name : (this.hasCurrentPlaylist() ? this.currentPlaylist.name : ''))
    }
  }
}
</script>
