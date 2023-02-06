import AxiosService from '@/services/AxiosService'

const basePath = '/users'
export default {
  getCredit() {
    return AxiosService.get(`${basePath}/deposits`)
  },
  getWallet() {
    return AxiosService.get(`${basePath}/wallets`)
  },
  getGameWallets() {
    return AxiosService.get(`${basePath}/game-wallets`)
  },
  getPurchaseHistory(walletId) {
    return AxiosService.get(
      `${basePath}/wallets/${walletId}/transactions?include=transaction`
    )
  },
  createDeposit(payload) {
    return AxiosService.post(`${basePath}/deposits`, payload)
  },
  processDeposit(payload) {
    return AxiosService.post(`${basePath}/deposits/process`, payload)
  },
  createWithdraw(payload) {
    return AxiosService.post(`${basePath}/withdrawals`, payload)
  },
  getUserWithdraw() {
    return AxiosService.get(`${basePath}/withdrawals`)
  },
  getPayouts(gameId) {
    return AxiosService.get(`${basePath}/games/${gameId}/payouts`)
  },
  createPayout(gameId) {
    return AxiosService.post(`${basePath}/games/${gameId}/payouts`)
  },
}
