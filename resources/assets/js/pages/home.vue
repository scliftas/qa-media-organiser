<template>
  <files/>
</template>

<script>
import axios from 'axios'
import Files from '~/components/Files'

export default {
  middleware: 'auth',

  components: {
    Files
  },

  metaInfo () {
    return { title: this.$t('Files') }
  },
}
</script>
