import axios from 'axios'

export default ({ store, route }) => {
  const token = store.getters['auth/token']

  if (process.server) {
    if (token) {
      axios.defaults.headers.common.Authorization = `Bearer ${token}`
    } else {
      delete axios.defaults.headers.common.Authorization
    }
  }
}
