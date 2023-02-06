import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get all maps
   */
  getAllMaps(id) {
    return AxiosService.get(`${basePath}/maps`)
  },
}
