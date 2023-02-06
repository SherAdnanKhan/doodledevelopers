<template>
  <main id="main">
    <AdminSideBar />
    <div class="px-4 py-16 lg:px-16 min-h-screen lg:pt-16">
      <nuxt />
    </div>
  </main>
</template>

<script>
import AdminSideBar from './Admin/AdminSideBar'

export default {
  name: 'AdminLayout',
  middleware: ['auth', 'admin-middleware'],
  components: {
    AdminSideBar,
  },
}
</script>

<style lang="scss" scoped>
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
