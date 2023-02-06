<template>
  <div class="px-4 pb-4 xl:pb-16">
    <div class="flex card-button">
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
          transition-colors
          text-black
          focus:outline-none
          right-0
          relative
          ml-auto
        "
        @click="toggleModal()"
      >
        Buy Credits
      </button>
    </div>
    <div>
      <div class="mb-4 xl:mb-8">
        <h1 class="text-white text-2xl mb-4 text-center mt-4">
          Credit Purchase History
        </h1>
        <p class="text-center">
          1 Credit purchase value is £1 GBP
        </p>
        <p class="text-center">
          Minimum purchase is 5 Credits
        </p>
      </div>
      <div
        v-if="allUserCredits && allUserCredits.length"
        class="grid lg:grid-cols-2 gap-4 max-w-3xl mx-auto"
      >
        <div
          v-for="(game, index) in allUserCredits"
          :key="index"
          class="game-card flex flex-col"
        >
          <div class="game-card-body p-4">
            <h2 class="font-bold text-white text-2xl">{{ game.name }}</h2>
            <span class="flex flex-row items-center mt-2">
              <div class="inline-block mr-2">
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Amount:</span>
                  <span class="text-white flex">
                    <img
                      class="w-6 h-6 inline-block"
                      src="~/assets/images/icon.png"
                      alt=""
                    />
                    {{ game.amount }}
                  </span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Status: </span>
                  <span class="text-white">{{ game.status }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">
                    Payment method:
                  </span>
                  <span class="text-white">{{ game.paymentMethod }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Date:</span>
                  <span class="text-white">{{
                    $moment(new Date(game.completed_at)).format(
                      'DD/MM/YYYY HH:mm:ss'
                    )
                  }}</span>
                </div>
              </div>
            </span>
          </div>
        </div>
      </div>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Add Credit</h1>
      </template>
      <template slot="content">
        <div
          class="max-w-xl flex flex-col w-full"
          @keyup.enter="prepareCheckout"
        >
          <div>
            <h3>Credit purchase value 1 x £1 GBP</h3>
            <p
              class="
              text-gold
              text-sm
            ">
              How many credits would you like to purchase? (minimum purchase is 5 credits)
            </p>
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
              Credit Currency
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
              v-model="creditAmount"
              type="number"
              name="creditAmount"
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
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="prepareCheckout()"
          >
            Add Credit
          </button>
        </div>
      </template>
    </base-modal>
    <base-modal
      :showing="paymentModalVisible"
      @close="paymentModalVisible = false"
    >
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Payment Details</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full">
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Credit Currency
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
            <div>&#163;{{ this.creditAmount }}</div>
          </div>
          <div class="group">
            <form
              :action="shopperResultUrl"
              class="paymentWidgets"
              data-brands="VISA MASTER AMEX"
            ></form>
          </div>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'UserWallet',
  scrollToTop: false,
  layout: 'User',
  components: { BaseModal },
  async asyncData({ store }) {
    await store.dispatch('UserPaymentsStore/getUserWallets')
    await store.dispatch('UserPaymentsStore/getUserCredit')
    await store.dispatch('UserPaymentsStore/getUserPurchaseHistory')
  },
  data: () => ({
    headerItems: [
      {
        id: 'amount',
        name: 'Amount',
      },
      {
        id: 'paymentMethod',
        name: 'Method',
      },
      {
        id: 'completed_at',
        name: 'Date',
      },
      {
        id: 'status',
        name: 'Status',
      },
    ],
    purchaseHeaderItems: [
      {
        id: 'id',
        name: 'ID',
      },
      {
        id: 'amount',
        name: 'Amount',
      },
      {
        id: 'wallet_balance',
        name: 'Balance',
      },
      {
        id: 'created_at',
        name: 'Date',
      },
      {
        id: 'status',
        name: 'Status',
      },
    ],
    modalVisible: false,
    paymentModalVisible: false,
    creditAmount: '',
    creditMethod: '',
    depositId: '',
    externalScript: null,
    shopperResultUrl: 'user-wallet?success=true',
    userCreditCurrency: 'GBP',
    paginationData: [],
    depositSrc: '',
  }),
  mounted() {
    this.depositSuccess()
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('UserPaymentsStore', [
      'getUserAllPurchaseHistory',
      'allUserCredits',
      'errorMessage',
    ]),
    allPurchaseHistory() {
      if (!this.getUserAllPurchaseHistory.length) return []
      return this.getUserAllPurchaseHistory.filter((purchases) =>
        purchases.transaction_type.toLowerCase().endsWith('usertransaction')
      )
    },
  },
  methods: {
    rowClicked(payload) {},
    ...mapActions('UserPaymentsStore', [
      'getUserPurchaseHistory',
      'getUserCredit',
      'createUserDeposit',
    ]),
    toggleModal() {
      this.modalVisible = true
    },
    togglePaymentModal() {
      this.paymentModalVisible = true
    },
    async prepareCheckout() {
      if (!this.creditAmount) {
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
      try {
        const payload = {
          currency: this.userCreditCurrency,
          amount: this.creditAmount,
        }
        const response = await this.createUserDeposit(payload)
        this.depositId = response.id
        this.modalVisible = false
        this.togglePaymentModal()
      } catch (e) {
        swal.fire({
          text: this.errorMessage,
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      }
    },
    async deposit() {},
    async depositSuccess() {
      const params = this.$route.query
      if (params.success === 'true') {
        const text = this.$t('credited_successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Deposit Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getUserCredit()
        await this.getUserPurchaseHistory()
        await this.$router.replace('user-wallet')
        await this.$nuxt.context.store.dispatch(
          'UserPaymentsStore/getUserWallets'
        )
      }
    },
    escEvent(e) {
      if (
        e.key === 'Escape' &&
        (this.modalVisible === true || this.paymentModalVisible)
      ) {
        this.modalVisible = false
        this.paymentModalVisible = false
      }
    },
  },
  watch: {
    depositId(val) {
      this.depositSrc = 'https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=' + val
    },
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
  head: {
    bodyAttrs: {
      class: 'footer-margin',
    },
  },
  head() {
    return {
      script: [
        {
          src: this.depositSrc,
          async: true,
          crossorigin: 'anonymous'
        },
      ],
    }
  },
}
</script>
<style>
.wpwl-form {
  color: #000000;
}

.game-card {
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid gray;
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 16%);
}
</style>
