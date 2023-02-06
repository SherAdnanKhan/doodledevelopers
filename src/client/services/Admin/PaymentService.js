import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get all Deposits of Users
   */

  getDeposits() {
    return AxiosService.get(
      `${basePath}/deposits?include=user&status=approved&payment_method=1`
    )
  },
  /**
   * Method to get all Deposits of Users
   */
  getPayouts(gameId) {
    return AxiosService.get(
      `${basePath}/games/${gameId}/payouts?include=wallet,game,user`
    )
  },
  /**
   * Method to get all Deposits of Users
   */
  upadtePayouts(gameId, payoutId, status) {
    return AxiosService.put(
      `${basePath}/games/${gameId}/payouts/${payoutId}?status=${status}&include=`
    )
  },
}
