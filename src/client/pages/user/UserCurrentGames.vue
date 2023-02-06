<template>
  <CurrentGames />
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'UserCurrentGames',
  layout: 'User',
  scrollToTop: false,
  components: {
    CurrentGames: () => import('@/components/User/CurrentGames.vue'),
  },
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getUserGames')
  },
  data: () => ({
    headerItems: [
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'entry_fee',
        name: 'Entry fee',
      },
      {
        id: 'days_remaining',
        name: 'Days left',
      },
    ],
  }),
  computed: {
    ...mapGetters({
      userGames: 'UserGameStore/userAllGames',
    }),
  },
  methods: {
    rowClicked(payload) {
      console.log('Following Row is Clicked', payload)
    },
  },
}
</script>

<style></style>
