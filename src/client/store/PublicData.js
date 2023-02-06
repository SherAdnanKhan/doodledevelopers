import PublicService from '@/services/Common/PublicService'

// state
export const state = () => ({
  liveGames: null,
  gamesWinners: null,
})

// getters
export const getters = {
  liveGames: (state) => state.liveGames,
  gamesWinners: (state) => state.gamesWinners,
}

// mutations
export const mutations = {
  FETCH_LIVE_GAMES_SUCCESS(state, liveGames) {
    state.liveGames = liveGames
  },
  FETCH_LIVE_GAMES_FAILURE(state) {
    state.liveGames = null
  },
  FETCH_GAMES_WINNERS_SUCCESS(state, gamesWinners) {
    state.gamesWinners = gamesWinners
  },
  FETCH_GAMES_WINNERS_FAILURE(state) {
    state.gamesWinners = null
  },
}

// actions
export const actions = {
  fetchLiveGames({ commit }) {
    try {
      return new Promise((resolve, reject) => {
        PublicService.getLiveGames()
          .then((response) => {
            commit('FETCH_LIVE_GAMES_SUCCESS', response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit('FETCH_LIVE_GAMES_FAILURE', error)
            reject(error)
          })
      })
    } catch (e) {
      commit('FETCH_LIVE_GAMES_FAILURE', e)
    }
  },
  fetchGamesWinners({ commit }) {
    try {
      return new Promise((resolve, reject) => {
        PublicService.getGamesWinners()
          .then((response) => {
            commit('FETCH_GAMES_WINNERS_SUCCESS', response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit('FETCH_GAMES_WINNERS_FAILURE', error)
            reject(error)
          })
      })
    } catch (e) {
      commit('FETCH_GAMES_WINNERS_FAILURE', e)
    }
  },
}
