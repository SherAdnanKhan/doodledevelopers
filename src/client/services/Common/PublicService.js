import AxiosService from '@/services/AxiosService'

const basePath = ''
export default {
  /**
   *  Fetches all Live Games
   * @param {*} payload
   */
  getLiveGames() {
    return AxiosService.get(`${basePath}/games`)
  },
  /**
   *  Fetches all Finished Games Winners
   * @param {*} payload
   */
  getGamesWinners() {
    return AxiosService.get(`${basePath}/games-winners?status=finished&include=map,players,historical_earnings,historical_earnings.user,historical_earnings.game_player`)
  },
}
