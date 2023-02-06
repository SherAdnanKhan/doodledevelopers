import AxiosService from '@/services/AxiosService'

const basePath = '/users/games'
export default {
  /**
   * Method to get all games for a customer
   */
  getAllGames() {
    return AxiosService.get(`${basePath}?include=players,map`)
  },
  getCurrentGames() {
    return AxiosService.get(`${basePath}?player_status=all&include=map`)
  },
  getCreditHistory() {
    return AxiosService.get(`users/game-wallets`)
  },
  getUserGameplay(gameId) {
    return AxiosService.get(`${basePath}/${gameId}/scores`)
  },
  getGameInvitationLink(gameId) {
    return AxiosService.get(`${basePath}/${gameId}/invitation-link`)
  },
  playGameById(gameId) {
    return AxiosService.post(`${basePath}/${gameId}/play`)
  },
  getLiveGames() {
    return AxiosService.get(`${basePath}?status=live&include=map`)
  },
  getCurrentEndedGames() {
    return AxiosService.get(`${basePath}/history`)
  },
  getLeaderboardGames() {
    return AxiosService.get(`${basePath}?status=live&player_status=all&include=players,map`)
  },
  getInvitationGames() {
    return AxiosService.get(`${basePath}?status=live&player_status=all&include=players,map`)
  },
  getEarningsGames() {
    return AxiosService.get(`${basePath}?status=live&include=map,players,earnings,earnings.user`)
  },
  getUserEarningsGames() {
    return AxiosService.get(`${basePath}?status=finished&player_status=all&include=map,players,historical_earnings,historical_earnings.user,historical_earnings.game_player`)
  },
}
