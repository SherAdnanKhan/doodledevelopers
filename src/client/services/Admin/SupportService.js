import AxiosService from '@/services/AxiosService'

const basePath = '/admin/tickets'
export default {
  /**
   * Method to get all support Tickets for Admin
   */
  getAllTickets() {
    return AxiosService.get(`${basePath}`)
  },
  /**
   * Method to get support Tickets for Admin by Id
   */
  getTicket(ticketId) {
    return AxiosService.get(`${basePath}/${ticketId}?include=messages`)
  },
  /**
   * Method to update support Tickets for Admin
   */
  updateTicket(ticketId, status, message) {
    return AxiosService.put(`${basePath}/${ticketId}?status=${status}`, message)
  },
}
