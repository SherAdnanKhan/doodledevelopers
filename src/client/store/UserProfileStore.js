import * as CONST from './mutations/User'
import ProfileService from '@/services/User/ProfileService'
// state
export const state = () => ({
  errorMsg: '',
})

// getters
export const getters = {
  errorMessage: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  [CONST.START_UPDATE_PERSONAL_INFO]: (state) => {},
  [CONST.FINISH_UPDATE_PERSONAL_INFO]: (state, payload) => {},
  [CONST.ERROR_UPDATE_PERSONAL_INFO]: (state, payload) => {
    state.errorMsg = payload
  },
  //  Mutations for User Password Update
  [CONST.START_USER_PASSWORD_UPDATE]: (state) => {},
  [CONST.FINISH_USER_PASSWORD_UPDATE]: (state, payload) => {},
  [CONST.ERROR_USER_PASSWORD_UPDATE]: (state) => {},
}

// actions
export const actions = {
  userProfileUpdate({ commit, rootGetters }, payload) {
    commit(CONST.START_UPDATE_PERSONAL_INFO)
    try {
      return new Promise((resolve, reject) => {
        ProfileService.updateProfile(
          rootGetters['auth/currentUser'].id,
          payload
        )
          .then((response) => {
            const userData = response.data.data
            commit(CONST.FINISH_UPDATE_PERSONAL_INFO, userData)
            commit('auth/FETCH_USER_SUCCESS', userData, {
              root: true,
            })
            resolve(response.data.data)
          })
          .catch((error) => {
            if (error.response.status === 413) {
              commit(
                CONST.ERROR_UPDATE_PERSONAL_INFO,
                'Profile image size too large. It should be 1MB max.'
              )
            } else if (error.response.status === 422) {
              commit(
                CONST.ERROR_UPDATE_PERSONAL_INFO,
                error.response.data.errors.errors
              )
            } else if (error.response.status === 401) {
            } else {
              commit(CONST.ERROR_UPDATE_PERSONAL_INFO, 'Internal Server Error')
            }

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_UPDATE_PERSONAL_INFO, e)
    }
  },
  userPasswordUpdate({ commit, rootGetters }, payload) {
    commit(CONST.START_USER_PASSWORD_UPDATE)
    try {
      return new Promise((resolve, reject) => {
        ProfileService.updatePassword(
          rootGetters['auth/currentUser'].id,
          payload
        )
          .then((response) => {
            const userData = response.data.data
            commit(CONST.FINISH_USER_PASSWORD_UPDATE, userData)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_PASSWORD_UPDATE, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_PASSWORD_UPDATE, e)
    }
  },
}
