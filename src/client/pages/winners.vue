<template>
  <div class="container mx-auto max-w-2xl px-4 py-4">
    <div class="grid grid-cols-1 gap-4">
      <div class="flex flex-row">
        <div class="card-header text-center flex-1 mb-4 lg:mb-8">
          <h1 class="text-2xl text-white">Previous Winners</h1>
          <p>
            Please note: All winnings will be paid by bank transfer after the
            winners have been through our K.Y.C. Process
          </p>
        </div>
      </div>
      <Winners :winners="mappedWinners"  />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Winners from '~/components/Shared/Winners.vue'

export default {
  layout: 'User',
  middleware: 'auth',
  components: {
    Winners,
  },
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getUserEarningGames')
  },
  data: () => ({
    title: process.env.appName,
    refreshing: false,
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userEarningGames']),
    mappedWinners() {
      if (!this.userEarningGames && !this.userEarningGames.length) {
        return []
      }
      return this.userEarningGames
        .filter((game) => game.historical_earnings && game.historical_earnings.length)
        .map((game) => ({
          gameName: game.name,
          winners: game.historical_earnings,
        }))
    },
  },
  head() {
    return { title: 'Winners' }
  },
}
</script>
