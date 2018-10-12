<template>
    <div class="row pl-3">
        <file v-for="file in this.files" :key="file.name" :file="file"/>
    </div>
</template>

<script>
import axios from 'axios'
import File from '~/components/File'
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',

  components: {
    File
  },

  computed: mapGetters({
    files: 'files/files'
  }),

  mounted: async function () {
    await this.$store.dispatch('files/getFiles', this.$router.currentRoute.params.type_id || false)
  },
}
</script>
