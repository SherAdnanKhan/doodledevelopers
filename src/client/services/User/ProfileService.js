import AxiosService from '@/services/AxiosService'

const basePath = '/users'
export default {
  updateProfile(userId, payload) {
    return AxiosService.put(`${basePath}/${userId}`, payload)
  },
  updatePassword(userId, payload) {
    return AxiosService.put(`${basePath}/${userId}/update-password`, payload)
  },
}
