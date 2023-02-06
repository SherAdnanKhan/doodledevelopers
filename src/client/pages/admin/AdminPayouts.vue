<template>
  <div>
    <base-table
      table-title="User Payouts"
      :header-items="headerItems"
      :records="getAllAdminPayouts"
      text-color="text-black"
      @on-row-click="(record) => $emit('row-clicked', record)"
    >
      <template slot="name" slot-scope="{ item }">
        <div>{{ item.user.first_name + ' ' + item.user.last_name }}</div>
      </template>
      <template slot="game_name" slot-scope="{ item }">
        <div>{{ item.game.name }}</div>
      </template>
      <template slot="type" slot-scope="{ item }">
        <div>{{ item.type.name }}</div>
      </template>
      <template slot="status" slot-scope="{ item }">
        <div>
          {{ item.status.name }}
        </div>
      </template>
      <template slot="actions" slot-scope="{ item }">
        <div v-if="item.status.id.toLowerCase() === 'pending'">
          <button class="btn p-3 rounded text-white" @click="approve(item)">
            Approve
          </button>
          <button class="btn p-3 rounded text-white" @click="reject(item)">
            Reject
          </button>
        </div>
        <div v-else>{{ item.status.id.toUpperCase() }}</div>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
export default {
  name: 'AdminPayouts',
  layout: 'Admin',
  async asyncData({ store, route }) {
    await store.dispatch('AdminPaymentStore/getAllPayouts', route.params.id)
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
        id: 'game_name',
        name: 'Game Name',
      },
      {
        id: 'type',
        name: 'Type',
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
    ...mapGetters('AdminPaymentStore', ['getAllAdminPayouts']),
  },
  methods: {
    ...mapActions('AdminPaymentStore', ['getAllPayouts', 'updateAdminPayouts']),
    async approve(payload) {
      const res = {
        gameId: payload.game.id,
        payoutId: payload.id,
        status: 'approved',
      }
      try {
        await this.updateAdminPayouts(res)
        const text = 'Payout Updated Successfully'
        swal.fire({
          text,
          type: 'success',
          title: 'Payout Updated',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      } catch (e) {}
      await this.getAllPayouts(this.$route.params.id)
    },
    async reject(payload) {
      const res = {
        gameId: payload.game.id,
        payoutId: payload.id,
        status: 'rejected',
      }
      try {
        await this.updateAdminPayouts(res)
        const text = 'Payout Updated Successfully'
        swal.fire({
          text,
          type: 'success',
          title: 'Payout Updated',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      } catch (e) {}
      await this.getAllPayouts(this.$route.params.id)
    },
  },
}
</script>

<style lang="scss" scoped></style>
