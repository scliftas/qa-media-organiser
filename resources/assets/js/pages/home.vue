<template>
  <div>
    <files/>
    <category-modal/>
    <playlist-modal/>
  </div>
</template>

<script>
import axios from 'axios'
import Files from '~/components/Files'
import CategoryModal from '~/components/CategoryModal'
import PlaylistModal from '~/components/PlaylistModal'

export default {
  middleware: 'auth',

  components: {
    Files,
    CategoryModal,
    PlaylistModal
  },

  metaInfo () {
    return { title: this.$t('Files') }
  },
}
</script>
