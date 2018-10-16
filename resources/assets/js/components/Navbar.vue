<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarToggler" aria-controls="navbarToggler"
      aria-expanded="false" :aria-label="$t('toggle_navigation')"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggler">
      <input accept="application/json" ref="fileUpload" type="file" style="display: none;" name="import" @change="uploadImport($event.target.files); fileCount = $event.target.files.length">
      <ul class="navbar-nav ml-auto">
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark"
            href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ user.name }}
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a @click.prevent="openUpload()" class="dropdown-item pl-3" href="#">
              <fa icon="upload" fixed-width/>
              Import
            </a>

            <div class="dropdown-divider"></div>
            <a @click.prevent="generateExport()" class="dropdown-item pl-3" href="#">
              <fa icon="download" fixed-width/>
              Export
            </a>

            <div class="dropdown-divider"></div>
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width/>
              {{ $t('settings') }}
            </router-link>

            <div class="dropdown-divider"></div>
            <a @click.prevent="logout" class="dropdown-item pl-3"  href="#">
              <fa icon="sign-out-alt" fixed-width/>
              {{ $t('logout') }}
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },

    openUpload () {
      this.$refs.fileUpload.value = null
      this.$refs.fileUpload.click()
    },

    async uploadImport (files) {
      if (!files.length) return;

      const formData = new FormData()
      formData.append('file', files[0])
      const { data } = await axios.post('/api/import/upload', formData)

      this.$store.dispatch('categories/setCategories', data.categories)
      this.$store.dispatch('playlists/setPlaylists', data.playlists)
      this.$store.dispatch('files/setFiles', data.files)
    },

    async generateExport () {
      axios({
        url: '/api/export/generate',
        method: 'POST',
        responseType: 'blob', // important
      }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'export.json');
        document.body.appendChild(link);
        link.click();
      });
    }
  }
}
</script>
