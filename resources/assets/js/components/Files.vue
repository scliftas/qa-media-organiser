<template>
    <div class="row pl-3">
        <file v-for="file in this.files" :key="file.id" v-if="showFile(file)" :file="file"/>
        <FileModal/>
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
    currentCategoryID: 'categories/currentCategoryID'
  }),

  mounted: async function () {
    await this.$store.dispatch('files/getFiles', this.$router.currentRoute.params.type_id || false)
  },

  methods: {
    showFile (file) {
      return (this.currentCategoryID === null || file.categories.includes(this.currentCategoryID))
    }
  }
}
</script>
