<template>
    <div class="w-100 p-3">
        <b-table :fields="fields" :items="getFiles()" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :hover="true" class="text-left">
            <template slot="actions" slot-scope="data">
                <fa icon="arrow-up" class="text-success m-1" v-if="data.index > 0" v-b-tooltip.hover title="Move Up"></fa>
                <fa icon="arrow-down" class="text-success m-1" v-b-tooltip.hover title="Move Down" @click="moveDown(data.item)"></fa>
                <fa icon="edit" class="text-success m-1" v-b-tooltip.hover title="Edit" @click="showModal(data.item)"></fa>
            </template>
        </b-table>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    data: () => ({
        fields: [
            { key: 'position', sortable: true, sortDirection: 'last' },
            { key: 'name' },
            { key: 'type' },
            { key: 'actions' }
        ],
        sortDesc: false,
        sortBy: 'position'
    }),

    computed: mapGetters({
        files: 'files/files',
        currentPlaylist: 'playlists/currentPlaylist'
    }),

    methods: {
        showFile (file) {
            return Object.keys(file.playlists).map(Number).includes(this.currentPlaylist.id)
        },

        getPosition (file) {
            return file.playlists[this.currentPlaylist.id][0].pivot.position
        },

        getFiles () {
            let files = []

            for (let file of this.files) {
                if (this.showFile(file)) {
                    file.position = file.playlists[this.currentPlaylist.id][0].pivot.position
                    files.push(file)
                }
            }

            return files
        },

        async showModal (file) {
            await this.$store.dispatch('files/setChosenFile', file)
            this.$root.$emit('bv::show::modal', 'file-modal')
        },

        async moveDown (file) {
            let data = {
                file: file,
                playlist: this.currentPlaylist
            }
            await this.$store.dispatch('files/moveFileDown', data)
        }
    }
}
</script>