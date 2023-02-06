<template>
  <header class="flex flex-row items-center z-50 w-full top-0 fixed">
    <div class="w-full flex">
      <nuxt-link
        :to="logoLink"
        class="header-logo"
        @click.native="toggleMenu(true)"
      >
        <IconLogo />
      </nuxt-link>
      <div
        v-if="isAuthenticated && $route.name !== 'game'"
        class="text-center lg:mr-6 lg:ml-auto flex items-center"
      >
        <div
          v-if="currentUser && currentUser.photo_url"
          class="rounded-full h-24 w-24 m-auto"
          :style="{ backgroundImage: 'url(' + currentUser.photo_url + ')' }"
        />
        <h3 v-if="currentUser.name" class="text-red-600 text-xl mt-3 mb-3">
          {{ currentUser.name }}
        </h3>
        <p v-if="currentUser.email" class="text-white text-xs">
          {{ currentUser.email }}
        </p>
      </div>
      <div
        v-if="$route.name === 'game'"
        class="playing__header flex-1 flex flex-row"
      >
        <div class="playing__shoots flex w-full justify-end"></div>
      </div>
    </div>
    <Navigation @mobileMenuVisibleToggle="toggleMenu" />
  </header>
</template>
<script>
import { mapGetters } from 'vuex'
import Navigation from '~/components/Navigation'
import IconLogo from '~/components/svg/IconLogo'

export default {
  name: 'Header',
  components: {
    IconLogo,
    Navigation,
  },
  data: () => ({
    userMenuOpen: false,
  }),
  computed: {
    ...mapGetters('auth', ['userName', 'currentUser', 'isAuthenticated']),
    logoLink() {
      let link = '/'
      if (this.currentUser) {
        link = this.currentUser.is_admin ? '/admin/dashboard' : '/live-games'
      }
      return link
    },
  },
  methods: {
    registerButton() {
      this.$router.push({
        name: 'register',
        query: { redirect: this.$router.currentRoute },
      })
    },
    toggleMenu(value) {
      this.$emit('mobileMenuVisibleToggle', value)
    },
    async logout() {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      await this.$router.push({ path: '/' })
    },
  },
}
</script>

<style scoped lang="scss">
header {
  min-height: 54px;
}
</style>
