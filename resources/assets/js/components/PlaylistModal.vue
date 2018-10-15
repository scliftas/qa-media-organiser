<template>
    <b-modal @hidden="modalHidden()" id="playlist-modal">
        <div slot="modal-header" class="w-100">
            <h5 class="text-info m-0">Create New Playlist</h5>
        </div>
        <div class="container">
            <input v-model="playlist_name" type="text" class="form-control"/>
        </div>
        <div slot="modal-footer">
            <b-button @click="closeModal()" variant="danger" :class="'text-white'">Cancel</b-button>
            <b-button @click="save()" :class="(this.status.saving ? 'btn-loading ' : '') + 'text-white'" variant="success">Create</b-button>
        </div>
    </b-modal>
</template>

<script>
export default {

    data: () => ({
        playlist_name: '',
        status: {
            saving: false
        }
    }),

    methods: {
        modalHidden () {
            this.playlist_name = ''
        },

        closeModal () {
            this.$root.$emit('bv::hide::modal', 'playlist-modal')
        },

        async save () {
            this.$set(this.status, 'saving', true)
            await this.$store.dispatch('playlists/createPlaylist', this.playlist_name)
            this.$set(this.status, 'saving', false)
            this.closeModal()
        },
    }
}
</script>