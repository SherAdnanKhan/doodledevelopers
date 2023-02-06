import AxiosService from '@/services/AxiosService'

const basePath = '/auth'
export default {
  /**
   *  Accepts User details to register a user
   * @param {*} payload
   */
  register(payload) {
    return AxiosService.post(`${basePath}/register`, payload)
  },
  /**
   *  Accepts credentials of user and post to server
   * @param {*} payload
   */
  login(payload) {
    return AxiosService.post(`${basePath}/login`, payload)
  },
  /**
   *  Used to remove session of user from server
   */
  logout() {
    return AxiosService.get(`${basePath}/logout`)
  },
  /**
   *  Used to remove session of user from server
   */
  fetchUser() {
    return AxiosService.get('/user')
  },
  /**
   *  Initiate Forget password
   */
  forgetPassword(payload) {
    return AxiosService.post(`${basePath}/forget-password`, payload)
  },
  /**
   *  Valid Forget password reset token
   */
  validateForgetPasswordToken(token) {
    return AxiosService.get(`${basePath}/forget-password/${token}`)
  },
  /**
   *  Reset password
   */
  resetPassword(payload) {
    return AxiosService.post(`${basePath}/forget-password/confirm`, payload)
  },
}
