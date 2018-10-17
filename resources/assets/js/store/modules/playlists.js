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
  },

  [types.DELETE_PLAYLIST_SUCCESS] (state, { id }) {
    const index = state.playlists.findIndex(playlist => playlist.id === id)
    if (index !== -1) state.playlists.splice(index, 1)
  },

  [types.UPDATE_PLAYLIST_SUCCESS] (state, { updatedPlaylist }) {
    const index = state.playlists.findIndex(playlist => playlist.id === updatedPlaylist.id)
    if (index !== -1) {
      state.playlists.splice(index, 1, updatedPlaylist)
      if (updatedPlaylist.id === state.currentPlaylist.id) state.currentPlaylist = updatedPlaylist
    }
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

  setPlaylists ({ commit }, playlists) {
    commit(types.FETCH_PLAYLISTS_SUCCESS, { playlists: playlists })
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
  },

  async update ({ commit }, playlist) {
    const playlistData = {
      id: playlist.id,
      name: playlist.name
    }

    const { data } = await axios.post('/api/playlists/update', playlistData)
    commit(types.UPDATE_PLAYLIST_SUCCESS, { updatedPlaylist: data })
  },

  async delete ({ commit }, playlist) {
    await axios.post('/api/playlists/delete', { id: playlist.id })
    commit(types.CLEAR_CURRENT_PLAYLIST)
    commit(types.DELETE_PLAYLIST_SUCCESS, { id: playlist.id })
  }
}
