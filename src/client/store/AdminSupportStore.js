import * as CONST from './mutations/Admin'
import SupportService from '@/services/Admin/SupportService'
// state
export const state = () => ({
  allSupportTickets: [],
  getTicketDetails: [],
  updateTicketDetails: [],
})

// getters
export const getters = {
  getAllAdminSupportTickets: (state) => state.allSupportTickets,
  getAdminSupportTicketDetails: (state) => state.getTicketDetails,
  updateAdminSupportTicketDetails: (state) => state.updateTicketDetails,
}

// mutations
export const mutations = {
  // Admin all Support Tickets Mutations
  [CONST.START_GET_ADMIN_ALL_TICKETS]: (state) => {},
  [CONST.FINISH_GET_ADMIN_ALL_TICKETS]: (state, payload) => {
    state.allSupportTickets = payload
  },
  [CONST.ERROR_GET_ADMIN_ALL_TICKETS]: (state) => {},
  // Admin Support Ticket Details Mutations
  [CONST.START_GET_ADMIN_TICKET_DETAILS]: (state) => {},
  [CONST.FINISH_GET_ADMIN_TICKET_DETAILS]: (state, payload) => {
    state.getTicketDetails = payload
  },
  [CONST.ERROR_GET_ADMIN_TICKET_DETAILS]: (state) => {},
  // Admin Update Support Ticket Details Mutations
  [CONST.START_UPDATE_ADMIN_TICKET_DETAILS]: (state) => {},
  [CONST.FINISH_UPDATE_ADMIN_TICKET_DETAILS]: (state, payload) => {
    state.updateTicketDetails = payload
  },
  [CONST.ERROR_UPDATE_ADMIN_TICKET_DETAILS]: (state) => {},
}
// actions
export const actions = {
  getAdminSupportTickets({ commit }) {
    commit(CONST.START_GET_ADMIN_ALL_TICKETS)
    try {
      return new Promise((resolve, reject) => {
        SupportService.getAllTickets()
          .then((response) => {
            commit(CONST.FINISH_GET_ADMIN_ALL_TICKETS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ADMIN_ALL_TICKETS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ADMIN_ALL_TICKETS, e)
    }
  },
  getAdminTicketDetails({ commit }, payload) {
    commit(CONST.START_GET_ADMIN_TICKET_DETAILS)
    try {
      return new Promise((resolve, reject) => {
        SupportService.getTicket(payload)
          .then((response) => {
            commit(CONST.FINISH_GET_ADMIN_TICKET_DETAILS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_ADMIN_TICKET_DETAILS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_ADMIN_TICKET_DETAILS, e)
    }
  },
  updateAdminTicketDetails({ commit }, payload) {
    commit(CONST.START_UPDATE_ADMIN_TICKET_DETAILS)
    try {
      return new Promise((resolve, reject) => {
        SupportService.updateTicket(
          payload.ticketId,
          payload.status,
          payload.message
        )
          .then((response) => {
            commit(CONST.FINISH_UPDATE_ADMIN_TICKET_DETAILS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_UPDATE_ADMIN_TICKET_DETAILS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_UPDATE_ADMIN_TICKET_DETAILS, e)
    }
  },
}
