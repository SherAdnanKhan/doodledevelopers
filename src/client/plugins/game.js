import * as _planckJs from 'planck-js'
import {
  Vector2,
  Vector3,
  Ray,
  Quaternion,
  Math as _Math,
  Plane,
  PlaneHelper,
  Sphere,
  Matrix4,
  Box3,
  SphereBufferGeometry,
  MeshBasicMaterial,
  InstancedMesh,
  DynamicDrawUsage,
  PlaneBufferGeometry,
  Mesh,
  Color,
} from 'three'
import {
  Graphics,
  RenderLoop,
  Configuration,
  EventManager,
  Debug,
  Input,
  ResourceContainer,
  ResourceBatch,
  BaseApplication,
  TouchInput,
  CameraManager,
  PerspectiveCamera,
  OrthographicCamera,
  Screen,
  NormalRender,
  SceneManager,
  CameraUtilities,
  MathUtilities,
  ArrayUtilities,
  Time,
  BaseShaderMaterial,
  SDFTextBatch,
} from 'ohzi-core'

function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a
}

class $a47b39a1f68b769584aa5500ce61083b$var$GameApi {
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

  shoot(firing_dir) {
    const url = this.end_point + '/game/' + this.session_id + '/shoot'
    const headers = {}
    headers['Content-Type'] = 'application/json'
    const body = JSON.stringify({
      firing_dir: {
        x: firing_dir.x,
        y: firing_dir.y,
      },
    })
    fetch(url, {
      method: 'POST',
      headers,
      body,
    })
  }

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

  game_started() {
    const url = this.end_point + '/game/' + this.session_id + '/start'
    const headers = {}
    headers['Content-Type'] = 'application/json'
    const body = JSON.stringify({})
    fetch(url, {
      method: 'POST',
      headers,
      body,
    })
  }

  validate_score(turn_number, points, time) {
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
  }
}

const $a47b39a1f68b769584aa5500ce61083b$export$default =
  new $a47b39a1f68b769584aa5500ce61083b$var$GameApi()

class $c3449a2e8f44a086b821dce4a5f0b801$export$default {
  constructor() {}

  on_enter(camera_controller) {}

  on_exit(camera_controller) {}

  update(TIME, camera_controller) {}
}

class $ef2a5e9f4cd262a692c86fe33270bb4$export$default extends $c3449a2e8f44a086b821dce4a5f0b801$export$default {
  constructor(oobb) {
    super()
    this.pan_speed = new Vector2()
    this.zoom_speed = 0
    this.zoom_t = 0
    this.tilt_degrees = 70
    this.tilt_speed = 0
    this.vector_down_axis = new Vector3(0, -1, 0)
    this.vector_up_axis = new Vector3(0, 1, 0)
    this.vector_back_axis = new Vector3(0, 0, -1)
    this.vector_left_axis = new Vector3(-1, 0, 0)
    this.tmp_dir = new Vector3()
    this.tmp_ray = new Ray()
    this.tmp_intersection = new Vector3()
    this.tmp_mouse_dir = new Vector2()
    this.last_point = new Vector3()
    this.last_NDC = new Vector2()
  }

  on_enter(camera_controller) {
    this.t_damping = 0
  }

  on_exit(camera_controller) {}

  update(camera_controller) {
    if (!camera_controller.input_enabled) {
      return
    }

    if (camera_controller.camera.isOrthographicCamera) {
      camera_controller.reference_zoom += Input.wheel_delta * 0.5
    } else {
      camera_controller.reference_zoom += Input.wheel_delta * 0.5
    }

    if (Input.left_mouse_button_pressed || Input.right_mouse_button_pressed) {
      this.last_point.copy(Input.NDC)
      this.last_NDC.copy(Input.NDC)
    }

    if (Input.left_mouse_button_down) {
      const mouse_delta_dir = Input.NDC.clone().sub(this.last_NDC)
      camera_controller.set_rotation_delta(
        mouse_delta_dir.x * -200,
        mouse_delta_dir.y * -200
      )
    }

    if (Input.right_mouse_button_down) {
      const prev_point = CameraUtilities.get_plane_intersection(
        camera_controller.reference_position,
        undefined,
        this.last_point
      ).clone()
      const current_point = CameraUtilities.get_plane_intersection(
        camera_controller.reference_position,
        undefined,
        Input.NDC
      ).clone()
      current_point.sub(prev_point)
      camera_controller.reference_position.x -= current_point.x
      camera_controller.reference_position.y -= current_point.y
      camera_controller.reference_position.z -= current_point.z
      this.last_point.copy(Input.NDC)
    }

    this.last_NDC.copy(Input.NDC)
  }
}

class $e3cc03d83037209b37c43423c6e8302$export$default {
  constructor() {}

  on_enter(camera_controller) {}

  on_exit(camera_controller) {}

  update(TIME, camera_controller) {}
}

class $bd288d7d1dcf423f7b63d9a1d4b266$export$default extends $e3cc03d83037209b37c43423c6e8302$export$default {
  constructor() {
    super()
    this.rotation_speed = new Vector2()
    this.vector_forward_axis = new Vector3(0, 0, -1)
    this.tmp_forward = new Vector3()
    this.tmp_quat = new Quaternion()
    this.tmp_camera_target_pos = new Vector3()
  }

  on_enter(camera_controller) {
    camera_controller.reference_rotation.copy(
      camera_controller.camera.quaternion
    )
  }

  update(camera_controller) {
    camera_controller.camera.quaternion.copy(
      camera_controller.reference_rotation
    )
    this.tmp_forward.copy(this.vector_forward_axis)
    const dir = this.tmp_forward.applyQuaternion(
      camera_controller.camera.quaternion
    )
    camera_controller.reference_zoom = _Math.clamp(
      camera_controller.reference_zoom,
      camera_controller.min_zoom,
      camera_controller.max_zoom
    )
    camera_controller.camera.position
      .copy(camera_controller.reference_position)
      .sub(dir.multiplyScalar(camera_controller.reference_zoom))

    camera_controller.__last_reference_position.copy(
      camera_controller.reference_position
    )
  }

  get_target_camera_pos(camera_controller) {
    this.tmp_quat.copy(camera_controller.reference_rotation)
    this.tmp_forward.copy(this.vector_forward_axis)
    const dir = this.tmp_forward.applyQuaternion(this.tmp_quat)

    const zoom = _Math.clamp(
      camera_controller.reference_zoom,
      camera_controller.min_zoom,
      camera_controller.max_zoom
    )

    this.tmp_camera_target_pos
      .copy(camera_controller.reference_position)
      .sub(dir.multiplyScalar(zoom))
    return this.tmp_camera_target_pos
  }
}

class $b962cf860b6cd5fd3e553d7e21122ee7$export$default {
  constructor() {
    this.camera = undefined
    this.camera_initial_rot = undefined
    this.camera_initial_pos = undefined
    this.current_state = new $c3449a2e8f44a086b821dce4a5f0b801$export$default()
    this.current_mode = new $bd288d7d1dcf423f7b63d9a1d4b266$export$default()
    this.point_of_interest = new Vector3()
    this.normalized_zoom = 0
    this.vector_up_axis = new Vector3(0, 1, 0)
    this.vector_right_axis = new Vector3(1, 0, 0)
    this.vector_forward_axis = new Vector3(0, 0, 1)
    this.tmp_forward = this.vector_forward_axis.clone()
    this.tmp_right = this.vector_right_axis.clone()
    this.tmp_dir = new Vector3()
    this.zoom = 10
    this.reference_zoom = 10
    this.orientation = 27 // degrees

    this.tilt = 70
    this.reference_rotation = new Quaternion()
    this.reference_position = new Vector3()
    this.__last_reference_position = new Vector3()
    this.tmp_size = new Vector3()
    this.tmp_quat = new Quaternion()
    this.min_zoom = 1
    this.max_zoom = 400
    this.current_tilt = 0
    this.current_orientation = 0
    this.input_enabled = true // this.debug_box = Debug.draw_cube(undefined,15);
    // this.debug_zoom_box = Debug.draw_sphere(undefined,15, 0x00ff00);

    this.projected_points = []

    for (let i = 0; i < 30; i++) {
      this.projected_points.push(Debug.draw_sphere(undefined, 0.5, 0x00FF00))
    }

    this.hide_projected_points()
    this.projection_plane_helper = new PlaneHelper(new Plane(), 1, 0xFF00)
    this.projection_plane_helper.visible = false
    SceneManager.current.add(this.projection_plane_helper)
    this.projection_sphere_helper = Debug.draw_sphere_helper(
      new Sphere(),
      0xFF0000
    )
    this.projection_sphere_helper.material.transparent = true
    this.projection_sphere_helper.material.opacity = 0.3
    this.projection_sphere_helper.visible = false
  }

  set_camera(camera) {
    this.camera = camera
    this.camera_initial_rot = camera.quaternion.clone()
    this.camera_initial_pos = camera.position.clone()
  }

  set_state(state) {
    // console.log("camera controller state switch to: " + state.constructor.name);
    this.current_state.on_exit(this)
    this.current_state = state
    this.current_state.on_enter(this)
  }

  set_mode(mode) {
    // console.log("camera controller mode switch to: " + mode.constructor.name);
    this.current_mode.on_exit(this)
    this.current_mode = mode
    this.current_mode.on_enter(this)
  }

  set_normalized_zoom(zoom) {
    this.normalized_zoom = _Math.clamp(zoom, 0, 1) // EventManager.fire_zoom_changed(this.normalized_zoom);
  }

  update_normalized_zoom(min_zoom, max_zoom) {
    const zoom = this.camera.position.distanceTo(this.reference_position)
    this.normalized_zoom = MathUtilities.linear_map(
      zoom,
      min_zoom,
      max_zoom,
      1,
      0
    )
    this.normalized_zoom = _Math.clamp(this.normalized_zoom, 0, 1) // EventManager.fire_zoom_changed(this.normalized_zoom);
  }

  update() {
    if (this.debug_box) {
      this.debug_box.position.copy(this.reference_position)
    } // this.debug_zoom_box.position.copy(this.reference_position)
    // this.debug_zoom_box.position.add(new Vector3(0,0,1Quaternion(this.quaternion).multiplyScalar(this.reference_zoom));

    this.current_state.update(this)
    this.current_mode.update(this)
    this.update_normalized_zoom(this.min_zoom, this.max_zoom)
  }

  set_idle() {
    this.set_state(new $c3449a2e8f44a086b821dce4a5f0b801$export$default())
  }

  camera_is_zoomed_out() {
    return this.normalized_zoom < 0.2
  }

  set_debug_mode() {
    this.set_state(new $ef2a5e9f4cd262a692c86fe33270bb4$export$default())
  }

  set_rotation(tilt, orientation) {
    this.old_orientation = this.current_orientation
    this.current_tilt = tilt || this.current_tilt
    this.current_orientation = orientation || this.current_orientation
    this.reference_rotation.copy(
      this.build_rotation(this.current_tilt, this.current_orientation)
    )
  }

  set_tilt(tilt) {
    const new_tilt = new Quaternion().setFromAxisAngle(
      this.vector_right_axis,
      (-tilt / 360) * Math.PI * 2
    )
    const old_tilt = new Quaternion().setFromAxisAngle(
      this.vector_right_axis,
      (-this.current_tilt / 360) * Math.PI * 2
    )
    old_tilt.conjugate()
    this.reference_rotation.multiply(old_tilt).multiply(new_tilt)
    this.current_tilt = tilt
  }

  set_rotation_delta(delta_x, delta_y) {
    this.current_orientation = (this.current_orientation + delta_x) % 360
    this.current_tilt += delta_y
    this.set_rotation(this.current_tilt, this.current_orientation)
  }

  lerp_rotation(from_tilt, to_tilt, from_orientation, to_orientation, t) {
    const raw_orientation = _Math.lerp(from_orientation, to_orientation, t)

    if (Math.abs(to_orientation - from_orientation) > 180) {
      if (from_orientation > 180) {
        from_orientation = (from_orientation % 360) - 360
      }

      if (to_orientation > 180) {
        to_orientation = (to_orientation % 360) - 360
      }
    }

    this.set_rotation(
      _Math.lerp(from_tilt, to_tilt, t),
      _Math.lerp(from_orientation, to_orientation, t)
    )
    this.current_orientation = raw_orientation
  }

  build_rotation(tilt, orientation) {
    const new_orientation = new Quaternion().setFromAxisAngle(
      this.vector_up_axis,
      (orientation / 360) * Math.PI * 2
    )
    const new_tilt = new Quaternion().setFromAxisAngle(
      this.vector_right_axis,
      (-tilt / 360) * Math.PI * 2
    )
    return new_orientation.multiply(new_tilt)
  }

  translate_forward(amount) {
    this.tmp_forward.copy(this.vector_forward_axis)
    this.tmp_forward.applyQuaternion(this.camera.quaternion)
    this.tmp_forward.y = 0
    this.tmp_forward.normalize()
    this.reference_position.add(this.tmp_forward.multiplyScalar(amount))
  }

  translate_right(amount) {
    this.tmp_right.copy(this.vector_right_axis)
    this.tmp_right.applyQuaternion(this.camera.quaternion)
    this.reference_position.add(this.tmp_right.multiplyScalar(amount))
  }

  focus_on_bounding_box(bb, scale = 1) {
    if (this.camera.isOrthographicCamera) {
      bb.getSize(this.tmp_size)
      const obj_x = this.tmp_size.x
      const obj_y = this.tmp_size.y
      const object_aspect = obj_x / obj_y

      if (Screen.aspect_ratio / object_aspect > 1) {
        this.camera.zoom = Screen.height / obj_y
      } else {
        this.camera.zoom = Screen.width / obj_x
      }

      bb.getCenter(this.reference_position)
    } else {
      const dir = new Vector3()
      dir.copy(bb.max).sub(bb.min)
      const p1 = bb.min.clone()
      const p2 = p1.clone().add(new Vector3(dir.x, 0, 0))
      const p3 = p1.clone().add(new Vector3(0, dir.y, 0))
      const p4 = p1.clone().add(new Vector3(0, 0, dir.z))
      const p5 = p1.clone().add(new Vector3(dir.x, 0, dir.z))
      const p6 = p1.clone().add(new Vector3(0, dir.y, dir.z))
      const p7 = bb.max.clone()
      const p8 = p1.clone().add(new Vector3(dir.x, dir.y, 0))
      this.focus_camera_on_points([p1, p2, p3, p4, p5, p6, p7, p8], scale)
    }
  }

