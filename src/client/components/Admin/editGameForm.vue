<template>
  <div class="w-full">
    <div class="grid grid-cols-2 gap-6 items-center" @keyup.enter="editGame">
      <div class="group">
        <label class="text-white text-xs transition-colors duration-300">
          {{ $t('game_name') }}
        </label>
        <input
          v-model="name"
          type="text"
          name="game_name"
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
        />
      </div>
      <div class="group">
        <label class="text-white text-xs transition-colors duration-300">
          {{ $t('jackpot_value') }}
        </label>
        <input
          v-model="jackpotValue"
          type="number"
          min="0"
          name="jackpot_value"
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
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('admin_fee_percentage') }}
        </label>
        <input
          v-model="adminPercentage"
          type="number"
          min="0"
          name="admin_fee_percentage"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('number_of_winners') }}
        </label>
        <input
          v-model="numberOfWinners"
          type="number"
          min="0"
          name="number_of_winners"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('entry_fee') }}
        </label>
        <input
          v-model="entryFee"
          type="number"
          name="entry_fee"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('game_ext_days') }}
        </label>
        <input
          v-model="gameExtensionDays"
          type="number"
          name="game_ext_days"
          min="0"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('start_date') }}
        </label>
        <input
          v-model="startDate"
          type="date"
          name="start_date"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-xs block">
          {{ $t('end_date') }}
        </label>
        <input
          v-model="endDate"
          type="date"
          name="end_date"
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
            focus:outline-none focus:border-red
          "
        />
      </div>
      <div class="col-span-2">
        <label class="text-white text-xs block">
          {{ $t('status') }}
        </label>
        <select
          v-model="gameStatus"
          name="gameStatus"
          class="w-full h-12 bg-white text-gray-900 border-r-2 p-1"
          required
        >
          <option value="">Select Status</option>
          <option value="notstarted">Not Started</option>
          <option value="live">Live</option>
          <option value="finished">Finished</option>
        </select>
      </div>
    </div>
    <button class="btn mt-5 w-full" type="button" @click="editGame()">
      {{ $t('edit_game') }}
    </button>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import swal from 'sweetalert2'
export default {
  name: 'CreateGameForm',
  data: () => ({
    name: '',
    entryFee: '',
    jackpotValue: '',
    adminPercentage: 0,
    gameExtensionDays: '',
    startDate: Date.now(),
    endDate: Date.now(),
    gameStatus: '',
    numberOfWinners: '',
  }),
  computed: {
    ...mapGetters('AdminGameStore', ['currentGameDetails', 'updateAdminGame']),
  },
  beforeMount() {
    if (this.currentGameDetails) {
      this.name = this.currentGameDetails.name
      this.entryFee = this.currentGameDetails.entry_fee
      this.jackpotValue = this.currentGameDetails.jackpot_value
      this.adminPercentage = this.currentGameDetails.admin_fee_percentage
      this.numberOfWinners = this.currentGameDetails.number_of_winners
      this.gameExtensionDays = this.currentGameDetails.game_ext_days
      this.startDate = new Date(this.currentGameDetails.start_date)
        .toISOString()
        .slice(0, 10)
      this.endDate = new Date(this.currentGameDetails.end_date)
        .toISOString()
        .slice(0, 10)
      this.gameStatus = this.currentGameDetails.status.id
    }
  },
  methods: {
    ...mapActions('AdminGameStore', ['editAdminGames']),
    validateForm() {
      const text = this.$t('required_fields_error')
      swal.fire({
        text,
        type: 'error',
        title: 'Fill all Fields',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
      })
      return false
    },
    async editGame() {
      if (
        !this.name ||
        !this.entryFee ||
        !this.adminPercentage ||
        !this.jackpotValue ||
        !this.gameExtensionDays ||
        !this.startDate ||
        !this.endDate ||
        !this.numberOfWinners ||
        !this.gameStatus
      ) {
        this.validateForm()
        return false
      }
      try {
        const payload = {
          name: this.name,
          jackpot_value: this.jackpotValue,
          admin_fee_percentage: this.adminPercentage,
          entry_fee: this.entryFee,
          game_ext_days: this.gameExtensionDays,
          start_date: this.startDate,
          end_date: this.endDate,
          number_of_winners: this.numberOfWinners,
          status: this.gameStatus,
        }

        const res = {
          gameId: this.currentGameDetails.id,
          details: payload,
        }
        await this.editAdminGames(res)
        this.$emit('edit-game')
      } catch (e) {
        const errors = e.response.data.errors.errors
        if (Object.keys(errors)[0]) {
          swal.fire({
            text: errors[Object.keys(errors)[0]],
            type: 'error',
            title: 'Error',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
        }
      }
    },
  },
}
</script>

<style></style>
