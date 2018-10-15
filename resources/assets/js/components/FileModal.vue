<template>
    <b-modal @hidden="modalHidden()" id="file-modal" size="lg">
        <div slot="modal-header" class="w-100">
            <h5 class="text-info m-0">{{ this.file.name }}</h5>
        </div>
        <div class="container" v-if="objectHasProperties(this.file)">
            <div class="row align-items-center pt-3 pb-3">
                <div class="col">
                    <img v-if="objectHasProperties(this.file.image)" :src="this.file.image.path"/>
                    <fa v-else class="m-4" size="6x" icon="play" :style="{ color: 'lightgrey' }"/>
                    <p><b>Type: </b>{{ this.file.type }}</p>
                </div>
                <div class="col">
                    <div class="container mb-3">
                        <div class="row">
                            <div class="col">
                                <p class="h6">Categories</p>
                            </div>
                            <div class="col">
                                <p class="h6">Playlists</p>
                            </div>
                        </div>
                    </div>

                    <textarea class="form-control mb-3" v-model="this.file.comment" placeholder="Comments" maxlength="255" rows="5" style="resize: none"></textarea>

                    <v-button :type="'info'" class="ml-auto my-auto text-white p-2 w-100">
                        Attach Image <fa icon="image" :style="{ color: 'white' }"/>
                    </v-button>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button-group class="text-white">
                <b-button @click="closeModal()" variant="danger">Cancel</b-button>
                <b-dropdown right variant="danger">
                    <b-dropdown-item>Delete</b-dropdown-item>
                </b-dropdown>
            </b-button-group>

            <b-button-group>
                <b-button class="text-white" variant="success">Save</b-button>
                <b-dropdown toggle-class="text-white" right variant="success">
                    <b-dropdown-item>Download</b-dropdown-item>
                </b-dropdown>
            </b-button-group>
        </div>
    </b-modal>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    computed: mapGetters({
        file: 'files/chosenFile'
    }),

    methods: {
        modalHidden () {
            this.$store.dispatch('files/clearChosenFile')
        },

        objectHasProperties (obj) {
            return Object.keys(obj).length > 0
        },

        closeModal () {
            this.$root.$emit('bv::hide::modal', 'file-modal')
        }
    }
}
</script>