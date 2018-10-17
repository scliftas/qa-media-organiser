<template>
    <b-modal @hidden="modalHidden()" id="edit-playlists-modal">
        <div slot="modal-header" class="w-100">
            <h5 class="text-info m-0">Edit Title</h5>
        </div>
        <div class="container">
            <input v-model="playlist.name" type="text" class="form-control"/>
        </div>
        <div slot="modal-footer">
            <b-button @click="closeModal()" variant="danger" :class="'text-white'">Cancel</b-button>
            <b-button @click="save()" :class="(this.status.saving ? 'btn-loading ' : '') + 'text-white'" variant="success">Save</b-button>
        </div>
    </b-modal>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    data: () => ({
        playlist: {
            id: '',
            name: ''
        },
        status: {
            saving: false
        }
    }),

    computed: mapGetters({
        currentPlaylist: 'playlists/currentPlaylist'
    }),

    watch: {
        currentPlaylist (playlist) {
            this.playlist = {
                id: playlist.id,
                name: playlist.name
            }
        }
    },

    methods: {
        closeModal () {
            this.$root.$emit('bv::hide::modal', 'edit-playlists-modal')
        },

        async save () {
            this.$set(this.status, 'saving', true)
            await this.$store.dispatch('playlists/update', this.playlist)
            this.$set(this.status, 'saving', false)
            this.closeModal()
        },
    }
}
</script>