<template>
  <nav
    class="
      z-10
      lg:ml-auto
      flex
      items-center
      justify-center
      flex-col
      lg:flex-row
    "
  >
    <ul
      v-if="$route.name !== 'game'"
      class="flex text-white items-center text-center"
    >
      <template v-if="isAuthenticated">
        <li class="mb-0 flex flex-1 justify-center text-center mr-4">
          <nuxt-link
            to="/live-games"
            class="whitespace-nowrap"
            @click.native="toggleMenu(true)"
          >
            {{ $t('live-games') }}
          </nuxt-link>
        </li>
        <li class="mb-0 flex flex-1 justify-center text-center mr-4">
          <a
            href="#"
            @click.prevent="
              logout()
              toggleMenu(true)
            "
          >
            {{ $t('logout') }}
          </a>
        </li>
      </template>
      <template v-else-if="isAdmin">
        <li class="mb-0 flex flex-1 items-center mr-4">
          <nuxt-link
            to="/admin/dashboard"
            class="ml-6 whitespace-nowrap"
            @click.native="toggleMenu(true)"
          >
            {{ $t('admin_dashboard') }}
          </nuxt-link>
        </li>
        <li class="mb-0 flex flex-1 items-center mr-4">
          <a
            href="#"
            class=":mb-0 flex flex-1 items-center whitespace-nowrap"
            @click.prevent="
              logout()
              toggleMenu(true)
            "
          >
            {{ $t('logout') }}
          </a>
        </li>
      </template>
      <template v-else>
        <li class="mb-0 flex flex-1 items-center mr-4 justify-center">
          <router-link
            :to="{ name: 'login' }"
            :class="{ 'text-red-600': $nuxt.$route.name === 'login' }"
            class="inline-block whitespace-nowrap"
            @click.native="toggleMenu(true)"
          >
            {{ $t('login') }}
          </router-link>
        </li>
        <li class="mb-0 flex flex-1 items-center mr-4 justify-center">
          <router-link
            :to="{ name: 'register' }"
            :class="{ 'text-red-600': $nuxt.$route.name === 'register' }"
            class="inline-block whitespace-nowrap"
            @click.native="toggleMenu(true)"
          >
            {{ $t('register') }}
          </router-link>
        </li>
      </template>
    </ul>
  </nav>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('auth', ['currentUser', 'isAuthenticated', 'isAdmin']),
  },
  methods: {
    toggleMenu(menuToClose) {
      this.$emit('mobileMenuVisibleToggle', menuToClose)
    },
    logout() {
      this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'welcome' })
    },
  },
}
</script>
<style lang="scss" scoped>
nav {
  position: relative;
  transition: top 350ms ease-in-out, height 350ms ease-in-out;

  @media only screen and (min-width: 1024px) {
    top: 0;
  }

  .js-hamburger--open & {
    @media only screen and (max-width: 1024px) {
      top: 0;
      height: 100vh;
    }
  }
}

.whitespace-nowrap {
  white-space: nowrap;
}
</style>
