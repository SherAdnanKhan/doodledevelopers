import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get all Users
   */
  getAllUsers() {
    return AxiosService.get(`${basePath}/users`)
  },
  /**
   * Method to disable a user
   * @param {Object} payload
   */
  disableUserAccount(payload) {
    return AxiosService.put(`${basePath}/disable-user-account`, payload)
  },
  updateUser(userId, payload) {
    return AxiosService.put(`${basePath}/users/${userId}`, payload)
  },
  /**
   * Method to get details of a single user
   */
  getUserDetails(userId) {
    return AxiosService.get(
      `${basePath}/users/${userId}?include=deposits,games,wallet,gamewallets,earnings`
    )
  },
}
