/* import axios from 'axios'

// state
export const state = () => ({
  user: null,
  liveGames: null,
  gameSessionId: null,
})

// getters
export const getters = {
  currentUser: (state) => state.user,
  liveGames: (state) => state.liveGames,
  gameSessionId: (state) => state.gameSessionId,
}

// mutations
export const mutations = {
  SET_GAME_SESSION_ID(state, gameSessionId) {
    state.gameSessionId = gameSessionId
  },
  SET_LIVE_GAMES_SUCCESS(state, games) {
    state.games = games
  },
  SET_LIVE_GAMES_FAILURE(state) {
    
  },
}

// actions
export const actions = {
  async getGame({ commit }) {},
  async getLiveGames({ commit }) {
    try {
      const { data } = await axios.post(
        'https://test-api.red6six.com/api/users/games'
      )
      commit('SET_LIVE_GAMES_SUCCESS', data.data)
    } catch (e) {
      commit('SET_LIVE_GAMES_FAILURE')
    }
  },
  async getSessionId({ commit }, game) {
    try {
      const { data } = await axios.post(
        `'https://test-api.red6six.com/api/users/games/${game}/play`
      )
      commit('SET_GAME_SESSION_ID', data.data)
    } catch (e) {
      commit('FETCH_USER_FAILURE')
    }
  },
}
 */