  get_zoom_to_focus_on_bounding_box(bb, tilt, orientation) {
    if (tilt !== undefined && orientation !== undefined) {
      this.tmp_quat.copy(this.reference_rotation)
      this.reference_rotation.copy(this.build_rotation(tilt, orientation))
    }

    const original_zoom = this.reference_zoom
    const original_pos = new Vector3().copy(this.reference_position)
    this.focus_camera_on_bounding_box(bb)
    const target_zoom = this.reference_zoom
    this.reference_position.copy(original_pos)
    this.reference_zoom = original_zoom

    if (tilt !== undefined && orientation !== undefined) {
      this.reference_rotation.copy(this.tmp_quat)
    }

    return target_zoom
  }

  get_zoom_to_focus_on_points(points, scale) {
    const old_zoom = this.reference_zoom
    const old_pos = new Vector3().copy(this.reference_position)
    this.focus_camera_on_points(points, scale)
    const new_zoom = this.reference_zoom
    this.reference_zoom = old_zoom
    this.reference_position.copy(old_pos)
    return new_zoom
  }

  get_target_pos_to_focus_on_points(points, scale) {
    const old_zoom = this.reference_zoom
    const old_pos = new Vector3().copy(this.reference_position)
    this.focus_camera_on_points(points, scale)
    const new_pos = this.reference_zoom.clone()
    this.reference_zoom = old_zoom
    this.reference_position.copy(old_pos)
    return new_pos
  }

  focus_camera_on_sphere(sphere, debug) {
    this.reference_zoom = this.get_zoom_to_sphere(sphere, debug)
    this.reference_position.copy(sphere.center)
  }

  get_zoom_to_sphere(sphere, debug) {
    const v_fov = ((this.camera.fov / 2) * Math.PI) / 180
    const h_fov = (2 * Math.atan(Math.tan(v_fov) * this.camera.aspect)) / 2 // if(debug )
    // {
    //  Debug.draw_math_sphere(sphere);
    // }
    // this.camera.zoom = 1/((sphere.radius*2) /(ViewApi.map.camera_controller.camera.top*2));
    // this.camera.updateProjectionMatrix();

    const distV = sphere.radius / Math.tan(v_fov)
    const distH = sphere.radius / Math.tan(h_fov)
    return Math.max(Math.abs(distH), Math.abs(distV))
  }

  hide_projected_points() {
    for (let i = 0; i < this.projected_points.length; i++) {
      this.projected_points[i].visible = false
    }
  }

  show_projected_points(points) {
    this.hide_projected_points()

    for (let i = 0; i < points.length; i++) {
      this.projected_points[i].visible = true
      this.projected_points[i].position.copy(points[i])
    }
  }

  show_plane_projection(plane, size = 1) {
    this.projection_plane_helper.plane = plane
    this.projection_plane_helper.size = size
    this.projection_plane_helper.updateMatrixWorld()
    this.projection_plane_helper.visible = true
  }

  show_sphere_projection(sphere) {
    this.projection_sphere_helper.scale.set(
      sphere.radius,
      sphere.radius,
      sphere.radius
    )
    this.projection_sphere_helper.position.copy(sphere.center)
    this.projection_sphere_helper.visible = true
  }

  focus_camera_on_points(points, zoom_scale = 1) {
    const points_sphere = new Sphere().setFromPoints(points)
    const world_space_center = points_sphere.center
    const camera_forward = new THREE.Vector3(0, 0, 1).applyQuaternion(
      this.reference_rotation
    ) // let near_plane = points_sphere.center.clone().add(camera_forward.clone().multiplyScalar(points_sphere.radius));

    const far_pos = this.camera.position
      .clone()
      .add(camera_forward.clone().multiplyScalar(100))
    const near_plane = ArrayUtilities.get_closest_point(points, far_pos).clone()
    const plane = new Plane().setFromNormalAndCoplanarPoint(
      camera_forward,
      near_plane
    )
    const points_on_plane = [] // this.show_plane_projection(plane, points_sphere.radius*2);
    // this.show_sphere_projection(points_sphere);

    const _projected_points = []

    for (let i = 0; i < points.length; i++) {
      const projected_point = new Vector3()
      plane.projectPoint(points[i], projected_point)
      projected_point.copy(points[i]) // let line = new TLine3(points[i].clone(), this.camera.position.clone());
      // plane.intersectLine(line, projected_point);

      points_on_plane.push(projected_point.clone())

      _projected_points.push(projected_point.clone())
    }

    this.show_projected_points(_projected_points)
    const up = new THREE.Vector3(0, 1, 0).applyQuaternion(
      this.reference_rotation
    )
    const right = up.clone().cross(camera_forward).normalize()
    const mat = new Matrix4().set(
      right.x,
      up.x,
      camera_forward.x,
      world_space_center.x,
      right.y,
      up.y,
      camera_forward.y,
      world_space_center.y,
      right.z,
      up.z,
      camera_forward.z,
      world_space_center.z,
      0,
      0,
      0,
      1
    )
    const inverse_mat = new Matrix4().getInverse(mat) // let inverse_mat = this.camera.matrixWorldInverse.clone();

    for (let i = 0; i < points_on_plane.length; i++) {
      points_on_plane[i].applyMatrix4(inverse_mat)
    }

    const size = new Vector3()
    const box = new Box3().setFromPoints(points_on_plane)
    box.getSize(size) // size.multiplyScalar(zoom_scale);

    const projected_center = new Vector3()
    box.getCenter(projected_center)
    this.reference_position.copy(
      projected_center
        .applyMatrix4(mat)
        .sub(camera_forward.clone().multiplyScalar(points_sphere.radius))
    ) // let zoom_scale_nofake = 1 + (zoom_scale-1)*2;
    // this.reference_zoom = this.__get_zoom_to_show_rect((size.x/2)*zoom_scale_nofake, (size.y/2)*zoom_scale_nofake)+points_sphere.radius;

    this.reference_zoom =
      this.__get_zoom_to_show_rect(
        size.x / 2,
        size.y / 2,
        1 + (1 - zoom_scale)
      ) + points_sphere.radius
  }

  get_current_tilt() {
    return this.current_tilt
  }

  get_current_orientation() {
    return this.current_orientation
  }

  __get_zoom_to_show_rect(width, height, scale = 1) {
    // let v_fov = (this.camera.fov/2) * Math.PI/180;
    const v_fov = _Math.degToRad(this.camera.fov / 2)

    const h_fov = (2 * Math.atan(Math.tan(v_fov) * this.camera.aspect)) / 2
    const distV = height / Math.tan(v_fov * scale)
    const distH = width / Math.tan(h_fov * scale)
    return Math.max(Math.abs(distH), Math.abs(distV))
  }
}

class $cbea740ada5053a558f611980f96c698$export$default {
  constructor() {
    this.name = undefined
    this.container = undefined
  }

  start(name, container) {
    this.name = name
    this.container = container
  }

  update() {}

  on_resize() {}

  show() {}

  hide() {}
}

class $f1b35cb0c323fd2d2f87647ca1c5e$export$default extends $cbea740ada5053a558f611980f96c698$export$default {
  start() {
    super.start('home', document.querySelector('.home'))
  }

  update() {}
}

class $cfb2277e624a264ce0a58ec$export$default {
  constructor() {}

  on_enter() {}

  on_exit() {}

  update() {}
}

class $c25284f8f5b5bcd8c343ad5c8d8$export$default {
  constructor() {}

  on_enter(level_player) {}

  on_exit(level_player) {}

  update(level_player) {}
}

class $b48491d920d149104e0d05e7ef0f04$export$default {
  constructor() {}

  on_enter(level_player) {}

  on_exit(level_player) {}

  update(level_player) {}
}

class $a0449278cf77c032bb502615a80934$export$default extends $b48491d920d149104e0d05e7ef0f04$export$default {
  constructor() {
    super()
  }

  on_enter(level_player) {
    level_player.player_view.show_start_playing_popup(false)
    level_player.game.start()
  }

  update(level_player, delta_time, time_scale) {
    level_player.update_view()
  }
}

class $f87dde42ffe0e4b1bdaae32e639c9$export$default {
  constructor() {}

  on_enter(level_player) {
    console.log('Asd')
    level_player.player_view.show_start_playing_popup(true)
    level_player.update_view()
  }

  on_exit(level_player) {}

  update(level_player) {
    if (level_player.player_view.is_prepare_to_play_view_showing === false) {
      level_player.set_state(this.next_state())
    }
  }

  next_state() {
    return new $a0449278cf77c032bb502615a80934$export$default()
  }
}

class $e6facc738b0114a29dec47fca3b201c5$export$default {
  constructor(level_descriptor) {
    this.level_descriptor = level_descriptor
  }

  on_enter(level_player) {
    level_player.set_level_descriptor(this.level_descriptor)
    this.set_next_state(level_player)
  }

  set_next_state(level_player) {
    const game = level_player.game

    if (game.can_play()) {
      if (game.can_fire()) {
        this.go_to_game_started(level_player)
      } else {
        this.go_to_waiting_for_start(level_player)
      }
    } else {
      level_player.game_over()
    }
  }

  go_to_game_started(level_player) {
    level_player.set_state(new GameStarted())
  }

  go_to_waiting_for_start(level_player) {
    level_player.set_state(new $f87dde42ffe0e4b1bdaae32e639c9$export$default())
  }

  on_exit(level_player) {}

  update(level_player) {}
}

class $b224c8a1c853d67c8b426a5679362bd2$export$default {
  constructor() {}

  on_enter(level_player) {
    level_player.update_view()
    level_player.player_view.game_over()
  }

  on_exit(level_player) {}

  update(level_player) {}
}

class $abc41a388d5324483742198167aaa2$export$default {
  constructor() {}

  on_block_created(block_id) {}

  on_ball_created(ball) {}

  on_wall_created(wall) {}

  on_block_destroyed(block_id) {}

  on_ball_destroyed(ball_id) {}

  on_block_hit(block) {}

  on_wall_destroyed(wall_id) {}

  on_turn_ended(turn_number) {}

  on_game_over() {}
}

class $c0b4a3fbc0bb081afa06457ec6f0b87$export$default extends $abc41a388d5324483742198167aaa2$export$default {
  constructor(level_player) {
    super()
    this.level_player = level_player
  }

  on_block_destroyed(game_block) {
    this.level_player.remove_block(game_block)
  }

  on_ball_destroyed(game_ball) {
    this.level_player.remove_ball(game_ball)
  }

  on_wall_destroyed(wall) {
    this.level_player.remove_wall(wall)
  }

  on_block_created(game_block) {
    this.level_player.create_block(game_block)
  }

  on_ball_created(game_ball) {
    this.level_player.create_ball(game_ball)
  }

  on_wall_created(wall) {
    this.level_player.create_wall(wall)
  }

  on_turn_ended(turn) {
    this.level_player.turn_ended(turn)
  }

  on_block_hit(block) {
    const renderable_block =
      this.level_player.game_renderer.find_renderable_block(block)
    renderable_block.hit()
  }

  on_game_over() {
    // console.log('GAME OVER');
    this.level_player.game_over()
  }
}

// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/js/components/game/Game.js
let $cd3954c1f6daa465a4087f7301$exports = {}

class $d2cd73747d2bafb54de3e8493ebfdd93$export$default {
  constructor(body) {
    this.body = body
  }

  get_position() {
    return this.body.getPosition()
  }

  set_position(x, y) {
    this.body.setPosition(_planckJs.Vec2(x, y))
  }

  get_immediate_position() {
    return this.body.getPosition()
  }
}

class $f9204f60334cd285cd8166d189a41815$export$default extends $d2cd73747d2bafb54de3e8493ebfdd93$export$default {
  constructor(
    id,
    body,
    total_hp = 1,
    current_hp,
    color_image,
    points_per_hit = 1,
    points_per_destruction = 1
  ) {
    super(body)
    this.id = id
    this.is_block = true
    this.total_hp = total_hp
    this.current_hp = current_hp !== undefined ? current_hp : total_hp
    this.color_image = color_image
    this.points_per_hit = points_per_hit
    this.points_per_destruction = points_per_destruction
  }

  get_size() {
    return {
      x: 1,
      y: 1,
    }
  }
}

class $f8e7347f4c3d81455dacbaa71be2969$export$default extends $d2cd73747d2bafb54de3e8493ebfdd93$export$default {
  constructor(body, side = 'bottom', board_width, board_height, color) {
    super(body)
    this.side = side
    this.board_width = board_width
    this.board_height = board_height
    this.is_wall = true
    this.color = color
  }

  get_normal() {
    if (this.side === 'left') {
      return {
        x: 1,
        y: 0,
      }
    }

    if (this.side === 'right') {
      return {
        x: -1,
        y: 0,
      }
    }

    if (this.side === 'bottom') {
      return {
        x: 0,
        y: 1,
      }
    }

    if (this.side === 'top') {
      return {
        x: 0,
        y: -1,
      }
    }

    console.error('Undefined side', this)
  }

  get_center() {
    return this.body.getPosition() // {x: this.body.position.x, y: this.body.position.y};
  }
}

class $dc42512a13f3bfa5707cdc9715c4d27d$export$default extends $d2cd73747d2bafb54de3e8493ebfdd93$export$default {
  constructor(body) {
    super(body)
    this.is_ball = true
    this.velocity = _planckJs.Vec2(0, 0)
  }

