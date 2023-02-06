<template>
  <div class="w-full">
    <div class="grid grid-cols-2 gap-6 items-center" @keyup.enter="createGame">
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
          {{ $t('admin_map') }}
        </label>
        <select
          v-model="mapId"
          name="mapId"
          class="rounded w-full text-gray-900 border-r-2 p-1"
          required
        >
          <option value="" class="rounded">Select Map</option>
          <option
            v-for="(map, index) in getMappedData"
            :key="index"
            :value="map.value"
            class="rounded"
          >
            {{ map.label }}
          </option>
        </select>
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
    </div>
    <button class="btn mt-5 w-full" type="button" @click="createGame()">
      {{ $t('create_new_game') }}
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
    adminPercentage: null,
    gameExtensionDays: '',
    startDate: Date.now(),
    endDate: Date.now(),
    mapId: '',
  }),
  computed: {
    ...mapGetters('AdminMapStore', ['allMaps']),
    ...mapGetters('AdminGameStore', ['getErrorMessage']),
    getMappedData() {
      if (this.allMaps && !this.allMaps.length) return []
      return this.allMaps.map((map) => ({
        label: `map ${map.id}`,
        value: map.id,
      }))
    },
  },
  methods: {
    ...mapActions('AdminGameStore', ['createNewGame']),
    validateForm() {
      if (
        !this.name ||
        !this.entryFee ||
        !this.jackpotValue ||
        !this.adminPercentage ||
        !this.gameExtensionDays ||
        !this.mapId
      ) {
        const text = this.$t('required_fields_error')
        swal.fire({
          text,
          type: 'error',
          title: 'Fill all Fields',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      return true
    },
    async createGame() {
      if (!this.validateForm()) {
        return
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
          map_id: this.mapId,
        }
        await this.createNewGame(payload)
        this.$emit('game-created')
      } catch (e) {
        const errors = this.getErrorMessage.response.data.errors.errors
        if (Object.keys(errors).length) {
          swal.fire({
            html: Object.values(errors).join('<br>'),
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
