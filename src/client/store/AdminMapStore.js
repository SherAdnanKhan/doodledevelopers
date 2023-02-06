import * as CONST from './mutations/Admin'
import MapsService from '@/services/Admin/MapsService'
// state
export const state = () => ({
  maps: [],
  errorMessage: '',
})

// getters
export const getters = {
  allMaps: (state) => state.maps,
  getErrorMessage: (state) => state.errorMessage,
}

// mutations
export const mutations = {
  [CONST.GET_ADMIN_MAPS]: (state) => {},
  [CONST.SET_ADMIN_MAPS]: (state, payload) => {
    state.maps = payload
  },
  [CONST.ERROR_ADMIN_MAPS]: (state) => {},
}

// actions
export const actions = {
  getAdminMaps({ commit }) {
    commit(CONST.GET_ADMIN_MAPS)
    try {
      return new Promise((resolve, reject) => {
        MapsService.getAllMaps()
          .then((response) => {
            commit(CONST.SET_ADMIN_MAPS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_ADMIN_MAPS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ADMIN_MAPS, e)
    }
  },
}