  apply_impulse(force_x, force_y) {
    // this.body.applyLinearImpulse(planck.Vec2(force_x, force_y), this.body.getPosition());
    this.velocity.x = force_x
    this.velocity.y = force_y
  }

  get_size() {
    return this.body.getFixtureList()[0].shape.getRadius()
  }
}

class $a76a04770cece6e1e4f3ef622b508$export$default {
  constructor(world) {
    this.world = world
    this.collision_groups = {
      BALL: 2 ** 0,
      WALL: 2 ** 1,
      BLOCK: 2 ** 2,
    }
  }

  build_blocks(blocks_data, block_thickness) {
    const blocks = []

    for (let i = 0; i < blocks_data.length; i++) {
      const b = blocks_data[i]
      blocks.push(
        new $f9204f60334cd285cd8166d189a41815$export$default(
          b.id,
          this.create_block_body(b.x, b.y, block_thickness),
          b.total_hp,
          b.current_hp,
          b.color_image,
          b.points_per_hit,
          b.points_per_destruction
        )
      )
    }

    return blocks
  }

  build_block(block_data, block_thickness) {
    const block_body = this.create_block_body(
      block_data.x,
      block_data.y,
      block_thickness
    )
    return new $f9204f60334cd285cd8166d189a41815$export$default(
      block_data.id,
      block_body,
      block_data.total_hp,
      block_data.current_hp,
      block_data.color_image,
      block_data.points_per_hit,
      block_data.points_per_destruction
    )
  }

  build_walls(board_width, board_height, color) {
    const walls = []
    const ground = new $f8e7347f4c3d81455dacbaa71be2969$export$default(
      this.create_wall_body('bottom', board_width, board_height),
      'bottom',
      board_width,
      board_height,
      color
    )
    const left_wall = new $f8e7347f4c3d81455dacbaa71be2969$export$default(
      this.create_wall_body('left', board_width, board_height),
      'left',
      board_width,
      board_height,
      color
    )
    const right_wall = new $f8e7347f4c3d81455dacbaa71be2969$export$default(
      this.create_wall_body('right', board_width, board_height),
      'right',
      board_width,
      board_height,
      color
    )
    const upper_wall = new $f8e7347f4c3d81455dacbaa71be2969$export$default(
      this.create_wall_body('top', board_width, board_height),
      'top',
      board_width,
      board_height,
      color
    )
    walls.push(ground)
    walls.push(left_wall)
    walls.push(right_wall)
    walls.push(upper_wall) // let position = planck.Vec2(3, board_height / 2);
    // let shape = planck.Edge(planck.Vec2(0, -board_height / 2), planck.Vec2(0, board_height / 2));
    // let body = this.world.createBody({
    //   type: 'static',
    //   position: position,
    //   friction: 0,
    //   density: 0
    // });
    // body.createFixture({
    //   shape: shape,
    //   filterCategoryBits: this.collision_groups.WALL,
    //   filterMaskBits: this.collision_groups.BALL,
    //   userData: 'wall'
    // });
    // walls.push(new Wall(body, 'left', board_width, board_height));
    // let position_2 = planck.Vec2(6, board_height / 2);
    // let shape2 = planck.Edge(planck.Vec2(0, -board_height / 2), planck.Vec2(0, board_height / 2));
    // let body2 = this.world.createBody({
    //   type: 'static',
    //   position: position_2,
    //   friction: 0,
    //   density: 0
    // });
    // body2.createFixture({
    //   shape: shape2,
    //   filterCategoryBits: this.collision_groups.WALL,
    //   filterMaskBits: this.collision_groups.BALL,
    //   userData: 'wall'
    // });
    // walls.push(new Wall(body2, 'right', board_width, board_height));

    return walls
  }

  create_wall_body(side = 'bottom', board_width = 0.1, board_height = 0.1) {
    let position
    let shape

    switch (side) {
      case 'bottom':
        position = _planckJs.Vec2(board_width / 2, 0)
        shape = _planckJs.Edge(
          _planckJs.Vec2(-board_width / 2, 0.0),
          _planckJs.Vec2(board_width / 2, 0)
        )
        break

      case 'left':
        position = _planckJs.Vec2(0, board_height / 2)
        shape = _planckJs.Edge(
          _planckJs.Vec2(0, -board_height / 2),
          _planckJs.Vec2(0, board_height / 2)
        )
        break

      case 'right':
        position = _planckJs.Vec2(board_width, board_height / 2)
        shape = _planckJs.Edge(
          _planckJs.Vec2(0, -board_height / 2),
          _planckJs.Vec2(0, board_height / 2)
        )
        break

      case 'top':
        position = _planckJs.Vec2(board_width / 2, board_height)
        shape = _planckJs.Edge(
          _planckJs.Vec2(-board_width / 2, 0.0),
          _planckJs.Vec2(board_width / 2, 0)
        )
        break
    }

    const body = this.world.createBody({
      type: 'static',
      position,
      friction: 0,
      density: 0,
    })
    body.createFixture({
      shape,
      filterCategoryBits: this.collision_groups.WALL,
      filterMaskBits: this.collision_groups.BALL,
      userData: 'wall',
    })
    return body
  }

  create_block_body(x = 0, y = 0, block_thickness = 0) {
    const body = this.world.createBody({
      type: 'static',
      position: _planckJs.Vec2(x, y),
      friction: 0,
      density: 0,
    })
    const width = 1 + block_thickness
    const height = 1 + block_thickness
    body.createFixture({
      shape: _planckJs.Box(width / 2, height / 2),
      filterCategoryBits: this.collision_groups.BLOCK,
      filterMaskBits: this.collision_groups.BALL,
      userData: 'block',
    })
    return body
  }

  build_ball(radius = 0.5) {
    const body = this.world.createDynamicBody({
      // angularDamping: 0,
      // linearDamping: 0
      fixedRotation: true,
    })
    body.setBullet(true)
    body.createFixture(_planckJs.Circle(radius), {
      density: 1,
      restitution: 1,
      friction: 0,
      userData: 'ball',
      filterCategoryBits: this.collision_groups.BALL,
      filterMaskBits: this.collision_groups.WALL | this.collision_groups.BLOCK,
    })
    return new $dc42512a13f3bfa5707cdc9715c4d27d$export$default(body)
  }
}

class $d541445c781c017043854442a$export$default {
  constructor(game) {
    this.game = game
    this.context = game.context
  }

  on_impact(ball, impacted_fixture) {
    const user_data = impacted_fixture.getUserData()

    if (user_data === 'block') {
      this.on_block_impact(impacted_fixture)
    }

    if (user_data === 'wall') {
      this.on_wall_impact(ball, impacted_fixture)
    }
  }

  on_block_impact(block_fixture) {
    const block = this.context.get_block_by_body(block_fixture.getBody())
    block.current_hp -= 1

    if (block.current_hp === 0) {
      this.context.remove_block_deferred(block)
      this.game.add_points(block.points_per_destruction)
    } else {
      this.game.on_block_hit(block)
      this.game.add_points(block.points_per_hit)
    }
  }

  on_wall_impact(ball, floor_fixture) {
    const wall = this.context.get_wall_by_body(floor_fixture.getBody())

    if (wall.side === 'bottom') {
      this.context.remove_ball_deferred(ball)
    }
  }

  get_ball_on_wall_contact(fixA, fixB) {
    let ball
    let wall

    if (fixA.getUserData() === 'ball') {
      ball = this.context.get_ball_by_body(fixA.getBody())
    }

    if (fixB.getUserData() === 'ball') {
      ball = this.context.get_ball_by_body(fixB.getBody())
    }

    if (fixA.getUserData() === 'wall') {
      wall = this.context.get_wall_by_body(fixA.getBody())
    }

    if (fixB.getUserData() === 'wall') {
      wall = this.context.get_wall_by_body(fixB.getBody())
    }

    if (wall && ball) {
      return {
        ball,
        wall,
      }
    }

    return undefined
  }

  get_ball_on_block_contact(fixA, fixB) {
    let ball
    let block

    if (fixA.getUserData() === 'ball') {
      ball = this.context.get_ball_by_body(fixA.getBody())
    }

    if (fixB.getUserData() === 'ball') {
      ball = this.context.get_ball_by_body(fixB.getBody())
    }

    if (fixA.getUserData() === 'block') {
      block = this.context.get_block_by_body(fixA.getBody())
    }

    if (fixB.getUserData() === 'block') {
      block = this.context.get_block_by_body(fixB.getBody())
    }

    if (block && ball) {
      return {
        ball,
        block,
      }
    }

    return undefined
  }
}

class $b834130c156ccd8f8675b284f28da$export$default {
  constructor(world, game_listener) {
    this.blocks = []
    this.walls = []
    this.balls = []
    this.balls_to_be_removed = []
    this.blocks_to_be_removed = []
    this.walls_to_be_removed = []
    this.listener = game_listener
    this.world = world
  }

  update() {
    this.check_for_pending_entities_to_be_removed()
  }

  add_wall(wall) {
    this.walls.push(wall)
    this.listener.on_wall_created(wall)
  }

  remove_wall(destroyed_wall) {
    this.world.destroyBody(destroyed_wall.body)
    this.walls = this.walls.filter((wall) => {
      return destroyed_wall !== wall
    })
    this.listener.on_wall_destroyed(destroyed_wall)
  }

  remove_wall_deferred(destroyed_wall) {
    this.walls_to_be_removed.push(destroyed_wall)
  }

  add_ball(ball) {
    this.balls.push(ball)
    this.listener.on_ball_created(ball)
  }

  remove_ball(destroyed_ball) {
    this.world.destroyBody(destroyed_ball.body)
    this.balls = this.balls.filter((ball) => {
      return destroyed_ball !== ball
    })
    this.listener.on_ball_destroyed(destroyed_ball)
  }

  remove_ball_deferred(destroyed_ball) {
    this.balls_to_be_removed.push(destroyed_ball)
  }

  add_block(block) {
    this.blocks.push(block)
    this.listener.on_block_created(block)
  }

  remove_block(destroyed_block) {
    this.world.destroyBody(destroyed_block.body)
    this.blocks = this.blocks.filter((block) => {
      return destroyed_block !== block
    })
    this.listener.on_block_destroyed(destroyed_block)
  }

  remove_block_deferred(destroyed_block) {
    this.blocks_to_be_removed.push(destroyed_block)
  }

  create_world() {
    const world = new _planckJs.World({
      gravity: _planckJs.Vec2(0, 0),
    })
    return world
  }

  check_for_pending_entities_to_be_removed() {
    while (this.balls_to_be_removed.length > 0) {
      this.remove_ball(this.balls_to_be_removed[0])
      this.balls_to_be_removed.shift()
    }

    while (this.blocks_to_be_removed.length > 0) {
      this.remove_block(this.blocks_to_be_removed[0])
      this.blocks_to_be_removed.shift()
    }

    while (this.walls_to_be_removed.length > 0) {
      this.remove_wall(this.walls_to_be_removed[0])
      this.walls_to_be_removed.shift()
    }
  }

  get_ball_by_body(body) {
    for (let i = 0; i < this.balls.length; i++) {
      if (this.balls[i].body === body) {
        return this.balls[i]
      }
    }

    return undefined
  }

  get_block_by_body(body) {
    for (let i = 0; i < this.blocks.length; i++) {
      if (this.blocks[i].body === body) {
        return this.blocks[i]
      }
    }

    return undefined
  }

  get_wall_by_body(body) {
    for (let i = 0; i < this.walls.length; i++) {
      if (this.walls[i].body === body) {
        return this.walls[i]
      }
    }

    return undefined
  }

  dispose() {
    while (this.walls.length > 0) {
      this.remove_wall(this.walls[0])
    }

    while (this.balls.length > 0) {
      this.remove_ball(this.balls[0])
    }

    while (this.blocks.length > 0) {
      this.remove_block(this.blocks[0])
    }

    this.check_for_pending_entities_to_be_removed()
  }
}

class $bd44b939f2b61b6a601419616fbe7e46$export$default {
  constructor() {}

  raycast(p1, p2, world, ignore_fixture) {
    let result
    world.rayCast(p1, p2, (fixture, point, normal, fraction) => {
      let valid = true // if(result !== undefined) //the first result is the closest contact point
      //   valid = false;

      if (fixture.getUserData() === 'ball') {
        valid = false
      }

      if (ignore_fixture !== undefined && fixture === ignore_fixture) {
        valid = false
      }

      if (valid) {
        if (result === undefined) {
          result = {
            fixture,
            point,
            normal,
            fraction,
            user_data: fixture.getUserData(),
          }
        } else if (fraction < result.fraction) {
          result = {
            fixture,
            point,
            normal,
            fraction,
            user_data: fixture.getUserData(),
          }
        }
      }
    })
    return result
  }
}

class $db2f1a94743d99979331b025c2dc5380$export$default {
  constructor(game_context, collision_resolver) {
    this.game_context = game_context
    this.collision_resolver = collision_resolver
  }

  update(delta_time) {
    const balls = this.game_context.balls
    const raycaster = new $bd44b939f2b61b6a601419616fbe7e46$export$default()

    for (let i = 0; i < balls.length; i++) {
      const b = balls[i]
      this.solve(raycaster, b, b.velocity.clone().mul(delta_time), undefined, 0)
    }
  }

