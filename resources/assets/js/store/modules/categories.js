import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
  categories: [],
  currentCategoryID: null
}

export const getters = {
  categories: state => state.categories,
  currentCategoryID: state => state.currentCategoryID
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

  [types.SET_CURRENT_CATEGORY] (state, { categoryID }) {
    state.currentCategoryID = categoryID
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

  setCurrentCategory ({ commit }, categoryID) {
    commit(types.SET_CURRENT_CATEGORY, { categoryID: categoryID })
  }
}
