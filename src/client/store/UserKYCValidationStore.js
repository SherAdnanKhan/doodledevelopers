import * as CONST from './mutations/User'
import KYCService from '~/services/User/KYCValidationService'
// state
export const state = () => ({
  userKYC: [],
  getUserKYC: [],
  userKYCDocument: [],
  getUserKYCDoc: [],
  editUserKYCDoc: [],
  errorMsg: '',
})

// getters
export const getters = {
  userKYCValidation: (state) => state.userKYC,
  getUserKYCValidation: (state) => state.getUserKYC,
  uploadUserKYCDocument: (state) => state.userKYCDocument,
  getUserDocument: (state) => state.getUserKYCDoc,
  editUserKYCDocument: (state) => state.editUserKYCDoc,
  errorMessage: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  [CONST.START_USER_KYC_VALIDATION]: (state) => {},
  [CONST.FINISH_USER_KYC_VALIDATION]: (state, payload) => {
    state.userKYC = payload
  },
  [CONST.ERROR_USER_KYC_VALIDATION]: (state) => {},

  [CONST.START_GET_USER_KYC_VALIDATION]: (state) => {},
  [CONST.FINISH_GET_USER_KYC_VALIDATION]: (state, payload) => {
    state.getUserKYC = payload
  },
  [CONST.ERROR_GET_USER_KYC_VALIDATION]: (state) => {},
  // Mutations for Document Upload
  [CONST.START_USER_KYC_DOCUMENT]: (state) => {},
  [CONST.FINISH_USER_KYC_DOCUMENT]: (state, payload) => {
    state.userKYCDocument = payload
  },
  [CONST.ERROR_USER_KYC_DOCUMENT]: (state, payload) => {
    state.errorMsg = payload
  },
  // Mutations to get KYC Document
  [CONST.START_GET_USER_KYC_DOCUMENT]: (state) => {},
  [CONST.FINISH_GET_USER_KYC_DOCUMENT]: (state, payload) => {
    state.getUserKYCDoc = payload
  },
  [CONST.ERROR_GET_USER_KYC_DOCUMENT]: (state) => {},
  // Mutations to edit KYC Document
  [CONST.START_EDIT_USER_KYC_DOCUMENT]: (state) => {},
  [CONST.FINISH_EDIT_USER_KYC_DOCUMENT]: (state, payload) => {
    state.editUserKYCDoc = payload
  },
  [CONST.ERROR_EDIT_USER_KYC_DOCUMENT]: (state, payload) => {
    state.errorMsg = payload
  },
  // Mutations to delete KYC Document
  [CONST.START_DELETE_USER_KYC_DOCUMENT]: (state) => {},
  [CONST.FINISH_DELETE_USER_KYC_DOCUMENT]: (state) => {
    state.getUserKYCDoc = []
  },
  [CONST.ERROR_DELETE_USER_KYC_DOCUMENT]: (state) => {},
}

// actions
export const actions = {
  createKYCValidation({ commit }) {
    commit(CONST.START_USER_KYC_VALIDATION)
    try {
      return new Promise((resolve, reject) => {
        KYCService.createKYC()
          .then((response) => {
            commit(CONST.FINISH_USER_KYC_VALIDATION, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_KYC_VALIDATION, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_KYC_VALIDATION, e)
    }
  },
  getKYCValidation({ commit }) {
    commit(CONST.START_GET_USER_KYC_VALIDATION)
    try {
      return new Promise((resolve, reject) => {
        KYCService.getKYC()
          .then((response) => {
            commit(CONST.FINISH_GET_USER_KYC_VALIDATION, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_KYC_VALIDATION, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_KYC_VALIDATION, e)
    }
  },
  createKYCDocuemnt({ commit }, payload) {
    commit(CONST.START_USER_KYC_DOCUMENT)
    try {
      return new Promise((resolve, reject) => {
        KYCService.uploadKYCDocument(payload.document, payload.kycId)
          .then((response) => {
            commit(CONST.FINISH_USER_KYC_DOCUMENT, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            if (error.response.status === 413) {
              commit(
                CONST.ERROR_USER_KYC_DOCUMENT,
                'Document size too large. It should be 1MB max.'
              )
            } else if (error.response.status === 422) {
              commit(
                CONST.ERROR_USER_KYC_DOCUMENT,
                error.response.data.errors.errors.file[0]
              )
            } else {
              commit(CONST.ERROR_USER_KYC_DOCUMENT, 'Internal Server Error')
            }
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_KYC_DOCUMENT, e)
    }
  },
  getUserKYCDocuemnt({ commit }, payload) {
    commit(CONST.START_GET_USER_KYC_DOCUMENT)
    try {
      return new Promise((resolve, reject) => {
        KYCService.getKYCDocument(payload.kycId, payload.docId)
          .then((response) => {
            commit(CONST.FINISH_GET_USER_KYC_DOCUMENT, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_KYC_DOCUMENT, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_KYC_DOCUMENT, e)
    }
  },
  editUserKYCDocuemnt({ commit }, payload) {
    commit(CONST.START_EDIT_USER_KYC_DOCUMENT)
    try {
      return new Promise((resolve, reject) => {
        KYCService.editKYCDocument(payload.data, payload.kycId, payload.docId)
          .then((response) => {
            commit(CONST.FINISH_EDIT_USER_KYC_DOCUMENT, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            if (error.response.status === 413) {
              commit(
                CONST.ERROR_EDIT_USER_KYC_DOCUMENT,
                'Document size too large. It should be 1MB max.'
              )
            } else if (error.response.status === 422) {
              commit(
                CONST.ERROR_EDIT_USER_KYC_DOCUMENT,
                error.response.data.errors.errors.file[0]
              )
            } else {
              commit(
                CONST.ERROR_EDIT_USER_KYC_DOCUMENT,
                'Internal Server Error'
              )
            }
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EDIT_USER_KYC_DOCUMENT, e)
    }
  },
  deleteUserKYCDocuemnt({ commit }, payload) {
    commit(CONST.START_DELETE_USER_KYC_DOCUMENT)
    try {
      return new Promise((resolve, reject) => {
        KYCService.deleteKYCDocument(payload.kycId, payload.docId)
          .then((response) => {
            commit(CONST.FINISH_DELETE_USER_KYC_DOCUMENT, response.data.data)
            commit(CONST.FINISH_GET_USER_KYC_DOCUMENT, '')
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_DELETE_USER_KYC_DOCUMENT, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_DELETE_USER_KYC_DOCUMENT, e)
    }
  },
}
