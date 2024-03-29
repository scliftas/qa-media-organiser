<template>
    <b-modal @hidden="modalHidden()" id="file-modal" size="lg">
        <div slot="modal-header" class="w-100">
            <h5 class="text-info m-0">{{ this.file.name }}</h5>
        </div>
        <div class="container" v-if="objectHasProperties(this.file)">
            <div class="row align-items-center pt-3 pb-3">
                <div class="col">
                    <img v-if="this.file.image !== null" class="img-fluid file-modal-image" :src="'data:image/png;base64, ' + this.file.image"/>
                    <fa v-else class="m-4" size="6x" icon="play" :style="{ color: 'lightgrey' }"/>
                    <p><b>Type: </b>{{ this.file.type }}</p>
                </div>
                <div class="col">
                    <div class="container mb-3">
                        <div class="row">
                            <div class="col">
                                <p class="h6">Categories</p>
                                <div v-for="(category, index) in this.categories" :key="index" class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="form.categories" :id="category.id" :value="category.id">
                                    <label class="form-check-label" :for="category.id">{{ category.name }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <p class="h6">Playlists</p>
                                <div v-for="(playlist, index) in this.playlists" :key="index" class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="form.playlists" :id="playlist.id" :value="playlist.id">
                                    <label class="form-check-label" :for="playlist.id">{{ playlist.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <textarea class="form-control mb-3" v-model="form.file.comment" placeholder="Comments" maxlength="255" rows="5" style="resize: none"></textarea>

                    <label class="btn btn-info btn-file w-100 text-white p-2">
                        Attach Image <fa icon="image" :style="{ color: 'white' }"/> <input accept="image/*" type="file" style="display: none;" name="attachImage" :disabled="this.status.saving" @change="attachImage($event.target.files); fileCount = $event.target.files.length">
                    </label>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button-group class="text-white">
                <b-button @click="closeModal()" variant="danger" :class="(this.status.deleting ? 'btn-loading' : '')">Cancel</b-button>
                <b-dropdown right variant="danger">
                    <b-dropdown-item @click="deleteFile()">Delete</b-dropdown-item>
                </b-dropdown>
            </b-button-group>

            <b-button-group>
                <b-button @click="saveFile()" :class="((this.status.saving || this.status.downloading) ? 'btn-loading ' : '') + 'text-white'" variant="success">Save</b-button>
                <b-dropdown toggle-class="text-white" right variant="success">
                    <b-dropdown-item @click="downloadFile()">Download</b-dropdown-item>
                </b-dropdown>
            </b-button-group>
        </div>
    </b-modal>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {

    data: () => ({
        form: {
            file: {
                id: '',
                comment: ''
            },
            image: {},
            categories: [],
            playlists: []
        },
        status: {
            downloading: false,
            deleting: false,
            saving: false
        }
    }),

    computed: mapGetters({
        file: 'files/chosenFile',
        categories: 'categories/categories',
        playlists: 'playlists/playlists'
    }),

    watch: {
        file (file) {
            this.form = {
                file: {
                    id: this.file.id,
                    comment: this.file.comment === null ? '' : this.file.comment
                },
                image: null,
                categories: this.file.categories,
                playlists: Object.keys(this.file.playlists)
            }
        }
    },

    methods: {
        modalHidden () {
            this.$store.dispatch('files/clearChosenFile')
        },

        objectHasProperties (obj) {
            return Object.keys(obj).length > 0
        },

        closeModal () {
            this.$root.$emit('bv::hide::modal', 'file-modal')
        },

        attachImage (files) {
            this.form.image = files[0]
        },

        async saveFile () {
            this.$set(this.status, 'saving', true)
            await this.$store.dispatch('files/updateFile', this.form)
            this.$set(this.status, 'saving', false)
            this.closeModal()
        },

        async downloadFile () {
            this.$set(this.status, 'downloading', true)

            axios({
                url: '/api/files/download',
                method: 'POST',
                data: { id: this.file.id },
                responseType: 'blob',
            })
            .then(response => {
                if (!response.data) {
                    throw new Error('File could not be downloaded');
                }

                this.$set(this.status, 'downloading', false)
                
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', this.file.name + '.' + this.file.type);
                document.body.appendChild(link);
                link.click();
            })
        },

        async deleteFile () {
            this.$set(this.status, 'deleting', true)
            await this.$store.dispatch('files/deleteFile', this.file);
            this.$set(this.status, 'deleting', false)
            this.closeModal()
        },
    }
}
</script>