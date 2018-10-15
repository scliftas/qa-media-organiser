import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  categories: []
}

export const getters = {
  categories: state => state.categories
}

export const mutations = {
  [types.FETCH_CATEGORIES_SUCCESS] (state, { categories }) {
    state.categories = categories
  },

  [types.FETCH_CATEGORIES_FAILURE] (state) {
    state.categories = []
  }
}

export const actions = {
  async getCategories ({ commit }) {
    try {
      const { data } = await axios.post('/api/categories/get')

      commit(types.FETCH_CATEGORIES_SUCCESS, { categories: data })
    } catch (e) {
      commit(types.FETCH_CATEGORIES_FAILURE)
    }
  }
}
