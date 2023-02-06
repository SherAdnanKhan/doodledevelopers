<template>
  <div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <CurrentGames
        :user-all-games="userAllGames"
        widget-title="All Games"
        :is-all-games="true"
      />
      <CurrentGames
        :user-all-games="currentGames"
        widget-title="Current Games"
        :is-all-games="false"
      />
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <CurrentGames
        :user-all-games="gameHistory"
        widget-title="Game History"
        :is-all-games="false"
      />
      <base-table
        :table-title="widgetTitle"
        :header-items="headerItems"
        :records="userCreditHistory"
        @on-row-click="rowClicked"
      >
        <template slot="name" slot-scope="{ item }">
          <div>
            {{ item.game.name }}
          </div>
        </template>
        <template slot="status" slot-scope="{ item }">
          <div>
            {{ item.game.status.name }}
          </div>
        </template>
        <template slot="entry_fee" slot-scope="{ item }">
          <div>
            {{ item.game.entry_fee }}
          </div>
        </template>
        <template slot="map" slot-scope="{ item }">
          <div>
            {{ item.map.id }}
          </div>
        </template>
        <template slot="no-items"> Nothing Found </template>
      </base-table>
    </div>
    <LeaderBoard :games="mappedGames" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LeaderBoard from '~/components/Shared/LeaderBoard.vue'
// import PlayCredit from '~/components/User/PlayCredit.vue'
import CurrentGames from '~/components/User/CurrentGames.vue'
export default {
  name: 'UserDashboard',
  layout: 'User',
  scrollToTop: false,
  components: {
    // PlayCredit,
    CurrentGames,
    LeaderBoard,
  },
  props: {
    widgetTitle: {
      type: String,
      default: 'Game Credit History',
    },
  },
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getUserGames')
    await store.dispatch('UserGameStore/getUserCurrentGames')
    await store.dispatch('UserGameStore/getUserCreditHistory')
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
        id: 'credit',
        name: 'Credit',
      },
      {
        id: 'entry_fee',
        name: 'Entry Fee',
      },
      {
        id: 'map',
        name: 'Map',
      },
    ],
  }),
  computed: {
    ...mapGetters('UserGameStore', [
      'userAllCurrentGames',
      'userCurrentGameScore',
      'userAllGames',
      'userCreditHistory',
      'userLeaderboardGames',
    ]),
    mappedGames() {
      if (!this.userLeaderboardGames && !this.userLeaderboardGames.length)
        return []

      return this.userLeaderboardGames
        .filter((game) => game.players && game.players.length)
        .map((game) => ({
          gameName: game.name,
          players: game.players,
        }))
    },
    gameHistory() {
      if (!this.userAllGames.length) return []
      return this.userAllGames.filter(
        (playedgames) => playedgames.status.name.toLowerCase() === 'finished'
      )
    },
    currentGames() {
      if (!this.userAllCurrentGames.length) return []
      return this.userAllCurrentGames.filter(
        (playedgames) => playedgames.status.name.toLowerCase() === 'live'
      )
    },
  },
  methods: {
    rowClicked() {
      // TODO: Do something...
    },
  },
}
</script>

<style></style>