  solve(raycaster, b, velocity, ignore_fixture, invocaciones) {
    const current_pos = b.get_position()
    const new_x = current_pos.x + velocity.x
    const new_y = current_pos.y + velocity.y
    const thickness = 0.2 * 0.01
    const skin_offset = velocity.clone()
    skin_offset.normalize()
    skin_offset.mul(thickness)
    const result = raycaster.raycast(
      current_pos,
      _planckJs.Vec2(new_x + skin_offset.x, new_y + skin_offset.y),
      this.game_context.world,
      ignore_fixture
    )

    if (result === undefined) {
      b.set_position(new_x, new_y)
    } else {
      b.set_position(
        result.point.x - skin_offset.x,
        result.point.y - skin_offset.y
      )
      const reflected_dir_x = (1 - result.fraction) * velocity.x - skin_offset.x
      const reflected_dir_y = (1 - result.fraction) * velocity.y - skin_offset.y
      const remaining_reflected_velocity = this.reflect_vector(
        _planckJs.Vec2(reflected_dir_x, reflected_dir_y),
        result.normal
      )
      const reflected_velocity = this.reflect_vector(b.velocity, result.normal)
      b.velocity.x = reflected_velocity.x
      b.velocity.y = reflected_velocity.y
      this.collision_resolver.on_impact(b, result.fixture) // Enable this to solve multiple bounces on the same frame

      this.solve(
        raycaster,
        b,
        remaining_reflected_velocity,
        result.fixture,
        invocaciones + 1
      )
    }
  }

  reflect_vector(dir, normal) {
    const n_dot_dir = _planckJs.Vec2.dot(normal, dir)

    const tmp = normal.clone()
    tmp.mul(2 * n_dot_dir)
    return _planckJs.Vec2.sub(dir, tmp)
  }
}

class $a3461a2ab0e5222461c39d$export$default {
  constructor() {}

  on_enter(game) {}

  on_exit(game) {}

  update(game, delta_time, time_scale) {}

  can_fire() {
    return false
  }

  can_start() {
    return false
  }

  import_state(state) {}

  export_state() {
    return {
      type: 'BaseState',
    }
  }
}

class $ba92546b65c3cf40db8847cd1b0417$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor() {
    super()
  }

  can_start() {
    return true
  }

  export_state() {
    return {
      type: 'WaitingToStart',
    }
  }
}

class $ecf0e16c58fcba31f3c94749d3fa3e9d$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor() {
    super()
  }

  on_enter(game) {
    this.start_date = new Date()
  }

  on_exit(game) {
    game.elapsed_time = (new Date() - this.start_date) / 1000.0
    console.log('STARTED TIME', game.elapsed_time)
  }

  update(game, delta_time, time_scale) {
    game.elapsed_time = (new Date() - this.start_date) / 1000.0
  }

  can_fire() {
    return true
  }

  export_state() {
    return {
      type: 'Started',
      start_date: this.start_date.valueOf(),
    }
  }

  import_state(data) {
    this.start_date = new Date(data.start_date)
  }
}

class $d547ec21e87383317bc65e352f209c$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor() {
    super()
  }

  on_enter(game) {
    game.over()
  }

  can_fire() {
    return false
  }

  export_state() {
    return {
      type: 'GameOver',
    }
  }
}

class $bdc39256e71d7e548282d485c21a0ad$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor() {
    super()
  }

  on_enter(game) {
    game.scores[game.times_played].points = game.current_points
    game.scores[game.times_played].time = game.elapsed_time
    console.log('TOTAL TIME: ', game.elapsed_time)
    game.times_played++

    if (game.can_play()) {
      game.elapsed_time = 0
      game.reset_points()
      game.set_state(new $ba92546b65c3cf40db8847cd1b0417$export$default())
      game.reload_blocks()
      game.listener.on_turn_ended(game.times_played - 1)
    } else {
      game.set_state(new $d547ec21e87383317bc65e352f209c$export$default())
    }
  }

  can_fire() {
    return false
  }

  export_state() {
    return {
      type: 'ComputingScore',
    }
  }
}

class $ade012335df96342e942822fb87f9dd4$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor() {
    super()
  }

  on_enter(game) {
    this.start_time = game.elapsed_time
  }

  on_exit(game) {
    console.log('WAITFORCLEAR TIME', game.elapsed_time - this.start_time)
  }

  update(game, delta_time, time_scale) {
    game.elapsed_time += delta_time * time_scale

    if (game.balls.length === 0) {
      game.set_state(new $bdc39256e71d7e548282d485c21a0ad$export$default())
    }
  }

  can_fire() {
    return false
  }

  export_state() {
    return {
      type: 'WaitingForBallClear',
    }
  }
}

class $f98c8857ddeb876a7390f5ffbe822d$export$default extends $a3461a2ab0e5222461c39d$export$default {
  constructor(firing_direction) {
    super()
    this.firing_direction = firing_direction
    this.firing_rate = 0
    this.elapsed_time_since_firing = 0
    this.firing_velocity = {
      x: 0,
      y: 0,
    }
    this.remaining_balls_to_fire = -1
  }

  on_enter(game) {
    this.firing_velocity.x = this.firing_direction.x * game.firing_speed
    this.firing_velocity.y = this.firing_direction.y * game.firing_speed
    this.remaining_balls_to_fire = game.amount_of_balls_to_fire
    this.firing_rate = game.firing_rate
    this.elapsed_time_since_firing = 0
    this.start_time = game.elapsed_time
    this.fire_ball(game)
  }

  on_exit(game) {
    console.log('FIRING TIME', game.elapsed_time - this.start_time)
  }

  update(game, delta_time, time_scale) {
    if (this.remaining_balls_to_fire > 0) {
      if (this.elapsed_time_since_firing > this.firing_rate) {
        this.fire_ball(game)
        this.elapsed_time_since_firing -= this.firing_rate
        this.remaining_balls_to_fire -= 1
      }
    }

    this.elapsed_time_since_firing += delta_time * time_scale
    game.elapsed_time += delta_time * time_scale

    if (this.remaining_balls_to_fire === 0) {
      game.set_state(new $ade012335df96342e942822fb87f9dd4$export$default())
    }
  }

  fire_ball(game) {
    const ball = new $a76a04770cece6e1e4f3ef622b508$export$default(
      game.world
    ).build_ball(game.level_descriptor.ball_radius)
    ball.set_position(game.firing_position.x, game.firing_position.y)
    ball.apply_impulse(this.firing_velocity.x, this.firing_velocity.y)
    game.context.add_ball(ball)
  }

  can_fire() {
    return false
  }

  export_state() {
    return {
      type: 'Firing',
    }
  }
}

class $c2d1f0a735523d1d8b0b771773$export$default {
  load(state_data) {
    let state

    switch (state_data.type) {
      case 'BaseState':
        state = new $a3461a2ab0e5222461c39d$export$default()
        break

      case 'WaitingToStart':
        state = new $ba92546b65c3cf40db8847cd1b0417$export$default()
        break

      case 'Started':
        state = new $ecf0e16c58fcba31f3c94749d3fa3e9d$export$default()
        break

      case 'Firing':
        state = new $f98c8857ddeb876a7390f5ffbe822d$export$default()
        break

      case 'WaitingForBallClear':
        state = new $ade012335df96342e942822fb87f9dd4$export$default()
        break

      case 'ComputingScore':
        state = new $bdc39256e71d7e548282d485c21a0ad$export$default()
        break

      case 'GameOver':
        state = new $d547ec21e87383317bc65e352f209c$export$default()
        break

      default:
        state = new $a3461a2ab0e5222461c39d$export$default()
        break
    }

    state.import_state(state_data)
    return state
  }
}

class $cd3954c1f6daa465a4087f7301$var$Game {
  constructor(listener) {
    listener = listener || new $abc41a388d5324483742198167aaa2$export$default()
    this.listener = listener
    this.world = this.create_world()
    this.context = new $b834130c156ccd8f8675b284f28da$export$default(
      this.world,
      this.listener
    )
    this.collision_resolver = new $d541445c781c017043854442a$export$default(
      this
    )
    this.level_descriptor = undefined
    this.current_points = 0
    this.total_attempts = 0
    this.times_played = 0
    this.amount_of_balls_to_fire = 50
    this.firing_rate = 0.3
    this.firing_speed = 20
    this.simulation = new $db2f1a94743d99979331b025c2dc5380$export$default(
      this.context,
      this.collision_resolver
    )
    this.current_state = new $a3461a2ab0e5222461c39d$export$default()
    this.elapsed_time = 0
    this.scores = []
  }

  get blocks() {
    return this.context.blocks
  }

  get walls() {
    return this.context.walls
  }

  get balls() {
    return this.context.balls
  }

  set_state(new_state) {
    // console.log("GAME -- new state", new_state.constructor.name);
    this.current_state.on_exit(this)
    this.current_state = new_state
    this.current_state.on_enter(this)
  }

  fire_balls(firing_dir) {
    if (this.can_fire()) {
      const dir = this.get_clamped_firing_direction(firing_dir) // dir.x = 0;
      // dir.y = 1;

      this.set_state(new $f98c8857ddeb876a7390f5ffbe822d$export$default(dir))
    }
  }

  reset_points() {
    this.current_points = 0
  }

  start() {
    if (this.current_state.can_start()) {
      this.set_state(new $ecf0e16c58fcba31f3c94749d3fa3e9d$export$default())
    }
  }

  add_points(value) {
    this.current_points += value
  }

  can_fire() {
    return this.current_state.can_fire() && this.can_play()
  }

  can_play() {
    return this.times_played < this.total_attempts
  }

  reload_blocks() {
    this.import_blocks(this.level_descriptor)
  }

  get remaining_attempts() {
    return this.total_attempts - this.times_played
  }

  update(delta_time, time_scale = 1) {
    // time_scale = 2;
    this.current_state.update(this, delta_time, time_scale)
    this.simulation.update(delta_time * time_scale)
    this.context.update()
  }

  get_clamped_firing_direction(firing_dir) {
    let angle = Math.atan2(Math.max(firing_dir.y, 0), firing_dir.x)
    angle = Math.max(0.174, angle)
    angle = Math.min(2.967, angle)
    return {
      x: Math.cos(angle),
      y: Math.sin(angle),
    }
  }

  is_firing_dir_allowed(firing_dir) {
    const angle = Math.atan2(firing_dir.y, firing_dir.x)
    return angle > 0.174 && angle < 2.967
  }

  create_world() {
    const world = new _planckJs.World({
      gravity: _planckJs.Vec2(0, 0),
    })
    return world
  }

  over() {
    // console.log('game over');
    this.listener.on_game_over()
  }

  on_block_hit(block) {
    this.listener.on_block_hit(block)
  }

  import_state(level_descriptor) {
    this.level_descriptor = level_descriptor
    this.times_played = this.level_descriptor.times_played || 0
    this.total_attempts = this.level_descriptor.total_attempts
    this.amount_of_balls_to_fire = this.level_descriptor.amount_of_balls_to_fire
    this.import_blocks(level_descriptor)
    this.import_score(level_descriptor.scores, this.total_attempts)

    if (level_descriptor.game_state === undefined) {
      level_descriptor.game_state = {
        type: 'WaitingToStart',
      }
    }

    this.current_state = new $c2d1f0a735523d1d8b0b771773$export$default().load(
      level_descriptor.game_state
    )
    this.elapsed_time = 0
    this.elapsed_time =
      level_descriptor.elapsed_time === undefined
        ? 0
        : level_descriptor.elapsed_time
  }

  export_state() {
    return {
      total_attempts: this.total_attempts,
      times_played: this.times_played,
      amount_of_balls_to_fire: this.amount_of_balls_to_fire,
      ball_radius: this.level_descriptor.ball_radius,
      ball_color: this.level_descriptor.ball_color,
      wall_color: this.level_descriptor.wall_color,
      board_width: this.level_descriptor.board_width,
      board_height: this.level_descriptor.board_height,
      last_generated_id: this.level_descriptor.last_generated_id,
      blocks: this.export_blocks(),
      scores: this.scores,
      game_state: this.current_state.export_state(),
      elapsed_time: this.elapsed_time,
    }
  }

  export_blocks() {
    const blocks = []

    for (let i = 0; i < this.blocks.length; i++) {
      const block = this.blocks[i]

      if (block.id !== -1) {
        blocks.push({
          id: block.id,
          x: block.get_position().x,
          y: block.get_position().y,
          color_image: block.color_image,
          total_hp: block.total_hp,
          current_hp: block.current_hp,
          points_per_hit: block.points_per_hit,
          points_per_destruction: block.points_per_destruction,
        })
      }
    }

    return blocks
  }

  import_blocks(level_descriptor) {
    this.dispose()
    const level_builder = new $a76a04770cece6e1e4f3ef622b508$export$default(
      this.world
    )
    const thickness = level_descriptor.ball_radius * 2
    const blocks = level_builder.build_blocks(
      level_descriptor.blocks,
      thickness
    )
    const walls = level_builder.build_walls(
      level_descriptor.board_width,
      level_descriptor.board_height,
      level_descriptor.wall_color
    )

    for (let i = 0; i < blocks.length; i++) {
      this.context.add_block(blocks[i])
    }

    for (let i = 0; i < walls.length; i++) {
      this.context.add_wall(walls[i])
    }

    this.firing_position = {
      x: 0,
      y: 0,
    }
    this.firing_position.x = level_descriptor.board_width / 2
    this.firing_position.y = level_descriptor.ball_radius * 2
  }

  import_score(score, total_attempts) {
    // safe init
    this.scores.length = 0

    for (let i = 0; i < total_attempts; i++) {
      this.scores.push({
        points: 0,
        time: 0,
      })
    } // import if exists

    if (score && score.length === total_attempts) {
      this.scores = JSON.parse(JSON.stringify(score))
    }
  }

  dispose() {
    this.context.dispose()
  }
}

$cd3954c1f6daa465a4087f7301$exports = $cd3954c1f6daa465a4087f7301$var$Game

class $ef090c0ee6346f6e47c78a6ff1$export$default {
  constructor() {}

  trace(origin, dir, walls) {
    const planes = []

    for (let i = 0; i < walls.length; i++) {
      planes.push(walls[i].get_normal_plane())
    }

    const collision_points = []
    let bounce_count = 2
    const ray = new Ray(origin.clone(), dir.clone())

    while (bounce_count > 0) {
      bounce_count--
      const intersection = this.get_intersection(ray, planes)

      if (intersection.point) {
        collision_points.push(intersection.point.clone())
        const new_dir = ray.direction.clone().reflect(intersection.normal)
        ray.origin.copy(intersection.point)
        ray.origin.add(intersection.normal.clone().multiplyScalar(0.001))
        ray.direction.copy(new_dir)
      }
    }

    return collision_points
  }

