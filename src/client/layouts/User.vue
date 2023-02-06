<template>
  <main id="main">
    <UserSideBar />
    <div
      class="
        body
        lg:pb-16 lg:px-16
        min-h-screen
        bg-black
        text-white
        flex flex-col
        relative
      "
    >
      <nuxt />
      <Footer />
    </div>
  </main>
</template>

<script>
import UserSideBar from './User/UserSideBar'
import Footer from '~/components/Footer'

export default {
  name: 'UserLayout',
  scrollToTop: false,
  middleware: ['auth', 'user-middleware'],
  components: {
    UserSideBar,
    Footer,
  },
}
</script>

<style lang="scss" scoped>
.body {
  padding-top: 50px;
}

#main {
  display: grid;

  @media only screen and (min-width: 1024px) {
    grid-template-columns: 20% 80%;
  }

  @media only screen and (min-width: 1280px) {
    grid-template-columns: 15% 85%;
  }
}
</style>
