<template>
  <div class="grid grid-cols-1 gap-4">
    <base-table
      table-title="All Users Deposits"
      :header-items="headerItems"
      :records="getAllUserDeposits"
      text-color="text-white"
      @on-row-click="(record) => $emit('row-clicked', record)"
    >
      <template slot="name" slot-scope="{ item }">
        <div>{{ item.user.first_name + ' ' + item.user.last_name }}</div>
      </template>
      <template slot="paymentMethod" slot-scope="{ item }">
        <div>{{ item.paymentMethod.name }}</div>
      </template>
      <template slot="email" slot-scope="{ item }">
        <div>{{ item.user.email }}</div>
      </template>
      <template slot="phone" slot-scope="{ item }">
        <div>{{ item.user.phone }}</div>
      </template>
      <template slot="status" slot-scope="{ item }">
        <div>{{ item.status.name }}</div>
      </template>

      <template slot="no-items"> Nothing Found </template>
    </base-table>
    <AllGamesWidget
      :allgames="playedGames"
      widget-title="Finished Games Earning"
    />
    <base-table
      table-title="User Payouts"
      :header-items="headerItemsPayouts"
      :records="adminAllGames"
      text-color="text-black"
      @on-row-click="(record) => $emit('row-clicked', record)"
    >
      <template slot="status" slot-scope="{ item }">
        <div>{{ item.status.name }}</div>
      </template>
      <template slot="actions" slot-scope="{ item }">
        <button
          class="
            bg-yellow-500
            h-8
            m-2
            text-md
            bg-opacity-75
            text-black
            rounded
            px-4
            py-1
            focus:outline-none
          "
          type="button"
          @click.stop="showPayouts(item)"
        >
          Details
        </button>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AllGamesWidget from '~/components/Admin/AllGamesWidget.vue'

export default {
  name: 'AdminPayments',
  layout: 'Admin',
  components: {
    AllGamesWidget,
  },
  async asyncData({ store }) {
    await store.dispatch('AdminPaymentStore/getAllDeposits')
    await store.dispatch('AdminGameStore/getAdminGames')
  },
  data: () => ({
    headerItems: [
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'amount',
        name: 'Amount',
      },
      {
        id: 'completed_at',
        name: 'Completed At',
      },
      {
        id: 'paymentMethod',
        name: 'Payment Method',
      },
      {
        id: 'email',
        name: 'Email',
      },
      {
        id: 'phone',
        name: 'Phone',
      },
      {
        id: 'status',
        name: 'Status',
      },
    ],
    headerItemsPayouts: [
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'admin_earning',
        name: 'Earning',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'actions',
        name: 'Actions',
      },
    ],
  }),
  computed: {
    ...mapGetters('AdminPaymentStore', ['getAllUserDeposits']),
    ...mapGetters('AdminGameStore', ['adminAllGames']),
    playedGames() {
      if (!this.adminAllGames.length) return []
      return this.adminAllGames.filter(
        (game) => game.status.name.toLowerCase() === 'finished'
      )
    },
  },
  methods: {
    showPayouts(payload) {
      this.$router.push({ name: 'game-payouts', params: { id: payload.id } })
    },
  },
}
</script>

<style></style>
