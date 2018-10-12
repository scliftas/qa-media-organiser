<template>
    <div @click="showModal()" class="col-sm-2 hvr-shrink m-3">
        <div :id="'file-' + this.file.id" class="file">
            <img v-if="this.file.image !== {}" :src="this.file.image.path"/>
            <fa v-else class="h-50 w-50 m-5" icon="play" :style="{ color: 'lightgrey' }"/>
            <span class="file-name p-3">{{ this.file.name }}</span>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: {
        file: {
            type: Object
        }
    },

    methods: {
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
                link.setAttribute('download', this.file.name);
                document.body.appendChild(link);
                link.click();
            })
            
            
        },

        async deleteFile () {
            this.$set(this.status, 'deleting', true)
            await this.$store.dispatch('files/deleteFile', this.file);
            this.$set(this.status, 'deleting', false)
        },

        async showModal () {
            await this.$store.dispatch('files/setChosenFile', this.file)
            this.$root.$emit('bv::show::modal', 'file-modal')
        }
    }
}
</script>