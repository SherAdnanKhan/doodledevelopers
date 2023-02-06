<template>
  <div>
    <section class="c-hero">
      <div class="c-hero__video-pattern" />
      <video
        ref="videoRef"
        class="c-hero__video"
        autoplay
        muted
        playsinline
        loop
      >
        <source
          src="https://player.vimeo.com/external/578015777.sd.mp4?s=34492cb4989ba18e03fc60d1cdbb40d295734dab&profile_id=165"
          type="video/mp4"
        />
      </video>
    </section>
    <section class="text-center pt-8 lg:pt-16">
      <h1 class="text-white text-3xl lg:text-5xl">Enter our live competitions to win real cash prizes.</h1>
      <h2 class="text-white text-2xl lg:text-3xl">
        Why leave things to chance?
      </h2>
    </section>
    <section class="py-8 lg:py-16">
      <div class="max-w-4xl m-auto">
        <div
          v-if="liveGames && liveGames.length"
          class="grid gap-8 px-8 lg:px-0"
          :class="
            liveGames.length < 2
              ? 'md:grid-cols-1 max-w-lg mx-auto'
              : 'md:grid-cols-2'
          "
        >
          <div
            v-for="(game, index) in liveGames"
            :key="index"
            class="game-card flex flex-col max-w-2xl relative"
          >
            <div
              v-if="authenticated"
            >
              <nuxt-link
                :to="setUrl(balance, game)"
              >
                <div
                  class="game-card-image"
                  :style="{
                    backgroundImage:
                      'url(' + require('~/assets/images/game.png') + ')',
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
                      <span class="text-white flex">
                        <img
                          class="w-6 h-6 inline-block mr-2"
                          src="~/assets/images/icon.png"
                          alt=""
                        />
                        {{ game.entry_fee }}
                      </span>
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
                            <span
                              slot="process"
                              slot-scope="{ timeObj }"
                              class="text-white"
                              >{{
                                `${timeObj.d}d ${timeObj.h}h ${timeObj.m}m ${timeObj.s}s GMT`
                              }}</span
                            >
                            <span slot="finish text-white">Competition ended!</span>
                          </vac>
                        </client-only>
                      </div>
                      <p class="text-sm text-white">
                        *Jackpot prize advertised is up to, but not limited to.
                      </p>
                    </div>
                  </span>
                </div>
                <div
                  v-if="!isUserHasCredit(game)"
                  class="nocredit-overlay flex justify-center items-center"
                >
                  <span>You don't have enough credits to play...</span>
                </div>
              </nuxt-link>
            </div>
            <div v-else>
              <div
                class="game-card-image"
                :style="{
                  backgroundImage:
                    'url(' + require('~/assets/images/game.png') + ')',
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
                    <span class="text-white flex">
                      <span class="text-gold font-semibold mr-2">Entry Fee:</span>
                      <img
                        class="w-6 h-6 inline-block mr-2"
                        src="~/assets/images/icon.png"
                        alt=""
                      />
                      {{ game.entry_fee }}&nbsp;
                      <span class="text-gold">Credit</span>
                    </span>
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
                          <span
                            slot="process"
                            slot-scope="{ timeObj }"
                            class="text-white"
                            >{{
                              `${timeObj.d}d ${timeObj.h}h ${timeObj.m}m ${timeObj.s}s GMT`
                            }}</span
                          >
                          <span slot="finish text-white">Competition ended!</span>
                        </vac>
                      </client-only>
                    </div>
                    <p class="text-sm text-white">
                      *Jackpot prize advertised is up to, but not limited to.
                    </p>
                  </div>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="text-white text-center">
          <p>There are no live games...</p>
        </div>
      </div>
    </section>
    <section class="py-8 lg:py-16 bg-grey">
      <div class="container mx-auto max-w-2xl px-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <h1
              class="
                text-2xl
                lg:text-3xl
                text-white text-center
                block
                mb-4
                lg:mb-8
              "
            >
              Historical Winners
            </h1>
          </div>
          <Winners :winners="mappedWinners"  />
        </div>
      </div>
    </section>
    <section class="py-8 lg:py-16">
      <div class="container mx-auto max-w-2xl px-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <h1 class="text-2xl lg:text-3xl text-white text-center block">
              How to play
            </h1>
          </div>
          <client-only>
            <video
              id="my-player"
              class="how-to-video"
              controls
              preload="auto"
              :poster="require('~/assets/images/game-2.png')"
              data-setup="{}"
            >
              <source
                src="https://player.vimeo.com/external/578016862.sd.mp4?s=ffc1fc484d12d61ce234305283518e96a93f6943&profile_id=165"
                type="video/mp4"
              />
              <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider
                upgrading to a web browser that
                <a
                  href="https://videojs.com/html5-video-support/"
                  target="_blank"
                >
                  supports HTML5 video
                </a>
              </p>
            </video>
          </client-only>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Winners from '~/components/Shared/Winners.vue'

