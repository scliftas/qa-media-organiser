<template>
    <div id="upload" class="text-white bg-success align-bottom p-4 d-flex justify-content-center hvr-icon-up">  
        <input accept="video/*, audio/*" type="file" multiple :name="uploadFieldName" :disabled="isSaving" @change="save($event.target.files); fileCount = $event.target.files.length" class="input-file"> 
        <span class="my-auto h4 mr-3">Upload</span>
        <fa icon="cloud-upload-alt" class="upload-icon hvr-icon"></fa>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data: () => ({
        uploadError: null,
        currentStatus: null,
        uploadFieldName: 'files'
    }),

    computed: {
      isInitial() {
        return this.currentStatus === 'STATUS_INITIAL'
      },
      isSaving() {
        return this.currentStatus === 'STATUS_SAVING'
      },
      isSuccess() {
        return this.currentStatus === 'STATUS_SUCCESS'
      },
      isFailed() {
        return this.currentStatus === 'STATUS_FAILED'
      }
    },

    methods: {
        reset () {
            this.currentStatus = 'STATUS_INITIAL'
            this.uploadError = null
        },
        
        save (files) {
            if (!files.length) return;

            this.currentStatus = 'STATUS_SAVING'

            this.$store.dispatch('files/uploadFiles', files)
            .then(response => {
                this.currentStatus = 'STATUS_SUCCESS'
            }).catch(error => {
                this.uploadError = error.response
                this.currentStatus = 'STATUS_FAILED'
            })
        },
    },

    mounted () {
        this.reset()
    }
}
</script>
