import * as CONST from './mutations/User'
import PaymentService from '@/services/User/PaymentService'
// state
export const state = () => ({
  userCredit: [],
  userPurchaseHistory: [],
  userDeposit: '',
  errorMsg: '',
  getWithdraw: [],
  getPayouts: [],
  createPayout: [],
  getWallet: [],
  getGameWallets: null,
})

// getters
export const getters = {
  allUserCredits: (state) => state.userCredit,
  getUserAllPurchaseHistory: (state) => state.userPurchaseHistory,
  createNewDeposit: (state) => state.userDeposit,
  errorMessage: (state) => state.errorMsg,
  getCurrentUserWithdrawals: (state) => state.getWithdraw,
  getAllUserPayouts: (state) => state.getPayouts,
  createUserPayoutRequest: (state) => state.createPayout,
  getUserWallet: (state) =>
    state.getWallet && state.getWallet.length ? state.getWallet[0].balance : 0,
  getWallet: (state) => state.getWallet[0],
  getGameWallets: (state) => state.getGameWallets,
}

// mutations
export const mutations = {
  // User Credit History Mutations
  [CONST.START_USER_CREDIT]: (state) => {},
  [CONST.FINISH_USER_CREDIT]: (state, payload) => {
    state.userCredit = payload
  },
  [CONST.ERROR_USER_CREDIT]: (state) => {},
  // User Purchase History
  [CONST.START_USER_PURCHASE_HISTORY]: (state) => {},
  [CONST.FINISH_USER_PURCHASE_HISTORY]: (state, payload) => {
    state.userPurchaseHistory = payload
  },
  [CONST.ERROR_USER_PURCHASE_HISTORY]: (state) => {},
  // Create User Deposit
  [CONST.START_CREATE_USER_DEPOSIT]: (state) => {},
  [CONST.FINISH_CREATE_USER_DEPOSIT]: (state, payload) => {
    state.userDeposit = payload
  },
  [CONST.ERROR_CREATE_USER_DEPOSIT]: (state, payload) => {
    state.errorMsg = payload
  },
  // Create User Withdraw
  [CONST.START_CREATE_USER_WITHDRAW]: (state) => {},
  [CONST.FINISH_CREATE_USER_WITHDRAW]: (state) => {},
  [CONST.ERROR_CREATE_USER_WITHDRAW]: (state, payload) => {
    state.errorMsg = payload
  },
  // Get User Withdraw
  [CONST.START_GET_USER_WITHDRAW]: (state) => {},
  [CONST.FINISH_GET_USER_WITHDRAW]: (state, payload) => {
    state.getWithdraw = payload
  },
  [CONST.ERROR_GET_USER_WITHDRAW]: (state) => {},
  // Get User Payouts
  [CONST.START_GET_ALL_PAYOUTS]: (state) => {},
  [CONST.FINISH_GET_ALL_PAYOUTS]: (state, payload) => {
    state.getPayouts = payload
  },
  [CONST.ERROR_GET_ALL_PAYOUTS]: (state) => {},
  // Create User Payout
  [CONST.START_CREATE_USER_PAYOUT]: (state) => {},
  [CONST.FINISH_CREATE_USER_PAYOUT]: (state, payload) => {
    state.getPayouts = payload
  },
  [CONST.ERROR_CREATE_USER_PAYOUT]: (state, payload) => {
    state.errorMsg = payload
  },
  [CONST.FINISH_GET_USER_WALLET]: (state, payload) => {
    state.getWallet = payload
  },
  [CONST.START_GET_USER_WALLET]: (state) => {},
  [CONST.ERROR_GET_USER_WALLET]: (state) => {},

  [CONST.START_GET_GAME_WALLET]: (state) => {},
  [CONST.FINISH_GET_GAME_WALLET]: (state, payload) => {
    state.getGameWallets = payload
  },
  [CONST.ERROR_GET_GAME_WALLET]: (state) => {},
}
// actions
export const actions = {
  getUserWallets({ commit }) {
    commit(CONST.START_GET_USER_WALLET)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getWallet()
          .then((response) => {
            const data = response.data.data.map((wallet) => ({
              id: wallet.id,
              balance: wallet.balance,
            }))
            commit(CONST.FINISH_GET_USER_WALLET, data)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_WALLET, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_WALLET, e)
    }
  },
  getGameWallets({ commit }) {
    commit(CONST.START_GET_GAME_WALLET)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getGameWallets()
          .then((response) => {
            const data = response.data.data
            commit(CONST.FINISH_GET_GAME_WALLET, data)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_GAME_WALLET, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_GAME_WALLET, e)
    }
  },
  getUserCredit({ commit }) {
    commit(CONST.START_USER_CREDIT)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getCredit()
          .then((response) => {
            const data = response.data.data.map((credit) => ({
              amount: credit.converted_amount,
              status: credit.status.name,
              paymentMethod: credit.paymentMethod.name,
              completed_at: credit.completed_at.toLocaleString(),
            }))
            commit(CONST.FINISH_USER_CREDIT, data)
            resolve(data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_CREDIT, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_CREDIT, e)
    }
  },
  // Purchase History
  getUserPurchaseHistory({ commit, getters }) {
    commit(CONST.START_USER_PURCHASE_HISTORY)
    try {
      return new Promise((resolve, reject) => {
        const walletId = getters.getWallet.id
        PaymentService.getPurchaseHistory(walletId)
          .then((response) => {
            console.log(response.data)
            const data = response.data.data.map((purchase) => ({
              id: purchase.id,
              amount: purchase.converted_amount,
              status: purchase.transaction.status.name,
              paymentMethod: purchase.transaction.paymentMethod,
              transactional_type: purchase.transaction.transactional_type,
              transaction_type: purchase.transaction_type,
              wallet_balance: purchase.wallet.balance,
              created_at: purchase.created_at.toLocaleString(),
            }))
            commit(CONST.FINISH_USER_PURCHASE_HISTORY, data)
            resolve(data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_PURCHASE_HISTORY, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_PURCHASE_HISTORY, e)
    }
  },
  // Create User Deposit
  createUserDeposit({ commit }, payload) {
    commit(CONST.START_CREATE_USER_DEPOSIT)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.createDeposit(payload)
          .then((response) => {
            commit(CONST.FINISH_CREATE_USER_DEPOSIT, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_CREATE_USER_DEPOSIT, error.response.data.message)

            reject(error.response.data)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_CREATE_USER_DEPOSIT, e)
    }
  },
  // Create User Withdraw
  createUserWithdraw({ commit }, payload) {
    commit(CONST.START_CREATE_USER_WITHDRAW)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.createWithdraw(payload)
          .then((response) => {
            commit(CONST.FINISH_CREATE_USER_WITHDRAW, response.data.data)
            resolve(response)
          })
          .catch((error) => {
            commit(
              CONST.ERROR_CREATE_USER_WITHDRAW,
              error.response.data.message
            )
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_CREATE_USER_DEPOSIT, e)
    }
  },
  // Get User Withdraw
  getUserWithdrawals({ commit }) {
    commit(CONST.START_GET_USER_WITHDRAW)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getUserWithdraw()
          .then((response) => {
            const data = response.data.data.map((withdraw) => ({
              id: withdraw.id,
              amount: withdraw.converted_amount,
              status: withdraw.status,
              paymentMethod: withdraw.paymentMethod,
              created_at: withdraw.created_at.toLocaleString(),
            }))
            commit(CONST.FINISH_GET_USER_WITHDRAW, data)
            resolve(data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_WITHDRAW, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_WITHDRAW, e)
    }
  },
  // Get All User Payouts
  getUserPayouts({ commit }, payload) {
    commit(CONST.START_GET_ALL_PAYOUTS)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.getPayouts(payload)
          .then((response) => {
            commit(CONST.FINISH_GET_ALL_PAYOUTS, response.data.data)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ALL_PAYOUTS, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ALL_PAYOUTS, e)
    }
  },
  // Get All User Payouts
  createUserPayout({ commit }, payload) {
    commit(CONST.START_CREATE_USER_PAYOUT)
    try {
      return new Promise((resolve, reject) => {
        PaymentService.createPayout(payload)
          .then((response) => {
            commit(CONST.FINISH_CREATE_USER_PAYOUT, response.data.data)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_CREATE_USER_PAYOUT, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_CREATE_USER_PAYOUT, e)
    }
  },
}
