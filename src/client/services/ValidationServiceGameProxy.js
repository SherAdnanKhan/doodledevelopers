/* eslint-disable */
import ValidationService from './ValidationService.js'

// The game is expecting a service that conforms with this api in snake case
// So this proxy acts as a pass-through to the actual validation service
export default class ValidationServiceGameProxy {
  constructor(game_session_id, api_endpoint) {
    this.validationService = ValidationService(game_session_id, api_endpoint)
  }

  load_level_descriptor(level_descriptor_callback) {
    let self = this
    this.validationService.getLevelDescriptor().then((data) => {
      console.log('load_level_descriptor', data)
      level_descriptor_callback(data.game_state)
    })
  }

  shoot_start(firing_dir) {
    console.log('SHOOT START', firing_dir)
    this.validationService.shootStart(firing_dir)
  }

  shoot_end(acceleration_time, time) {
    console.log('SHOOT END', acceleration_time, time)
    this.validationService.shootEnd(acceleration_time, time)
  }

  set_firing_position(firing_pos_x) {
    console.log('SET FIRING POS', firing_pos_x)
    this.validationService.setFiringPosition({ x: firing_pos_x })
  }

  game_started() {
    console.log('STARTED')
    this.validationService.gameStarted()
  }
  
  export_game_state() {
    console.log('STARTED')
    this.validationService.export_game_state()
  }

  validate_score(turn_number, points, time) {
    let score = {
      turn_number: turn_number,
      points: points,
      time: time,
    }
    console.log('VALIDATE', score)
    this.validationService.validateScore({ score: score })
  }
}
