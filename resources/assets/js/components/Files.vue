<template>
  <div class="col">
    <div v-if="!hasNeither()" class="row text-left pl-4">
      <h3 class="mr-2">{{ getCurrentTitle() }}</h3>
      <fa icon="edit" @click="showModal" class="text-secondary m-2" size="lg" v-b-tooltip.hover title="Edit"/>
      <fa icon="trash" @click="deleteCurrent" class="text-secondary m-2" size="lg" v-b-tooltip.hover title="Delete"/>
    </div>
    <div class="row">
      <div class="col" v-if="hasNeither() || hasCurrentCategory()">
        <div class="row pl-3">
          <file v-for="file in this.files" :key="file.id" v-if="showFile(file)" :file="file"/>
        </div>
      </div>
      <playlist v-else-if="hasCurrentPlaylist()"/>
      <FileModal/>
      <EditTitleModal :type="currentType()"/>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import File from '~/components/File'
import Playlist from '~/components/Playlist'
import FileModal from '~/components/FileModal'
import EditTitleModal from '~/components/EditTitleModal'
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',

  components: {
    File,
    Playlist,
    FileModal,
    EditTitleModal
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

    hasNeither () {
      return !this.hasCurrentCategory() && !this.hasCurrentPlaylist()
    },

    currentType () {
      return this.hasCurrentCategory() ? 'categories' : (this.hasCurrentPlaylist() ? 'playlists' : '')
    },

    showFile (file) {
      let categoryMatches = this.hasCurrentCategory() && file.categories.includes(this.currentCategory.id)

      return (this.hasNeither()) || (categoryMatches)
    },

    getCurrentTitle () {
      return (this.hasCurrentCategory() ? this.currentCategory.name : (this.hasCurrentPlaylist() ? this.currentPlaylist.name : ''))
    },

    showModal () {
      this.$root.$emit('bv::show::modal', 'edit-title-modal')
    },

    deleteCurrent () {
      this.$store.dispatch(this.currentType() + '/delete', this.currentType() === 'categories' ? this.currentCategory : this.currentPlaylist)
      this.$router.push('/')
    }
  }
}
</script>
