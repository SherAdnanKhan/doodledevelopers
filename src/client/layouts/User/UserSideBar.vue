<template>
  <nav v-if="isAuthenticated" class="lg:h-full flex flex-col w-full">
    <div class="nav-inner flex flex-row lg:flex-col items-center w-full">
      <nuxt-link :to="'/'" class="lg:w-full inline-flex lg:l-auto lg:mr-auto lg:mb-2 logo h-full">
        <IconLogo class="w-full" />
      </nuxt-link>
      <div v-if="isAuthenticated" class="text-center w-full ml-auto lg:ml-0" style="max-width: 320px">
        <div
          v-if="currentUser && currentUser.photo_url"
          class="rounded-full h-24 w-24 m-auto"
          :style="{ backgroundImage: 'url(' + currentUser.photo_url + ')' }"
        />
        <div class="p-2 font-bold text-center text-white w-full text-sm lg:text-base flex flex-row items-center justify-around">
          <nuxt-link :to="'/user/settings'" class="">
            <span>{{ userName | truncate(6) }}</span>
          </nuxt-link>
          <span>|</span>
          <nuxt-link :to="{ name: 'user-wallet' }" class="flex items-center">
            <img class="w-6 h-6 inline-block mr-2" src="~/assets/images/icon.png" alt="" />
            <span>{{ getUserWallet }}</span>
          </nuxt-link>
          <span>|</span>
          <span>
            <a href="#" @click.prevent="logout">
              {{ $t('logout') }}
            </a>
          </span>
        </div>
      </div>
      <div class="c-hamburger z-20 ml-4 pr-4 lg:hidden">
        <div @click="toggleMenu(false)">
          <span />
          <span />
          <span />
          <span />
        </div>
      </div>
    </div>
    <div class="nav-inner-sibling overflow-scroll lg:overflow-auto w-full max-h-full">
      <ul class="text-grey pt-8">
        <li
          v-for="(navItem, index) in navItems"
          :key="index"
          class="px-2 py-6 transition duration-500 cursor-pointer hover:bg-red hover:bg-opacity-75 hover:text-white text-white border-l-4 border-transparent hover:border-gold flex"
          :class="{
            'bg-red text-white border-l-4 border-gold': $nuxt.$route.name.includes(navItem.name),
          }"
          @click="performNavigation(navItem.name)"
        >
          <p
            class="ml-6 lg:hover:border-red lg:hover:text-white transition duration-500 cursor-pointer flex"
            :class="{
              'border-red text-white': $nuxt.$route.path.includes(navItem.name),
            }"
          >
            {{ $t(navItem.title) }}
          </p>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import IconLogo from '~/components/svg/IconLogo'

export default {
  name: 'UserSideBar',
  components: {
    IconLogo,
  },
  async fetch() {
    await this.$nuxt.context.store.dispatch('UserPaymentsStore/getUserWallets')
  },
  data: () => ({
    mobileMenuVisible: false,
    navItems: [
      {
        name: 'live-games',
        title: 'live-games',
      },
      {
        name: 'winners',
        title: 'winners',
      },
      {
        name: 'leaderboard',
        title: 'leaderboard',
      },
      {
        path: '/user/settings',
        name: 'profileSettings.profile',
        title: 'profile-setting',
      },
      {
        name: 'user-wallet',
        title: 'user-wallet',
      },
      /* {
        name: 'user-payouts',
        title: 'user-payouts',
      }, */
      {
        name: 'withdraw',
        title: 'withdrawals',
      },
      {
        name: 'games-history',
        title: 'games-history',
      },
      {
        name: 'user-invitation',
        title: 'user-invitation',
      },
      {
        name: 'kyc-validation',
        title: 'kyc-validation',
      },
      {
        name: 'user-support',
        title: 'user-support',
      },
    ],
  }),
  computed: {
    ...mapGetters('auth', ['userName', 'currentUser', 'isAuthenticated']),
    ...mapGetters('UserPaymentsStore', ['getUserWallet']),
  },
  filters: {
    truncate(string, value) {
      return string.substring(0, value) + '…'
    },
  },
  methods: {
    toggleMenu() {
      if (this.mobileMenuVisible) {
        document.body.classList.remove('js-hamburger--open')
        this.mobileMenuVisible = false
      } else {
        document.body.classList.add('js-hamburger--open')
        this.mobileMenuVisible = true
      }
    },
    async logout() {
      await this.$router.push({ name: 'welcome' })
      await this.$store.dispatch('auth/logout')
      this.toggleMenu(true)
    },
    performNavigation(routeName) {
      if (routeName === this.$route.name) {
        this.toggleMenu(false)
      } else {
        this.toggleMenu(false)
        this.$router.push({ name: routeName })
      }
    },
  },
}
</script>

<style scoped lang="scss">
.logo {
  width: 90px;

  @media only screen and (min-width: 1024px) {
    width: 100%;
  }
}

nav {
  position: fixed;
  z-index: 50;
  background-color: #404040;
  width: 100%;
  height: 50px;
  overflow: hidden;
  transition: height 350ms ease-in-out;

  @media only screen and (min-width: 1024px) {
    transition: initial;
    position: relative;
    width: auto;
    height: 100%;
  }

  .js-hamburger--open & {
    @media only screen and (max-width: 1024px) {
      height: 100vh;
    }
  }
}

.nav-inner {
  height: 53px;
  position: relative;
  top: 0;
  width: 100%;

  @media only screen and (min-width: 1024px) {
    height: auto;
  }
}

.nav-inner-sibling {
  height: 0;
  transition: height 350ms ease-in-out;

  @media only screen and (min-width: 1024px) {
    transition: initial;
    height: auto;
  }

  .js-hamburger--open & {
    @media only screen and (max-width: 1024px) {
      height: 100vh;
    }
  }
}
</style>