  get_intersection(ray, planes) {
    const intersections = []

    for (let i = 0; i < planes.length; i++) {
      const intersection = ray.intersectPlane(planes[i], new Vector3())

      if (intersection) {
        intersections.push({
          point: intersection,
          normal: planes[i].normal,
        })
      }
    }

    let closest_intersection = intersections[0]

    for (let i = 1; i < intersections.length; i++) {
      if (
        intersections[i].point.distanceTo(ray.origin) <
        closest_intersection.point.distanceTo(ray.origin)
      ) {
        closest_intersection = intersections[i]
      }
    }

    return closest_intersection
  }
}

class $bb8ab07f02b5040e9bba782b47afbbd$export$default {
  constructor(entity_size = 1, max_allocations = 100) {
    this.max_allocations = max_allocations
    this.entity_size = entity_size
    const geo = new SphereBufferGeometry()
    const mat = new MeshBasicMaterial({
      color: 0x00FF00,
    })
    this.mesh = new InstancedMesh(geo, mat, this.max_allocations)
    this.mesh.instanceMatrix.usage = DynamicDrawUsage
    SceneManager.current.add(this.mesh)
  }

  draw_array(entities) {
    if (entities.length > this.max_allocations) {
      console.error(
        'draw_array -- Exceeded maximum pre allocations',
        this.max_allocations,
        entities.length
      )
      return
    }

    const mat = new Matrix4()
    mat.makeScale(this.entity_size, this.entity_size, this.entity_size)

    for (let i = 0; i < entities.length; i++) {
      mat.setPosition(entities[i].position)
      this.mesh.setMatrixAt(i, mat)
    }

    this.mesh.count = entities.length
    this.mesh.instanceMatrix.needsUpdate = true
  }

  draw_point_array(points) {
    if (points.length > this.max_allocations) {
      console.error(
        'draw_point_array -- Exceeded maximum pre allocations',
        this.max_allocations,
        points.length
      )
      return
    }

    const mat = new Matrix4()
    mat.makeScale(this.entity_size, this.entity_size, this.entity_size)

    for (let i = 0; i < points.length; i++) {
      mat.setPosition(points[i])
      this.mesh.setMatrixAt(i, mat)
    }

    this.mesh.count = points.length
    this.mesh.instanceMatrix.needsUpdate = true
  }

  set_color(col) {
    this.mesh.material.color.set(col)
  }

  set_size(value) {
    this.entity_size = value
  }

  show(boolean) {
    this.mesh.visible = boolean
  }

  dispose() {
    SceneManager.current.remove(this.mesh)
    this.mesh.geometry.dispose()
    this.mesh.material.dispose()
  }
}

class $a16788ec351f200743c866627a4bae7$export$default extends $bb8ab07f02b5040e9bba782b47afbbd$export$default {
  constructor(size = 1, color = '#FF0000') {
    super(size, 200)
    this.set_color(color)
  }
}

class $e9dbb159ee3fe8c38e95395ae101d60$export$default {
  constructor() {
    this.total_available = 50
    this.ball_array_drawer =
      new $a16788ec351f200743c866627a4bae7$export$default(0.1, '#bf5fff')
  }

  show(boolean) {
    this.ball_array_drawer.show(boolean)
  }

  draw(points, resample_count) {
    resample_count = resample_count || this.total_available // let catmull = new CatmullRomCurve3(points);
    // let curve_length = catmull.getLength();

    const new_points = []
    const dist = points[0].distanceTo(points[1])
    const separation_distance = 0.4
    const point_count = dist / separation_distance

    for (let i = 0; i < point_count; i++) {
      const p0 = points[0].clone()
      const pos = p0.clone().lerp(points[1], i / (point_count - 1))
      pos.z = 3
      new_points.push(pos)
    }

    const dir = points[2].clone().sub(points[1]).normalize()

    for (let i = 0; i < 7; i++) {
      const p0 = points[1].clone()
      const pos = p0.add(dir.clone().multiplyScalar(i * separation_distance))
      pos.z = 3
      new_points.push(pos)
    }

    this.ball_array_drawer.draw_point_array(new_points)
  }

  dispose() {
    this.ball_array_drawer.dispose()
  }
}

class $fb2c99c9cf2eb3edc00a25ebb3195ab$export$default {
  constructor() {}

  update() {}

  get position() {
    return new Vector3()
  }

  dispose() {}
}

class $bf5de6c52db1dae76db33cf317e80e$export$default extends $fb2c99c9cf2eb3edc00a25ebb3195ab$export$default {
  constructor(game_ball) {
    super()
    this.game_ball = game_ball // this.ball = Debug.draw_sphere(undefined, game_ball.get_size());
    // this.ball.visible = false;
    // let pos = this.game_ball.get_immediate_position();
    // this.ball.position.set(pos.x, pos.y, 0);
  }

  update() {
    // this.ball.position.copy(this.get_position());
  }

  get position() {
    const pos = this.game_ball.get_position()
    return new Vector3(pos.x, pos.y, 0)
  }

  get id() {
    return this.game_ball.id
  }

  dispose() {
    // this.ball.material.dispose();
    // this.ball.geometry.dispose();
    // SceneManager.current.remove(ball.ball);
  }
}

class $ff879b7613681d9865f18b3a4e84e422$var$Configuration {
  constructor() {
    this.wall_thickness = 0.025 // this.api_url = 'http://localhost:3000/';
    // this.api_url = 'https://redsix-game-server.herokuapp.com/';
  }
}

const $ff879b7613681d9865f18b3a4e84e422$export$default =
  new $ff879b7613681d9865f18b3a4e84e422$var$Configuration()

class $a8b904b440ddb7e5569e90e81e7$export$default {
  constructor(game_wall) {
    this.game_wall = game_wall
    this.wall = Debug.draw_cube(undefined, undefined, game_wall.color)
    const board_width = game_wall.board_width
    const board_height = game_wall.board_height
    const thickness =
      $ff879b7613681d9865f18b3a4e84e422$export$default.wall_thickness
    let width = 1
    let height = 1

    switch (game_wall.side) {
      case 'bottom':
        width = board_width + thickness * 2
        height = thickness
        break

      case 'left':
        width = thickness
        height = board_height
        break

      case 'right':
        width = thickness
        height = board_height
        break

      case 'top':
        width = board_width + thickness * 2
        height = thickness
        break
    }

    this.wall.scale.x = width
    this.wall.scale.y = height
    const wall_pos = this.game_wall.get_position()
    this.wall.position.set(wall_pos.x, wall_pos.y, 0)
    this.wall.updateMatrixWorld()
  }

  update() {}

  get id() {
    return this.game_wall.id
  }

  dispose() {
    this.wall.material.dispose()
    this.wall.geometry.dispose()
  }

  get_normal_plane() {
    const normal_dir = this.game_wall.get_normal()
    const center = this.game_wall.get_center()
    return new Plane().setFromNormalAndCoplanarPoint(
      new Vector3(normal_dir.x, normal_dir.y, 0),
      new Vector3(center.x, center.y, 0)
    )
  }
}

// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/shaders/block/block.frag
let $a199002a56156c7f9bee9ffabf3dabd6$exports = {}
$a199002a56156c7f9bee9ffabf3dabd6$exports =
  '#define GLSLIFY 1\nuniform sampler2D _MainTex;\nuniform float _Emission;\n\nvarying vec2 vUv;\n\nvoid main()\n{\n  vec4 col = texture2D(_MainTex, vUv);\n\n  gl_FragColor = col; \n  gl_FragColor.rgb = mix(col.rgb, vec3(1.0), _Emission);\n}'
// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/shaders/block/block.vert
let $fc75fffc7a940860aee61ff079b6c90$exports = {}
$fc75fffc7a940860aee61ff079b6c90$exports =
  '#define GLSLIFY 1\nvarying vec2 vUv;\n\nvoid main()\n{\n  gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);\n\n  vUv = uv;\n}'
const $fc75fffc7a940860aee61ff079b6c90$$interop$default =
  $parcel$interopDefault($fc75fffc7a940860aee61ff079b6c90$exports)
const $a199002a56156c7f9bee9ffabf3dabd6$$interop$default =
  $parcel$interopDefault($a199002a56156c7f9bee9ffabf3dabd6$exports)

class $db99185b917e4a2c189aae20bd3$export$default extends BaseShaderMaterial {
  constructor() {
    super(
      $fc75fffc7a940860aee61ff079b6c90$$interop$default,
      $a199002a56156c7f9bee9ffabf3dabd6$$interop$default,
      {
        _MainTex: {
          value: undefined,
        },
        _Emission: {
          value: 0,
        },
      }
    )
    this.transparent = true
    this.depthWrite = false
  }

  set_texture(tex) {
    this.uniforms._MainTex.value = tex
  }

  set_emission(val) {
    this.uniforms._Emission.value = val
  }
}

class $ae8db583dd4e3fb86ef40f5ffd0182$export$default {
  constructor(game_block, color, image, text_element) {
    this.game_block = game_block
    this.block = Debug.draw_cube(undefined, undefined, '#FFFFFF')
    this.block.material = new $db99185b917e4a2c189aae20bd3$export$default()
    this.block.material.set_texture(ResourceContainer.get(image))
    this.block.scale.x = game_block.get_size().x
    this.block.scale.y = game_block.get_size().y
    const pos = this.game_block.get_immediate_position()
    this.block.position.set(pos.x, pos.y, 0)
    this.current_hp = game_block.current_hp // this.hp_label = new Text2D(game_block.current_hp, '40px Arial', '#FFFFFF');

    this.hp_label = text_element
    this.hp_label.set_position(new Vector3(pos.x, pos.y, 0))
    this.hp_label.set_size(0.5)
    this.hp_label.text = this.current_hp + '' // this.block.add(this.hp_label);

    this.block.updateMatrixWorld() // this.hp_label.updateMatrixWorld();

    this.hit_animation_time = 0
  }

  update() {
    const pos = this.game_block.get_immediate_position()
    this.block.position.set(pos.x, pos.y, 0)

    if (this.current_hp !== this.game_block.current_hp) {
      this.current_hp = this.game_block.current_hp
      this.hp_label.text = this.current_hp + ''
    }

    this.block.material.set_emission(this.hit_animation_time)
    this.hit_animation_time -= Time.delta_time * 10
    this.hit_animation_time = Math.max(0, this.hit_animation_time)
  }

  update_position() {
    this.block.updateMatrixWorld()
  }

  update_image() {
    this.block.material.map = ResourceContainer.get(this.game_block.color_image)
  }

  get_position() {
    return this.block.position.clone()
  }

  get id() {
    return this.game_block.id
  }

  dispose() {
    this.block.material.dispose()
    this.block.geometry.dispose() // this.hp_label.dispose();
  }

  show(bool) {
    this.block.visible = bool
  }

  hit() {
    if (this.hit_animation_time < 0.01) {
      this.hit_animation_time = 1
    }
  }
}

class $e752c73555c3323de63adf84e9$export$default {
  constructor() {
    this.balls = []
    this.blocks = []
    this.walls = []
    this.ball_array_drawer =
      new $a16788ec351f200743c866627a4bae7$export$default(0.1)
    this.text_batch = undefined
  }

  init() {
    this.text_batch = new SDFTextBatch(
      ResourceContainer.get('font_layout'),
      ResourceContainer.get('font_atlas')
    )
    SceneManager.current.add(this.text_batch)
    this.text_batch.renderOrder = 500
  }

  update() {
    this.text_batch.update()

    for (let i = 0; i < this.balls.length; i++) {
      this.balls[i].update()
    }

    for (let i = 0; i < this.blocks.length; i++) {
      this.blocks[i].update()
    }

    for (let i = 0; i < this.walls.length; i++) {
      this.walls[i].update()
    }

    this.ball_array_drawer.draw_array(this.balls)
  }

  create_ball(game_ball) {
    this.balls.push(
      new $bf5de6c52db1dae76db33cf317e80e$export$default(game_ball)
    )
  }

  create_block(game_block) {
    const text_element = this.text_batch.add_text('0')
    this.blocks.push(
      new $ae8db583dd4e3fb86ef40f5ffd0182$export$default(
        game_block,
        game_block.color,
        game_block.color_image,
        text_element
      )
    )
  }

  create_wall(game_wall) {
    this.walls.push(new $a8b904b440ddb7e5569e90e81e7$export$default(game_wall))
  }

  remove_ball(game_ball) {
    const ball = this.find_renderable_ball(game_ball)

    if (ball === undefined) {
      console.error('cannot remove non-existent renderable ball.', game_ball)
    } else {
      ball.dispose()
      ArrayUtilities.remove_elem(this.balls, ball)
    }
  }

  remove_block(game_block) {
    const block = this.find_renderable_block(game_block)

    if (block === undefined) {
      console.error('cannot remove non-existent renderable block.', game_block)
    } else {
      block.dispose()
      ArrayUtilities.remove_elem(this.blocks, block)
      this.text_batch.remove_text(block.hp_label)
      SceneManager.current.remove(block.block)
    }
  }

  remove_wall(game_wall) {
    const wall = this.find_renderable_wall(game_wall)

    if (wall === undefined) {
      console.error('cannot remove non-existent renderable wall.', game_wall)
    } else {
      wall.dispose()
      ArrayUtilities.remove_elem(this.walls, wall)
      SceneManager.current.remove(wall.wall)
    }
  }

  find_renderable_ball(game_ball) {
    for (let i = 0; i < this.balls.length; i++) {
      if (this.balls[i].game_ball === game_ball) {
        return this.balls[i]
      }
    }

    return undefined
  }

