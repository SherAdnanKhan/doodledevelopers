import * as CONST from './mutations/Admin'
import KYCValidationService from '~/services/Admin/KYCValidationService'
// state
export const state = () => ({
  getAllValidations: [],
})

// getters
export const getters = {
  getAllUserKYCValidations: (state) => state.getAllValidations,
}

// mutations
export const mutations = {
  [CONST.START_GET_ALL_KYC_VALIDATIONS]: (state) => {},
  [CONST.FINISH_GET_ALL_KYC_VALIDATIONS]: (state, payload) => {
    state.getAllValidations = payload
  },
  [CONST.ERROR_GET_ALL_KYC_VALIDATIONS]: (state) => {},

  [CONST.START_UPDATE_KYC_VALIDATIONS]: (state) => {},
  [CONST.START_UPDATE_KYC_VALIDATIONS]: (state) => {},
  [CONST.ERROR_UPDATE_KYC_VALIDATIONS]: (state) => {},

  [CONST.START_DELETE_KYC_VALIDATIONS]: (state) => {},
  [CONST.FINISH_DELETE_KYC_VALIDATIONS]: (state) => {},
  [CONST.ERROR_DELETE_KYC_VALIDATIONS]: (state) => {},
}

// actions
export const actions = {
  // Get All KYC Validations
  getAllKYCValidations({ commit }) {
    commit(CONST.START_GET_ALL_KYC_VALIDATIONS)
    try {
      return new Promise((resolve, reject) => {
        KYCValidationService.getAllKYC()
          .then((response) => {
            commit(CONST.FINISH_GET_ALL_KYC_VALIDATIONS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ALL_KYC_VALIDATIONS, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ALL_KYC_VALIDATIONS, e)
    }
  },
  updateKYCValidations({ commit }, payload) {
    commit(CONST.START_UPDATE_KYC_VALIDATIONS)
    try {
      return new Promise((resolve, reject) => {
        KYCValidationService.updateKYC(payload.doc, payload.id)
          .then((response) => {
            commit(CONST.FINISH_UPDATE_KYC_VALIDATIONS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_UPDATE_KYC_VALIDATIONS, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_UPDATE_KYC_VALIDATIONS, e)
    }
  },
  deleteKYCValidations({ commit }, payload) {
    commit(CONST.START_DELETE_KYC_VALIDATIONS)
    try {
      return new Promise((resolve, reject) => {
        KYCValidationService.daleteKYC(payload)
          .then((response) => {
            commit(CONST.FINISH_DELETE_KYC_VALIDATIONS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_DELETE_KYC_VALIDATIONS, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_DELETE_KYC_VALIDATIONS, e)
    }
  },
}
