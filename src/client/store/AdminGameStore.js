import * as CONST from './mutations/Admin'
import GamesService from '@/services/Admin/GamesService'
// state
export const state = () => ({
  adminGames: [],
  gameDetails: {},
  editGames: [],
  errorMessage: '',
})

// getters
export const getters = {
  adminAllGames: (state) => state.adminGames,
  currentGameDetails: (state) => state.gameDetails,
  updateAdminGame: (state) => state.editGames,
  getErrorMessage: (state) => state.errorMessage,
}

// mutations
export const mutations = {
  [CONST.GET_ADMIN_GAMES]: (state) => {},
  [CONST.SET_ADMIN_GAMES]: (state, payload) => {
    state.adminGames = payload
  },
  [CONST.ERROR_ADMIN_GAMES]: (state) => {},

  // User Current Game Score Mutations
  [CONST.START_GAME_DETAILS]: (state) => {},
  [CONST.FINISH_GAME_DETAILS]: (state, payload) => {
    state.gameDetails = payload
  },
  [CONST.ERROR_GAME_DETAILS]: (state) => {},

  // Create Game Mutations
  [CONST.START_CREATE_GAME]: (state) => {},
  [CONST.FINISH_CREATE_GAME]: (state, payload) => {},
  [CONST.ERROR_CREATE_GAME]: (state, payload) => {
    state.errorMessage = payload
  },

  // Stop All Games Mutations
  [CONST.START_STOP_ALL_GAMES]: (state) => {},
  [CONST.FINISH_STOP_ALL_GAMES]: (state, payload) => {},
  [CONST.ERROR_STOP_ALL_GAMES]: (state) => {},
  // Edit Games Mutations
  [CONST.START_EDIT_GAME]: (state) => {},
  [CONST.FINISH_EDIT_GAME]: (state, payload) => {
    state.editGames = payload
  },
  [CONST.ERROR_EDIT_GAME]: (state, payload) => {
    state.errorMessage = payload
  },
  // Delete Games Mutations
  [CONST.START_DELETE_GAME]: (state) => {},
  [CONST.FINISH_DELETE_GAME]: (state) => {},
  [CONST.ERROR_DELETE_GAME]: (state, payload) => {
    state.errorMessage = payload
  },
}

// actions
export const actions = {
  getAdminGames({ commit }) {
    commit(CONST.GET_ADMIN_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getAllGames()
          .then((response) => {
            commit(CONST.SET_ADMIN_GAMES, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_ADMIN_GAMES, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_ADMIN_GAMES, e)
    }
  },
  getGameDetails({ commit }, gameId) {
    // Current Game Score
    commit(CONST.START_GAME_DETAILS)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getGameDetails(gameId)
          .then((response) => {
            commit(CONST.FINISH_GAME_DETAILS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GAME_DETAILS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GAME_DETAILS, e)
    }
  },
  createNewGame({ commit }, payload) {
    // Create Game
    commit(CONST.START_CREATE_GAME)
    try {
      return new Promise((resolve, reject) => {
        GamesService.createNewGame(payload)
          .then((response) => {
            commit(CONST.FINISH_CREATE_GAME, response)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_CREATE_GAME, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_CREATE_GAME, e)
    }
  },
  editAdminGames({ commit }, payload) {
    // Edit Game
    commit(CONST.START_EDIT_GAME)
    try {
      return new Promise((resolve, reject) => {
        GamesService.editGames(payload.gameId, payload.details)
          .then((response) => {
            commit(CONST.FINISH_EDIT_GAME, response)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_EDIT_GAME, error.response.data.message)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EDIT_GAME, e)
    }
  },
  delAdminGames({ commit }, payload) {
    // Delete Game
    commit(CONST.START_DELETE_GAME)
    try {
      return new Promise((resolve, reject) => {
        GamesService.deleteGames(payload)
          .then((response) => {
            commit(CONST.FINISH_DELETE_GAME, response)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_DELETE_GAME, error.response.data.message)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_DELETE_GAME, e)
    }
  },
  stopAllUserGames({ commit }) {
    // Create Game
    commit(CONST.START_STOP_ALL_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.stopGames()
          .then((response) => {
            commit(CONST.FINISH_STOP_ALL_GAMES, response)
            resolve(response)
          })
          .catch((error) => {
            commit(CONST.ERROR_STOP_ALL_GAMES, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_STOP_ALL_GAMES, e)
    }
  },
}
