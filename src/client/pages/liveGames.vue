<template>
  <div class="bg-black mb-16">
    <div class="flex card-button">
      <button
        class="
          card-button
          py-4
          px-8
          mb-4
          capitalize
          text-center
          bg-gold
          lg:hover:bg-red lg:hover:text-white
          transition-colors
          text-black
          focus:outline-none
          right-0
          relative
          ml-auto
        "
        @click="toggleModal()"
      >
        How to Play
      </button>
    </div>
    <h1
      class="
        text-white text-2xl
        mb-4
        text-center
        mt-4
        lg:mb-8
        xl:mb-16 xl:text-4xl
      "
    >
      Live games
    </h1>
    <div
      v-if="liveGames && liveGames.length"
      class="grid gap-8 px-8 lg:px-0 m-auto"
      :class="
        liveGames.length < 2
          ? 'md:grid-cols-1 max-w-md mx-auto'
          : 'md:grid-cols-2 max-w-xl'
      "
    >
      <nuxt-link
        v-for="(game, index) in liveGames"
        :key="index"
        :to="setUrl(balance, game)"
        class="game-card flex flex-col cursor-pointer relative"
      >
        <div
          class="game-card-image"
          :style="{
            backgroundImage: 'url(' + require('~/assets/images/game.png') + ')',
          }"
        />
        <div class="game-card-body p-4 border-red border-t-4 flex-1">
          <h2 class="font-bold text-white text-2xl">{{ game.name }}</h2>
          <span class="flex flex-row items-center mt-2">
            <div class="block mr-2 w-full">
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">Jackpot:</span>
                <span class="text-white">£{{ game.jackpot_value }}*</span>
              </div>
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">Entry Fee:</span>
                <span class="text-white flex">
                  <img
                    class="w-6 h-6 inline-block mr-2"
                    src="~/assets/images/icon.png"
                    alt=""
                  />
                  {{ game.entry_fee }}&nbsp;
                  <span class="text-gold">Credit</span>
                </span>
              </div>
              <div class="flex mb-2 flex-col md:flex-row">
                <span class="text-gold font-semibold mr-2">End date:</span>
                <span class="text-white"
                  >{{ $moment(game.end_date).format('DD/MM/YYYY') }} |
                  00:00:00</span
                >
              </div>
              <div class="flex mb-2 flex-col md:flex-row">
                <span class="text-gold font-semibold mr-2"
                  >Competition closes in:
                </span>
                <client-only>
                  <vac :end-time="new Date(game.end_date).getTime()">
                    <span slot="process" slot-scope="{ timeObj }">{{
                      `${timeObj.d}d ${timeObj.h}h ${timeObj.m}m ${timeObj.s}s GMT`
                    }}</span>
                    <span slot="finish">Competition ended!</span>
                  </vac>
                </client-only>
              </div>
              <p class="text-sm">
                *Jackpot prize advertised is up to, but not limited to.
              </p>
            </div>
          </span>
        </div>
        <div
          v-if="!isUserHasCredit(game)"
          class="nocredit-overlay flex justify-center items-center"
        >
          <span>Please purchase credits to enter competitions.</span>
        </div>
      </nuxt-link>
    </div>
    <div v-else class="text-white text-center">
      <p>There are no live games...</p>
    </div>
    <transition mode="in-out" name="fade">
      <div v-if="modalVisible" class="video-modal">
        <span class="close cursor-pointer" @click="toggleModal()"
          ><svg
            id="Capa_1"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            width="20px"
            height="20px"
            viewBox="0 0 41.756 41.756"
            style="enable-background: new 0 0 41.756 41.756"
            xml:space="preserve"
          >
            <g>
              <path
                fill="white"
                d="M27.948,20.878L40.291,8.536c1.953-1.953,1.953-5.119,0-7.071c-1.951-1.952-5.119-1.952-7.07,0L20.878,13.809L8.535,1.465
                c-1.951-1.952-5.119-1.952-7.07,0c-1.953,1.953-1.953,5.119,0,7.071l12.342,12.342L1.465,33.22c-1.953,1.953-1.953,5.119,0,7.071
                C2.44,41.268,3.721,41.755,5,41.755c1.278,0,2.56-0.487,3.535-1.464l12.343-12.342l12.343,12.343
                c0.976,0.977,2.256,1.464,3.535,1.464s2.56-0.487,3.535-1.464c1.953-1.953,1.953-5.119,0-7.071L27.948,20.878z"
              />
            </g>
          </svg>
        </span>
        <video
          id="my-player"
          class="video-js"
          controls
          preload="auto"
          poster=""
          data-setup="{}"
        >
          <source
            src="https://player.vimeo.com/external/578016862.sd.mp4?s=ffc1fc484d12d61ce234305283518e96a93f6943&profile_id=165"
            type="video/mp4"
          />
          <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading
            to a web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank">
              supports HTML5 video
            </a>
          </p>
        </video>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'User',
  async asyncData({ store }) {
    await store.dispatch('auth/fetchUser')
    await store.dispatch('UserGameStore/getUserCurrentGames')
    await store.dispatch('UserPaymentsStore/getUserWallets')
    await store.dispatch('UserPaymentsStore/getGameWallets')
  },
  data: () => ({
    title: process.env.appName,
    modalVisible: false,
  }),
  computed: {
    balance() {
      return this.walletBalance
    },
    ...mapGetters({
      walletBalance: 'UserPaymentsStore/getUserWallet',
      authenticated: 'auth/isAuthenticated',
      liveGames: 'UserGameStore/userAllCurrentGames',
      gameWallets: 'UserPaymentsStore/getGameWallets',
    }),
  },
  methods: {
    toggleModal() {
      this.modalVisible = !this.modalVisible
    },
    setUrl(balance, game) {
      if (this.isUserHasCredit(game) || balance >= game.entry_fee) {
        return `/game/${game.id}`
      }
      return `/user/user-wallet`
    },
    isUserHasCredit(game) {
      if (this.gameWallets) {
        let gameWallet = this.gameWallets.filter(
          (gameWallet) => gameWallet.game.id === game.id
        )
        if (gameWallet.length) {
          gameWallet = gameWallet[0]
          if (gameWallet.credit >= game.entry_fee) {
            return true
          }
        }
      }
      if (this.walletBalance >= game.entry_fee) {
        return true
      }
      return false
    },
  },
  head() {
    return {
      title: this.$t('live-games'),
      script: [
        {
          src: 'https://unpkg.com/video.js/dist/video.min.js',
        },
      ],
    }
  },
}
</script>
<style scoped lang="scss">
.game-card {
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid gray;
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 35%);
}

.video-js {
  width: 100%;
  height: 100%;
}

.video-modal {
  position: fixed;
  display: flex;
  z-index: 1000000;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: #404040;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;

  .close {
    z-index: 1000;
    position: absolute;
    top: 2rem;
    right: 1.5rem;
  }
}

.how-to-play {
  position: fixed;
  z-index: 1000;
  right: 0;
  bottom: 0;
  background-color: #dbba6b;
  color: #000000;
  text-align: center;
  padding-top: 1rem;
  padding-right: 1rem;
  padding-bottom: 1rem;
  padding-left: 1rem;
  width: 100%;
}

.nocredit-overlay {
  background: rgba(red, 0.6);
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
