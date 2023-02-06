<template>
  <div class="container mx-auto max-w-2xl px-4 py-4 lg:pb-16">
    <div class="grid grid-cols-1 gap-4">
      <div class="flex flex-row relative">
        <div class="card-header text-2xl text-center text-white flex-1">
          Leaderboard(s)
        </div>
        <div class="absolute right-0">
          <svg
            width="35px"
            height="35px"
            class="text-white cursor-pointer"
            :class="{ 'animate-spin text-green-500': refreshing }"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            @click="refreshLeaderboard"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
            />
          </svg>
        </div>
      </div>
      <leader-board :games="mappedGames" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LeaderBoard from '~/components/Shared/LeaderBoard.vue'

export default {
  layout: 'User',
  middleware: 'auth',
  components: {
    LeaderBoard,
  },
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getLeaderboardGames')
  },
  data: () => ({
    title: process.env.appName,
    refreshing: false,
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userLeaderboardGames']),
    mappedGames() {
      if (!this.userLeaderboardGames && !this.userLeaderboardGames.length) {
        return []
      }
      return this.userLeaderboardGames
        .filter((game) => game.players && game.players.length)
        .map((game) => ({
          gameName: game.name,
          players: game.players,
        }))
    },
  },
  methods: {
    async refreshLeaderboard() {
      this.refreshing = true
      await this.$store.dispatch('UserGameStore/getLeaderboardGames')
      this.refreshing = false
    },
  },
  head() {
    return { title: 'Leaderboard' }
  },
}
</script>