  find_renderable_block(game_block) {
    for (let i = 0; i < this.blocks.length; i++) {
      if (this.blocks[i].game_block === game_block) {
        return this.blocks[i]
      }
    }

    return undefined
  }

  find_renderable_wall(game_wall) {
    for (let i = 0; i < this.walls.length; i++) {
      if (this.walls[i].game_wall === game_wall) {
        return this.walls[i]
      }
    }

    return undefined
  }

  dispose() {
    this.ball_array_drawer.dispose()
    this.text_batch.dispose()
    SceneManager.current.remove(this.text_batch)
  }
}

// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/shaders/gradient/gradient.frag
let $b4830a97f7cf90fff621473769804dc$exports = {}
$b4830a97f7cf90fff621473769804dc$exports =
  '#define GLSLIFY 1\nuniform vec3 _Col1;\nuniform vec3 _Col2;\nuniform vec2 _Screen;\nuniform sampler2D _BlueNoise;\n\nvarying vec2 vUv;\nvarying vec4 vProjPos;\n\nvec3 pow_v3(vec3 v, float p)\n{\n  return vec3(pow(v.x, p),pow(v.y, p),pow(v.z, p));\n}\n\nvoid main()\n{\n  vec2 screen_pos = vProjPos.xy / vProjPos.w;\n  screen_pos.x = screen_pos.x * 0.5 + 0.5;\n  screen_pos.y = screen_pos.y * 0.5 + 0.5;\n\n  vec2 noise_size = vec2(_Screen.x/64.0, _Screen.y/64.0);\n\n  vec2 noise_uv = vec2(fract(screen_pos.x * noise_size.x), fract(screen_pos.y * noise_size.y));\n  float noise = texture2D(_BlueNoise, noise_uv).r/255.0;\n\n  vec3 col1 = pow_v3(_Col1, 2.2);\n  vec3 col2 = pow_v3(_Col2, 2.2);\n\n  vec3 col = pow_v3(mix(col1, col2, vUv.y), 0.4545);\n\n  gl_FragColor = vec4(col + vec3(noise), 1.0); \n\n}'
// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/shaders/gradient/gradient.vert
let $c27e9b9e0bdab27a1a114df73a7cfd81$exports = {}
$c27e9b9e0bdab27a1a114df73a7cfd81$exports =
  '#define GLSLIFY 1\nvarying vec2 vUv;\nvarying vec4 vProjPos;\n\nvoid main()\n{\n  gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);\n\n  vUv = uv;\n\n  vProjPos = gl_Position;\n}'
const $c27e9b9e0bdab27a1a114df73a7cfd81$$interop$default =
  $parcel$interopDefault($c27e9b9e0bdab27a1a114df73a7cfd81$exports)
const $b4830a97f7cf90fff621473769804dc$$interop$default =
  $parcel$interopDefault($b4830a97f7cf90fff621473769804dc$exports)

class $afca602b2ff40b402e0c70d517e52703$export$default extends BaseShaderMaterial {
  constructor() {
    super(
      $c27e9b9e0bdab27a1a114df73a7cfd81$$interop$default,
      $b4830a97f7cf90fff621473769804dc$$interop$default,
      {
        _Col1: {
          value: new Color('#2A2B2C'),
        },
        _Col2: {
          value: new Color('#08090D'),
        },
        _BlueNoise: {
          value: ResourceContainer.get('blue_noise'),
        },
        _Screen: {
          value: new Vector2(Screen.width, Screen.height),
        },
      }
    )
  }
}

class $c6279a6a66ad33e41fa9ebdc6da9ee8f$export$default extends Mesh {
  constructor() {
    super(
      new PlaneBufferGeometry(),
      new $afca602b2ff40b402e0c70d517e52703$export$default()
    )
  }

  dispose() {
    this.geometry.dispose()
    this.material.dispose()
  }
}

const $cd3954c1f6daa465a4087f7301$$interop$default = $parcel$interopDefault(
  $cd3954c1f6daa465a4087f7301$exports
)

class $cd10cabb5963c27a5d2696a76a0e6574$export$default extends $cfb2277e624a264ce0a58ec$export$default {
  constructor(player_view) {
    super()
    this.game = new $cd3954c1f6daa465a4087f7301$$interop$default(
      new $c0b4a3fbc0bb081afa06457ec6f0b87$export$default(this)
    )
    this.game_renderer = new $e752c73555c3323de63adf84e9$export$default()
    this.line_tracer = new $ef090c0ee6346f6e47c78a6ff1$export$default()
    this.point_array_drawer =
      new $e9dbb159ee3fe8c38e95395ae101d60$export$default()
    this.firing_sphere = Debug.draw_sphere(undefined, 0.05, 0x00FF00)
    this.firing_point = new Vector2()
    this.current_level_descriptor = undefined
    this.gradient = new $c6279a6a66ad33e41fa9ebdc6da9ee8f$export$default()
    this.camera_drag_cooldown = 0
    this.player_view = player_view
    this.time_scale_strength = 0
    this.start_cooldown = 0.5
    this.current_state = new $b48491d920d149104e0d05e7ef0f04$export$default()
  }

  set_state(new_state) {
    // console.log("new state", new_state.constructor.name);
    this.current_state.on_exit(this)
    this.current_state = new_state
    this.current_state.on_enter(this)
  }

  update() {
    this.start_cooldown -= Time.delta_time

    if (this.player_view.is_prepare_to_play_view_showing) {
      this.start_cooldown = 0.5
      return
    }

    if (TouchInput.touches === 2) {
      this.camera_drag_cooldown = 0.5
    }

    this.game_renderer.update()
    const mouse = new Vector3(Input.NDC.x, Input.NDC.y, 0).unproject(
      CameraManager.current
    )
    const firing_dir = new Vector2(
      mouse.x - this.firing_point.x,
      mouse.y - this.firing_point.y
    ).normalize()

    if (
      Input.left_mouse_button_down &&
      this.game.can_fire() &&
      this.camera_drag_cooldown < 0.01
    ) {
      const start_point = new Vector3(
        this.firing_point.x,
        this.firing_point.y,
        0
      )
      const clamped_firing_dir =
        this.game.get_clamped_firing_direction(firing_dir)
      const points = this.line_tracer.trace(
        start_point,
        new Vector3(clamped_firing_dir.x, clamped_firing_dir.y, 0),
        this.game_renderer.walls
      )
      points.unshift(start_point)
      this.point_array_drawer.draw(points)
      this.point_array_drawer.show(true)
    } else {
      this.point_array_drawer.show(false)
    }

    if (
      Input.left_mouse_button_released &&
      this.camera_drag_cooldown < 0.01 &&
      this.start_cooldown < 0 &&
      this.game.can_fire()
    ) {
      this.fire(firing_dir)
    }

    this.time_scale_strength +=
      Time.delta_time * (this.player_view.speed_up === true ? 1 : -1)
    this.time_scale_strength = _Math.clamp(this.time_scale_strength, 0, 1)
    this.game.update(
      Time.delta_time,
      _Math.lerp(1, 2, this.time_scale_strength)
    )
    this.camera_drag_cooldown -= Time.delta_time
    this.camera_drag_cooldown = Math.max(this.camera_drag_cooldown, 0)
    this.current_state.update(this)
  }

  is_mouse_within_bounds() {
    return (
      Input.uNDC.x > -1 &&
      Input.uNDC.x < 1 &&
      Input.uNDC.y > -1 &&
      Input.uNDC.y < 1
    )
  }

  on_enter() {
    SceneManager.current.add(this.gradient)
    this.game_renderer.init()
  }

  on_exit() {
    SceneManager.current.remove(this.gradient)
    this.dispose()
  }

  update_view() {
    const player_view = this.player_view
    const game = this.game

    for (let i = 0; i < game.scores.length; i++) {
      if (i === game.times_played) {
        player_view.set_score(i, game.current_points, game.elapsed_time)
      } else {
        player_view.set_score(i, game.scores[i].points, game.scores[i].time)
      }
    }

    player_view.set_remaining_attempts(game.remaining_attempts)
  }

  fire(firing_dir) {
    this.game.fire_balls(firing_dir)
  }

  init_level(level_descriptor) {
    this.set_state(
      new $e6facc738b0114a29dec47fca3b201c5$export$default(level_descriptor)
    )
  }

  set_level_descriptor(level_descriptor) {
    this.game.import_state(level_descriptor)
    this.firing_point.copy(
      new Vector2(this.game.firing_position.x, this.game.firing_position.y)
    )
    this.firing_sphere.position.x = this.firing_point.x
    this.firing_sphere.position.y = this.firing_point.y
    this.game_renderer.ball_array_drawer.set_color(level_descriptor.ball_color)
    this.game_renderer.ball_array_drawer.set_size(level_descriptor.ball_radius)
    this.firing_sphere.updateMatrixWorld()
    this.current_level_descriptor = level_descriptor
    this.gradient.scale.x = level_descriptor.board_width
    this.gradient.scale.y = level_descriptor.board_height
    this.gradient.position.x = level_descriptor.board_width / 2
    this.gradient.position.y = level_descriptor.board_height / 2
    this.gradient.position.z = -2
    this.gradient.updateMatrixWorld()
    this.player_view.setup_scores(this.game.scores)
  }

  export_level() {
    return this.game.export_state()
  }

  create_ball(game_ball) {
    this.game_renderer.create_ball(game_ball)
  }

  create_block(game_block) {
    this.game_renderer.create_block(game_block)
  }

  create_wall(game_wall) {
    this.game_renderer.create_wall(game_wall)
  }

  remove_ball(game_ball) {
    this.game_renderer.remove_ball(game_ball)
  }

  remove_block(game_block) {
    this.game_renderer.remove_block(game_block)
  }

  remove_wall(game_wall) {
    this.game_renderer.remove_wall(game_wall)
  }

  turn_ended(turn_number) {
    this.set_state(new $f87dde42ffe0e4b1bdaae32e639c9$export$default())
  }

  game_over() {
    this.set_state(new $b224c8a1c853d67c8b426a5679362bd2$export$default())
  }

  dispose() {
    this.game.dispose()
    this.game_renderer.dispose()
    this.point_array_drawer.dispose()
    SceneManager.current.remove(this.firing_sphere)
    this.firing_sphere.geometry.dispose()
    this.firing_sphere.material.dispose()
    this.gradient.dispose()
  }
}

// ASSET: /Users/fedegratti/Projects/ohzi/red6six-game/app/js/components/TestGameListener.js
let $c1fc7f677834f9bde79a0ad47fd859e9$exports = {}

class $c1fc7f677834f9bde79a0ad47fd859e9$var$TestGameListener {
  constructor() {
    this.balls_cleared = false
    this.game_over = false
  }

  on_block_destroyed(game_block) {
    // console.log("on_block_destroyed");
  }

  on_ball_destroyed(game_ball) {
    // console.log("on_ball_destroyed");
  }

  on_wall_destroyed(wall) {}

  on_block_created(game_block) {}

  on_ball_created(game_ball) {
    // console.log("on_ball_created");
  }

  on_wall_created(wall) {}

  on_turn_ended() {
    this.balls_cleared = true
  }

  on_game_over() {
    this.game_over = true
  }

  on_block_hit() {}
}

$c1fc7f677834f9bde79a0ad47fd859e9$exports =
  $c1fc7f677834f9bde79a0ad47fd859e9$var$TestGameListener
const $c1fc7f677834f9bde79a0ad47fd859e9$$interop$default =
  $parcel$interopDefault($c1fc7f677834f9bde79a0ad47fd859e9$exports)

class $ab03a0e9252d3d0656566105c97c220$export$default {
  constructor() {}

  on_enter() {}

  on_exit() {}

  update() {}

  turn_ended() {}

  fire(firing_dir) {}

  init_level(level_descriptor) {
    const game_listener =
      new $c1fc7f677834f9bde79a0ad47fd859e9$$interop$default()
    let game = new $cd3954c1f6daa465a4087f7301$$interop$default(game_listener)
    game.import_state(level_descriptor)
    game.start()
    const state = JSON.stringify(game.export_state())
    console.log(JSON.parse(state))
    setTimeout(() => {
      game = new $cd3954c1f6daa465a4087f7301$$interop$default(game_listener)
      game.import_state(JSON.parse(state))
      const clamped_firing_dir = game.get_clamped_firing_direction({
        x: 0,
        y: 1,
      })
      console.log('start')

      if (game.can_fire()) {
        game.fire_balls(clamped_firing_dir)

        while (
          game_listener.balls_cleared === false &&
          game_listener.game_over === false
        ) {
          game.update(0.016666, 4)
        }
      }

      console.log('done')
    }, 1000)
  }
}

class $af949736f0b948ab82b6f03ed47c69$export$default extends $a0449278cf77c032bb502615a80934$export$default {
  constructor() {
    super()
  }

  on_enter(networked_level_player) {
    super.on_enter(networked_level_player) // console.log("NETWORK START");

    $a47b39a1f68b769584aa5500ce61083b$export$default.game_started()
  }
}

class $eba838696ee19021e08bd9955f67a1ec$export$default extends $f87dde42ffe0e4b1bdaae32e639c9$export$default {
  constructor() {
    super()
  }

  next_state() {
    return new $af949736f0b948ab82b6f03ed47c69$export$default()
  }
}

class $c99c0e8b197573f1fe23cab137$export$default extends $e6facc738b0114a29dec47fca3b201c5$export$default {
  constructor() {
    super()
    this.level_descriptor = undefined
  }

  on_enter(networked_level_player) {
    this.start_loading(networked_level_player)
  }

  start_loading(networked_level_player) {
    const self = this
    $a47b39a1f68b769584aa5500ce61083b$export$default.load_level_descriptor(
      (level_descriptor) => {
        networked_level_player.set_level_descriptor(level_descriptor)
        self.set_next_state(networked_level_player)
      }
    )
  }

  go_to_game_started(networked_level_player) {
    networked_level_player.set_state(
      new $af949736f0b948ab82b6f03ed47c69$export$default()
    )
  }

