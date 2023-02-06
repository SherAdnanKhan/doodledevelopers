import * as CONST from './mutations/User'
import ConstantService from '~/services/Common/ConstantService'

// state
export const state = () => ({
  getConstants: [],
  errorMsg: '',
})

// getters
export const getters = {
  getConstants: (state) => state.getConstants,
  errorMessage: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  [CONST.START_GET_CONSTANTS]: (state) => {},
  [CONST.FINISH_GET_CONSTANTS]: (state, payload) => {
    state.getConstants = payload
  },
  [CONST.ERROR_GET_CONSTANTS]: (state, payload) => {
    state.errorMsg = payload
  },
}

// actions
export const actions = {
  getConstants({ commit }) {
    commit(CONST.START_GET_CONSTANTS)
    try {
      return new Promise((resolve, reject) => {
        ConstantService.getConstants()
          .then((response) => {
            commit(CONST.FINISH_GET_CONSTANTS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_CONSTANTS, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_CONSTANTS, e)
    }
  },
}
