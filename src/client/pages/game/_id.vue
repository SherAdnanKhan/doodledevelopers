<template>
  <div v-if="loaded">
    <div class="section loader">
      <div class="loader__progress-bar">
        <div class="loader__progress-bar-fill"></div>
      </div>
    </div>
    <div class="app-container">
      <div class="section playing">
        <div class="playing__body">
          <div class="app-canvas">
            <canvas id="main-canvas"></canvas>
          </div>
          <div class="shooting-ended hidden">
            <div class="shooting-ended__container">
              <div class="shooting-ended__footer">
                <div
                  class="button shooting-ended__continue"
                  @click="start = true"
                >
                  <div class="shooting-ended__continue-text">START GAME</div>
                </div>
              </div>
            </div>
          </div>
          <div class="end-game hidden">
            <div class="end-game__container">
              <div class="end-game__header">SCORE</div>
              <div class="end-game__body">
                <div class="end-game__best-shot">Best shot: 0</div>
                <div class="end-game__timer">
                  <div class="end-game__timer-icon">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="18.667"
                      viewbox="0 0 16 18.667"
                    >
                      <path
                        d="M15.167,1.5H9.833V3.278h5.333ZM11.611,13.056h1.778V7.722H11.611ZM18.749,7.18l1.262-1.262a9.821,9.821,0,0,0-1.253-1.253L17.5,5.927A8,8,0,1,0,18.749,7.18ZM12.5,18.389a6.222,6.222,0,1,1,6.222-6.222A6.218,6.218,0,0,1,12.5,18.389Z"
                        transform="translate(-4.5 -1.5)"
                        fill="#fff"
                      ></path>
                    </svg>
                  </div>
                  <div class="end-game__timer-time">0</div>
                </div>
                <div class="end-game__score">Score: 0</div>
              </div>
              <div class="end-game__footer">
                <div class="button end-game__home-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="30.575"
                    height="33.75"
                    viewbox="0 0 30.575 33.75"
                  >
                    <g transform="translate(-3.5 -2)">
                      <path
                        d="M4.5,14.112,18.787,3,33.075,14.112V31.575A3.175,3.175,0,0,1,29.9,34.75H7.675A3.175,3.175,0,0,1,4.5,31.575Z"
                        transform="translate(0 0)"
                        fill="none"
                        stroke="#101114"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                      ></path>
                      <path
                        d="M13.5,33.875V18h9.525V33.875"
                        transform="translate(0.525 0.875)"
                        fill="none"
                        stroke="#101114"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                      ></path>
                    </g>
                  </svg>
                </div>
                <div class="button end-game__next">
                  <div class="end-game__next-text">Play again - 1 credit</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="playing__footer">
          <div class="playing__footer-left">
            <div class="playing__ball-icon"></div>
            <div class="playing__remaining-attempts">0</div>
          </div>
          <div class="playing__footer-center">
            <div class="button playing__speed-up">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="35"
                height="30"
                viewbox="0 0 35 30"
              >
                <path
                  d="M19.75,4.5a17.494,17.494,0,0,0-13.1,29.094c.086.094.164.188.25.273a1.968,1.968,0,0,0,2.9-.008,13.526,13.526,0,0,1,19.906,0,1.968,1.968,0,0,0,2.9.008l.25-.273A17.494,17.494,0,0,0,19.75,4.5ZM18.656,8.086a1.094,1.094,0,0,1,2.188,0V10.9a1.094,1.094,0,0,1-2.188,0Zm-10,15H5.844a1.094,1.094,0,1,1,0-2.187H8.656a1.094,1.094,0,0,1,0,2.188Zm4.023-8.164h0a1.1,1.1,0,0,1-1.547,0L9.141,12.938a1.1,1.1,0,0,1,0-1.547h0a1.1,1.1,0,0,1,1.547,0l1.992,1.992A1.094,1.094,0,0,1,12.68,14.922Zm12.547,2.7-3.711,5.9a2.422,2.422,0,0,1-.547.547,2.352,2.352,0,1,1-2.734-3.828l5.9-3.711a.8.8,0,0,1,.914,0A.786.786,0,0,1,25.227,17.617Zm3.141-2.7a1.1,1.1,0,0,1-1.547,0h0a1.1,1.1,0,0,1,0-1.547l1.992-1.992a1.1,1.1,0,0,1,1.547,0h0a1.1,1.1,0,0,1,0,1.547Zm5.289,8.164H30.844a1.094,1.094,0,0,1,0-2.187h2.812a1.094,1.094,0,0,1,0,2.188Z"
                  transform="translate(-2.25 -4.5)"
                  fill="#fff"
                ></path>
              </svg>
            </div>
          </div>
          <div class="playing__footer-right"></div>
        </div>
      </div>
    </div>
    <div class="section home hidden"></div>
    <div class="reusable-elements">
      <div class="playing__shoot">
        <div class="playing__shoot-number">Shoot 0:</div>
        <div class="playing__shoot-score">0</div>
        <div class="playing__shoot-timer">
          <div class="playing__shoot-timer-icon">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="18.667"
              viewbox="0 0 16 18.667"
            >
              <path
                d="M15.167,1.5H9.833V3.278h5.333ZM11.611,13.056h1.778V7.722H11.611ZM18.749,7.18l1.262-1.262a9.821,9.821,0,0,0-1.253-1.253L17.5,5.927A8,8,0,1,0,18.749,7.18ZM12.5,18.389a6.222,6.222,0,1,1,6.222-6.222A6.218,6.218,0,0,1,12.5,18.389Z"
                transform="translate(-4.5 -1.5)"
                fill="#fff"
              ></path>
            </svg>
          </div>
          <div class="playing__shoot-timer-time">0</div>
        </div>
      </div>
    </div>
    <div v-if="showLowPower" class="low-power-mode-banner b-grey relative">
      <span class="close" @click="closeLowPowerNotification()">X</span>
      <h1>
        Your iPhone is on low power mode. this means you will have degradded
        performance. Please charge your phone for the best experience.
      </h1>
    </div>
    <video id="myVideo" class="myVideo" autoplay playsinline>
      <source src="/path/to/video.mp4" type="video/mp4" />
    </video>
  </div>
