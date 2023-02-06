import AxiosService from '@/services/AxiosService'

const basePath = '/admin'
export default {
  /**
   * Method to get where did you hear about us
   */
  getAllKYC() {
    return AxiosService.get(`${basePath}/kyc-validations?include=document`)
  },
  updateKYC(payload, kycId) {
    return AxiosService.put(`${basePath}/kyc-validations/${kycId}`, payload)
  },
  daleteKYC(kycId) {
    return AxiosService.delete(`${basePath}/kyc-validations/${kycId}`)
  },
}
