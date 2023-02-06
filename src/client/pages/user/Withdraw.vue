<template>
  <div class="px-4 pb-4">
    <!-- <div class="flex card-button">
      <button
        class="
          card-button
          py-4
          px-8
          mb-4
          capitalize
          text-center
          bg-gold
          lg:hover:bg-red lg:hover:text-white
          text-black
          focus:outline-none
          right-0
          relative
          ml-auto
        "
        @click="toggleModal()"
      >
        Make a Withdrawal
      </button>
    </div> -->
    <div>
      <h1 class="text-white text-2xl mb-4 text-center mt-4">Withdrawals</h1>
      <p class="text-center">
        Please note: All winnings will be paid by bank transfer after the
        winners have been through our K.Y.C. Process
      </p>
      <!--   <div
        v-if="getCurrentUserWithdrawals && getCurrentUserWithdrawals.length"
        class="grid lg:grid-cols-2 gap-4 max-w-3xl mx-auto"
      >
        <! <div
          v-for="(game, index) in getCurrentUserWithdrawals"
          :key="index"
          class="game-card flex flex-col cursor-pointer"
        >
          <div class="game-card-body p-4 border-red border-t-4">
            <h2 class="font-bold text-white text-2xl">{{ game.name }}</h2>
            <span class="flex flex-row items-center mt-2">
              <div class="inline-block mr-2">
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Amount:</span>
                  <span class="text-white">£{{ game.amount }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Status: </span>
                  <span class="text-white">{{ game.status.name }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">
                    Payent method:
                  </span>
                  <span class="text-white">{{ game.paymentMethod.name }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Date:</span>
                  <span class="text-white">{{
                    $moment(new Date(game.created_at)).format(
                      'DD/MM/YYYY HH:mm:ss'
                    )
                  }}</span>
                </div>
              </div>
            </span>
          </div>
        </div>
      </div> -->
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Make a Withdraw</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full" @keyup.enter="performAction">
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Currency
            </label>
            <div>GBP</div>
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Amount
            </label>
            <input
              v-model="withdrawAmount"
              type="number"
              name="name"
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
                border-b
                bg-transparent
                group-focus:border-red
                focus:outline-none focus:border-red
              "
              required
            />
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Card Type
            </label>
            <select
              v-model="paymentBrand"
              name="paymentBrand"
              class="rounded w-full text-gray-900 border-r-2 p-1"
              required
            >
              <option value="">Select Card Type</option>
              <option value="VISA">VISA</option>
              <option value="MASTER">MASTER</option>
              <option value="AMEX">AMERICAN EXPRESS</option>
            </select>
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Card Number
            </label>
            <input
              v-model="paymentCardNumber"
              type="text"
              name="paymentCardNumber"
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
              @keypress="isNumber"
            />
          </div>
          <div class="flex justify-between align-items-baseline">
            <div class="group">
              <label
                class="
                  text-white text-xs
                  group-focus:text-red-600
                  transition-colors
                  duration-300
                "
              >
                Expiry Month
              </label>
              <input
                v-model="paymentExpiryMonth"
                minlength="2"
                maxlength="2"
                type="text"
                name="paymentExpiryMonth"
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
                @keypress="isNumber"
              />
            </div>
            <div class="group">
              <label
                class="
                  text-white text-xs
                  group-focus:text-red-600
                  transition-colors
                  duration-300
                "
              >
                Expiry Year
              </label>
              <input
                v-model="paymentExpiryYear"
                minlength="4"
                maxlength="4"
                type="text"
                name="paymentExpiryYear"
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
                @keypress="isNumber"
              />
            </div>
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Card Holder
            </label>
            <input
              v-model="paymentCardHolder"
              type="text"
              name="paymentCardHolder"
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
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              CVV
            </label>
            <input
              v-model="paymentCvv"
              type="text"
              name="paymentCvv"
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
              @keypress="isNumber"
            />
          </div>
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="performAction()"
          >
            {{ buttonText }}
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import swal from 'sweetalert2'
// import { mapActions, mapGetters } from 'vuex'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'WithDraw',
  scrollToTop: false,
  layout: 'User',
  components: { BaseModal },
  async asyncData({ store }) {
    // await store.dispatch('UserPaymentsStore/getUserWithdrawals')
  },
  data: () => ({
    headerItems: [
      {
        id: 'amount',
        name: 'Amount',
      },
      {
        id: 'paymentMethod',
        name: 'Payment Method',
      },
      {
        id: 'completed_at',
        name: 'Completed at',
      },
      {
        id: 'status',
        name: 'Status',
      },
    ],
    modalVisible: false,
    withdrawCurrency: 'GBP',
    withdrawAmount: '',
    buttonText: 'Submit',
    paymentBrand: '',
    paymentCardNumber: '',
    paymentExpiryMonth: '',
    paymentExpiryYear: '',
    paymentCardHolder: '',
    paymentCvv: '',
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
  /* computed: {
    ...mapGetters('UserPaymentsStore', [
      'errorMessage',
      'getCurrentUserWithdrawals',
    ]),
  }, */
  methods: {
    /* ...mapActions('UserPaymentsStore', [
      'createUserWithdraw',
      'getUserWithdrawals',
    ]), */
    rowClicked(payload) {
      console.log('This row is clicked', payload)
    },
    toggleModal() {
      this.modalVisible = true
    },
    async performAction() {
      if (
        !this.withdrawAmount ||
        !this.paymentBrand ||
        !this.paymentCardNumber ||
        !this.paymentExpiryMonth ||
        !this.paymentExpiryYear ||
        !this.paymentCardHolder ||
        !this.paymentCvv
      ) {
        const text = this.$t('required_fields_error')
        swal.fire({
          text,
          type: 'error',
          title: 'Fill all Fields',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }

      if (isNaN(Number(this.paymentCardNumber))) {
        const text = this.$t('invalid_payment_card_number')
        swal.fire({
          text,
          type: 'error',
          title: 'Invalid Card Number',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }

      if (isNaN(Number(this.paymentCvv))) {
        const text = this.$t('invalid_payment_cvv')
        swal.fire({
          text,
          type: 'error',
          title: 'Invalid CVV',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      if (isNaN(Number(this.paymentExpiryMonth))) {
        const text = this.$t('invalid_payment_expiry_month')
        swal.fire({
          text,
          type: 'error',
          title: 'Invalid Expiry Month',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      if (isNaN(Number(this.paymentExpiryYear))) {
        const text = this.$t('invalid_payment_expiry_year')
        swal.fire({
          text,
          type: 'error',
          title: 'Invalid Expiry Year',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }

      try {
        const payload = {
          currency: this.withdrawCurrency,
          amount: this.withdrawAmount,
          payment_brand: this.paymentBrand,
          payment_card_number: this.paymentCardNumber,
          payment_expiry_month: this.paymentExpiryMonth,
          payment_expiry_year: this.paymentExpiryYear,
          payment_card_holder: this.paymentCardHolder,
        }
        await this.createUserWithdraw(payload)
        this.withdrawAmount = ''
        this.paymentBrand = ''
        this.paymentCardNumber = ''
        this.paymentExpiryMonth = ''
        this.paymentExpiryYear = ''
        this.paymentCardHolder = ''
        this.paymentCvv = ''
        this.modalVisible = false

        const text = this.$t('amount_withdrawn_successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Successfull Withdraw',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getUserWithdrawals()
        await this.$nuxt.context.store.dispatch(
          'UserPaymentsStore/getUserWallets'
        )
      } catch (e) {
        const text = this.errorMessage
        swal.fire({
          text,
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      }
    },
    isNumber(val) {
      if (isNaN(Number(val.key))) {
        return val.preventDefault()
      }
    },
    escEvent(e) {
      if (e.key === 'Escape' && this.modalVisible === true) {
        this.modalVisible = false
      }
    },
  },
  head: {
    bodyAttrs: {
      class: 'footer-margin',
    },
  },
}
</script>

<style></style>
