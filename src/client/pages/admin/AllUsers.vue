<template>
  <div class="grid grid-cols-1 gap-4">
    <all-users-widget
      table-title="All Users"
      :users="allUsers"
      @row-clicked="getUserDetails"
    ></all-users-widget>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'AllUsers',
  layout: 'Admin',
  components: {
    AllUsersWidget: () => import('~/components/Admin/AllUsersWidget.vue'),
  },
  async asyncData({ store }) {
    await store.dispatch('AdminUsersStore/getAllUsers')
  },
  computed: { ...mapGetters('AdminUsersStore', ['allUsers']) },
  methods: {
    getUserDetails(payload) {
      this.$router.push({ name: 'user-details', params: { id: payload.id } })
    },
  },
}
</script>

<style></style>
