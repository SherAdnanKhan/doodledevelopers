import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get where did you hear about us
   */
  getAdminConfigurations() {
    return AxiosService.get(`${basePath}/configurations`)
  },
  editAdminConfigurations(payload) {
    return AxiosService.put(`${basePath}/configurations/1`, payload)
  },
}
