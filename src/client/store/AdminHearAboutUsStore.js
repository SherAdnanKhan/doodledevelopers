import * as CONST from './mutations/Admin'
import HearAboutUs from '@/services/Admin/HearAboutUs'
// state
export const state = () => ({
  allPlatforms: [],
  delPlatformMSg: '',
  errorMsg: '',
})

// getters
export const getters = {
  allPlatformsHAU: (state) => state.allPlatforms,
  delMsgHAU: (state) => state.delPlatformMSg,
  errorMsgAddHAU: (state) => state.errorMsg,
}

// mutations
export const mutations = {
  [CONST.GET_HAU_PLATFORM_OPTS]: (state) => {},
  [CONST.SET_HAU_PLATFORM_OPTS]: (state, payload) => {
    state.allPlatforms = payload
  },
  [CONST.START_DEL_HAU_PLATFORM]: (state) => {},
  [CONST.FINISH_DEL_HAU_PLATFORM]: (state, payload) => {
    state.delPlatformMSg = payload
  },
  [CONST.ERROR_DEL_HAU_PLATFORM]: (state) => {},

  [CONST.START_ADD_HAU_PLATFORM]: (state) => {},
  [CONST.FINISH_ADD_HAU_PLATFORM]: (state) => {},
  [CONST.ERROR_ADD_HAU_PLATFORM]: (state, payload) => {
    state.errorMsg = payload
  },

  [CONST.START_EDIT_HAU_PLATFORM]: (state) => {},
  [CONST.FINISH_EDIT_HAU_PLATFORM]: (state) => {},
  [CONST.ERROR_EDIT_HAU_PLATFORM]: (state, payload) => {},
}

// actions
export const actions = {
  getAllPlatformsHAU({ commit }) {
    commit(CONST.GET_HAU_PLATFORM_OPTS)
    try {
      return new Promise((resolve, reject) => {
        HearAboutUs.getHEarAboutUs()
          .then((response) => {
            commit(CONST.SET_HAU_PLATFORM_OPTS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_HAU_PLATFORM_OPTS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_HAU_PLATFORM_OPTS, e)
    }
  },
  delPlatformsHAU({ commit }, platformId) {
    commit(CONST.START_DEL_HAU_PLATFORM)
    try {
      return new Promise((resolve, reject) => {
        HearAboutUs.delHearAboutUs(platformId)
          .then((response) => {
            commit(CONST.FINISH_DEL_HAU_PLATFORM, response.message)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_DEL_HAU_PLATFORM, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_DEL_HAU_PLATFORM, e)
    }
  },
  // Add a Platform
  addPlatformsHAU({ commit }, payload) {
    commit(CONST.START_ADD_HAU_PLATFORM)
    try {
      return new Promise((resolve, reject) => {
        HearAboutUs.addHearAboutUs(payload)
          .then((response) => {
            commit(CONST.FINISH_ADD_HAU_PLATFORM)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_ADD_HAU_PLATFORM, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ADD_HAU_PLATFORM, e)
    }
  },
  // Edit a Platform
  editPlatformsHAU({ commit }, payload) {
    commit(CONST.START_EDIT_HAU_PLATFORM)
    try {
      return new Promise((resolve, reject) => {
        HearAboutUs.editHearAboutUs(payload)
          .then((response) => {
            commit(CONST.FINISH_EDIT_HAU_PLATFORM)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_EDIT_HAU_PLATFORM, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EDIT_HAU_PLATFORM, e)
    }
  },
}
