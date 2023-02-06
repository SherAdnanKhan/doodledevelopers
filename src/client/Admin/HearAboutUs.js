import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get where did you hear about us
   */
  getHEarAboutUs() {
    return AxiosService.get(`${basePath}/hear-about-us-platforms`)
  },
  delHearAboutUs(platformId) {
    return AxiosService.delete(`${basePath}/hear-about-us-platforms/${platformId}`)
  },
  addHearAboutUs(payload) {
    return AxiosService.post(`${basePath}/hear-about-us-platforms`, payload)
  },
  editHearAboutUs(payload) {
    return AxiosService.put(`${basePath}/hear-about-us-platforms/${payload.id}`, payload)
  },
}
