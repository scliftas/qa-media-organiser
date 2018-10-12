import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  files: [],
  chosenFile: {},
  typeId: '0'
}

// getters
export const getters = {
  files: state => state.files,
  chosenFile: state => state.chosenFile,
  typeId: state => state.typeId
}

export const mutations = {
  [types.FETCH_FILES_SUCCESS] (state, { files }) {
    state.files = files
  },

  [types.FETCH_FILES_FAILURE] (state) {
    state.files = []
  },

  [types.UPLOAD_FILES_SUCCESS] (state, { files }) {
    for (var file of files) {
      if (file.type_id === state.typeId || state.typeId === '0') state.files.push(file)
    }
  },

  [types.DELETE_FILE_SUCCESS] (state, { id }) {
    let i = 0

    for (var file of state.files) {
      if (file.id === id && file.type_id === state.typeId) state.files.splice(i, 1)
      i++
    }
  },

  [types.SET_CHOSEN_TYPE] (state, { typeId }) {
    state.typeId = typeId
  },

  [types.LOGOUT] (state) {
    state.files = []
    state.typeId = null
  },

  [types.RESET_FILES] (state) {
    state.files = []
    state.typeId = null
  },

  async [types.SET_CHOSEN_FILE] (state, { chosenFile }) {
    state.chosenFile = chosenFile
  },

  [types.CLEAR_CHOSEN_FILE] (state) {
    state.chosenFile = {}
  }
}

export const actions = {
  async getFiles ({ commit }, typeId = false) {
    try {
      const { data } = await axios.post('/api/files/get', (typeId ? { file_type_id: typeId } : {}))

      commit(types.FETCH_FILES_SUCCESS, { files: data })
      commit(types.SET_CHOSEN_TYPE, { typeId: typeId || '0' })
    } catch (e) {
      commit(types.FETCH_FILES_FAILURE)
    }
  },

  async searchFiles ({ commit }, term) {
    try {
      const { data } = await axios.post('/api/files/search', { search_term: term })

      commit(types.FETCH_FILES_SUCCESS, { files: data })
    } catch (e) {
      commit(types.FETCH_FILES_FAILURE)
    }
  },

  async uploadFiles ({ commit }, files) {
    const formData = new FormData()

    for (var file of files) {
      formData.append('files[]', file)
    }

    try {
      const { data } = await axios.post('/api/files/upload', formData)

      commit(types.UPLOAD_FILES_SUCCESS, { files: data })
    } catch (e) {
      commit(types.UPLOAD_FILES_FAILURE)
    }
  },

  async deleteFile ({ commit }, file) {
    await axios.post('/api/files/delete', { id: file.id })
    commit(types.DELETE_FILE_SUCCESS, { id: file.id })
  },

  clearFiles ({ commit }) {
    commit(types.RESET_FILES)
  },

  async setChosenFile ({ commit }, chosenFile) {
    await commit(types.SET_CHOSEN_FILE, { chosenFile: chosenFile })
  },

  clearChosenFile ({ commit }) {
    commit(types.CLEAR_CHOSEN_FILE)
  }
}

