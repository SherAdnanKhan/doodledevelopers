import axios from 'axios'
import Cookies from 'js-cookie'
import AuthService from '@/services/Common/AuthService'
import * as CONST from './mutations/User'

// state
export const state = () => ({
  user: null,
  token: null,
  admin: false,
  errorMsg: '',
})

// getters
export const getters = {
  currentUser: (state) => state.user,
  userName: (state) =>
    state.user ? state.user.username : '',
  token: (state) => state.token || Cookies.get('token'), // To handle page refresh conditions
  isAuthenticated: (state) => state.user !== null,
  isAdmin: (state) => state.admin,
  errorMessage: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  SET_TOKEN(state, token) {
    state.token = token
  },

  FETCH_USER_SUCCESS(state, user) {
    state.user = user
  },

  FETCH_USER_FAILURE(state) {
    state.token = null
  },

  LOGOUT(state) {
    state.user = null
    state.token = null
    state.admin = false
  },

  UPDATE_USER(state, { user }) {
    state.user = user
  },
  SET_IS_ADMIN(state, isAdmin) {
    state.admin = isAdmin
  },

  START_REGISTER_USER(state) {},
  FINISH_REGISTER_USER(state) {},
  REGISTER_REGISTER_USER(state) {},

  // Mutations to forget password
  [CONST.START_FORGET_PASSWORD]: (state) => {},
  [CONST.FINISH_FORGET_PASSWORD]: (state, payload) => {},
  [CONST.ERROR_FORGET_PASSWORD]: (state, payload) => {
    state.errorMsg = payload
  },

  // Mutations to forget password validate token
  [CONST.START_VALIDATE_FORGET_PASSWORD_TOKEN]: (state) => {},
  [CONST.FINISH_VALIDATE_FORGET_PASSWORD_TOKEN]: (state, payload) => {},
  [CONST.ERROR_VALIDATE_FORGET_PASSWORD_TOKEN]: (state, payload) => {
    state.errorMsg = payload
  },

  // Mutations to reset password
  [CONST.START_RESET_PASSWORD]: (state) => {},
  [CONST.FINISH_RESET_PASSWORD]: (state, payload) => {},
  [CONST.ERROR_RESET_PASSWORD]: (state, payload) => {
    state.errorMsg = payload
  },
}

// actions
export const actions = {
  saveToken({ commit, dispatch }, { token, remember }) {
    commit('SET_TOKEN', token)

    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  login({ commit, dispatch }, payload) {
    try {
      return new Promise((resolve, reject) => {
        AuthService.login(payload)
          .then((response) => {
            const userData = response.data.data
            dispatch('saveToken', {
              token: userData.access_token,
              remember: payload.remember,
            })
            commit('SET_IS_ADMIN', userData.is_admin)
            resolve(userData)
          })
          .catch((error) => {
            reject(error)
          })
      })
    } catch (error) {}
  },

  register({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        AuthService.register(payload)
          .then((response) => {
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    } catch (error) {}
  },

  async fetchUser({ commit }) {
    try {
      const { data } = await AuthService.fetchUser()
      commit('FETCH_USER_SUCCESS', data.data)
      commit('SET_IS_ADMIN', data.data.is_admin)
    } catch (e) {
      Cookies.remove('token')

      commit('FETCH_USER_FAILURE')
    }
  },

  updateUser({ commit }, payload) {
    commit('UPDATE_USER', payload)
  },

  logout({ commit }) {
    try {
      return new Promise((resolve, reject) => {
        Cookies.remove('token')
        commit('LOGOUT')
        AuthService.logout()
          .then((response) => {
            resolve(response)
          })
          .catch((error) => {
            reject(error)
          })
      })
    } catch (e) {}
  },

  async fetchOauthUrl(ctx, { provider }) {
    const { data } = await axios.post(`/oauth/${provider}`)

    return data.url
  },

  forgetPassword({ commit }, payload) {
    commit(CONST.START_FORGET_PASSWORD)
    try {
      return new Promise((resolve, reject) => {
        AuthService.forgetPassword(payload)
          .then((response) => {
            commit(CONST.FINISH_FORGET_PASSWORD)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_FORGET_PASSWORD)
            reject(error.response.data.errors.errors)
          })
      })
    } catch (error) {
      commit(CONST.ERROR_FORGET_PASSWORD, error.response.data.errors.errors)
    }
  },

  validateForgetPasswordToken({ commit }, payload) {
    commit(CONST.START_VALIDATE_FORGET_PASSWORD_TOKEN)
    try {
      return new Promise((resolve, reject) => {
        AuthService.validateForgetPasswordToken(payload.token)
          .then((response) => {
            commit(CONST.FINISH_VALIDATE_FORGET_PASSWORD_TOKEN)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_VALIDATE_FORGET_PASSWORD_TOKEN)
            reject(error.response.data)
          })
      })
    } catch (error) {
      commit(CONST.ERROR_VALIDATE_FORGET_PASSWORD_TOKEN, error.response.data)
    }
  },

  resetPassword({ commit }, payload) {
    commit(CONST.START_RESET_PASSWORD)
    try {
      return new Promise((resolve, reject) => {
        AuthService.resetPassword(payload)
          .then((response) => {
            commit(CONST.FINISH_RESET_PASSWORD)
            resolve(response)
          })
          .catch((error) => {
            console.log(error.response)
            commit(CONST.ERROR_RESET_PASSWORD)
            reject(error.response.data.errors.errors)
          })
      })
    } catch (error) {
      commit(CONST.ERROR_RESET_PASSWORD, error.response.data.errors.errors)
    }
  },
}
