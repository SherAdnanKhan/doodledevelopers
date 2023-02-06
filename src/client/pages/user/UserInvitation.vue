<template>
  <div class="lg:w-3/4 mx-auto">
    <div v-if="linkNotFound">
      <UserInvitationCode :games="mappedGames" />
    </div>
    <div v-else class="flex mt-4 lg:w-3/4 mx-auto">
      <div
        class="
          card
          w-full
          bg-gray-800
          p-0
          rounded
          cursor-pointer
          bg-opacity-75
          hover:bg-gray-900
          transition
          duration-500
        "
      >
        <div
          class="
            card-header
            rounded
            bg-green-600
            p-4
            text-xl
            font-bold
            flex
            items-center
          "
        >
          <h2>You haven't played any game</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import UserInvitationCode from '~/components/User/UserInvitationCode.vue'
export default {
  name: 'UserInvitation',
  scrollToTop: false,
  layout: 'User',
  components: { UserInvitationCode },
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getInvitationGames')
  },
  data: () => ({
    copyMsg: '',
    playersPresent: false,
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userInvitationGames', 'getInvitationUserId']),
    mappedGames() {
      if (!this.userInvitationGames && !this.userInvitationGames.length)
        return []

      return this.userInvitationGames
        .filter(
          (game) =>
            game.players &&
            game.players.length &&
            game.status.id.toLowerCase() === 'live'
        )
        .map((game) => ({
          gameName: game.name,
          gameId: game.id,
          players: game.players.filter(
            (userId) => userId.user.id === this.getInvitationUserId
          ),
        }))
    },
    linkNotFound() {
      if (!this.userInvitationGames && !this.userInvitationGames.length)
        return []

      const payload = this.userInvitationGames
        .filter(
          (game) =>
            game.players &&
            game.players.length &&
            game.status.id.toLowerCase() === 'live'
        )
        .map((game) => ({
          check: game.players.filter(
            (userId) => userId.user.id === this.getInvitationUserId
          ).length,
        }))
      for (let a = 0; a < payload.length; a++) {
        if (payload[a].check !== 0) {
          return true
        }
      }

      return false
    },
  },
}
</script>
