import * as CONST from './mutations/User'
import SupportService from '@/services/User/SupportService'
// state
export const state = () => ({
  allSupportTickets: [],
  supportTicketDetails: [],
  sendMessage: [],
  editTicket: [],
  errorMessage: '',
  createTicket: '',
})

// getters
export const getters = {
  getAllUserSupportTickets: (state) => state.allSupportTickets,
  getUserSupportTicketDetails: (state) => state.supportTicketDetails,
  sendSupportUserMessage: (state) => state.sendMessage,
  editUserTicket: (state) => state.editTicket,
  errorSupportMessage: (state) => state.errorMessage,
  createUserTicket: (state) => state.createTicket,
}

// mutations
export const mutations = {
  // User all Support Tickets Mutations
  [CONST.START_GET_USER_ALL_TICKETS]: (state) => {},
  [CONST.FINISH_GET_USER_ALL_TICKETS]: (state, payload) => {
    state.allSupportTickets = payload
  },
  [CONST.ERROR_GET_USER_ALL_TICKETS]: (state) => {},
  // User Support Ticket Details Mutations
  [CONST.START_GET_USER_TICKET_DETAILS]: (state) => {},
  [CONST.FINISH_GET_USER_TICKET_DETAILS]: (state, payload) => {
    state.supportTicketDetails = payload
  },
  [CONST.ERROR_GET_USER_TICKET_DETAILS]: (state) => {},
  // Send User Message to Support Mutations
  [CONST.START_SEND_USER_SUPPORT_MESSAGE]: (state) => {},
  [CONST.FINISH_SEND_USER_SUPPORT_MESSAGE]: (state, payload) => {
    state.sendMessage = payload
  },
  [CONST.ERROR_SEND_USER_SUPPORT_MESSAGE]: (state) => {},
  // Edit User Ticket Mutations
  [CONST.START_EDIT_USER_TICKET]: (state) => {},
  [CONST.FINISH_EDIT_USER_TICKET]: (state, payload) => {
    state.editTicket = payload
  },
  [CONST.ERROR_EDIT_USER_TICKET]: (state, payload) => {
    state.errorMessage = payload
  },
  // Delete User Ticket Mutations
  [CONST.START_DELETE_USER_TICKET]: (state) => {},
  [CONST.FINISH_DELETE_USER_TICKET]: (state) => {},
  [CONST.ERROR_DELETE_USER_TICKET]: (state, payload) => {
    state.errorMessage = payload
  },
  // Create User Ticket Mutations
  [CONST.START_CREATE_USER_TICKET]: (state) => {},
  [CONST.FINISH_CREATE_USER_TICKET]: (state, payload) => {
    state.createTicket = payload
  },
  [CONST.ERROR_CREATE_USER_TICKET]: (state, payload) => {
    state.errorMessage = payload
  },
}
// actions
export const actions = {
  getUserSupportTickets({ commit }) {
    commit(CONST.START_GET_USER_ALL_TICKETS)
    try {
      return new Promise((resolve, reject) => {
        SupportService.getAllTickets()
          .then((response) => {
            commit(CONST.FINISH_GET_USER_ALL_TICKETS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_ALL_TICKETS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_ALL_TICKETS, e)
    }
  },
  getUserTicketDetails({ commit }, payload) {
    commit(CONST.START_GET_USER_TICKET_DETAILS)
    try {
      return new Promise((resolve, reject) => {
        SupportService.getTicketDetails(payload)
          .then((response) => {
            commit(CONST.FINISH_GET_USER_TICKET_DETAILS, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_GET_USER_TICKET_DETAILS, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_GET_USER_TICKET_DETAILS, e)
    }
  },
  sendSupportMessage({ commit }, payload) {
    commit(CONST.START_SEND_USER_SUPPORT_MESSAGE)
    try {
      return new Promise((resolve, reject) => {
        SupportService.sendMessage(payload)
          .then((response) => {
            commit(CONST.FINISH_SEND_USER_SUPPORT_MESSAGE, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_SEND_USER_SUPPORT_MESSAGE, error)

            reject(error)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_SEND_USER_SUPPORT_MESSAGE, e)
    }
  },
  editUserSupportTicket({ commit }, payload) {
    commit(CONST.START_EDIT_USER_TICKET)
    try {
      return new Promise((resolve, reject) => {
        SupportService.editTicket(payload.id, payload.status)
          .then((response) => {
            commit(CONST.FINISH_EDIT_USER_TICKET, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_EDIT_USER_TICKET, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_EDIT_USER_TICKET, e)
    }
  },
  deleteUserSupportTicket({ commit }, payload) {
    commit(CONST.START_DELETE_USER_TICKET)
    try {
      return new Promise((resolve, reject) => {
        SupportService.deleteTicket(payload)
          .then((response) => {
            commit(CONST.FINISH_DELETE_USER_TICKET, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_DELETE_USER_TICKET, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_DELETE_USER_TICKET, e)
    }
  },
  createUserSupportTicket({ commit }, payload) {
    commit(CONST.START_CREATE_USER_TICKET)
    try {
      return new Promise((resolve, reject) => {
        SupportService.createTicket(payload)
          .then((response) => {
            commit(CONST.FINISH_CREATE_USER_TICKET, response.data.data)
            resolve(response.data.data)
          })
          .catch((error) => {
            commit(CONST.ERROR_CREATE_USER_TICKET, error.response.data.message)
            reject(error.response.data.message)
          })
      })
    } catch (e) {
      commit(CONST.ERROR_CREATE_USER_TICKET, e)
    }
  },
}