  go_to_waiting_for_start(networked_level_player) {
    networked_level_player.set_state(
      new $eba838696ee19021e08bd9955f67a1ec$export$default()
    )
  }
}

class $a52696df17fd399c238dbb25fb04b99b$export$default extends $cd10cabb5963c27a5d2696a76a0e6574$export$default {
  constructor(player_view) {
    super(player_view)
    this.current_state = new $c25284f8f5b5bcd8c343ad5c8d8$export$default()
  }

  turn_ended(turn_number) {
    this.set_state(new $eba838696ee19021e08bd9955f67a1ec$export$default())
    $a47b39a1f68b769584aa5500ce61083b$export$default.validate_score(
      turn_number,
      this.game.scores[turn_number].points,
      this.game.scores[turn_number].time
    )
  }

  fire(firing_dir) {
    super.fire(firing_dir)
    $a47b39a1f68b769584aa5500ce61083b$export$default.shoot(firing_dir)
  }

  init_level() {
    this.set_state(new $c99c0e8b197573f1fe23cab137$export$default())
  }
}

class $d6374b59454f8ed79a46986abd7ee14a$export$default extends $abc41a388d5324483742198167aaa2$export$default {
  constructor(editor_context) {
    super()
    this.editor_context = editor_context
  }

  on_block_created(game_block) {
    this.editor_context.create_block(game_block)
  }

  on_block_destroyed(game_block) {
    this.editor_context.remove_block(game_block)
  }

  on_wall_created(wall) {
    this.editor_context.create_wall(wall)
  }

  on_wall_destroyed(wall) {
    this.editor_context.remove_wall(wall)
  }
}

class $c5d515c847a1b1d5e42778a8813b19d$export$default extends $cfb2277e624a264ce0a58ec$export$default {
  constructor() {
    super()
    this.level_descriptor = undefined
    this.game_renderer = new $e752c73555c3323de63adf84e9$export$default()
    this.game = new $cd3954c1f6daa465a4087f7301$$interop$default(
      new $d6374b59454f8ed79a46986abd7ee14a$export$default(this)
    )
    this.mock_block = undefined
    this.renderable_mock_block = undefined
    this.gradient = new $c6279a6a66ad33e41fa9ebdc6da9ee8f$export$default()
  }

  on_exit() {
    window.current_level_descriptor = this.export_level()
    SceneManager.current.remove(this.gradient)
    this.dispose()
  }

  on_enter() {
    SceneManager.current.add(this.gradient)
    this.game_renderer.init()
  }

  init_level(level_descriptor) {
    this.dispose()
    this.level_descriptor = level_descriptor
    this.game.import_state(this.get_editor_level_descriptor(level_descriptor))
    const block_thickness = level_descriptor.ball_radius * 2
    this.mock_block = new $a76a04770cece6e1e4f3ef622b508$export$default(
      this.game.world
    ).build_block(
      {
        id: -1,
        x: 0,
        y: 0,
        color_image: 'blue',
        total_hp: 1,
      },
      block_thickness
    )
    this.game.context.add_block(this.mock_block)
    this.renderable_mock_block =
      this.game_renderer.blocks[this.game_renderer.blocks.length - 1]
    this.gradient.scale.x = level_descriptor.board_width
    this.gradient.scale.y = level_descriptor.board_height
    this.gradient.position.x = level_descriptor.board_width / 2
    this.gradient.position.y = level_descriptor.board_height / 2
    this.gradient.position.z = -2
    this.gradient.updateMatrixWorld()
  }

  export_level() {
    // let blocks = [];
    // for(let i=0; i< this.game.blocks.length; i++)
    // {
    //   let block = this.game.blocks[i];
    //   if(block.id !== -1)
    //   {
    //     blocks.push({
    //       id: block.id,
    //       x: block.get_position().x,
    //       y: block.get_position().y,
    //       color_image: block.color_image,
    //       hp: block.total_hp
    //     });
    //   }
    // }
    const blocks = this.game.export_blocks()
    const level_descriptor = {
      total_attempts: this.level_descriptor.total_attempts,
      ball_radius: this.level_descriptor.ball_radius,
      ball_color: this.level_descriptor.ball_color,
      wall_color: this.level_descriptor.wall_color,
      board_width: this.level_descriptor.board_width,
      board_height: this.level_descriptor.board_height,
      blocks,
      last_generated_id: this.level_descriptor.last_generated_id,
    }
    return level_descriptor
  }

  get_editor_level_descriptor(main_level_descriptor) {
    const level_descriptor = {
      ball_radius: main_level_descriptor.ball_radius,
      ball_color: main_level_descriptor.ball_color,
      wall_color: '#FFFF00',
      board_width: main_level_descriptor.board_width,
      board_height: main_level_descriptor.board_height,
      blocks: main_level_descriptor.blocks,
      last_generated_id: this.level_descriptor.last_generated_id,
    }
    return level_descriptor
  }

  update() {
    this.game.update(Time.delta_time)
    this.game_renderer.update()
    const mouse = new Vector3(Input.NDC.x, Input.NDC.y, 0).unproject(
      CameraManager.current
    )
    const position = new Vector2(
      Math.floor(mouse.x) + 0.5,
      Math.floor(mouse.y) + 0.5
    )
    const is_point_widthin_bounds = this.point_is_within_bounds(
      position.x,
      position.y
    )
    const is_point_over_a_block = this.point_is_over_a_block(
      position.x,
      position.y
    )
    this.set_mock_block_visibility(
      is_point_widthin_bounds,
      is_point_over_a_block
    )
    this.set_mock_block_hp()
    this.mock_block.set_position(position.x, position.y)
    this.renderable_mock_block.update_position()

    if (Input.left_mouse_button_pressed && is_point_widthin_bounds) {
      if (is_point_over_a_block) {
        this.destroy_nearest_block(position.x, position.y)
      } else {
        this.create_game_block(
          position.x,
          position.y,
          this.mock_block.color_image,
          this.mock_block.total_hp
        )
      }
    }

    if (window.editor_settings.block_color !== this.mock_block.color_image) {
      this.mock_block.color_image = window.editor_settings.block_color
      this.renderable_mock_block.update_image()
    }
  }

  set_mock_block_visibility(is_widthin_bounds, is_over_a_block) {
    if (is_widthin_bounds && !is_over_a_block) {
      this.renderable_mock_block.show(true)
    } else {
      this.renderable_mock_block.show(false)
    }
  }

  set_mock_block_hp() {
    if (this.mock_block.total_hp !== window.editor_settings.block_hp) {
      this.mock_block.total_hp = window.editor_settings.block_hp
      this.mock_block.current_hp = window.editor_settings.block_hp
    }
  }

  point_is_within_bounds(x, y) {
    if (
      MathUtilities.between(x, 0, this.level_descriptor.board_width) &&
      MathUtilities.between(y, 0, this.level_descriptor.board_height)
    ) {
      return true
    }

    return false
  }

  point_is_over_a_block(x, y) {
    const ref_pos = new Vector3(x, y, 0)

    for (let i = 0; i < this.game_renderer.blocks.length; i++) {
      const b = this.game_renderer.blocks[i]

      if (b !== this.renderable_mock_block) {
        if (b.get_position().distanceTo(ref_pos) < 0.1) {
          return true
        }
      }
    }

    return false
  }

  destroy_nearest_block(x, y) {
    const ref_pos = new Vector3(x, y, 0)

    for (let i = 0; i < this.game_renderer.blocks.length; i++) {
      const b = this.game_renderer.blocks[i]

      if (b !== this.renderable_mock_block) {
        if (b.get_position().distanceTo(ref_pos) < 0.1) {
          this.game.context.remove_block(b.game_block)
          return
        }
      }
    }
  }

  create_game_block(x, y, color_image = 'blue', total_hp = 1) {
    const block_thickness = this.level_descriptor.ball_radius * 2
    const block = new $a76a04770cece6e1e4f3ef622b508$export$default(
      this.game.world
    ).build_block(
      {
        id: this.level_descriptor.last_generated_id + 1,
        x,
        y,
        total_hp,
        color_image,
        points_per_hit: 10,
        points_per_destruction: 25,
      },
      block_thickness
    )
    this.level_descriptor.last_generated_id++
    this.game.context.add_block(block)
  }

  create_ball(game_ball) {
    this.game_renderer.create_ball(game_ball)
  }

  create_block(game_block) {
    this.game_renderer.create_block(game_block)
  }

  create_wall(game_wall) {
    this.game_renderer.create_wall(game_wall)
  }

  remove_ball(game_ball) {
    this.game_renderer.remove_ball(game_ball)
  }

  remove_block(game_block) {
    this.game_renderer.remove_block(game_block)
  }

  remove_wall(game_wall) {
    this.game_renderer.remove_wall(game_wall)
  }

  dispose() {
    this.game.dispose()
    this.game_renderer.dispose()
  }
}

class $f3a324c807c98acbf0952b9675$export$default extends $cbea740ada5053a558f611980f96c698$export$default {
  start(end_game_view) {
    super.start('playing', document.querySelector('.playing'))
    this.end_game_view = end_game_view
    this.score = 0
    this.shot_time = 0
    this.best_shot = 0
    this.speed_up_el = document.querySelector('.playing__speed-up')
    this.speed_up_rect = this.speed_up_el.getBoundingClientRect()
    this.speed_up = false
    this.remaining_attempts_el = document.querySelector(
      '.playing__remaining-attempts'
    )
    this.start_playing_el = document.querySelector('.shooting-ended')
    this.continue_button = document.querySelector('.shooting-ended__continue')
    this.scores_container = document.querySelector('.playing__shoots')
    this.score_template = document.querySelector('.playing__shoot') // this.start_playing_el.addEventListener('mousedown', this.on_shooting_ended_mouse_down.bind(this), false);

    this.continue_button.addEventListener(
      'mouseup',
      this.close_shooting_ended_message.bind(this),
      false
    )
  }

  setup_scores(scores) {
    this.scores_container.innerHTML = ''

    for (let i = 0; i < scores.length; i++) {
      const score_container = this.score_template.cloneNode(true)
      score_container.classList.add('playing__shoot--'.concat(i))
      this.set_shoot_score(score_container, i, scores[i].points, scores[i].time)
      this.scores_container.append(score_container)
    } // console.log("SETUP", scores);
  }

  get is_prepare_to_play_view_showing() {
    return !this.start_playing_el.classList.contains('hidden')
  }

  set_remaining_attempts(remaining_attempts) {
    this.remaining_attempts_el.textContent = remaining_attempts
  }

  set_score(score_index, points, time) {
    // console.log("SET SCORE", score_index, points, time);
    const score_container = document.querySelector(
      '.playing__shoot--'.concat(score_index)
    )
    this.set_shoot_score(score_container, score_index, points, time)
    this.set_final_score(points, time, score_index)
  }

  set_final_score(points, time, shot) {
    if (points > this.score) {
      this.score = points
      this.best_shot = shot
    } else if (points === this.score) {
      if (time < this.shot_time) {
        this.score = points
        this.best_shot = shot
      }
    }

    if (shot === this.best_shot) {
      this.shot_time = time
    }
  }

  restart_scores() {
    this.score = 0
    this.best_shot = 0
    this.shot_time = 0
  }

  set_shoot_score(score_container, index, points, time) {
    // console.log(score_container, index, points, time)
    score_container.querySelector('.playing__shoot-number').textContent =
      'Shoot '.concat(index + 1, ': ')
    score_container.querySelector('.playing__shoot-score').textContent = points
    score_container.querySelector('.playing__shoot-timer-time').textContent =
      time.toFixed(2)
  }

  show_start_playing_popup(boolean) {
    if (boolean) {
      this.start_playing_el.classList.remove('hidden')
    } else {
      this.start_playing_el.classList.add('hidden')
    }
  }

  close_shooting_ended_message() {
    this.start_playing_el.classList.add('hidden')
  }

  update() {
    this.speed_up = false

    if (
      Input.left_mouse_button_down &&
      Input.mouse_is_within_bounds(this.speed_up_rect)
    ) {
      this.speed_up = true
    }
  }

  game_over() {
    this.end_game_view.set_score(this.score, this.best_shot, this.shot_time)
    this.end_game_view.show()
  }
}

class $b07f2c628e2f93a53f7e5e40083098d5$export$default extends $cbea740ada5053a558f611980f96c698$export$default {
  start(app) {
    super.start('end-game', document.querySelector('.end-game'))
    this.app = app
    this.best_shot_el = document.querySelector('.end-game__best-shot')
    this.time_el = document.querySelector('.end-game__timer-time')
    this.score_el = document.querySelector('.end-game__score')
    this.home_button = document.querySelector('.end-game__home-icon')
    this.next_button = document.querySelector('.end-game__next')
    this.home_button.addEventListener(
      'click',
      this.on_home_button_click.bind(this)
    )
    this.next_button.addEventListener(
      'click',
      this.on_next_button_click.bind(this)
    )
  }

  set_score(score, best_shot, time) {
    this.best_shot_el.textContent = 'Best shot: '.concat(best_shot + 1)
    this.time_el.textContent = time.toFixed(2)
    this.score_el.textContent = 'Score: '.concat(score)
  }

  restart_game() {
    this.hide()
    this.app.set_level()
  }

  blur_background() {
    document.querySelector('.playing__header').classList.add('blurred')
    document.querySelector('.app-canvas').classList.add('blurred')
    document.querySelector('.playing__footer').classList.add('blurred')
  }

  unblur_background() {
    document.querySelector('.playing__header').classList.remove('blurred')
    document.querySelector('.app-canvas').classList.remove('blurred')
    document.querySelector('.playing__footer').classList.remove('blurred')
  }

  on_home_button_click(event) {
    this.restart_game()
  }

  on_next_button_click(event) {
    this.restart_game()
  }

  show() {
    this.blur_background()
    this.container.classList.remove('hidden')
  }

