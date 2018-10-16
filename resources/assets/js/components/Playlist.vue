<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(file, index) in files" :key="index">
                <th scope="row">{{ index }}</th>
                <td>{{ file.name }}</td>
                <td>{{ file.type }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    computed: mapGetters({
        files: 'files/files',
        currentPlaylist: 'playlists/currentPlaylist'
    }),

    methods: {
        showFile (file) {
            return file.playlists.includes(this.currentPlaylist.id)
        }
    }
}
</script>