export default {
  components: {
    Winners,
  },
  async asyncData({ store }) {
    await store.dispatch('PublicData/fetchLiveGames')
    await store.dispatch('PublicData/fetchGamesWinners')
  },
  data: () => ({
    title: process.env.appName,
  }),
  beforeMount() {
    const body = document.body
    if (body.scrollTop > 5 || document.documentElement.scrollTop > 5) {
      if (!body.classList.contains('c-header--active')) {
        body.classList.add('c-header--active')
      }
    } else {
      body.classList.remove('c-header--active')
    }
    window.onscroll = function () {
      const body = document.body
      if (body.scrollTop > 5 || document.documentElement.scrollTop > 5) {
        if (!body.classList.contains('c-header--active')) {
          body.classList.add('c-header--active')
        }
      } else {
        body.classList.remove('c-header--active')
      }
    }
  },
  mounted() {
    this.$refs.videoRef.play()
    // Show loading animation.
    const playPromise = this.$refs.videoRef.play()

    // Attempt to fix this error: localhost/:1 Uncaught (in promise) DOMException: The play() request was interrupted by a call to pause().
    if (playPromise !== undefined) {
      playPromise.then(() => {
        // Automatic playback started!
        // Show playing UI.
        this.$refs.videoRef.play()
      })
    }
  },
  created() {
    if (this.authenticated) {
      this.init()
    }
  },
  computed: {
    balance() {
      return this.walletBalance
    },
    ...mapGetters({
      walletBalance: 'UserPaymentsStore/getUserWallet',
      authenticated: 'auth/isAuthenticated',
      gameWallets: 'UserPaymentsStore/getGameWallets',
      liveGames: 'PublicData/liveGames',
      gamesWinners: 'PublicData/gamesWinners'
    }),
    mappedWinners() {
      if (!this.gamesWinners && !this.gamesWinners.length) {
        return []
      }
      return this.gamesWinners
        .filter((game) => game.historical_earnings && game.historical_earnings.length)
        .map((game) => ({
          gameName: game.name,
          winners: game.historical_earnings,
        }))
    },
  },
  methods: {
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
    async init() {
      await this.$store.dispatch('UserPaymentsStore/getUserWallets')
      await this.$store.dispatch('UserPaymentsStore/getGameWallets')
    },
  },
  head() {
    return {
      title: this.$t('home'),
    }
  },
}
</script>
<style scoped lang="scss">
.c-hero {
  // height: 250px;
  position: relative;

  @media only screen and (min-width: 1024px) {
    height: 350px !important;
  }

  @media only screen and (min-width: 1280px) {
    height: 600px !important;
  }
}

.c-hero__video {
  height: 100%;
  margin: auto;
  object-fit: cover;
  width: 100%;
}

video[poster] {
  height: 100%;
  width: 100%;
}

.card-body {
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 12%);
}

.game-card {
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid gray;
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 35%);
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

.how-to-video {
  height: 300px !important;
  width: 100% !important;

  @media only screen and (min-width: 1024px) {
    height: 450px !important;
  }
}
</style>
