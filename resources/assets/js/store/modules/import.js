import axios from 'axios'

export const actions = {
  async uploadImport ({ commit }, file) {
    const formData = new FormData()

    formData.append('file', file)

    const { data } = await axios.post('/api/import/upload', formData)
  }
}
