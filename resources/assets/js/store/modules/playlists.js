import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  playlists: [],
  currentPlaylist: null
}

export const getters = {
  playlists: state => state.playlists,
  currentPlaylist: state => state.currentPlaylist
}

export const mutations = {
  [types.FETCH_PLAYLISTS_SUCCESS] (state, { playlists }) {
    state.playlists = playlists
  },

  [types.FETCH_PLAYLISTS_FAILURE] (state) {
    state.playlists = []
  },

  [types.CREATE_PLAYLIST_SUCCESS] (state, { playlist }) {
    state.playlists.push(playlist)
  },

  [types.SET_CURRENT_PLAYLIST] (state, { playlist }) {
    state.currentPlaylist = playlist
  },

  [types.CLEAR_CURRENT_PLAYLIST] (state) {
    state.currentPlaylist = null
  }
}

export const actions = {
  async getPlaylists ({ commit }) {
    try {
      const { data } = await axios.post('/api/playlists/get')

      commit(types.FETCH_PLAYLISTS_SUCCESS, { playlists: data })
    } catch (e) {
      commit(types.FETCH_PLAYLISTS_FAILURE)
    }
  },

  async createPlaylist ({ commit }, name) {
    const { data } = await axios.post('/api/playlists/create', { name: name })

    commit(types.CREATE_PLAYLIST_SUCCESS, { playlist: data })
  },

  setCurrentPlaylist ({ commit }, playlist) {
    commit(types.SET_CURRENT_PLAYLIST, { playlist: playlist })
  },

  clearCurrentPlaylist ({ commit }) {
    commit(types.CLEAR_CURRENT_PLAYLIST)
  }
}
