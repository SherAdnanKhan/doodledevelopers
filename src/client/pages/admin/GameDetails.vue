<template>
  <div>
    <div v-if="Object.keys(currentGameDetails).length" class="flex mt-4 w-full">
      <div
        class="
          card
          w-full
          bg-white
          p-0
          rounded
          cursor-pointer
          bg-opacity-75
          shadow-lg
        "
      >
        <div
          class="
            card-header
            bg-green-600
            p-4
            text-xl
            font-bold
            flex
            items-center
            border-b-4 border-gold
          "
        >
          <img
            src="https://cdna.artstation.com/p/assets/images/images/023/459/708/large/vaibhav-verma-game-logo.jpg?1579270067"
            width="100"
            height="100"
            class="
              shadow
              rounded-full
              max-w-full
              h-auto
              align-middle
              border-none
            "
          />
          <div class="flex flex-col ml-2">
            <span class="uppercase text-white">{{
              currentGameDetails.name
            }}</span>
            <span class="text-tiny text-white font-normal">
              Ending in
              {{ currentGameDetails.days_remaining }} day(s)
            </span>
          </div>
        </div>
        <div class="card-body p-4 grid grid-cols-3 gap-2">
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Start date</b>
            <span>{{ currentGameDetails.start_date }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">End date</b>
            <span>{{ currentGameDetails.end_date }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Admin Earnings</b>
            <span>{{ currentGameDetails.admin_earning }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Number of Winners</b>
            <span>{{ currentGameDetails.number_of_winners }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Jackpot Value</b>
            <span>{{ currentGameDetails.jackpot_value }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500">Game Status</b>
            <span>{{ currentGameDetails.status.name }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Entry Fee</b>
            <span>{{ currentGameDetails.entry_fee }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Jackpot Value</b>
            <span>{{ currentGameDetails.jackpot_value }}</span>
          </div>
          <div class="mb-2 text-grey flex flex-col">
            <b class="text-green-500 mb-1">Pot Value</b>
            <span>{{ currentGameDetails.pot_value }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-2 w-3/4 gap-4 mx-auto">
      <div class="flex items-center flex-row my-8 justify-center gap-4 bg">
        <button
          class="
            card-header
            p-3
            rounded
            text-2xl text-center text-white
            bg-green-700
            focus:outline-none
            h-a
            w-full
          "
          @click="editGame()"
        >
          Edit Game
        </button>
      </div>
      <div class="flex items-center flex-row my-8 justify-center gap-4 bg">
        <button
          class="
            card-header
            p-3
            rounded
            text-2xl text-center text-white
            bg-green-700
            focus:outline-none
            h-a
            w-full
          "
          @click="deleteGame()"
        >
          Delete Game
        </button>
      </div>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">
          {{ $t('edit_game') }}
        </h1>
      </template>
      <template slot="content">
        <edit-game-form @edit-game="getDetails" />
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'
import editGameForm from '~/components/Admin/editGameForm.vue'

export default {
  name: 'AdminGameDetails',
  layout: 'Admin',
  components: {
    BaseModal,
    editGameForm,
  },
  async asyncData({ store, route }) {
    if (route.params.id) {
      await store.dispatch('AdminGameStore/getGameDetails', route.params.id)
    }
  },
  data: () => ({
    modalVisible: false,
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('AdminGameStore', ['currentGameDetails', 'getErrorMessage']),
  },
  methods: {
    ...mapActions('AdminGameStore', [
      'getGameDetails',
      'editAdminGames',
      'delAdminGames',
    ]),
    async getDetails() {
      this.modalVisible = false
      const text = this.$t('edit_successfull')
      swal.fire({
        text,
        type: 'success',
        title: 'Edited Successfully',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
      })
      if (this.$route.params.id) {
        await this.getGameDetails(this.$route.params.id)
      }
    },
    editGame() {
      if (this.currentGameDetails) {
      }
      this.modalVisible = true
    },
    async deleteGame() {
      if (this.currentGameDetails) {
        const payload = this.currentGameDetails.id
        try {
          await this.delAdminGames(payload)
        } catch (e) {}
        if (!this.getErrorMessage) {
          const text = this.$t('delete_successfull')
          swal.fire({
            text,
            type: 'success',
            title: 'Deleted Successfully',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
          this.$router.push({
            name: 'all-games',
          })
          return true
        } else {
          const text = this.getErrorMessage
          swal.fire({
            text,
            type: 'error',
            title: 'Error',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
        }
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

<style></style>
