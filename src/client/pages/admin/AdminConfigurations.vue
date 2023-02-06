<template>
  <div class="w-full">
    <div class="grid grid-cols-2 gap-6 items-center">
      <div class="group">
        <label class="text-white text-xs transition-colors duration-300">
          {{ $t('min_deposit_amount') }}
        </label>
        <input
          v-model="minDepositAmount"
          type="number"
          min="0"
          name="min_deposit_amount"
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
          {{ $t('max_deposit_amount') }}
        </label>
        <input
          v-model="maxDepositAmount"
          type="number"
          min="0"
          name="max_deposit_amount"
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
          {{ $t('min_withdrawal_amount') }}
        </label>
        <input
          v-model="minWithdrawalAmount"
          type="number"
          min="0"
          name="min_withdrawal_amount"
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
          {{ $t('max_withdrawal_amount') }}
        </label>
        <input
          v-model="maxWithdrawalAmount"
          type="number"
          min="0"
          name="max_withdrawal_amount"
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
          {{ $t('amount_of_balls_to_fire') }}
        </label>
        <input
          v-model="amountOfBallsToFire"
          type="number"
          min="0"
          name="amount_of_balls_to_fire"
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
          {{ $t('total_attempts') }}
        </label>
        <input
          v-model="totalAttempts"
          type="number"
          min="0"
          name="total_attempts"
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
          {{ $t('currency_conversion_duration') }}
        </label>
        <input
          v-model="currencyConversionDuration"
          type="number"
          min="0"
          name="currency_conversion_duration"
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
    </div>
    <button
      class="btn mt-5 w-full"
      type="button"
      @click="updateConfiguration()"
    >
      {{ $t('admin_update_configuration') }}
    </button>
  </div>
</template>

<script>
import swal from 'sweetalert2'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'AdminConfigurations',
  layout: 'Admin',
  async asyncData({ store }) {
    await store.dispatch('AdminConfigurationStore/getAllConfigurations')
  },
  data: () => ({
    minDepositAmount: null,
    maxDepositAmount: null,
    minWithdrawalAmount: null,
    maxWithdrawalAmount: null,
    amountOfBallsToFire: null,
    totalAttempts: null,
    currencyConversionDuration: null,
  }),
  beforeMount() {
    if (this.allConfigurations) {
      this.minDepositAmount = this.allConfigurations.min_deposit_amount
      this.maxDepositAmount = this.allConfigurations.max_deposit_amount
      this.minWithdrawalAmount = this.allConfigurations.min_withdrawal_amount
      this.maxWithdrawalAmount = this.allConfigurations.max_withdrawal_amount
      this.amountOfBallsToFire = this.allConfigurations.amount_of_balls_to_fire
      this.totalAttempts = this.allConfigurations.total_attempts
      this.currencyConversionDuration =
        this.allConfigurations.currency_conversion_duration
    }
  },
  computed: {
    ...mapGetters('AdminConfigurationStore', ['allConfigurations', 'errorMsg']),
  },
  methods: {
    ...mapActions('AdminConfigurationStore', ['editConfigurations']),
    validateForm() {
      if (
        !this.minDepositAmount ||
        !this.maxDepositAmount ||
        !this.minWithdrawalAmount ||
        !this.maxWithdrawalAmount ||
        !this.amountOfBallsToFire ||
        !this.totalAttempts ||
        !this.currencyConversionDuration
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
    async updateConfiguration() {
      if (!this.validateForm()) {
        return
      }
      try {
        const payload = {
          min_deposit_amount: this.minDepositAmount,
          max_deposit_amount: this.maxDepositAmount,
          min_withdrawal_amount: this.minWithdrawalAmount,
          max_withdrawal_amount: this.maxWithdrawalAmount,
          amount_of_balls_to_fire: this.amountOfBallsToFire,
          total_attempts: this.totalAttempts,
          currency_conversion_duration: this.currencyConversionDuration,
        }
        await this.editConfigurations(payload)
        const text = this.$t('edit_successfull')
        swal.fire({
          text,
          type: 'success',
          title: 'Edited Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      } catch (e) {
        console.log(e)
        console.log(this.errorMessage)
        if (this.errorMsg) {
          const text = this.errorMsg
          swal.fire({
            text,
            type: 'error',
            title: 'Error',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
          return false
        }
      }
    },
  },
}
</script>

<style></style>
