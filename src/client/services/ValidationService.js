/* eslint-disable */
import axios from 'axios'

export default function (gameSessionId, apiUrl) {
  return {
    /**
     *  Retrieves game state from validation server,
     *  this ensures that both the validation server and the client
     *  are working on the same data.
     *  Returns game sate
     */
    getLevelDescriptor() {
      return new Promise((resolve, reject) => {
        axios
          .get(`${apiUrl}/game_session/${gameSessionId}`)
          .then((response) => {
            console.log('getLevelDescriptor', response)
            if (this.isValidResponse(response)) {
              resolve(response.data)
            } else {
              reject(response)
            }
          })
          .catch((error) => reject(error))
      })
    },
    /**
     *  Retrieves game state from validation server,
     *  this ensures that both the validation server and the client
     *  are working on the same data.
     *  Returns game sate
     */
     saveGameState() {
      return new Promise((resolve, reject) => {
        axios
          .get(`${apiUrl}/game/${gameSessionId}/save_state`)
          .then((response) => {
            console.log('saveGameState', response)
            if (this.isValidResponse(response)) {
              resolve(response.data)
            } else {
              reject(response)
            }
          })
          .catch((error) => reject(error))
      })
    },
    /**
     *  Triggers gameStarted
     *  Accepts SessionId of player that is starting a game
     *  Returns __________
     * @param {*} SessionId
     */
    gameStarted() {
      return new Promise((resolve, reject) => {
        console.log('gameStarted')
        axios
          .post(`${apiUrl}/game/${gameSessionId}/start`)
          .then((response) => {
            console.log(response)
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
     *  Triggers validateScore
     *  Accepts SessionId of player that is starting a game
     *  Returns __________
     * @params {*} SessionId, score
     */
    validateScore(score) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${apiUrl}/game/${gameSessionId}/validate_score`, score)
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
     *  Triggered at the start of a shot
     *  Returns __________
     * @params {*} SessionId turnNumber score
     */
    shootStart(firingDir) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${apiUrl}/game/${gameSessionId}/shoot_start`, {
            firing_dir: firingDir,
          })
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
     *  Triggers at the end of a shot
     *  Returns __________
     * @params {*} SessionId turnNumber score
     */
    shootEnd(acceleration_time, time) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${apiUrl}/game/${gameSessionId}/shoot_end`, {
            acceleration_time: acceleration_time,
            time: time,
          })
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
     *  Sets firing position before shooting.
     *  Returns __________
     * @params {*} SessionId turnNumber
     */
    setFiringPosition(firingPosition) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${apiUrl}/game/${gameSessionId}/set_firing_position`, {
            firing_pos: firingPosition,
          })
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
        validResponse = [
          'success',
          'loaded',
          'ok',
          '1',
          'form_errors',
        ].includes(response.data.status)
      } else if (typeof response.data.error !== 'undefined') {
        // check for error
        validResponse = !response.data.error
      } else {
        validResponse = !!response.data
      }
      return validResponse
    },
  }
}
