<template>
  <nav class="lg:h-full flex flex-col w-full">
    <div class="nav-inner flex flex-row lg:flex-col items-center h-full w-full">
      <nuxt-link
        to="/admin/dashboard"
        class="
          lg:w-full
          inline-flex
          lg:l-auto lg:mr-auto lg:mb-8
          logo
          h-full
          lg:h-auto
        "
        @click="toggleMenu(true)"
      >
        <IconLogo class="w-full" />
      </nuxt-link>
      <div
        v-if="isAuthenticated"
        class="text-center lg:mr-6 ml-auto lg:ml-0 lg:mb-8"
      >
        <div
          v-if="currentUser && currentUser.photo_url"
          class="rounded-full h-24 w-24 bg-white m-auto"
          :style="{ backgroundImage: 'url(' + currentUser.photo_url + ')' }"
        />
        <p v-if="currentUser.username" class="text-white text-xs">
          {{ currentUser.username }}
        </p>
      </div>
      <div class="c-hamburger z-20 ml-8 pr-4 lg:hidden">
        <div @click="toggleMenu(false)">
          <span />
          <span />
          <span />
          <span />
        </div>
      </div>
    </div>
    <button
      class="rounded-full w-24 h-24 mx-auto bg-red text-white block"
      @click="stopAllGames"
    >
      Stop
    </button>
    <div class="overflow-scroll lg:overflow-auto w-full max-h-full">
      <ul class="text-grey pt-8">
        <li
          v-for="(navItem, index) in navItems"
          :key="index"
          class="
            px-2
            py-6
            transition
            duration-500
            cursor-pointer
            hover:bg-red hover:bg-opacity-75 hover:text-white
            text-white
            border-l-4 border-transparent
            hover:border-gold
            flex
          "
          :class="{
            'bg-red text-white border-l-4 border-gold':
              $nuxt.$route.name.includes(navItem.name),
          }"
          @click="performNavigation(navItem.name)"
        >
          <div class="inline-block align-middle"></div>
          <p
            class="
              ml-6
              py-2
              lg:hover:border-red lg:hover:text-white
              transition
              duration-500
              cursor-pointer
              flex
            "
            :class="{
              'border-red text-white': $nuxt.$route.name.includes(navItem.name),
            }"
          >
            {{ $t(navItem.title) }}
          </p>
        </li>
        <li
          class="
            mb-6
            p-2
            px-2
            py-6
            transition
            duration-500
            cursor-pointer
            hover:bg-red hover:bg-opacity-75 hover:text-white
            text-white
            border-l-4 border-transparent
            hover:border-gold
            flex
          "
          @click="logout"
        >
          <div class="inline-block align-middle"></div>
          <a href="#" class="ml-6">
            {{ $t('logout') }}
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import IconLogo from '~/components/svg/IconLogo'
export default {
  name: 'AdminSideBar',
  components: {
    IconLogo,
  },
  data: () => ({
    mobileMenuVisible: false,
    navItems: [
      {
        name: 'admin-dashboard',
        title: 'dashboard',
      },
      {
        name: 'all-users',
        title: 'all_users',
      },
      {
        name: 'all-games',
        title: 'all_games',
      },
      {
        name: 'admin-kyc',
        title: 'admin-kyc',
      },
      {
        name: 'hear-about-us',
        title: 'hear_about_us',
      },
      {
        name: 'admin-payments',
        title: 'payments',
      },
      {
        name: 'admin-configurations',
        title: 'admin_configurations',
      },
      {
        name: 'admin-support',
        title: 'admin-support',
      },
    ],
  }),
  computed: {
    ...mapGetters('auth', ['userName', 'currentUser', 'isAuthenticated']),
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
      await this.$store.dispatch('auth/logout')
      this.$router.push({
        name: 'welcome',
      })
    },
    async stopAllGames() {
      try {
        await this.$store.dispatch('AdminGameStore/stopAllUserGames')
      } catch (e) {}
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
  transition: height 350ms ease-in-out;
  overflow: hidden;

  @media only screen and (min-width: 1024px) {
    position: relative;
    width: auto;
    height: 100%;
    flex-flow: column;
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
</style>
