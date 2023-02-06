import * as CONST from './mutations/User'
import GamesService from '@/services/User/GamesService'
// state
export const state = () => ({
  userGames: [],
  userCurrentGames: [],
  userPlayedGames: [],
  currentGameId: '',
  userCredit: [],
  userGameplay: [],
  userLeaderboard: [],
  earningGames: [],
  userEarningGames: [],
  userId: '',
  gameSession: null,
  gameInvitationLink: null,
  currentEndedGames: [],
  invitationGames: [],
  invitationUserId: '',
})

// getters
export const getters = {
  userAllGames: (state) => state.userGames,
  userInvitationGames: (state) => state.invitationGames,
  userAllPlayedGames: (state) => state.userPlayedGames,
  userAllCurrentGames: (state) => state.userCurrentGames,
  userCurrentGameScore: () => [],
  userCreditHistory: (state) => state.userCredit,
  userGameplayHistory: (state) => state.userGameplay,
  userLeaderboardGames: (state) => state.userLeaderboard,
  getUserId: (state) => state.userId,
  getInvitationUserId: (state) => state.invitationUserId,
  gameSession: (state) => state.gameSession,
  gameInvitationLink: (state) => state.gameInvitationLink,
  getCurrentEndedGames: (state) => state.currentEndedGames,
  userEarningGames: (state) => state.userEarningGames,
  earningGames: (state) => state.earningGames,
}

// mutations
export const mutations = {
  [CONST.GET_USER_GAMES]: (state) => {},
  [CONST.SET_USER_GAMES]: (state, payload) => {
    state.userGames = payload
  },
  [CONST.ERROR_USER_GAMES]: (state) => {},
  // USER Current Games Mutations
  [CONST.GET_USER_CURRENT_GAMES]: (state) => {},
  [CONST.SET_USER_CURRENT_GAMES]: (state, payload) => {
    state.userCurrentGames = payload
  },
  [CONST.ERROR_USER_CURRENT_GAMES]: (state) => {},
  // USER Played Games Mutations
  [CONST.GET_USER_PLAYED_GAMES]: (state) => {},
  [CONST.SET_USER_PLAYED_GAMES]: (state, payload) => {
    state.userPlayedGames = payload
  },
  [CONST.ERROR_USER_PLAYED_GAMES]: (state) => {},
  // User Credit Histpory
  [CONST.START_USER_GAME_CREDIT]: (state) => {},
  [CONST.FINISH_USER_GAME_CREDIT]: (state, payload) => {
    state.userCredit = payload
  },
  [CONST.ERROR_USER_GAME_CREDIT]: (state) => {},
  // User Gameplay History
  [CONST.START_USER_GAMEPLAY_HISTORY]: (state) => {},
  [CONST.FINISH_USER_GAMEPLAY_HISTORY]: (state, payload) => {
    state.userGameplay = payload
  },
  [CONST.ERROR_USER_GAMEPLAY_HISTORY]: (state) => {},
  // User Leaderboard Games
  [CONST.START_USER_LEADERBOARD_GAMES]: (state) => {},
  [CONST.FINISH_USER_LEADERBOARD_GAMES]: (state, payload) => {
    state.userLeaderboard = payload
  },
  [CONST.ERROR_USER_LEADERBOARD_GAMES]: (state) => {},
  // User Id
  [CONST.START_GET_USER_ID]: (state) => {},
  [CONST.FINISH_GET_USER_ID]: (state, payload) => {
    state.userId = payload
  },
  [CONST.ERROR_GET_USER_ID]: (state) => {},
  // User GAME PLAY
  [CONST.SET_USER_GAME_DATA]: (state, payload) => {
    state.gameSession = payload
  },
  // User Game Invitation Link
  [CONST.START_USER_GAME_INVITATION_LINK]: (state) => {},
  [CONST.FINISH_USER_GAME_INVITATION_LINK]: (state, payload) => {
    state.gameInvitationLink = payload
  },
  [CONST.ERROR_USER_GAME_INVITATION_LINK]: (state) => {},
  // Ended Games
  [CONST.START_ENDED_GAMES]: (state) => {},
  [CONST.FINISH_ENDED_GAMES]: (state, payload) => {
    state.currentEndedGames = payload
  },
  [CONST.ERROR_ENDED_GAMES]: (state) => {},
  // Invitation Games
  [CONST.START_GET_INVITATION_GAMES]: (state) => {},
  [CONST.FINISH_GET_INVITATION_GAMES]: (state, payload) => {
    state.invitationGames = payload
  },
  [CONST.ERROR_GET_INVITATION_GAMES]: (state) => {},
  // Invitation User Id
  [CONST.START_GET_INVITATION_USER_ID]: (state) => {},
  [CONST.FINISH_GET_INVITATION_USER_ID]: (state, payload) => {
    state.invitationUserId = payload
  },
  [CONST.ERROR_GET_INVITATION_USER_ID]: (state) => {},
  // Earning Games
  [CONST.START_EARNING_GAMES]: (state) => {},
  [CONST.FINISH_EARNING_GAMES]: (state, payload) => {
    state.earningGames = payload
  },
  [CONST.ERROR_EARNING_GAMES]: (state) => {},
  // User Earning Games
  [CONST.START_USER_EARNING_GAMES]: (state) => {},
  [CONST.FINISH_USER_EARNING_GAMES]: (state, payload) => {
    state.userEarningGames = payload
  },
  [CONST.ERROR_USER_EARNING_GAMES]: (state) => {},
}

