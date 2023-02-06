import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get all games for a customer
   */
  getAllGames() {
    return AxiosService.get(`${basePath}/games?include=players,map`)
  },
  /**
   * Method to get details of a single game
   */
  getGameDetails(gameId) {
    return AxiosService.get(`${basePath}/games/${gameId}`)
  },
  /**
   * Method to create a game
   */
  createNewGame(payload) {
    return AxiosService.post(`${basePath}/games`, payload)
  },
  /**
   * Method to stop all games
   */
  stopGames() {
    return AxiosService.post(`${basePath}/stop-games`)
  },
  /**
   * Method to edit games
   */
  editGames(id, payload) {
    return AxiosService.put(`${basePath}/games/${id}`, payload)
  },
  /**
   * Method to delete game
   */
  deleteGames(id) {
    return AxiosService.delete(`${basePath}/games/${id}`)
  },
}
