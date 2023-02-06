import axios from 'axios'

export default {
  /**
   *  Accepts URL of API that needs to be hit
   *  Returns payload or Error received from API
   * @param {*} urlOfApi
   */
  get(urlOfApi) {
    return new Promise((resolve, reject) => {
      axios
        .get(urlOfApi)
        .then((response) => {
          if (this.isValidResponse(response)) {
            resolve(response)
          } else {
            reject(response)
          }
        })
        .catch((error) => reject(error))
    })
  },
  /**
   *  Accepts two parameters, first one is url of api that needs to be Hit, Second one is Data
   *  Returns payload or Error received from API
   * @param {*} urlOfApi
   * @param {*} payloadToPost
   */
  post(urlOfApi, payloadToPost) {
    return new Promise((resolve, reject) => {
      axios
        .post(urlOfApi, payloadToPost)
        .then((response) => {
          if (this.isValidResponse(response)) {
            resolve(response)
          } else {
            reject(response)
          }
        })
        .catch((error) => reject(error))
    })
  },
  /**
   * Accepts two parameters, first one is url of api that needs to be Hit,
   * Second one is Data to be updated
   * @param {*} urlOfApi
   * @param {*} payloadToPost
   */
  put(urlOfApi, payloadToPost) {
    return new Promise((resolve, reject) => {
      axios
        .put(urlOfApi, payloadToPost)
        .then((response) => {
          if (this.isValidResponse(response)) {
            resolve(response)
          } else {
            reject(response)
          }
        })
        .catch((error) => reject(error))
    })
  },
  /**
   *  Delete method
   * @param {*} urlOfApi
   */
  delete(urlOfApi) {
    return new Promise((resolve, reject) => {
      axios
        .delete(urlOfApi)
        .then((response) => {
          if (this.isValidResponse(response)) {
            resolve(response)
          } else {
            reject(response)
          }
        })
        .catch((error) => reject(error))
    })
  },
  /**
   *  Accepts response of an Api Call
   * @param {*} response
   */
  isValidResponse(response) {
    let validResponse = false
    if (typeof response.data.status !== 'undefined') {
      // check for status
      validResponse = ['success', 'loaded', 'ok', '1', 'form_errors'].includes(
        response.data.status
      )
    } else if (typeof response.data.error !== 'undefined') {
      // check for error
      validResponse = !response.data.error
    } else {
      validResponse = !!response.data
    }
    return validResponse
  },
}