// actions
export const actions = {
  getUserGames({ commit, rootGetters }) {
    commit(CONST.GET_USER_GAMES)
    commit(CONST.START_GET_USER_ID)
    try {
      return new Promise((resolve, reject) => {
        if (
          rootGetters['auth/currentUser'] &&
          rootGetters['auth/currentUser'].id
        ) {
          const userId = rootGetters['auth/currentUser'].id
          GamesService.getAllGames()
            .then((response) => {
              const data = response.data.data.map((game) => ({
                id: game.id,
                name: game.name,
                status: game.status,
                entry_fee: game.entry_fee,
                jackpot_value: game.jackpot_value.toLocaleString(),
                end_date: game.end_date.toLocaleString(),
                days_remaining: game.days_remaining,
                total_attempts: game.total_attempts,
                start_date: game.start_date.toLocaleString(),
                map: game.map,
              }))
              commit(CONST.SET_USER_GAMES, data)
              commit(CONST.FINISH_GET_USER_ID, userId)
              resolve(response.data.data)
            })
            .catch((error) => {
              commit(CONST.ERROR_USER_GAMES, error)
              commit(CONST.ERROR_GET_USER_ID, error)
              reject(error)
            })
        }
      })
    } catch (e) {
      commit(CONST.ERROR_USER_GAMES, e)
      commit(CONST.ERROR_GET_USER_ID, e)
    }
  },
  // User Current Games Action
  getUserCurrentGames({ commit }) {
    commit(CONST.GET_USER_CURRENT_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getLiveGames()
          .then((response) => {
            const data = response.data.data.map((game) => ({
              id: game.id,
              name: game.name,
              entry_fee: game.entry_fee,
              jackpot_value: game.jackpot_value.toLocaleString(),
              start_date: new Date(game.start_date).toLocaleDateString(),
              end_date: game.end_date.toLocaleString(),
              days_remaining: game.days_remaining,
              total_attempts: game.total_attempts,
              map: game.map,
            }))
            commit(CONST.SET_USER_CURRENT_GAMES, data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_CURRENT_GAMES, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_CURRENT_GAMES, e)
    }
  },
  // Ended Games Action
  getCurrentEndedGames({ commit }) {
    commit(CONST.START_ENDED_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getCurrentEndedGames()
          .then((response) => {
            const data = response.data.data.map((game) => ({
              id: game.id,
              name: game.name,
              entry_fee: game.entry_fee,
              jackpot_value: game.jackpot_value.toLocaleString(),
              start_date: game.start_date.toLocaleString(),
              end_date: game.end_date.toLocaleString(),
              total_attempts: game.total_attempts,
              position_finished: game.position_finished,
              prize_won: game.prize_won,
            }))
            commit(CONST.FINISH_ENDED_GAMES, data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_ENDED_GAMES, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_CURRENT_GAMES, e)
    }
  },
  // User Leaderboard Games Action
  getLeaderboardGames({ commit }) {
    commit(CONST.START_USER_LEADERBOARD_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getLeaderboardGames()
          .then((response) => {
            commit(CONST.FINISH_USER_LEADERBOARD_GAMES, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_LEADERBOARD_GAMES, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_LEADERBOARD_GAMES, e)
    }
  },
  // User Invitation Games Action
  getInvitationGames({ commit, rootGetters }) {
    commit(CONST.START_GET_INVITATION_GAMES)
    commit(CONST.START_GET_INVITATION_USER_ID)
    try {
      return new Promise((resolve, reject) => {
        if (rootGetters['auth/currentUser'] && rootGetters['auth/currentUser'].id) {
          const userId = rootGetters['auth/currentUser'].id
          GamesService.getInvitationGames()
            .then((response) => {
              commit(CONST.FINISH_GET_INVITATION_GAMES, response.data.data)
              commit(CONST.FINISH_GET_INVITATION_USER_ID, userId)
              resolve(response.data.data)
            })
            .catch((error) => {
              commit(CONST.ERROR_GET_INVITATION_GAMES, error)
              commit(CONST.ERROR_GET_INVITATION_USER_ID, error)
              reject(error)
            })
        }
      })
    } catch (e) {
      commit(CONST.ERROR_GET_INVITATION_GAMES, e)
      commit(CONST.ERROR_GET_INVITATION_USER_ID, e)
    }
  },
  // Earning Games Action
  getEarningGames({ commit }) {
    commit(CONST.START_EARNING_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getEarningsGames()
          .then((response) => {
            commit(CONST.FINISH_EARNING_GAMES, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_EARNING_GAMES, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EARNING_GAMES, e)
    }
  },
  // User Earning Games Action
  getUserEarningGames({ commit }) {
    commit(CONST.START_USER_EARNING_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getUserEarningsGames()
          .then((response) => {
            commit(CONST.FINISH_USER_EARNING_GAMES, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_EARNING_GAMES, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_EARNING_GAMES, e)
    }
  },
  // User Current Games Action
  getUserPlayedGames({ commit }) {
    commit(CONST.GET_USER_PLAYED_GAMES)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getCurrentGames()
          .then((response) => {
            const data = response.data.data.map((game) => ({
              id: game.id,
              name: game.name,
              status: game.status,
              entry_fee: game.entry_fee,
              jackpot_value: game.jackpot_value.toLocaleString(),
              start_date: game.start_date.toLocaleString(),
              end_date: game.end_date.toLocaleString(),
              days_remaining: game.days_remaining,
              total_attempts: game.total_attempts,
              map: game.map,
            }))
            commit(CONST.SET_USER_PLAYED_GAMES, data)
            console.log(response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_PLAYED_GAMES, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_PLAYED_GAMES, e)
    }
  },
  // User Credit History
  getUserCreditHistory({ commit }) {
    commit(CONST.START_USER_GAME_CREDIT)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getCreditHistory()
          .then((response) => {
            commit(CONST.FINISH_USER_GAME_CREDIT, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_GAME_CREDIT, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_GAME_CREDIT, e)
    }
  },
  // Get Game by Id
  playGameById({ commit }, gameId) {
    console.log('playGameById')
    try {
      return new Promise((resolve, reject) => {
        GamesService.playGameById(gameId)
          .then((response) => {
            // Handle returned game data
            console.log(response)
            commit(CONST.SET_USER_GAME_DATA, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_GAME_DATA, error)
            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_GAME_DATA, e)
    }
  },
  // User Gameplay History
  getUserGameplayHistory({ commit }, payload) {
    commit(CONST.START_USER_GAMEPLAY_HISTORY)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getUserGameplay(payload)
          .then((response) => {
            const data = response.data.data.map((details) => ({
              duration: details.duration,
              score: details.score,
              id: details.game.id,
              name: details.game.name,
              status: details.game.status.name,
              entry_fee: details.game.entry_fee,
              end_date: details.game.end_date.toLocaleString(),
              days_remaining: details.game.days_remaining,
              start_date: details.game.start_date.toLocaleString(),
              invitationLink: details.invitationLink,
            }))
            commit(CONST.FINISH_USER_GAMEPLAY_HISTORY, data)
            resolve(data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_GAMEPLAY_HISTORY, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_GAMEPLAY_HISTORY, e)
    }
  },
  getGameInvitationLink({ commit }, payload) {
    commit(CONST.START_USER_GAME_INVITATION_LINK)
    try {
      return new Promise((resolve, reject) => {
        GamesService.getGameInvitationLink(payload)
          .then((response) => {
            const data = response.data.data
            commit(CONST.FINISH_USER_GAME_INVITATION_LINK, data)
            resolve(data)
          })
          .catch((error) => {
            commit(CONST.ERROR_USER_GAME_INVITATION_LINK, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_USER_GAME_INVITATION_LINK, e)
    }
  },
}
