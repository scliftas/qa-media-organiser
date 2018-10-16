<template>
    <b-modal @hidden="modalHidden()" id="edit-title-modal">
        <div slot="modal-header" class="w-100">
            <h5 class="text-info m-0">Edit Title</h5>
        </div>
        <div class="container">
            <input v-model="(this.type === 'categories' ? this.currentCategory : this.currentPlaylist).name" type="text" class="form-control"/>
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
        status: {
            saving: false
        }
    }),

    computed: mapGetters({
        currentCategory: 'categories/currentCategory',
        currentPlaylist: 'playlists/currentPlaylist'
    }),

    props: {
        type: {
            type: String,
            default: ''
        }
    },

    methods: {
        modalHidden () {
            this.playlist_name = ''
        },

        closeModal () {
            this.$root.$emit('bv::hide::modal', 'playlist-modal')
        },

        async save () {
            this.$set(this.status, 'saving', true)
            await this.$store.dispatch(this.type + '/update', this.type === 'categories' ? this.currentCategory : this.currentPlaylist)
            this.$set(this.status, 'saving', false)
            this.closeModal()
        },
    }
}
</script>