</template>
<script>
import ValidationServiceGameProxy from '../../services/ValidationServiceGameProxy'
export default {
  middleware: 'auth',
  data: () => ({
    showLowPower: false,
    title: process.env.appName,
    gveUrl: process.env.gveUrl,
    apiUrl: process.env.apiUrl,
    sessionToken: '',
    loaded: false,
    game: null,
    start: false,
  }),

  beforeRouteLeave(to, from, next) {
    // If the form is dirty and the user did not confirm leave,
    // prevent losing unsaved changes by canceling navigation
    if (this.confirmStayInDirtyForm()) {
      next(false)
    } else {
      // Navigate to next view
      next()
    }
  },

  created() {
    this.playGameById()
    if (process.browser) {
      this.addListener()
    }
  },

  beforeDestroy() {
    this.game.dispose()
    console.log('DISPOSE')
    if (process.browser) {
      window.removeEventListener('beforeunload', this.beforeWindowUnload)
    }
  },

  methods: {
    closeLowPowerNotification() {
      console.log('clicked')
      this.showLowPower = !this.showLowPower
      console.log(this.showLowPower)
    },
    checkLowPowerMode() {
      if (process.browser) {
        const video = document.getElementById('myVideo')
        console.log(video)
        video.addEventListener('suspend', () => {
          // We're in low-power mode, show fallback UI
          console.log('low power mode')
          this.showLowPower = true
        })
        video.addEventListener('play', () => {
          // Remove fallback UI if user plays video manually
          console.log('normal power mode')
        })
      }
    },

    addListener() {
      document.body.addEventListener('keydown', (e) => {
        // console.log(e.key)
        if ((e.metaKey && e.key === '=') || e.key === '-') {
          e.preventDefault()
        }
      })
    },

    confirmLeave() {
      if (process.browser) {
        return window.confirm(
          'If you want to cancel out of your game press cancel, otherwise press ok.',
          function (result) {
            console.log('result:', result)
          }
        )
      }
    },

    confirmStayInDirtyForm() {
      return this.confirmLeave()
    },

    beforeWindowUnload(e) {
      if (this.confirmStayInDirtyForm()) {
        // Cancel the event
        e.preventDefault()
        // Chrome requires returnValue to be set
        e.returnValue = ''
      }
    },
    /* eslint-disable */
    playGameById() {
      if (process.browser) {
        this.$store
          .dispatch('UserGameStore/playGameById', this.$route.params.id)
          .then((res) => {
            console.log(res)
            this.loaded = true
            return res
          })
          .then((res) => {
            this.sessionToken = res.game_player_token
            this.initGame(res.game_player_token)
          })
      }
    },
    initGame(SessionToken) {
      if (process.browser) {
        this.checkLowPowerMode()
        const ApiService = new ValidationServiceGameProxy(SessionToken, this.gveUrl)
        const Game = require('red6six-game-ui').GameUI
        console.log('GAME UI REVISION', require('red6six-game-ui').REVISION)

        this.game = Game
        const gameEventListener = {
          on_leaderboard_button_click: () => {
            console.log('on_leaderboard_button_click')
            this.$router.push({ name: 'leaderboard' })
          },
          on_play_again_button_click: () => {
            console.log('on_play_again_button_click')
            window.location.reload()
          },
        }
        Game.init(gameEventListener)

        const loader = document.querySelector('.loader')
        const progressBar = document.querySelector('.loader__progress-bar-fill')
        const checkResourceLoading = (batch, onResourcesLoaded) => {
          progressBar.style.width = `${batch.get_progress() * 100}%`

          if (batch.loading_finished) {
            if (batch.has_errors) {
              batch.print_errors()
            } else {
              onResourcesLoaded()
            }
          } else {
            setTimeout(function () {
              checkResourceLoading(batch, onResourcesLoaded)
            }, 200)
          }
        }
        const batch = Game.create_resource_batch()
        batch.add_texture('ball', '../game_assets/textures/main_ball.png')
        batch.add_texture('tracer_ball', '../game_assets/textures/tracer_ball.png')
        batch.add_texture('blue', '../game_assets/textures/blue.png')
        batch.add_texture('green', '../game_assets/textures/green.png')
        batch.add_texture('purple', '../game_assets/textures/purple.png')
        batch.add_texture('red', '../game_assets/textures/red.png')
        batch.add_texture('yellow', '../game_assets/textures/yellow.png')
        batch.add_texture('blue_noise', '../game_assets/textures/blue_noise.png')
        batch.add_texture('wall_frame', '../game_assets/textures/wall_frame.png')
        batch.add_texture('font_atlas', '../game_assets/sdf_fonts/atlas.png')
        batch.add_json('font_layout', '../game_assets/sdf_fonts/layout.json')
        batch.load(Game.resource_container)

        const onResourceReady = () => {
          loader.classList.add('hidden')
          Game.resource_loading_completed()
          Game.start()
          Game.set_online_level(ApiService)
        }
        checkResourceLoading(batch, onResourceReady)
      }
    },
  },
  head() {
    return {
      bodyAttrs: {
        class: 'game-page',
      },
      link: [
        {
          rel: 'stylesheet',
          href: '../game_assets/application.css',
        },
      ],
    }
  },
}
</script>

<style scoped lang="scss">
.game-page {
  overflow: hidden;
  position: fixed;
  width: 100%;
  height: 100%;
}

.game {
  height: 100vh;
  padding-top: 12px;
}

.myVideo {
  display: none;
  visibility: hidden;
  z-index: -1;
  position: absolute;
  left: -99999px;
}

.low-power-mode-banner {
  background-color: #404040;
  padding: 1rem;
  z-index: 100;
  position: absolute;
  padding-top: 2rem;
  right: 0;
  left: 0;
  bottom: 0;
  transition: bottom 350ms ease-in-out;

  .close {
    position: absolute;
    right: 0.75rem;
    top: 0.5rem;
  }
}
</style>
