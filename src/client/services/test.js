class GameApi {
  constructor() {
    this.end_point = undefined
    this.session_id = undefined
  }

  set_end_point(end_point) {
    this.end_point = end_point
  }

  set_session_id(session_id) {
    this.session_id = session_id
  }

  load_level_descriptor(level_descriptor_callback) {
    if (!this.config_is_valid()) {
      return
    }

    fetch(this.end_point + '/game_sessions/' + this.session_id)
      .then(function (response) {
        if (response.status !== 200) {
          console.log(
            'Looks like there was a problem with the server. Status Code: ' +
              response.status
          )

          localStorage.removeItem('game_session_id')
          return
        }

        response.json().then(function (data) {
          if (data.game_state) {
            level_descriptor_callback(data.game_state)
          }
        })
      })
      .catch(function (err) {
        console.log('Fetch Error :-S', err)
      })
  }

  /* shoot(firing_dir) {
    const url = this.end_point + '/game/' + this.session_id + '/shoot'
    const headers = {}
    headers['Content-Type'] = 'application/json'

    const body = JSON.stringify({
      firing_dir: { x: firing_dir.x, y: firing_dir.y },
    })

    fetch(url, {
      method: 'POST',
      headers,
      body,
    })
  } */

  config_is_valid() {
    if (this.end_point === undefined) {
      console.error('No api end point set')
      return false
    }
    if (this.session_id === undefined) {
      console.error('No session id set')
      return false
    }
    return true
  }

  /*  game_started() {
    const url = this.end_point + '/game/' + this.session_id + '/start'
    const headers = {}
    headers['Content-Type'] = 'application/json'

    const body = JSON.stringify({})

    fetch(url, {
      method: 'POST',
      headers,
      body,
    })
  } */

  /* validate_score(turn_number, points, time) {
    const url = this.end_point + '/game/' + this.session_id + '/validate_score'
    const headers = {}
    headers['Content-Type'] = 'application/json'

    const body = JSON.stringify({
      score: {
        turn_number,
        points,
        time,
      },
    })

    fetch(url, {
      method: 'POST',
      headers,
      body,
    })
      .then(function (response) {
        if (response.status !== 200) {
          console.log(
            'Looks like there was a problem with the server. Status Code: ' +
              response.status
          )
          return
        }

        response.json().then(function (data) {
          console.log('VALIDATION:', data)
        })
      })
      .catch(function (err) {
        console.log('Fetch Error :-S', err)
      })
  } */
}

export default new GameApi()
