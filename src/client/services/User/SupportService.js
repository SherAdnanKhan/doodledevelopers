import AxiosService from '@/services/AxiosService'

const basePath = '/users/tickets'
export default {
  /**
   * Method to get all Support Tickets a user
   */
  getAllTickets() {
    return AxiosService.get(`${basePath}?include=messages`)
  },
  /**
   * Method to get Support Ticket Details for a user
   */
  getTicketDetails(ticketId) {
    return AxiosService.get(`${basePath}/${ticketId}?include=messages`)
  },
  /**
   * Method to send Message from User
   */
  sendMessage(payload) {
    return AxiosService.post(`/users/ticket-message`, payload)
  },
  /**
   * Method to edit User Ticket
   */
  editTicket(ticketID, payload) {
    return AxiosService.put(`${basePath}/${ticketID}?status=${payload}`)
  },
  /**
   * Method to delete User Ticket
   */
  deleteTicket(ticketID) {
    return AxiosService.delete(`${basePath}/${ticketID}`)
  },
  /**
   * Method to create User Ticket
   */
  createTicket(payload) {
    return AxiosService.post(`${basePath}`, payload)
  },
}
