import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  categories: [],
  currentCategory: null
}

export const getters = {
  categories: state => state.categories,
  currentCategory: state => state.currentCategory
}

export const mutations = {
  [types.FETCH_CATEGORIES_SUCCESS] (state, { categories }) {
    state.categories = categories
  },

  [types.FETCH_CATEGORIES_FAILURE] (state) {
    state.categories = []
  },

  [types.CREATE_CATEGORY_SUCCESS] (state, { category }) {
    state.categories.push(category)
  },

  [types.SET_CURRENT_CATEGORY] (state, { category }) {
    state.currentCategory = category
  },

  [types.CLEAR_CURRENT_CATEGORY] (state) {
    state.currentCategory = null
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
  },

  async createCategory ({ commit }, name) {
    const { data } = await axios.post('/api/categories/create', { name: name })

    commit(types.CREATE_CATEGORY_SUCCESS, { category: data })
  },

  setCurrentCategory ({ commit }, category) {
    commit(types.SET_CURRENT_CATEGORY, { category: category })
  },

  clearCurrentCategory ({ commit }) {
    commit(types.CLEAR_CURRENT_CATEGORY)
  }
}
