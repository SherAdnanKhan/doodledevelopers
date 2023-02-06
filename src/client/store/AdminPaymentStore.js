import * as CONST from './mutations/Admin'
import PaymentService from '~/services/Admin/PaymentService'
// state
export const state = () => ({
  allDeposits: [],
  allPayouts: [],
})

// getters
export const getters = {
  getAllUserDeposits: (state) => state.allDeposits,
  getAllAdminPayouts: (state) => state.allPayouts,
}

// mutations
export const mutations = {
  [CONST.START_GET_ALL_DEPOSITS]: (state) => {},
  [CONST.FINISH_GET_ALL_DEPOSITS]: (state, payload) => {
    state.allDeposits = payload
  },
  [CONST.ERROR_GET_ALL_DEPOSITS]: (state) => {},
  // Get All Admin Payouts for users
  [CONST.START_GET_ADMIN_PAYOUTS]: (state) => {},
  [CONST.FINISH_GET_ADMIN_PAYOUTS]: (state, payload) => {
    state.allPayouts = payload
  },
  [CONST.ERROR_GET_ADMIN_PAYOUTS]: (state) => {},
  // Update Admin Payout
  [CONST.START_UPDATE_ADMIN_PAYOUTS]: (state) => {},
  [CONST.FINISH_UPDATE_ADMIN_PAYOUTS]: (state) => {},
  [CONST.ERROR_UPDATE_ADMIN_PAYOUTS]: (state) => {},
}

// actions
export const actions = {
  getAllDeposits({ commit }) {
    commit(CONST.START_GET_ALL_DEPOSITS)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getDeposits()
          .then((response) => {
            commit(CONST.FINISH_GET_ALL_DEPOSITS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ALL_DEPOSITS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ALL_DEPOSITS, e)
    }
  },

  getAllPayouts({ commit }, payload) {
    commit(CONST.START_GET_ADMIN_PAYOUTS)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getPayouts(payload)
          .then((response) => {
            commit(CONST.FINISH_GET_ADMIN_PAYOUTS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ADMIN_PAYOUTS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ADMIN_PAYOUTS, e)
    }
  },
  updateAdminPayouts({ commit }, payload) {
    commit(CONST.START_UPDATE_ADMIN_PAYOUTS)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.upadtePayouts(
          payload.gameId,
          payload.payoutId,
          payload.status
        )
          .then((response) => {
            commit(CONST.FINISH_UPDATE_ADMIN_PAYOUTS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_UPDATE_ADMIN_PAYOUTS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_UPDATE_ADMIN_PAYOUTS, e)
    }
  },
}
