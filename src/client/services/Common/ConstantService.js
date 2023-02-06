import AxiosService from '@/services/AxiosService'

const basePath = ''

export default {
  /**
   * Method to get all constants
   */
  getConstants() {
    return AxiosService.get(`${basePath}/constants`)
  },
}
