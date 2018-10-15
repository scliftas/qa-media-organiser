<template>
  <div>
    <files/>
    <category-modal/>
  </div>
</template>

<script>
import axios from 'axios'
import Files from '~/components/Files'
import CategoryModal from '~/components/CategoryModal'

export default {
  middleware: 'auth',

  components: {
    Files,
    CategoryModal
  },

  metaInfo () {
    return { title: this.$t('Files') }
  },
}
</script>
