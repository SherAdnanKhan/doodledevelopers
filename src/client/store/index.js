import Cookies from 'js-cookie'
import { cookieFromRequest } from '~/utils'
export const actions = {
  async nuxtServerInit({ commit, dispatch }, { req, store, $axios }) {
    const token = cookieFromRequest(req, 'token')
    if (token) {
      // Set token here for axios
      $axios.setHeader('Authorization', `Bearer ${token}`)
      dispatch('auth/saveToken', token)
      await store.dispatch('auth/fetchUser')
    }

    const locale = cookieFromRequest(req, 'locale')
    if (locale) {
      commit('lang/SET_LOCALE', { locale })
    }
  },

  nuxtClientInit({ commit, dispatch }) {
    const token = Cookies.get('token')
    if (token) {
      dispatch('auth/saveToken', token)
    }

    const locale = Cookies.get('locale')
    if (locale) {
      commit('lang/SET_LOCALE', { locale })
    }
  },
}
