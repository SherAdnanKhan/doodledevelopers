import AxiosService from '@/services/AxiosService'

const basePath = '/users'
export default {
  /**
   * Method to validate a customer
   */
  createKYC() {
    return AxiosService.post(`${basePath}/kyc-validations`)
  },
  getKYC() {
    return AxiosService.get(`${basePath}/kyc-validations?include=document`)
  },
  uploadKYCDocument(payload, kycId) {
    return AxiosService.post(
      `${basePath}/kyc-validations/${kycId}/documents`,
      payload
    )
  },
  getKYCDocument(kycId, docId) {
    return AxiosService.get(
      `${basePath}/kyc-validations/${kycId}/documents/${docId}`
    )
  },
  editKYCDocument(payload, kycId, docId) {
    return AxiosService.put(
      `${basePath}/kyc-validations/${kycId}/documents/${docId}`,
      payload
    )
  },
  deleteKYCDocument(kycId, docId) {
    return AxiosService.delete(
      `${basePath}/kyc-validations/${kycId}/documents/${docId}`
    )
  },
}
