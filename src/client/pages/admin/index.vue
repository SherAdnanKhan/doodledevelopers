<template>
  <div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <AllUsersWidget :users="allUsers" table-title="All Users" />
      <AllUsersWidget :users="newUsers" table-title="Recent Sign Ups" />
    </div>
    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
      <AllGamesWidget :allgames="adminAllGames" widget-title="All Games" />
      <AllGamesWidget :allgames="playedGames" widget-title="Finished Games" />
    </div>
    <LeaderBoard :games="mappedGames" text-color="text-white" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LeaderBoard from '~/components/Shared/LeaderBoard.vue'
import AllGamesWidget from '~/components/Admin/AllGamesWidget.vue'
import AllUsersWidget from '~/components/Admin/AllUsersWidget.vue'

export default {
  name: 'AdminPage',
  layout: 'Admin',
  components: {
    LeaderBoard,
    AllGamesWidget,
    AllUsersWidget,
  },
  async asyncData({ store }) {
    await store.dispatch('AdminGameStore/getAdminGames')
    await store.dispatch('AdminUsersStore/getAllUsers')
  },
  computed: {
    ...mapGetters('AdminGameStore', ['adminAllGames']),
    ...mapGetters('AdminUsersStore', ['allUsers']),
    mappedGames() {
      if (!this.adminAllGames && !this.adminAllGames.length) return []

      return this.adminAllGames
        .filter((game) => game.players && game.players.length)
        .map((game) => ({
          gameName: game.name,
          players: game.players,
        }))
    },
    playedGames() {
      if (!this.adminAllGames.length) return []
      return this.adminAllGames.filter(
        (game) => game.status.name.toLowerCase() === 'finished'
      )
    },
    newUsers() {
      if (!this.allUsers.length) return []
      return this.allUsers.filter((user) => !user.is_viewed)
    },
  },
  head() {
    return {
      title: 'Admin',
    }
  },
}
</script>
