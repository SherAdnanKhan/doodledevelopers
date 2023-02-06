import * as CONST from './mutations/Admin'
import ConfigurationService from '@/services/Admin/ConfigurationService'
// state
export const state = () => ({
  allConfigurations: [],
  errorMsg: '',
})

// getters
export const getters = {
  allConfigurations: (state) => state.allConfigurations,
  errorMsg: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  [CONST.GET_ADMIN_CONFIGURATIONS]: (state) => {},
  [CONST.SET_ADMIN_CONFIGURATIONS]: (state, payload) => {
    state.allConfigurations = payload
  },
  [CONST.ERROR_ADMIN_CONFIGURATIONS]: (state, payload) => {
    state.errorMsg = payload
  },

  [CONST.START_EDIT_ADMIN_CONFIGURATIONS]: (state) => {},
  [CONST.FINISH_EDIT_ADMIN_CONFIGURATIONS]: (state, payload) => {
    state.allConfigurations = payload
  },
  [CONST.ERROR_EDIT_ADMIN_CONFIGURATIONS]: (state, payload) => {
    state.errorMsg = payload
  },
}

// actions
export const actions = {
  getAllConfigurations({ commit }) {
    commit(CONST.GET_ADMIN_CONFIGURATIONS)
    try {
      return new Promise((resolve, reject) => {
        ConfigurationService.getAdminConfigurations()
          .then((response) => {
            commit(CONST.SET_ADMIN_CONFIGURATIONS, response.data.data[0])
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(
              CONST.ERROR_ADMIN_CONFIGURATIONS,
              error.response.data.errors.message
            )

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ADMIN_CONFIGURATIONS, e)
    }
  },
  // Edit configuration
  editConfigurations({ commit }, payload) {
    commit(CONST.START_EDIT_ADMIN_CONFIGURATIONS)
    try {
      return new Promise((resolve, reject) => {
        ConfigurationService.editAdminConfigurations(payload)
          .then((response) => {
            commit(CONST.FINISH_EDIT_ADMIN_CONFIGURATIONS)
            resolve(response)
          })
          .catch((error) => {
            commit(
              CONST.ERROR_EDIT_ADMIN_CONFIGURATIONS,
              error.response.data.errors.message
            )
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EDIT_ADMIN_CONFIGURATIONS, e)
    }
  },
}
