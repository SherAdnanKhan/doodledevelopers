import * as CONST from './mutations/Admin'
import UsersService from '~/services/Admin/UsersService'
// state
export const state = () => ({
  users: [],
  userDetails: {},
  errorMessage: '',
})

// getters
export const getters = {
  allUsers: (state) => state.users,
  currentUserDetails: (state) => state.userDetails,
  getErrorMessage: (state) => state.errorMessage,
}

// mutations
export const mutations = {
  [CONST.GET_ALL_USERS]: (state) => {},
  [CONST.SET_ALL_USERS]: (state, payload) => {
    state.users = payload
  },
  [CONST.ERROR_ALL_USERS]: (state) => {},

  [CONST.START_DISABLE_USER_ACCOUNT]: (state, payload) => {},
  [CONST.FINISH_DISABLE_USER_ACCOUNT]: (state) => {},
  [CONST.ERROR_DISABLE_USER_ACCOUNT]: (state) => {},

  // User details
  [CONST.START_USER_DETAILS]: (state) => {},
  [CONST.FINISH_USER_DETAILS]: (state, payload) => {
    state.userDetails = payload
  },
  [CONST.ERROR_USER_DETAILS]: (state, payload) => {
    state.errorMessage = payload
  },
}

// actions
export const actions = {
  getAllUsers({ commit }) {
    commit(CONST.GET_ALL_USERS)
    try {
      return new Promise((resolve, reject) => {
        UsersService.getAllUsers()
          .then((response) => {
            commit(CONST.SET_ALL_USERS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_ALL_USERS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ALL_USERS, e)
    }
  },
  updateUserAccount({ commit }, { userId, payload }) {
    commit(CONST.START_DISABLE_USER_ACCOUNT, payload)
    try {
      return new Promise((resolve, reject) => {
        UsersService.updateUser(userId, payload)
          .then((response) => {
            commit(CONST.FINISH_DISABLE_USER_ACCOUNT)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_DISABLE_USER_ACCOUNT, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ALL_USERS, e)
    }
  },
  getUserDetails({ commit }, userId) {
    // Current Game Score
    commit(CONST.START_USER_DETAILS)
    try {
      return new Promise((resolve, reject) => {
        UsersService.getUserDetails(userId)
          .then((response) => {
            commit(CONST.FINISH_USER_DETAILS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_DETAILS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_DETAILS, e)
    }
  },
}
