<template>
  <div class="pl-4 pr-4 max-w-4xl m-auto">
    <div class="mt-4 grid grid-cols-1 gap-4">
      <h1 class="text-2xl lg:text-4xl text-center px-8">
        Welcome to Invite a Friend!
      </h1>
      <p class="text-lg text-center mb-8 px-8">
        You must enter a competition 5 times to activate your unique code. Remember, the more friends that play, the more free credits you will earn. Why leave things to chance?!
      </p>
    </div>
    <div class="mt-4 grid lg:grid-cols-2 gap-8">
      <div v-for="(game, pos) in games" :key="pos">
        <div v-if="game.players.length" class="c-card">
          <template class="c-card">
            <div
              class="game-card-image rounded mb-4 border border-gray-600"
              :style="{
                backgroundImage:
                  'url(' + require('~/assets/images/game.png') + ')',
              }"
            />
            <h2
              v-if="
                game.players[0].number_of_times_played &&
                game.players[0].number_of_times_played <= 4
              "
              class="text-base"
            >
              You've played
              <span class="font-bold text-gold">{{ game.gameName }}</span>
              {{ game.players[0].number_of_times_played }}
              <span v-if="game.players.number_of_times_played > 1">times,</span>
              <span v-else>time(s),</span>
              {{ parseInt(5 - game.players[0].number_of_times_played) }}
              attempt(s) left to get a social sharing link and a free go.
            </h2>
            <div v-else class="text-center c-card">
              <h1 class="text-2xl">{{ game.gameName }}</h1>
              <h2 class="text-base">
                Congratulations! Your activation code is now ready.
              </h2>
              <h2 class="text-base mb-4">
                Please copy the link below to invite your friends and earn free credits.
              </h2>
              <button
                class="
                  card-header
                  py-3
                  px-6
                  text-1xl text-center
                  bg-gold
                  focus:outline-none
                  w-full
                  mx-auto
                  text-black
                  rounded
                "
                @click="copyInvitationCode(game.gameId)"
              >
                Copy invitation link
              </button>
            </div>
          </template>
          <template slot="no-items"> Nothing Found </template>
        </div>
      </div>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Invitation Link</h1>
      </template>
      <template slot="content">
        <div
          class="max-w-xl flex flex-col w-full"
          @keyup.enter="invitationMethod"
        >
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Invitation Link
            </label>
            <input
              v-model="invitationCode"
              type="text"
              name="invitationCode"
              class="
                bg-brand
                text-white
                px-2
                h-8
                mt-4
                mb-4
                w-full
                border-white
                transition-colors
                duration-300
                border-b
                bg-transparent
                group-focus:border-red
                focus:outline-none focus:border-red
              "
              required
            />
          </div>
          <p class="text-green-600">{{ copyMsg }}</p>
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="invitationMethod"
          >
            {{ buttonText }}
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'UserInvitationCode',
  components: { BaseModal },
  props: {
    games: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    headerItems: [
      {
        id: 'details',
        name: '',
      },
    ],
    modalVisible: false,
    copyMsg: '',
    invitationCode: '',
    buttonText: '',
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('UserGameStore', ['gameInvitationLink']),
    getInvitationLink() {
      if (!this.gameInvitationLink) {
        return ''
      } else {
        return this.gameInvitationLink.invitation_link
      }
    },
  },
  methods: {
    ...mapActions('UserGameStore', ['getGameInvitationLink']),
    async copyInvitationCode(payload) {
      await this.getGameInvitationLink(payload)
      this.invitationCode = this.getInvitationLink
      this.buttonText = 'Copy Invitation Link'
      this.isCopyButton = true
      this.toggleModal()
    },
    toggleModal() {
      this.modalVisible = true
    },
    async copyCode() {
      try {
        await this.$copyText(this.invitationCode)
        this.copyMsg = 'Copied!'
      } catch (e) {
        console.error(e)
      }
    },
    invitationMethod() {
      if (this.isCopyButton) {
        this.copyCode()
      } else {
      }
    },
    escEvent(e) {
      if (e.key === 'Escape' && this.modalVisible === true) {
        this.modalVisible = false
      }
    },
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
}
</script>
<style scoped lang="scss">
.c-card {
  border-radius: 12px;
  border: 1px solid white;
  padding: 1rem;
  overflow: hidden;
  border: 1px solid gray;
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 35%);
}
</style>