  hide() {
    this.unblur_background()
    this.container.classList.add('hidden')
  }
}

// import {OrthographicCamera} from 'three'
class $c382e361c5b27c638bb1cfc719cf1871$export$default extends BaseApplication {
  constructor() {
    super()
    this.camera_controller =
      new $b962cf860b6cd5fd3e553d7e21122ee7$export$default()
    this.normal_render_mode = new NormalRender()
    document.querySelector('canvas').addEventListener(
      'contextmenu',
      (event) => {
        event.preventDefault()
      },
      false
    )
    document.addEventListener('gesturestart', function (e) {
      e.preventDefault()
    })
    document.addEventListener('gestureend', function (e) {
      e.preventDefault()
    })
    SceneManager.current.autoUpdate = false
  }

  get_random_color_image() {
    const arr = ['blue', 'green', 'purple', 'red', 'yellow']
    return arr[Math.floor(Math.random() * 5)]
  }

  start() {
    Graphics.set_state(this.normal_render_mode)
    this.board_width = 0
    this.board_height = 0
    this.perspective_scale = 0
    this.lower_blank_space = 0
    CameraManager.current = new PerspectiveCamera(60, 1, 0.1, 200)
    Graphics.update()

    this.__init_camera()

    this.__init_camera_controller()

    this.config = ResourceContainer.get_resource('config') // Debug.draw_axis();
    // SceneManager.current.add(new Components.Grid());

    this.home_view = new $f1b35cb0c323fd2d2f87647ca1c5e$export$default()
    this.home_view.start()
    this.end_game_view = new $b07f2c628e2f93a53f7e5e40083098d5$export$default()
    this.end_game_view.start(this)
    this.playing_view = new $f3a324c807c98acbf0952b9675$export$default()
    this.playing_view.start(this.end_game_view)
    this.squares = []
    this.current_state = new $cfb2277e624a264ce0a58ec$export$default() // this.set_online_level();
    // this.set_level();
    // this.set_editor();

    this.y_offset = 0
    this.target_y_offset = 0
    this.last_center = new Vector2()
    this.previous_touch_count = 0
    this.settings = window.settings || {
      columns: 9,
      rows: 10,
      board_width: 9,
      board_height: 27,
      perspective_scale: 1.4,
      lower_blank_space: 2,
      ball_radius: 0.1,
      ball_count: 50,
    }
    window.current_level_descriptor = this.get_dummy_level_descriptor(
      this.settings
    )
  }

  set_state(new_state) {
    this.current_state.on_exit()
    this.current_state = new_state
    this.current_state.on_enter()
  }

  set_level(json) {
    this.playing_view.restart_scores()
    this.set_state(
      new $cd10cabb5963c27a5d2696a76a0e6574$export$default(this.playing_view)
    )
    json = json || window.current_level_descriptor
    const level_descriptor =
      json || this.get_dummy_level_descriptor(this.settings)
    this.current_state.init_level(level_descriptor)
  }

  set_test(json) {
    this.set_state(new $ab03a0e9252d3d0656566105c97c220$export$default())
    json = json || window.current_level_descriptor
    const level_descriptor =
      json || this.get_dummy_level_descriptor(this.settings)
    this.current_state.init_level(level_descriptor)
  }

  set_online_level() {
    this.playing_view.restart_scores()
    this.set_state(
      new $a52696df17fd399c238dbb25fb04b99b$export$default(this.playing_view)
    )
    this.current_state.init_level()
  }

  set_editor(json) {
    this.set_state(new $c5d515c847a1b1d5e42778a8813b19d$export$default())
    json = json || window.current_level_descriptor
    const level_descriptor =
      json || this.get_dummy_level_descriptor(this.settings)
    this.current_state.init_level(level_descriptor)
  }

  editor_test() {
    const level_descriptor = this.current_state.export_level()
    this.set_level(level_descriptor)
  }

  export_level() {
    return this.current_state.export_level()
  }

  update() {
    this.camera_controller.update()
    this.home_view.update()
    this.playing_view.update()
    this.end_game_view.update()
    this.current_state.update()
    this.perspective_scale = this.settings.perspective_scale
    this.check_for_config_change(this.settings)
    const wall_thickness =
      $ff879b7613681d9865f18b3a4e84e422$export$default.wall_thickness
    const board_width = this.board_width + wall_thickness * 2 // if (Screen.width > Screen.height && false)
    // {
    //   CameraManager.current.left = -Screen.aspect_ratio * board_width * 0.5 * this.perspective_scale;
    //   CameraManager.current.right = Screen.aspect_ratio * board_width * 0.5 * this.perspective_scale;
    //   CameraManager.current.top =     board_width * 0.5 * this.perspective_scale;
    //   CameraManager.current.bottom = -board_width * 0.5 * this.perspective_scale;
    // }
    // else
    // {

    CameraManager.current.left = -board_width * 0.5 - wall_thickness
    CameraManager.current.right = board_width * 0.5 - wall_thickness
    CameraManager.current.top = (board_width * 0.5) / Screen.aspect_ratio
    CameraManager.current.bottom = (-board_width * 0.5) / Screen.aspect_ratio // }

    this.camera_controller.reference_position.y =
      (CameraManager.current.top - CameraManager.current.bottom) / 2 -
      $ff879b7613681d9865f18b3a4e84e422$export$default.wall_thickness
    this.camera_controller.reference_position.x = board_width * 0.5
    this.camera_controller.reference_position.y += this.y_offset

    if (Input.right_mouse_button_pressed) {
      this.last_center.copy(TouchInput.center)
    }

    if (TouchInput.touches === 2) {
      const drag_delta = TouchInput.center.clone().sub(this.last_center)
      this.target_y_offset += drag_delta.y * 0.05
    }

    this.target_y_offset += Input.wheel_delta * 2
    this.target_y_offset = Math.max(this.target_y_offset, 0)
    const camera_height =
      CameraManager.current.top - CameraManager.current.bottom
    this.target_y_offset = Math.min(
      29 +
        $ff879b7613681d9865f18b3a4e84e422$export$default.wall_thickness * 2 -
        camera_height,
      this.target_y_offset
    )
    this.y_offset += (this.target_y_offset - this.y_offset) * 0.1
    this.last_center.copy(TouchInput.center)
    this.previous_touch_count = TouchInput.touches
  }

  get_dummy_level_descriptor(settings) {
    const columns = settings.columns
    const rows = settings.rows
    const size_x = 1
    const size_y = 1
    const blocks = []

    for (let i = 0; i < columns * rows; i++) {
      const y = Math.floor(i / columns)
      const x = i % columns
      blocks.push({
        id: i,
        x: x * size_x + size_x * 0.5,
        y: y * size_y + size_y * 0.5 + settings.lower_blank_space,
        color_image: this.get_random_color_image(),
        total_hp: 5,
      })
    }

    let level_descriptor = {
      ball_radius: settings.ball_radius,
      remaining_attempts: 3,
      total_attempts: 3,
      ball_color: '#00ffff',
      wall_color: '#ff0000',
      block_width: size_x,
      block_height: size_y,
      board_width: settings.board_width,
      board_height: settings.board_height + settings.lower_blank_space,
      blocks: [],
      last_generated_id: blocks.length,
    }
    level_descriptor = {
      amount_of_balls_to_fire: 5,
      total_attempts: 3,
      times_played: 0,
      ball_radius: 0.2,
      ball_color: '#00ffff',
      wall_color: '#ff0000',
      block_width: 1,
      block_height: 1,
      board_width: 9,
      board_height: 29,
      blocks: [
        {
          id: 91,
          x: 4.5,
          y: 26.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 92,
          x: 3.5,
          y: 25.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 93,
          x: 5.5,
          y: 25.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 94,
          x: 2.5,
          y: 24.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 95,
          x: 1.5,
          y: 23.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 96,
          x: 6.5,
          y: 24.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 97,
          x: 7.5,
          y: 23.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 102,
          x: 3.5,
          y: 14.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 103,
          x: 4.5,
          y: 13.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 104,
          x: 5.5,
          y: 14.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 105,
          x: 0.5,
          y: 10.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 106,
          x: 1.5,
          y: 9.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 107,
          x: 1.5,
          y: 8.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 108,
          x: 0.5,
          y: 7.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 111,
          x: 3.5,
          y: 4.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 112,
          x: 5.5,
          y: 4.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 113,
          x: 0.5,
          y: 2.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 114,
          x: 8.5,
          y: 2.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 115,
          x: 8.5,
          y: 7.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 116,
          x: 7.5,
          y: 8.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 117,
          x: 7.5,
          y: 9.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 118,
          x: 8.5,
          y: 10.5,
          color_image: 'yellow',
          total_hp: 30,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 119,
          x: 4.5,
          y: 4.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 120,
          x: 8.5,
          y: 8.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 121,
          x: 8.5,
          y: 9.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 122,
          x: 0.5,
          y: 9.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 123,
          x: 0.5,
          y: 8.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 124,
          x: 4.5,
          y: 14.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 125,
          x: 2.5,
          y: 23.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 126,
          x: 4.5,
          y: 25.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 127,
          x: 6.5,
          y: 23.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 130,
          x: 0.5,
          y: 20.5,
          color_image: 'green',
          total_hp: 150,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 131,
          x: 0.5,
          y: 18.5,
          color_image: 'green',
          total_hp: 150,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 132,
          x: 8.5,
          y: 20.5,
          color_image: 'green',
          total_hp: 150,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 133,
          x: 8.5,
          y: 18.5,
          color_image: 'green',
          total_hp: 150,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 134,
          x: 3.5,
          y: 19.5,
          color_image: 'blue',
          total_hp: 240,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 135,
          x: 5.5,
          y: 19.5,
          color_image: 'blue',
          total_hp: 240,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 136,
          x: 7.5,
          y: 19.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 137,
          x: 1.5,
          y: 19.5,
          color_image: 'red',
          total_hp: 90,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 138,
          x: 4.5,
          y: 15.5,
          color_image: 'blue',
          total_hp: 240,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
        {
          id: 139,
          x: 4.5,
          y: 5.5,
          color_image: 'blue',
          total_hp: 240,
          points_per_hit: 10,
          points_per_destruction: 25,
        },
      ],
      last_generated_id: 139,
    }
    return level_descriptor
  }

  __init_camera() {
    // let camera = new PerspectiveCamera(60, Screen.aspect_ratio, 0.1, 200);
    // let camera = new THREE.OrthographicCamera(-Screen.width/2, Screen.width/2, Screen.height/2, -Screen.height/2, 0.1, 100);
    const left = -Screen.aspect_ratio * this.board_width * 0.5
    const right = Screen.aspect_ratio * this.board_width * 0.5
    const top = this.board_height * 2
    const bottom = -this.board_height * 2
    const camera = new OrthographicCamera(left, right, top, bottom, 0.1, 100)
    camera.clear_color = new Color('#101014')
    camera.clear_alpha = 1
    camera.updateProjectionMatrix()
    camera.position.z = 10
    CameraManager.current = camera
  }

  __init_camera_controller() {
    this.camera_controller.set_camera(CameraManager.current)
    this.camera_controller.set_idle() // this.camera_controller.set_debug_mode();

    this.camera_controller.min_zoom = 1
    this.camera_controller.max_zoom = 40
    this.camera_controller.reference_zoom = 30
    this.camera_controller.reference_position.set(0, 0, 0) // this.camera_controller.set_rotation(45, 0);
  }

  check_for_config_change(settings) {
    // let needs_resize = false;
    // let needs_rebuild = false;
    if (Math.abs(settings.board_width - this.board_width) > 0.001) {
      this.board_width = settings.board_width // needs_rebuild = true;
    }

    if (Math.abs(settings.board_height - this.board_height) > 0.001) {
      this.board_height = settings.board_height // needs_rebuild = true;
    }

    if (Math.abs(settings.lower_blank_space - this.lower_blank_space) > 0.001) {
      this.lower_blank_space = settings.lower_blank_space // needs_resize = true;
    }
  }
}

class $d3a1e1b785bcf3197e0ebe68$var$Api {
  constructor() {
    this.application = new $c382e361c5b27c638bb1cfc719cf1871$export$default(
      Graphics
    )
    this.resource_container = ResourceContainer
    this.render_loop = new RenderLoop(this.application, Graphics)
    this.config = Configuration
  }

  init() {
    const app_container = document.querySelector('.app-container')
    const canvas = document.getElementById('main-canvas')
    Graphics.init(canvas)
    Configuration.dpr = window.devicePixelRatio
    Input.init(app_container, canvas)
    Debug.init(Graphics)
  }

  dispose() {
    this.render_loop.stop()

    Graphics._renderer.dispose()
  }

  draw_debug_axis() {
    Debug.draw_axis()
  }

  on_orientation_change() {}

  register_event(name, callback) {
    EventManager.on(name, callback)
  }

  resource_loading_completed() {
    this.application.resources_fully_loaded()
  }

  set_resource(name, resource) {
    this.resource_container.set_resource(name, resource)
  }

  start() {
    this.render_loop.start()
  }

  stop() {
    this.render_loop.stop()
  }

  set_level(json) {
    this.application.set_level(json)
  }

  set_test(json) {
    this.application.set_test(json)
  }

  set_online_level() {
    this.application.set_online_level()
  }

  set_editor(json) {
    this.application.set_editor(json)
  }

  editor_test() {
    this.application.editor_test()
  }

  export_level() {
    return this.application.export_level()
  }

  set_api_endpoint(end_point) {
    $a47b39a1f68b769584aa5500ce61083b$export$default.set_end_point(end_point)
  }

  set_session_id(session_id) {
    $a47b39a1f68b769584aa5500ce61083b$export$default.set_session_id(session_id)
  }

  create_resource_batch() {
    return new ResourceBatch()
  }
}

export const Game = new $d3a1e1b785bcf3197e0ebe68$var$Api()
// # sourceMappingURL=game_api.js.map
